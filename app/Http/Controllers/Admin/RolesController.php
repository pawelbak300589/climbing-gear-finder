<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreNewRole;
use App\Http\Requests\Admin\UpdateRole;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:role-list'])->only('index');
        $this->middleware(['permission:role-create'])->only(['create', 'store']);
        $this->middleware(['permission:role-edit'])->only(['edit', 'update']);
        $this->middleware(['permission:role-delete'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        $permissions = [];

        foreach ($roles as $role)
        {
            if ($role->permissions()->count())
            {
                $permissions[$role->id] = 'Granted permissions to:<br>';
                $permissions[$role->id] .= '<ul>';
                foreach ($role->permissions()->get() as $permission)
                {
                    $permissions[$role->id] .= '<li class="text-left">' . $permission->name . '</li>';
                }
                $permissions[$role->id] .= '</ul>';
            }
            else
            {
                $permissions[$role->id] = 'No permissions granted';
            }
        }

        return view('admin.roles.index', compact(['roles', 'permissions']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $permissions = Permission::all();

        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreNewRole $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreNewRole $request)
    { // TODO: test permissions
        $validated = $request->validated();
        $permissions = $validated['permissions'] ?? [];
        unset($validated['permissions']);

        // Create new role
        $role = Role::create($validated);

        // Assign permissions for new role if there are some in request
        if ($permissions)
        {
            foreach ($permissions as $permission)
            {
                $role->givePermissionTo($permission);
            }
        }

        return redirect('admin/roles');
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();

        return view('admin.roles.edit', compact(['role', 'permissions']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRole $request
     * @param Role $role
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateRole $request, Role $role)
    {
        $validated = $request->validated();
        $permissions = $validated['permissions'] ?? [];
        unset($validated['permissions']);

        // Update role
        $role->update($validated);
        // revoke all permissions for updated role
        $role->syncPermissions();

        // Assign new permissions if there are some in request
        if ($permissions)
        {
            foreach ($permissions as $permission)
            {
                $role->givePermissionTo($permission);
            }
        }

        return redirect('admin/roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Role $role)
    {
        // delete role
//        TODO: what will happen with all users after removing role
        foreach ($role->users()->get() as $user)
        {
            $user->assignRole(Role::findOrCreate('Guest'));
        }

        $role->delete();

        return redirect('admin/roles');
    }
}
