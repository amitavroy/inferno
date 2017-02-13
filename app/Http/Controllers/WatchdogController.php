<?php

namespace App\Http\Controllers;

use App\Repositories\Watchdog\WatchdogRepository;
use Illuminate\Http\Request;
use Setting;

class WatchdogController extends Controller
{
    private $watchdog;

    function __construct(WatchdogRepository $watchdog)
    {
        $this->watchdog = $watchdog;
        $feature = Setting::get('watchdog', false);
        if (!$feature) {
            abort(403, 'This feature is not enabled.');
        }
    }

    public function getWatchdogPage(Request $request)
    {
        $options = [
            'search_text' => $request->input('search_text'),
            'level' => $request->input('level'),
        ];

        $rows = $this->watchdog->getUserActivityList(null, $options);
        return view('adminlte.pages.watchdog', compact('rows', 'options'));
    }
}
