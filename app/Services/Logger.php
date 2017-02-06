<?php

namespace App\Services;

use App\Repositories\Watchdog\WatchdogRepository;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class Logger
{
    private $request;
    private $auth;
    protected $user = null;
    private $watchdog;

    function __construct(Request $request, Guard $auth, WatchdogRepository $watchdog)
    {
        $this->request = $request;
        $this->auth = $auth;
        $this->watchdog = $watchdog;
    }

    public function log($description, $level = 'info')
    {
        return $this->watchdog->create([
            'description' => $description,
            'level' => $level,
            'ip_address' => $this->request->ip(),
            'user_id' => $this->getUserId(),
        ]);
    }

    private function getUserId()
    {
        if ($this->request->user()) {
            return $this->request->user()->id;
        }
        else {
            return 1;
        }
    }
}