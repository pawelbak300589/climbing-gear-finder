<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreNewUser;
use App\Http\Requests\Admin\UpdateUser;
use App\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:user-list'])->only('index');
        $this->middleware(['permission:user-create'])->only(['create', 'store']);
        $this->middleware(['permission:user-edit'])->only(['edit', 'update']);
        $this->middleware(['permission:user-delete'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::all();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreNewUser $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreNewUser $request)
    { // TODO: test permissions
        $validated = $request->validated();
        $validated['password'] = Hash::make('password'); // TODO: create default password and send it to user with text about changing this password at first login - maybe force to reset password at first login too...

        User::create($validated)->assignRole($request->role);

        return redirect('admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $roles = Role::all();

        return view('admin.users.show', compact(['roles', 'user']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();

        return view('admin.users.edit', compact(['roles', 'user']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUser $request
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateUser $request, User $user)
    {
        $validated = $request->validated();

        $user->update($validated);

        $user->updateRole($request->role);

        return redirect('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(User $user)
    {
        // TODO: ask if you are sure ou want to remove this user
        $user->delete();

        return redirect('admin/users');
    }
}
