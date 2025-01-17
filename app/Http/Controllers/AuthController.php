<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function create_user(RegisterRequest $request, $role) {
        try {
            $data = $request->validated();
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            if (!$user) {
                return response()->json([
                    'message' => 'User registration failed. Please try again after some time'
                ], 400);
            }

            $this->assign_role($user, $role);
            return response()->json([
                'message' => 'User registration successful',
                'data' => $user
            ], 200);
        } catch(Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    private function assign_role(User $user, $roleName)
    {
        try {
            $role = Role::where('name', $roleName)->first();

            if (!$role) {
                throw new \Exception("Role '$roleName' not found.");
            }

            $user->roles()->attach($role);

        } catch (Throwable $e) {
            throw $e;
        }
    }
    
    public function login(LoginRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();           

            // Check if user exists and password is correct
            $user = User::where('email', $data['email'])->first();

            if (!$user || !Hash::check($data['password'], $user->password)) {
                DB::rollBack();
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            // Generate a new personal access token
            $tokenName = env('APP_NAME'). ":".$user->id;
            $token = $user->createToken($tokenName)->plainTextToken;
            // Retrieve the roles for the user
            $role_name = $user->roles()->first()->name; 
            DB::commit();

            return response()->json([
                'message' => 'Login successful',
                'data' => array_merge($user->toArray(), ['token' => $token, 'role' => $role_name])
            ]);

        } catch (Throwable $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

}
