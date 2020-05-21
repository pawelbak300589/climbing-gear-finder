<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreNewUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:List users'])->only(['index', 'show']);
        $this->middleware(['permission:Create users'])->only('store');
        $this->middleware(['permission:Update users'])->only('update');
        $this->middleware(['permission:Delete users'])->only('destroy');
    }

    /**
     * Returns the Users resource with the roles relation.
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $users = User::with('roles.permissions')->paginate($request->get('limit', config('app.pagination_limit', 20)));
        if ($request->has('limit'))
        {
            $users->appends('limit', $request->get('limit'));
        }

        return response()->json($users);
    }

    /**
     * Returns the User resource with the roles relation.
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $user = User::with('roles.permissions')->findOrFail($id);

        return response()->json($user);
    }

    /**
     * @param StoreNewUser $request
     * @return mixed
     */
    public function store(StoreNewUser $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($request->has('password') ? $validated['password'] : 'password'); // TODO: create default password and send it to user with text about changing this password at first login - maybe force to reset password at first login too...

        $createdUser = User::create($validated)->assignRole($request->role);

        return response()->json($createdUser);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required',
        ];
        if ($request->method() == 'PATCH')
        {
            $rules = [
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
                'role' => 'sometimes|required',
            ];
        }
        $this->validate($request, $rules);

        // Update user
        // Except password as we don't want to let the users change a password from this endpoint
        $user->update($request->except('password'));
        // Reset roles for updated user
        $user->syncRoles($request->role);

        return response()->json($user->fresh());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => 'User successfully removed'
        ]);
    }
}
