<?php

namespace App;

/**
 * Class Role.
 */
class Role extends \Spatie\Permission\Models\Role
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'guard_name'];
}
