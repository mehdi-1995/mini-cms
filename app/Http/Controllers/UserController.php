<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Services\UserService;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UserRequest\UserStoreRequest;
use App\Http\Requests\UserRequest\UserUpdateRequest;

class UserController extends Controller
{
    public function __construct(private UserService $service)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->service->getAll(6);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where(['guard_name' => 'web'])->get();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        try {
            $user = $this->service->create($request->validated());
            return redirect()
            ->route('admin.users.index')
            ->with('success', __('messages.user_created', ['name' => $user->name]));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::where(['guard_name' => 'web'])->get();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        try {
            $this->service->update($user, $request->validated());
            return redirect()->route('admin.users.index')->with(
                'success',
                __('messages.user_updated', ['name' => $user->name])
            );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $this->service->delete($user);

            return redirect()->back()
                ->with(
                    'success',
                    __('messages.user_deleted', ['name' => $user->name])
                );

        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }
}
