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

    /**
     * @param int $take
     * @return array
     */
    public function getUsersWithoutInfo($take = 1)
    {
        $userIds = $this->followersFreeTable->where('screen_name', '')->get(['user_id'])->take($take)->toArray();

        foreach($userIds as &$userId){
            $userId = $userId->user_id;
        }

        return $userIds;
    }

    /**
     * @param array $userInfos
     */
    public function saveUserInfos($userInfos)
    {
        foreach($userInfos as $userInfo){
            $userInfo = (array)$userInfo;

            $this->followersFreeTable->where('user_id', $userInfo['id'])->update([
                'screen_name' => $userInfo['screen_name'],
                'name' => $userInfo['name'],
                'lang' => $userInfo['lang'],
                'location' => $userInfo['location'],
                'geo_enabled' => $userInfo['geo_enabled'],
                'time_zone' => $userInfo['time_zone'],
                'utc_offset' => $userInfo['utc_offset'],
                'created_at' => date('Y-m-d H:i:s', strtotime($userInfo['created_at'])),
                'follow_request_sent' => $userInfo['follow_request_sent'],
                'followers_count' => $userInfo['followers_count'],
                'friends_count' => $userInfo['friends_count'],
                'favourites_count' => $userInfo['favourites_count'],
                'statuses_count' => $userInfo['statuses_count'],
            ]);
        }
    }

}