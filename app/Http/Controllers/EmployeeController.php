<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeReqeust;
use App\Models\Projects;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $employees = Employee::latest()->orderBy('id', 'desc')->get();
            return response()->json([
                'message' => 'Employees retrieved successfully', 'data' => $employees
            ], 400);
        } catch(Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function deleted_employees()
    {
        try {
            $deleted_employees = Employee::onlyTrashed()->latest()->orderBy('id', 'desc')->get();
            return response()->json([
                'message' => 'Deleted Employees retrieved successfully', 'data' => $deleted_employees
            ], 400);
        } catch(Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeReqeust $request)
    {
        try {
            $employee = Employee::create($request->validated());
            return response()->json(['message' => 'Employee created successfully', 'data' => $employee], 200);
        } catch(Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $employee = Employee::find($id);
            if (!$employee) {
                return response()->json(['message' => 'Employee not found'], 400);
            }
            return response()->json(['message' => 'Employee retrieved successfully', 'data' => $employee], 200);
        } catch(Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeReqeust $request, $id)
    {
        try {
            $employee = Employee::find($id);
            if (!$employee) {
                return response()->json(['message' => 'Employee not found'], 400);
            }
            $is_updated = $employee->update($request->all());
            if ($is_updated) {
                return response()->json(['message' => 'Employee updated successfully'], 200);
            }
            return response()->json(['message' => 'Employee not updated'], 400);
        } catch(Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $employee = Employee::find($id);
    
            if (!$employee) {
                return response()->json(['message' => 'Employee not found'], 404);
            }
        
            $employee->delete();
            return response()->json(['message' => 'Employee deleted successfully']);
        } catch(Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }
    
}
