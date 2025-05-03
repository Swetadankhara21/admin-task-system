<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['assignedTo', 'assignedBy'])->get();
        return view('tasks.index', compact('tasks'));
    }
    public function dashboard()
    {
        return view('welcome');
    }

    public function create()
    {
        $users = User::where('role', 'admin')->get(); // Fetch only admins
        return view('tasks.create', compact('users')); // Pass as $users
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'assigned_to' => 'required|exists:users,id|in:' . implode(',', User::where('role', 'admin')->pluck('id')->toArray()),
        ]);

        Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'assigned_to' => $validated['assigned_to'],
            'assigned_by' => auth()->id(),
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task Assigned');
    }

    public function myTasks()
    {
        $tasks = Task::where('assigned_to', auth()->id())->get();
        return view('tasks.my', compact('tasks'));
    }

    public function markDone(Task $task)
    {
        if ($task->assigned_to !== auth()->id()) {
            abort(403);
        }

        $task->is_done = true;
        $task->save();

        return redirect()->route('tasks.my')->with('success', 'Task marked as done');
    }

    public function user()
    {
        $assignedIds = auth()->user()->assigned_admins;
        if ($assignedIds) {
            $assignedIdsArray = explode(',', $assignedIds);

            $admins = User::whereIn('id', $assignedIdsArray)->get();
        } else {
            $admins = collect(); 
        }
        return view('admins.indexs', compact('admins'));
    }
    public function user_task()
    {
        $assignedIds = auth()->user()->assigned_admins;

        if ($assignedIds) {
            $assignedIdsArray = explode(',', $assignedIds);
        
            $tasks = Task::with(['assignedTo', 'assignedBy'])
                ->whereIn('assigned_to', $assignedIdsArray)
                ->get();
        } else {
            $tasks = collect(); 
        }
        
        return view('tasks.index', compact('tasks'));
        
    }
    
}
