<?php
/**
 * User: amitavroy
 * Date: 18/02/17
 * Time: 9:23 PM
 */

namespace App\Events\User;


use App\User;

class Activate
{
    private $user;

    function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getName()
    {
        return $this->user->name;
    }
}