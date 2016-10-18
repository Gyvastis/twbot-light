<?php

namespace Twbot\Repository;


use Twbot\Core\Repository;
use Twbot\Entity\Account;

class CronRepository extends Repository
{
    /**
     * @param string $username
     * @param string $type
     * @return \DateTime|null
     */
    public function getJobDate($username, $type)
    {
        $date = $this->db->get('cron_job', 'created_at', compact('username', 'type'));

        $this->handleDatabaseException();

        return $date ? new \DateTime(strtotime($date)) : null;
    }

    /**
     * @param Account $account
     * @param string $jobType
     */
    public function addCompletedJob($account, $jobType)
    {
        $this->db->insert('cron_job', [
            'username' => $account->getUsername(),
            'type' => $jobType
        ]);

        $this->handleDatabaseException();
    }
}