<?php

namespace App\Http\Controllers;

use App\Http\Requests\task_validate;
use App\Mail\TaskAssignedMail;
use App\Models\login;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TaskController extends Controller
{  

    public function my_tasks()
    {
        $tasks = Task::where('user_id',Auth::id())->with('project')->latest()->get();
        $counts = [
        'all'         => $tasks->count(),
        'pending'     => $tasks->where('status', 'pending')->count(),
        'in_progress' => $tasks->where('status', 'in_progress')->count(),
        'completed'   => $tasks->where('status', 'completed')->count(),
    ];
        return view('projects.my_tasks',compact('tasks','counts'));
    }
    public function create()
    {
        return view('projects.create');
    }

    public function store(task_validate $request, Project $project)
    {
    
        $task = $project->tasks()->create($request->validated());

        $employee =login::find($request->user_id);

        if ($employee && $employee->email) {
        Mail::to($employee->email)->send(new TaskAssignedMail($task)); 
        }
        return redirect()->route('projects.show',$project)->with('success',"Task has Added and email sent .");
    }
    public function destroy(Task $task)
    {
        $project_id= $task->project_id;
        $task->delete();
        return redirect()->route('projects.show',$project_id)->with('success',"task has been deleted");
    }
    public function update(Task $task ,request $request)
    {
        $project_id=$task->project_id;
        $task->update($request->validate([
            'status'=> ['sometimes', 'string', 'in:pending,in_progress,completed'],
        ]));
        if(Auth::user()->role ==='admin'){
        return redirect()->route('projects.show',$project_id)->with('success',"task has been Updated");
        }
        else
            {
                return redirect()->route('my_tasks')->with('success','task has been updated');
            }
    }
}
