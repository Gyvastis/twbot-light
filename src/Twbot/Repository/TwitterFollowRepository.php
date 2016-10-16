<?php

namespace Twbot\Repository;

use Illuminate\Database\Query\Builder;

class TwitterFollowRepository
{
    /**
     * @var Builder
     */
    protected $followersFreeTable;

    /**
     * @var Builder
     */
    protected $followersUsedTable;

    /**
     * TwitterFollowRepository constructor.
     */
    public function __construct()
    {
        $this->followersFreeTable = getProvider('db')->table('followers_free');
        $this->followersUsedTable = getProvider('db')->table('followers_used');
    }

    /**
     * @param string $user_id
     * @return bool
     */
    public function isUserIdUsed($user_id)
    {
        return $this->followersUsedTable->select('id')->where('user_id', $user_id)->exists();
    }

    /**
     * @param string $username
     * @param string $user_id
     */
    public function addUserIdUsed($username, $user_id)
    {
        $this->followersUsedTable->insert(compact('username', 'user_id'));
    }

    /**
     * @param string $user_id
     */
    public function addUserIdFree($user_id)
    {
        if(!$this->followersFreeTable->select('id')->where('user_id', $user_id)->exists()) {

            $this->followersFreeTable->insert(compact('user_id'));
        }
    }

    /**
     * @param array $user_ids
     */
    public function addUserIdFreeBulk($user_ids)
    {
        $insert = [];

        foreach($user_ids as $user_id){
            if(!$this->followersFreeTable->select('id')->where('user_id', $user_id)->exists()) {
                $insert[] = [
                    'user_id' => $user_id
                ];
            }
        }

        if(!empty($insert)){
            $this->followersFreeTable->insert($insert);
        }
    }

}