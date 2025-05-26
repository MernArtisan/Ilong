<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        try {
            $roles = Role::select('id', 'name','description')->get();
            return response()->json([
                'status' => 200,
                'data' => $roles,
                'Message' => 'Roles fetched successfully'
            ]);
        } catch (Exception $exception) {
            return response()->json([
                "error" => $exception->getMessage()
            ], 400);
        }
    }
    public function create(Request $request,$id){
        try{
            $request->validate([
                "name" => 'required|string|max:255,unique:roles,name',
                "description" => 'required|string|max:255',
            ]);

            $role = Role::create([
                'name'=> $request->name,
                'description'=> $request->description,
            ]);
            return response()->json([
                "status" => 201,
                "data" => $role,
                "message" => "Role created successfully"
            ]);
        }catch(Exception $exception){
            return response()->json([
                "error" => $exception->getMessage()
            ], 400);
        }
    }
    public function update(Request $request, $id){
        try{
            $request->validate([
                "name"=> "required|string|max:255",
                "description"=> "required|string|max:255",
            ]);

            $role = Role::findOrFail($id);
            $role->update($request->all());


            return response()->json([
                "status" => 200,
                "data" => $role,
                "message" => "Role updated successfully"
            ]);

        }catch(Exception $exception){
            return response()->json([
                "error" => $exception->getMessage()
            ], 400);
        }
    }
    public function delete($id){
        try{
            $role = Role::findOrFail($id);
            $role->delete();
            return response()->json([
                "status" => 200,
                "message" => "Role deleted successfully"
            ]);
        }catch(Exception $exception){
            return response()->json([
                "error" => $exception->getMessage()
            ], 400);
        }
    }
}
