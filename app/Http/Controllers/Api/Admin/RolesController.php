<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreNewRole;
use App\Http\Requests\Admin\UpdateRole;
use App\Role;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:List roles'])->only(['index', 'show']);
        $this->middleware(['permission:Create roles'])->only('store');
        $this->middleware(['permission:Update roles'])->only('update');
        $this->middleware(['permission:Delete roles'])->only('destroy');
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $roles = Role::with('permissions')->all();

        return response()->json($roles);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $role = Role::with('permissions')->findOrFail($id);

        return response()->json($role);
    }

    /**
     * @param StoreNewRole $request
     * @return mixed
     */
    public function store(StoreNewRole $request)
    {
        $request->validated();
        // Create role
        $role = Role::create($request->except('permissions'));
        // Sync permissions for created role
        if ($request->has('permissions'))
        {
            $role->syncPermissions($request['permissions']);
        }

        return response()->json($role->fresh());
    }

    /**
     * @param UpdateRole $request
     * @param $id
     * @return mixed
     */
    public function update(UpdateRole $request, $id)
    {
        $role = Role::findOrFail($id);
        $request->validated();

        // Update role
        $role->update($request->except('permissions'));
        // Sync permissions for updated role
        if ($request->has('permissions'))
        {
            $role->syncPermissions($request['permissions']);
        }

        return response()->json($role->fresh());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        // move all users from this role and assign to Guest role
        foreach ($role->users()->get() as $user)
        {
            $user->assignRole(Role::findOrCreate('Guest'));
        }

        $role->delete();

        return response()->json([
            'message' => 'Role successfully removed'
        ]);
    }
}
