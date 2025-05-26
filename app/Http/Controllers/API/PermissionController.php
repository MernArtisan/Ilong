<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Exception;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        try {
            $permissions = Permission::select('id', 'name', 'description')->get();
            return response()->json([
                'status' => 200,
                'data' => $permissions,
                'message' => 'Permissions retrieved successfully',
            ]);
        } catch (Exception $exception) {
            return response()->json([
                "error" => $exception->getMessage()
            ], 400);
        }
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|max:255,unique:permissions',
                'description' => 'required|max:1000',
            ]);
            $permission = Permission::create($request->all());
            return response()->json([
                'status' => 200,
                'data' => $permission,
                'message' => 'Permissions created successfully',
            ]);
        } catch (Exception $exception) {
            return response()->json([
                "error" => $exception->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|max:255',
                'description' => 'required',
            ]);
            $permission = Permission::findOrFail($id);
            $permission->update($request->all());
            return response()->json([
                'status' => 200,
                'data' => $permission,
                'message' => 'Permissions updated successfully',
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                "error" => $exception->getMessage()
            ], 400);
        }
    }

    public function delete($id)
    {
        try {
            $permission = Permission::findOrFail($id);
            $permission->delete();
            return response()->json([
                "status" => 200,
                "data" => $permission,
                "message" => 'Permissions deleted successfully'
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                "error" => $exception->getMessage()
            ], 400);
        }
    }
}
