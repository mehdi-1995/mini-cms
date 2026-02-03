<?php

namespace App\Http\Controllers;

use App\Http\Services\RoleService;
use Spatie\Permission\Models\Role;
use App\Http\Requests\RoleRequest\RoleStoreRequest;
use App\Http\Requests\RoleRequest\RoleUpdateRequest;

class RoleController extends Controller
{
    public function __construct(private RoleService $service)
    {
    }

    public function index()
    {
        $this->authorize('viewAny', Role::class);
        $roles = $this->service->getAll();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = $this->service->getAllPermissions();
        return view('roles.create', compact('permissions'));
    }

    public function store(RoleStoreRequest $request)
    {
        $this->authorize('create', Role::class);
        try {
            $validatedData = $request->validated();
            $this->service->store($validatedData);
            return redirect()
            ->route('admin.roles.index')
            ->with('success', __('messages.role_created'));
        } catch (\Exception $e) {
            return back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    public function edit(Role $role)
    {
        $this->authorize('update', $role);
        $permissions = $this->service->getAllPermissions();
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(RoleUpdateRequest $request, Role $role)
    {
        $this->authorize('update', $role);
        try {
            $this->service->update($request->validated(), $role);
            return redirect()
            ->route('admin.roles.index')
            ->with('success', __('messages.role_updated', ['name' => $role->name]));
        } catch (\Exception $e) {
            return back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    // حذف نقش
    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);
        $this->service->delete($role);
        return redirect()
            ->route('admin.roles.index')
            ->with('success', __('messages.role_deleted', ['name' => $role->name]));
    }
}
