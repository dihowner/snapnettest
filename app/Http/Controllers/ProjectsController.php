<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeReqeust;
use Throwable;
use App\Models\Projects;
use App\Http\Requests\ProjectRequest;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $projects = Projects::latest()->orderBy('id', 'desc')->get();
            return response()->json([
                'message' => 'Projects retrieved successfully', 'data' => $projects
            ], 200);
        } catch(Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function deleted_projects()
    {
        try {
            $deleted_projects = Projects::onlyTrashed()->latest()->orderBy('id', 'desc')->get();
            return response()->json([
                'message' => 'Deleted Employees retrieved successfully', 'data' => $deleted_projects
            ], 200);
        } catch(Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {
        try {
            $project = Projects::create($request->validated());
            return response()->json(['message' => 'Project created successfully', 'data' => $project], 200);
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
            $project = Projects::find($id);
            if (!$project) {
                return response()->json(['message' => 'Project not found'], 400);
            }
            return response()->json(['message' => 'Project retrieved successfully', 'data' => $project], 200);
        } catch(Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, $id)
    {
        try {
            $project = Projects::find($id);
            if (!$project) {
                return response()->json(['message' => 'Project not found'], 400);
            }
            $is_updated = $project->update($request->all());
            if ($is_updated) {
                return response()->json(['message' => 'Project updated successfully'], 200);
            }
            return response()->json(['message' => 'Project not updated'], 400);
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
            $project = Projects::find($id);
    
            if (!$project) {
                return response()->json(['message' => 'Project not found'], 404);
            }
        
            $project->delete();
            return response()->json(['message' => 'Project deleted successfully']);
        } catch(Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function addEmployeeToProject(EmployeeReqeust $request, $projectId)
    {
        try {
            $project = Projects::find($projectId);
    
            if (!$project) {
                return response()->json(['message' => 'Project not found'], 404);
            }

            $employee = $project->employees()->create($request->all());

            return response()->json([
                'message' => 'Employee added to project and email sent successfully!',
                'data' => array_merge($employee->toArray(), $project->toArray()),
            ], 200);
        } catch(Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
