<?php

namespace App\Repositories\Watchdog;

use App\Repositories\AbstractInterface;

interface WatchdogRepository extends AbstractInterface
{
    public function getUserActivityList($userId, array $options);

    public function getUserActivityGraph($userId);
}