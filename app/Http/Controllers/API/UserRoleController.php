<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function assign(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'role_ids' => 'required|array',
                'role_ids.*' => 'exists:roles,id',
            ]);

            $user = User::find($request->user_id);
            $roleIds = $request->role_ids;
            $alreadyAssignedRoles = $user->roles()->whereIn('role_id', $roleIds)->pluck('role_id')->toArray(); // Get the existing role IDs assigned to the user and convert it to an array $alreadyAssignedRoles = $user->roles()->pluck('role_id')->toArray();
            $newRoleIds = array_diff($roleIds, $alreadyAssignedRoles);
            if (empty($newRoleIds)) {
                return response()->json([
                    'message' => 'All roles are already assigned to user'
                ]);
            }
            $user->roles()->attach($newRoleIds);
            $assignedRoleNames = Role::whereIn('id', $newRoleIds)->pluck('name')->toArray();
            return response()->json([
                'status' => 200,
                'message' => 'Roles assigned successfully',
                'assigned_roles_ids' => $newRoleIds,
                'assigned_roles_names' => $assignedRoleNames,
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                "error" => $exception->getMessage()
            ], 400);
        }
    }

    public function remove(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'role_ids' => 'required|array',
                'role_ids.*' => 'exists:roles,id',
            ]);

            $user = User::find($request->user_id);
            $roleIds = $request->role_ids;
            $user->roles()->detach($roleIds);
            return response()->json([
                'status' => 200,
                'message' => 'Roles removed successfully',
                'role_ids_removed' => $roleIds,
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                "error" => $exception->getMessage()
            ], 400);
        }
    }
}
