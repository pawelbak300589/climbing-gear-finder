<?php

namespace App;

/**
 * Class Permission.
 */
class Permission extends \Spatie\Permission\Models\Permission
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'guard_name'];
}
