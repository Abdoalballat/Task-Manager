<?php

namespace App\Http\Controllers;
use App\Http\Requests\project_valedate;
use App\Models\activity_logs;
use App\Models\login;
use App\Models\Project
;
use Illuminate\Http\Request;
use View;

class ProjectController extends Controller
{
    public function index(Request $request)
{
    $query = Project::query();

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('title', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%");
        });
    }

    $projects = $query->latest()->get();

    return view('projects.index', compact('projects'));
}
    
    public function store(project_valedate $request)
    {
        $project= Project::create($request->validated());
        return redirect()->route('projects.index')->with('success',"project has been created");
        // return response()->json($project,201);
    
    }
    public function create()
    {
        return view('projects.create');
    }
public function show(Project $project)
{
    $tasks = $project->tasks;
    $users = login::all();

    $logs = activity_logs::where('project_id', $project->id)
        ->latest()
        ->get();

    return view('projects.show', compact('project', 'tasks', 'users', 'logs'));
}
    public function destroy(Project $project )
    {   
        // $projects = $project->findOrFail($project);
        $project->delete();
        // return response()->json('"Deleted"',204);
        return redirect()->route('projects.index')->with('success',"Project has been deleted");
    }
}

