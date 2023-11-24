<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\PermissionCollection;

class PermissionController extends Controller
{
    public function index(Request $request): PermissionCollection
    {
        $this->authorize('list', Permission::class);

        $search = $request->get('search', '');
        $permissions = Permission::where('name', 'like', "%{$search}%")->paginate();

        return new PermissionCollection($permissions);
    }

    public function store(Request $request): PermissionResource
    {
        $this->authorize('create', Permission::class);

        $validated = $this->validate($request, [
            'name' => 'required|max:64',
            'roles' => 'array'
        ]);

        $permission = Permission::create($validated);
        
        $roles = Role::find($request->roles);
        $permission->syncRoles($roles);

        return new PermissionResource($permission);
    }

    public function show(Permission $permission): PermissionResource
    {
        $this->authorize('view', Permission::class);

        return new PermissionResource($permission);
    }

    public function update(Request $request, Permission $permission): PermissionResource
    {
        $this->authorize('update', $permission);

        $validated = $this->validate($request, [
            'name' => 'required|max:40',
            'roles' => 'array'
        ]);

        $permission->update($validated);
        
        $roles = Role::find($request->roles);
        $permission->syncRoles($roles);

        return new PermissionResource($permission);
    }

    public function destroy(Permission $permission): Response
    {
        $this->authorize('delete', $permission);

        $permission->delete();

        return response()->noContent();
    }
}
