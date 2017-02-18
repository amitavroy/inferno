<?php
/**
 * User: amitavroy
 * Date: 06/02/17
 * Time: 9:11 PM
 */

namespace App\Listeners;

use App\Events\User\LoggedIn;
use App\Events\User\LoggedOut;
use App\Events\User\ProfileEdited;
use App\Events\User\Registered;
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

    public function userProfileEdited(ProfileEdited $event)
    {
        $name = Auth::user()->name;
        $this->logger->log("User {$name} changed his profile");
    }

    public function userRegistered(Registered $event)
    {
        $event->handleUserRegistration(); // handling activities on user register
        $name = $event->getUserName();
        $this->logger->log("A new User {$name} registered. Activation is pending.");
    }

    public function subscribe($events)
    {
        $class = 'App\Listeners\UserEventListeners';
        $events->listen(LoggedIn::class, "{$class}@userLoggedIn");
        $events->listen(LoggedOut::class, "{$class}@userLoggedOut");
        $events->listen(ProfileEdited::class, "{$class}@userProfileEdited");
        $events->listen(Registered::class, "{$class}@userRegistered");
    }
}