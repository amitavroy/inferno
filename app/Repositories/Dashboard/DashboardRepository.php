<?php
/**
 * Created by PhpStorm.
 * User: Amitav Roy
 * Date: 08/04/17
 * Time: 11:06 AM
 */

namespace App\Repositories\Dashboard;


interface DashboardRepository
{
    public function userLastWeekActivities($userId);
    public function systemLastWeekActivities();
}