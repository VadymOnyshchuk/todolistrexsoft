<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Mail\Mailer;
use App\Task;
use App\Repositories\TaskRepository;
class TaskController extends Controller
{
    protected $tasks;

    public function __construct(TaskRepository $tasks)
    {
        $this->middleware('auth');

        $this->tasks = $tasks;
    }

    public function index(Request $request)
    {
        return view('tasks.index', [
            'tasks' => $this->tasks->forUser($request->user()),
        ]);
    }

    public function indexMyTasks(Request $request)
    {
        return view('tasks.myTasks', [
            'tasks' => $this->tasks->forUser($request->user()),
        ]);
    }
    public function mail(Request $request, Mailer $mailer  )
    {
        $mailer
            ->to($request->input('receiver'))
            ->send(new \App\Mail\notification($request->input('name')));
        return redirect()->back();
    }
    public function store(Request $request,Mailer $mailer)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'receiver' => 'required|max:255',
        ]);

        $request->user()->tasks()->create([
            'name' => $request->name,
            'receiver' => $request->receiver,
        ]);
$this->mail($request,$mailer);
        return redirect('/tasks');
    }

    public function destroy(Request $request, Task $task)
    {
       // $this->authorize('destroy', $task);

        $task->delete();

        return redirect('/tasks');
    }
}
