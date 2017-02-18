<?php
/**
 * User: amitavroy
 * Date: 18/02/17
 * Time: 3:25 PM
 */

namespace App\Events\User;

use App\Profile;
use App\User;

class Registered
{
    private $user;

    function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUserName()
    {
        return $this->user->name;
    }

    public function makeUserProfile()
    {
        Profile::create([
            'user_id' => $this->user->id,
            'options' => ['sidebar' => true]
        ]);
    }
}