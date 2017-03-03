<?php
/**
 * Created by PhpStorm.
 * User: amitavroy
 * Date: 03/03/17
 * Time: 8:20 AM
 */

namespace App\Events\User;


use Spatie\Permission\Models\Role;

class RoleCreated
{
    private $role;

    /**
     * RoleCreated constructor.
     */
    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function getName()
    {
        return $this->role->name;
    }
}