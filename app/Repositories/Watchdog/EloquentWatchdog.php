<?php

namespace App\Repositories\Watchdog;

use App\Repositories\AbstractRepository;
use App\Watchdog;
use Illuminate\Support\Facades\DB;

class EloquentWatchdog extends AbstractRepository implements WatchdogRepository
{
    protected $model;

    function __construct(Watchdog $watchdog)
    {
        $this->model = $watchdog;
    }

    public function getUserActivityList($userId = null)
    {
        $query = $this->model->select();

        if ($userId != null) {
            $query->where('user_id', $userId);
        }

        $query->orderBy('created_at', 'desc');
        return $query->paginate(10);
    }

    public function getUserActivityGraph($userId = null)
    {
        $query = DB::table('watchdogs');
        $query->select(DB::raw("count(id) AS count, DATE_FORMAT(created_at, '%M %d') AS date"));

        if ($userId != null) {
            $query->where('user_id', $userId);
        }

        $query->groupBy('date');
        $query->limit(20);
        $query->orderBy('created_at', 'desc');
        $data = $query->get();

        $rowData = [];

        foreach ($data as $row) {
            $rowData[] = [$row->date, $row->count];
        }

        return $rowData;
    }
}