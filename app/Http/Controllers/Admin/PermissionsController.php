<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreNewPermission;
use App\Http\Requests\Admin\UpdatePermission;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:permission-list'])->only('index');
        $this->middleware(['permission:permission-create'])->only(['create', 'store']);
        $this->middleware(['permission:permission-edit'])->only(['edit', 'update']);
        $this->middleware(['permission:permission-delete'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $permissions = Permission::all();
        $roles = [];

        foreach ($permissions as $permission)
        {
            if ($permission->roles()->count())
            {
                $roles[$permission->id] = '<div class="text-left">Used by:<br>';
                $roles[$permission->id] .= '<ul>';
                foreach ($permission->roles()->get() as $role)
                {
                    $roles[$permission->id] .= '<li class="text-left">' . $role->name . '</li>';
                }
                $roles[$permission->id] .= '</ul></div>';
            }
            else
            {
                $roles[$permission->id] = 'Permission not assigned to any role';
            }
        }

        return view('admin.permissions.index', compact(['roles', 'permissions']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::all();

        return view('admin.permissions.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreNewPermission $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreNewPermission $request)
    { // TODO: test permissions
        $validated = $request->validated();
        $roles = $validated['roles'] ?? [];
        unset($validated['roles']);

        // Create new permission
        $permission = Permission::create($validated);

        // Assign permission to roles if there are some in request
        if ($roles)
        {
            foreach ($roles as $role)
            {
                $permission->assignRole($role);
            }
        }

        return redirect('admin/permissions');
    }

    /**
     * Display the specified resource.
     *
     * @param Permission $permission
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Permission $permission)
    {
        return view('admin.permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        $roles = Role::all();

        return view('admin.permissions.edit', compact(['roles', 'permission']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePermission $request
     * @param Permission $permission
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdatePermission $request, Permission $permission)
    {
        $validated = $request->validated();
        $roles = $validated['roles'] ?? [];
        unset($validated['roles']);

        // Update permission
        $permission->update($validated);
        // Sync roles for updated permission
        $permission->syncRoles($roles);

        return redirect('admin/permissions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Permission $permission
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Permission $permission)
    {
        // delete permission
        $permission->delete();

        return redirect('admin/permissions');
    }
}
