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
        $date = $this->db->get('cron_job', 'created_at', [
            'AND' => [
                'username' => $username,
                'type' => $type,
                'is_last' => 1
            ]
        ]);

        $this->handleDatabaseException();

        return $date ? date_create_from_format('Y-m-d H:i:s', $date) : null;
    }

    /**
     * @param Account $account
     * @param string $jobType
     */
    protected function resetJobLast($account, $jobType)
    {
        $this->db->update('cron_job', [
            'is_last' => 0
        ], [
            'AND' => [
                'username' => $account->getUsername(),
                'type' => $jobType
            ]
        ]);

        $this->handleDatabaseException();
    }

    /**
     * @param Account $account
     * @param string $jobType
     */
    public function addCompletedJob($account, $jobType)
    {
        $this->resetJobLast($account, $jobType);

        $this->db->insert('cron_job', [
            'username' => $account->getUsername(),
            'type' => $jobType,
            'is_last' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $this->handleDatabaseException();
    }
}