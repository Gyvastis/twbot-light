<?php

namespace Twbot\Service;


class CronService
{
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