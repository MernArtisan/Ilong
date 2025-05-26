<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function assign(Request $request)
    {
        try {
            $request->validate([
                'role_id' => 'required|exists:roles,id',
                'permissions' => 'required|array',
                'permissions.*' => 'exists:permissions,id',
            ]);

            $role = Role::find($request->role_id);

            $role->permissions()->syncWithoutDetaching($request->permissions);

            $roleWithPermissions = $role->load('permissions:id,name');

            return response()->json([
                'status' => 200,
                'message' => 'Permissions assigned successfully.',
            ]);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }


    public function remove(Request $request)
    {
        try {
            $request->validate([
                'role_id' => 'required|exists:roles,id',
                'permissions' => 'required|array',
                'permissions.*' => 'exists:permissions,id',
            ]);
            $role = Role::find($request->role_id);
            $role->permissions()->detach($request->permissions);
            return response()->json([
                'status' => 200,
                'message' => 'Permissions removed successfully.'
            ]);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
