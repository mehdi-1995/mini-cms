<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Presenters\RolePresenter;
use App\Http\Services\RoleService;
use Spatie\Permission\Models\Role;
use App\Http\Requests\RoleStoreRequest;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct(private RoleService $service)
    {
    }

    public function index()
    {
        $this->authorize('viewAny', Role::class);
        $roles = Role::with('permissions')->get();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(RoleStoreRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $this->service->store($validatedData);
            return redirect()->route('admin.roles.index')->with('success', 'نقش با موفقیت ایجاد شد.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    public function edit(Role $role)
    {
        $this->authorize('update', $role);
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|unique:roles,name,'.$role->id,
                'permissions' => 'array',
            ]);
            $this->service->update($validatedData, $role);
            return redirect()->route('roles.index')->with('success', 'نقش با موفقیت بروزرسانی شد.');

        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    // حذف نقش
    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'نقش با موفقیت حذف شد.');
    }
}
