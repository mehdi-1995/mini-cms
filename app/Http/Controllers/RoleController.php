<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\RoleService;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct(private RoleService $service)
    {
    }

    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|unique:roles,name',
                'permissions' => 'array',
            ]);
            $this->service->store($validatedData);
            return redirect()->route('roles.index')->with('success', 'نقش با موفقیت ایجاد شد.');

        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function edit(Role $role)
    {
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
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'نقش با موفقیت حذف شد.');
    }
}
