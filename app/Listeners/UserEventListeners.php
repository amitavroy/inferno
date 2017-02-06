<?php
/**
 * User: amitavroy
 * Date: 06/02/17
 * Time: 9:11 PM
 */

namespace App\Listeners;

use App\Events\User\LoggedIn;
use App\Events\User\LoggedOut;
use App\Services\Logger;
use Illuminate\Support\Facades\Auth;

class UserEventListeners
{
    private $logger;

    function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }
    
    public function userLoggedIn(LoggedIn $event)
    {
        $name = Auth::user()->name;
        $this->logger->log("User {$name} logged in");
    }

    public function userLoggedOut(LoggedOut $event)
    {
        $name = Auth::user()->name;
        $this->logger->log("User {$name} logged out");
    }

    public function subscribe($events)
    {
        $class = 'App\Listeners\UserEventListeners';
        $events->listen(LoggedIn::class, "{$class}@userLoggedIn");
        $events->listen(LoggedOut::class, "{$class}@userLoggedOut");
    }
}