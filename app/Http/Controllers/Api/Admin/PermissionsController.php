<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreNewPermission;
use App\Http\Requests\Admin\UpdatePermission;
use Spatie\Permission\Models\Role;
use App\Permission;

class PermissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:List permissions'])->only(['index', 'show']);
        $this->middleware(['permission:Create permissions'])->only('store');
        $this->middleware(['permission:Update permissions'])->only('update');
        $this->middleware(['permission:Delete permissions'])->only('destroy');
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $permissions = Permission::all();

        return response()->json($permissions);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $permissions = Permission::findOrFail($id);

        return response()->json($permissions);
    }

    /**
     * @param StoreNewPermission $request
     * @return mixed
     */
    public function store(StoreNewPermission $request)
    {
        $request->validated();
        // Create new permission
        $permission = Permission::create($request->except('roles'));
        // Sync roles for created permission
        if ($request->has('roles'))
        {
            $permission->syncRoles($request['roles']);
        }

        return response()->json($permission->fresh());
    }

    /**
     * @param UpdatePermission $request
     * @param $id
     * @return mixed
     */
    public function update(UpdatePermission $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $request->validated();

        // Update permission
        $permission->update($request->except('roles'));
        // Sync roles for updated permission
        if ($request->has('roles'))
        {
            $permission->syncRoles($request['roles']);
        }

        return response()->json($permission->fresh());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        // delete permission
        $permission->delete();

        return response()->json([
            'message' => 'Permission successfully removed'
        ]);
    }
}
