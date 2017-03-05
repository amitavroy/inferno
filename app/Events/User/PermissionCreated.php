<?php
/**
 * Created by PhpStorm.
 * User: amitavroy
 * Date: 05/03/17
 * Time: 9:41 PM
 */

namespace App\Events\User;


use Spatie\Permission\Models\Permission;

class PermissionCreated
{

    /**
     * PermissionCreated constructor.
     */
    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    public function getName()
    {
        return $this->permission->name;
    }
}