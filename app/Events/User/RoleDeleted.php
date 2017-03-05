<?php
/**
 * Created by PhpStorm.
 * User: amitavroy
 * Date: 05/03/17
 * Time: 9:36 PM
 */

namespace App\Events\User;


use Spatie\Permission\Models\Role;

class RoleDeleted
{
    private $role;

    /**
     * RoleDeleted constructor.
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