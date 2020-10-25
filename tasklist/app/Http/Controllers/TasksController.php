<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TasksController extends Controller
{
    public function index($concluded = null) {
        $tasks = null;
        if (!is_null($concluded)) {
            if($concluded == 'concluded') {
                $tasks = auth()->user()->tasks->where('is_concluded', 1);
            } elseif($concluded == 'unconcluded') {
                $tasks = auth()->user()->tasks->where('is_concluded', 0);
            }
        } else {
            $tasks = auth()->user()->tasks()->get();
        }

        return view('dashboard')->with('tasks', $tasks);
    }

    public function conclude(Task $task)
    {
        $activity = new ActivityLog();
        $activity->user_id = auth()->user()->id;

        if ($task->is_concluded == false) {
            $task->is_concluded = 1;
            $task->perc_done = 100;

            $activity->type_activity = "Conclusion";
            $activity->activity = "Task com nome " . $task->name . " concluida às " . Carbon::now();
            $activity->save();

        } else {
            //reabrir
            $task->is_concluded = 0;
            $task->perc_done = 0;

            $activity->type_activity = "Conclusion";
            $activity->activity = "Task com nome " . $task->name . " reaberta às " . Carbon::now();
            $activity->save();
        }
        $task->save();

        return redirect('/dashboard');

    }

    public function add() {
        return view('add');
    }

    public function create(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'final_date' => 'required|after:now'
        ]);
        $task = new Task();
        $task->name = $request->name;
        $task->final_date = $request->final_date;
        $task->user_id = auth()->user()->id;
        $task->save();

        $activity = new ActivityLog();
        $activity->user_id = auth()->user()->id;
        $activity->type_activity = "Create";
        $activity->activity = "Task com nome " . $task->name . " criada às " . Carbon::now();
        $activity->save();

        return redirect('/dashboard');
    }

    public function edit(Task $task) {
        if (auth()->user()->id == $task->user_id) {
            return view('edit', compact('task'));
        } else {
            return redirect('/dashboard');
        }
    }

    public function update(Request $request, Task $task)
    {
        if (isset($_POST['delete'])) {
            $activity = new ActivityLog();
            $activity->user_id = auth()->user()->id;
            $activity->type_activity = "Delete";
            $activity->activity = "Task com nome " . $task->name . " apagada às " . Carbon::now();
            $activity->save();

            $task->delete();

            return redirect('/dashboard');
        } else {
            $this->validate($request, [
                'name' => 'required',
                'perc_done' => 'numeric|between:0,100',
                //'final_date' => 'after:now'
            ]);
            $task->name = $request->name;
            $task->final_date = $request->final_date;
            $task->perc_done = $request->perc_done;
            $task->save();

            $activity = new ActivityLog();
            $activity->user_id = auth()->user()->id;
            $activity->type_activity = "Edit";
            $activity->activity = "Task com nome " . $task->name . " editada às " . Carbon::now();
            $activity->save();

            return redirect('/dashboard');
        }
    }
}
