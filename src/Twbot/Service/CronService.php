<?php

namespace Twbot\Service;


use Twbot\Entity\Account;
use Twbot\Enumerator\CronEnumerator;
use Twbot\Repository\CronRepository;

class CronService
{
    /**
     * @var CronRepository $cronRepository
     */
    protected $cronRepository;

    /**
     * CronService constructor.
     * @param CronRepository $cronRepository
     */
    public function __construct(CronRepository $cronRepository)
    {
        $this->cronRepository = $cronRepository;
    }

    /**
     * @return CronRepository
     */
    public function getCronRepository()
    {
        return $this->cronRepository;
    }

    /**
     * @param Account $account
     * @return bool
     */
    public function shouldPost($account)
    {
        $lastPostDate = $this->getCronRepository()->getJobDate($account->getUsername(), CronEnumerator::POST_JOB);

        return !$lastPostDate || $this->getDateTimeDiffMinutes($lastPostDate) > $account->getPostIntervalMinutes();
    }

    /**
     * @param Account $account
     * @return bool
     */
    public function shouldFollow($account)
    {
        $lastFollowDate = $this->getCronRepository()->getJobDate($account->getUsername(), CronEnumerator::FOLLOW_JOB);

        return !$lastFollowDate || $this->getDateTimeDiffMinutes($lastFollowDate) > $account->getFollowIntervalMinutes();
    }

    /**
     * @param Account $account
     * @return bool
     */
    public function shouldUnfriend($account)
    {
        $lastUnfriendDate = $this->getCronRepository()->getJobDate($account->getUsername(), CronEnumerator::UNFRIEND_JOB);

        return !$lastUnfriendDate || $this->getDateTimeDiffMinutes($lastUnfriendDate) > $account->getUnfriendIntervalMinutes();
    }

    /**
     * @param \DateTime $compareTime
     * @param bool|\DateTime $currentTime
     * @return int|float
     */
    protected function getDateTimeDiffMinutes($compareTime, $currentTime = true)
    {
        if(is_bool($currentTime)) {
            $currentTime = new \DateTime('now');
        }

        $diffMinutes = $compareTime->getTimestamp() - $currentTime->getTimestamp();
        $diffMinutes = $diffMinutes / 60;
        $diffMinutes = round($diffMinutes, 2);

        return $diffMinutes;
    }
}