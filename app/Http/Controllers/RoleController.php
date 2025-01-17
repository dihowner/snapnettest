<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function assignRole(User $user, Request $request)
    {
        try {
            $role = Role::find($request->role_id);
            if (!$role) {
                return response()->json(['message' => 'Role not found'], 400);
            }
            $user->roles()->attach($role);
            return response()->json(['message' => 'Role assigned successfully'], 200);
        } catch (Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function removeRole(User $user, Request $request)
    {
        try {
            $role = Role::find($request->role_id);
            if (!$role) {
                return response()->json(['message' => 'Role not found'], 400);
            }
            $user->roles()->detach($role);
            return response()->json(['message' => 'Role removed successfully'], 200);
        } catch (Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
