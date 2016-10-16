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
     * @param string $username
     * @param string $user_id
     */
    public function addUserIdUsed($username, $user_id)
    {
        $this->followersUsedTable->insert(compact('username', 'user_id'));
    }

}