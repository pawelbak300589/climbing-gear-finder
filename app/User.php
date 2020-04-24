<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function path()
    {
        return "/users/{$this->id}";
    }

    public function adminPath()
    {
        return "/admin/users/{$this->id}";
    }

    public function role()
    {
        return $this->getRoleNames();
    }

    public function updateRole($roleId)
    {
        foreach (Role::all() as $role)
        {
            $this->removeRole($role);
        }

        $role = Role::where('id', '=', $roleId)->firstOrFail();
        $this->assignRole($role);

        return $this->getRoleNames();
    }

    public function getTableClass()
    {
        if ($this->id === auth()->user()->id)
        {
            $class = 'table-secondary';
        }
        else
        {
            switch ($this->getRoleNames()[0])
            {
                case 'SuperAdmin':
                case 'Admin':
                    $class = 'table-info';
                    break;
                case 'NormalUser':
                    $class = 'table-light';
                    break;
                case 'PremiumUser':
                    $class = 'table-success';
                    break;
                default:
                    $class = 'table-danger';
            }
        }
        return $class;
    }
}
