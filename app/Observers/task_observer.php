<?php

namespace App\Observers;

use App\Models\activity_logs;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class task_observer
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
$username = Auth::user()?->username ?? Auth::user()?->user_name ?? 'System';
        $projectTitle = $task->project?->title ?? 'Unknown Project';
        $project_id =$task->project_id ?? null ;
        activity_logs::create([
            'action' =>'Create',
            'description' =>"$username Created New Task: $task->title in Project: $projectTitle" ,
            'task_id'   =>$task->id,
            'user_id'=>Auth::id(),
            'project_id'=>$project_id,
            ]);
            }
            
            /**
             * Handle the Task "updated" event.
            */
            public function updated(Task $task): void
            {       
        $username = Auth::user()?->username ?? 'System';
        $projectTitle = $task->project?->title ?? 'Unknown Project';
            $project_id =$task->project_id;
            $project =Project::where('project_id',$project_id);

            $changes = $task->getChanges();
            unset($changes['updated_at']);
            foreach( $changes as $field => $new_values)
                {
                    $old_values =$task->getOriginal($field);
                if($new_values != $old_values)
                    {
                activity_logs::create([
                'action' =>"Update in Project $projectTitle Task: $task->title",
                'description' => "$username updated $field From: {$old_values} to {$new_values}" ,
                'task_id'   =>$task->id,
                'user_id'=>Auth::id(),
                'project_id'=>$project_id,
    ]);
                    }
                }
            

            }
            
            /**
     * Handle the Task "deleted" event.
            */
            public function deleting(Task $task): void
            {

            $username = Auth::user()?->username ?? 'System';
            $projectTitle = $task->project?->title ?? 'Unknown Project';
            $task_id =$task->id;


                $project_id =$task->project_id;
                $project =Project::where('project_id',$project_id);
                activity_logs::create([
                    'action' =>'Delete',
                    'description' => "{$username} deleted task: '{$task->title}' from project: '{$projectTitle}'", 
                    'task_id'   =>$task_id,
                    'user_id'=>Auth::id(),
                    'project_id'=>$project_id,

                ]);
        
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        //
    }
}
