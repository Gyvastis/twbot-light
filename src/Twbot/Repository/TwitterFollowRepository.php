<?php

namespace Twbot\Repository;

use Twbot\Core\Repository;
use Twbot\Factory\SeederFactory;

class TwitterFollowRepository extends Repository
{

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
     * @param string $user_id
     */
    public function removeUserId($user_id)
    {
        $this->db->delete('followers_used', compact('user_id'));

        $this->handleDatabaseException();
    }

    /**
     * @param string $seeder_username
     * @param string $user_ids
     */
    public function addUserIdFreeBulk($seeder_username, $user_ids)
    {
        $insertSt = [];

        foreach ($user_ids as $user_id) {
            if (!$this->db->has('followers_free', compact('user_id'))) {
                $insertSt[] = compact('seeder_username', 'user_id');
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
                'followers_count' => $userInfo['followers_count'],
                'friends_count' => $userInfo['friends_count'],
                'favourites_count' => $userInfo['favourites_count'],
                'statuses_count' => $userInfo['statuses_count'],
//                'retweet_count' => $userInfo['retweet_count'],
                'default_profile_image' => $userInfo['default_profile_image'],
            ], ['user_id' => $userInfo['id_str']]);

            $this->handleDatabaseException();
        }
    }

    public function getEligibleToBeFollowed($take = 10)
    {
        $preferredFollower = SeederFactory::getPreferredFollower();

        $result = $this->db->select('followers_free', [
            '[>]followers_used' => ['user_id' => 'user_id']
        ], 'followers_free.user_id', [
            'AND' => [
                'followers_free.followers_count[>]' => $preferredFollower['min_follower_count'],
                'followers_free.statuses_count[>]' => $preferredFollower['min_statuses_count'],
                'followers_free.favourites_count[>]' => $preferredFollower['min_favorites_count'],
//                'followers_free.retweet_count[>]' => $preferredFollower['min_retweet_count'],
//                '[>]created_at' => $preferredFollower['min_days_registered'],
                'followers_free.default_profile_image' => (int)(!(bool)$preferredFollower['has_profile_picture']),
                'followers_used.username' => null
            ],
            'LIMIT' => $take
        ]);

        $this->handleDatabaseException();

        return $result;
    }
}