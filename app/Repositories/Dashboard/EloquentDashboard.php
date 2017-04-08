<?php
/**
 * Created by PhpStorm.
 * User: Amitav Roy
 * Date: 08/04/17
 * Time: 11:08 AM
 */

namespace App\Repositories\Dashboard;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EloquentDashboard implements DashboardRepository
{
    private function baseActivityQuery()
    {
        $select = [
            DB::raw("count(id) AS count, DATE_FORMAT(created_at, '%M %d') AS date")
        ];

        $query = DB::table('watchdogs');
        $query->select($select);
        $query->where('created_at', '>', Carbon::today()->subDays(7));
        $query->where('created_at', '<', Carbon::today());
        $query->orderBy('created_at', 'desc');
        $query->groupBy('date');

        return $query;
    }

    public function userLastWeekActivities($userId)
    {
        $query = $this->baseActivityQuery();
        $query->where('user_id', $userId);
        return $query->get();
    }

    public function systemLastWeekActivities()
    {
        $query = $this->baseActivityQuery();
        return $query->get();
    }
}