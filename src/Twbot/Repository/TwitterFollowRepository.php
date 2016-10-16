<?php

namespace Twbot\Repository;

use Twbot\Exception\DatabaseException;

class TwitterFollowRepository
{
    /**
     * @var \medoo
     */
    protected $db;

    /**
     * TwitterFollowRepository constructor.
     */
    public function __construct()
    {
        $this->db = getProvider('db');
    }

    /**
     * @throws DatabaseException
     */
    protected function handleDatabaseException()
    {
        $error = $this->db->error();

        if (!isset($error[2]) && !empty($error[2])) {
            throw new DatabaseException($error[2]);
        }

        unset($error);
    }

    /**
     * @param string $user_id
     * @return bool
     */
    public function isUserIdUsed($user_id)
    {
        $exists = $this->db->has('followers_used', compact('user_id'));

        $this->handleDatabaseException();

        return $exists;
    }

    /**
     * @param string $username
     * @param string $user_id
     */
    public function addUserIdUsed($username, $user_id)
    {
        $this->db->insert('followers_used', compact('username', 'user_id'));

        $this->handleDatabaseException();
    }

    /**
     * @param $user_ids
     */
    public function addUserIdFreeBulk($user_ids)
    {
        $insertSt = [];

        foreach ($user_ids as $user_id) {
            if (!$this->db->has('followers_free', compact('user_id'))) {
                $insertSt[] = compact('user_id');
            }

            $this->handleDatabaseException();
        }

        if (!empty($insertSt)) {
            $this->db->insert('followers_free', $insertSt);

            $this->handleDatabaseException();
        }
    }

    /**
     * @param int $take
     * @return array
     */
    public function getUsersWithoutInfo($take = 1)
    {
        $result = $this->db->select('followers_free', 'user_id', [
            'screen_name' => '',
            'LIMIT' => $take
        ]);

        $this->handleDatabaseException();

        return $result;
    }

    /**
     * @param array $userInfos
     */
    public function saveUserInfos($userInfos)
    {
        foreach ($userInfos as $userInfo) {
            $userInfo = (array)$userInfo;

            $this->db->update('followers_free', [
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
            ], ['user_id' => $userInfo['id_str']]);

            $this->handleDatabaseException();
        }
    }

}