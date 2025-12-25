<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();

        // Add user_ids to each task
        foreach ($tasks as $task) {
            $task->user_ids = DB::table('task_user')
                ->where('task_id', $task->id)
                ->pluck('user_id')
                ->toArray();
        }

        return response()->json($tasks);
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task = Task::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'status' => $request->input('status', 'pending'),
        ]);

        return response()->json($task, 201);
    }

    public function show($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        // Add user_ids to the task
        $task->user_ids = DB::table('task_user')
            ->where('task_id', $task->id)
            ->pluck('user_id')
            ->toArray();

        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task->update($request->only(['title', 'description', 'status']));

        // Add user_ids to the updated task
        $task->user_ids = DB::table('task_user')
            ->where('task_id', $task->id)
            ->pluck('user_id')
            ->toArray();

        return response()->json($task);
    }

    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }

    public function assignUsers(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'required|integer',
        ]);

        // Remove existing assignments
        DB::table('task_user')->where('task_id', $task->id)->delete();

        // Add new assignments
        foreach ($request->user_ids as $userId) {
            DB::table('task_user')->insert([
                'task_id' => $task->id,
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Return task with updated user_ids
        $task->user_ids = $request->user_ids;
        return response()->json($task);
    }

    public function removeUser(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $request->validate([
            'user_id' => 'required|integer',
        ]);

        DB::table('task_user')
            ->where('task_id', $task->id)
            ->where('user_id', $request->user_id)
            ->delete();

        // Return task with updated user_ids
        $task->user_ids = DB::table('task_user')
            ->where('task_id', $task->id)
            ->pluck('user_id')
            ->toArray();

        return response()->json($task);
    }
}
