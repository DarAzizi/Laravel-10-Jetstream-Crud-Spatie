<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use App\Http\Resources\RoleResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleCollection;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index(Request $request): RoleCollection
    {
        $this->authorize('list', Role::class);

        $search = $request->get('search', '');
        $roles = Role::where('name', 'like', "%{$search}%")->paginate();

        return new RoleCollection($roles);
    }

    public function store(Request $request): RoleResource
    {
        $this->authorize('create', Role::class);

        $validated = $this->validate($request, [
            'name' => 'required|unique:roles|max:32',
            'permissions' => 'array',
        ]);

        $role = Role::create($validated);

        $permissions = Permission::find($request->permissions);
        $role->syncPermissions($permissions);

        return new RoleResource($role);
    }

    public function show(Role $role): RoleResource
    {
        $this->authorize('view', Role::class);

        return new RoleResource($role);
    }

    public function update(Request $request, Role $role): RoleResource
    {
        $this->authorize('update', $role);

        $validated = $this->validate($request, [
            'name'=>'required|max:32|unique:roles,name,'.$role->id,
            'permissions' =>'array',
        ]);
        
        $role->update($validated);

        $permissions = Permission::find($request->permissions);
        $role->syncPermissions($permissions);

        return new RoleResource($role);
    }

    public function destroy(Role $role): Response
    {
        $this->authorize('delete', $role);

        $role->delete();

        return response()->noContent();
    }
}