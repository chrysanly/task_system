<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        return view("tasks.index");
    }
    public function create()
    {
        return view("tasks.create", [
            'method' => 'POST',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
        ]);

        Task::create([
            'user_id' => $request->userId,
            'description' => $request->description,
        ]);

        return response()->json(['redirect' => route('tasks.index')]);
    }
    /**
     * Display the specified resource.
     */
    public function show(Task $tasks)
    {
        return $tasks;
    }

    public function showById(Task $task)
    {
        return $task;
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view("tasks.create", [
            'method' => 'PATCH',
            'task' => $task,
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'description' => 'required',
        ]);

        $task->update([
            'description' => $request->description
        ]);

        return response()->json(['redirect' => route('tasks.index')]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $tasks)
    {
        $tasks->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
