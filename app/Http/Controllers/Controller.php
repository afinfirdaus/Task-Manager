<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;




    public function LoginPage()
    {
        return view("Authentication.login");
    }
    public function LoginLogic(Request $request)
    {
        $incominginput = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $query = DB::table('users')->where('email', $request->email)->pluck('role');

        if (auth()->attempt(['email' => $incominginput['email'], 'password' => $incominginput['password']])) {
            $request->session()->regenerate();
            if ($query[0] == 'Manager') {
                return redirect('manager');
            } else {
                return redirect('developer');
            }
        }

        return redirect('/')->with('message', 'Email Or Password Is Wrong');
    }




    public function RegisterPage()
    {
        return view("Authentication.register");
    }
    public function RegisterLogic(Request $request)
    {
        $incominginput = $request->validate([
            'username' => ['required', 'min:2', 'max:50', Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'max:50'],
            'role' => ['required'],
        ]);

        $incominginput['password'] = bcrypt($incominginput['password']);

        User::create($incominginput);

        return redirect('/');
    }




    public function DeveloperPage()
    {
        $tasks = Task::where('developer', '=', Auth::user()->username)->get();
        return view("Developer.developer", compact('tasks'));
    }
    public function ShowTaskLogic($id)
    {
        $projectid = $id;
        $tasks = Task::where('project_id', '=', $id)->where('developer', '=', Auth::user()->username)->paginate(1);
        $currentdate = Carbon::now()->toDateString();
        $comments = Comment::all();
        return view('Developer.task', compact('tasks', 'currentdate', 'comments', 'projectid'));
    }
    public function FinishLogic($taskid)
    {
        // find the spesific task and update it
        $task = Task::find($taskid);
        $task->update(['status' => 1]);

        // find the project based on the finished task
        $project = Project::find($task->project_id);

        // total task that the developer have in the same project
        $total = count(Task::where('project_id', '=', $task->project_id)->get());

        // old value of that progress 
        $progress = $project->progress;

        // sum up the old value with the recent progress
        $result = $progress + (100 / $total);

        // and update the project progress
        $project->update(['progress' => $result]);

        return redirect()->back();
    }
    public function CommentLogic(Request $request, $id)
    {
        $data = $request->comment;

        Comment::create([
            'comment' => $data,
            'user_id' => Auth::user()->id,
            'project_id' => $id
        ]);

        return redirect()->back();
    }




    public function ManagerPage()
    {
        $projects = Project::all();
        $tasks = DB::table('tasks')
            ->join('projects', 'tasks.project_id', '=', 'projects.id')
            ->select('tasks.project_id', 'tasks.title', 'tasks.status', 'tasks.id')
            ->get();

        return view("Manager.manager", compact("projects", 'tasks'));
    }
    public function StoreProjectLogic(Request $request)
    {
        $incominginput = $request->validate([
            'title' => ['required']
        ]);

        Project::create($incominginput);

        return response()->json([
            'title' => $incominginput['title'],
            'recent' => Project::latest()->first(),
        ]);
    }
    public function AddPage($id)
    {
        $project_id = $id;
        $developers = User::where('role', 'Developer')->get();
        return view('Manager.add', compact('project_id', 'developers'));
    }
    public function AddLogic(Request $request, $id)
    {
        $incominginput = $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'deadline' => ['required', 'after:now'],
            'developer' => ['required']
        ]);

        $incominginput['project_id'] = $id;

        Task::create($incominginput);

        $project = Project::find($id);

        if ($project->progress != 0) {
            $total = Task::where('project_id', '=', $id)->count();
            $done = Task::where('status', '=', 1)->where('project_id', '=', $id)->count();
            $project->update(['progress' => ($done / $total) * 100]);
        }

        return redirect('manager');
    }
    public function EditPage($id)
    {
        $task = Task::find($id);
        $developers = User::where('role', 'developer')->get();
        return view('Manager.edit', compact('task', 'developers'));
    }
    public function EditLogic(Task $id, Request $request)
    {
        $incominginput = $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'deadline' => ['required', 'after:now'],
            'developer' => ['required']
        ]);

        $id->update($incominginput);

        return redirect()->back()->with('message', 'Update Successful');
    }
    public function DeleteLogic($id)
    {
        $task = Task::find($id);
        $task->delete();

        $done = Task::where('status', '=', 1)->where('project_id', '=', $task->project_id)->count();
        $total = Task::where('project_id', '=', $task->project_id)->count();

        $project = Project::find($task->project_id);
        $project->update(['progress' => ($done / $total) * 100]);

        return redirect('manager');
    }

    public function DeleteProjectLogic($id)
    {
        $project = Project::find($id);
        $project->delete();

        return response()->json();
    }




    public function LogoutLogic()
    {
        auth()->logout();

        return redirect("/");
    }
}
