<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TaskUser;
use Illuminate\Support\Facades\DB;

class TaskUserController extends Controller
{
    public function users($taskId)
    {
        $task = Task::find($taskId);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $userIds = DB::table('task_user')
            ->where('task_id', $taskId)
            ->pluck('user_id')
            ->toArray();

        return response()->json(['user_ids' => $userIds]);
    }

    // List all tasks assigned to a user
    public function tasksByUser($userId)
    {
        $taskIds = DB::table('task_user')
            ->where('user_id', $userId)
            ->pluck('task_id')
            ->toArray();

        $tasks = Task::whereIn('id', $taskIds)->get();

        // Add user_ids to each task
        foreach ($tasks as $task) {
            $task->user_ids = DB::table('task_user')
                ->where('task_id', $task->id)
                ->pluck('user_id')
                ->toArray();
        }

        return response()->json($tasks);
    }

    // Assign users to a task
    public function assign(Request $request, $taskId)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'integer'
        ]);

        $task = Task::find($taskId);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        // Add new assignments (without detaching existing ones)
        foreach ($request->user_ids as $userId) {
            DB::table('task_user')->updateOrInsert(
                ['task_id' => $taskId, 'user_id' => $userId],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }

        // Get updated user_ids
        $task->user_ids = DB::table('task_user')
            ->where('task_id', $taskId)
            ->pluck('user_id')
            ->toArray();

        return response()->json([
            'message' => 'Users assigned successfully',
            'task' => $task
        ]);
    }

    // Unassign users from a task
    public function unassign(Request $request, $taskId)
    {
        $request->validate([
            'user_id' => 'required|integer'
        ]);

        $task = Task::find($taskId);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        DB::table('task_user')
            ->where('task_id', $taskId)
            ->where('user_id', $request->user_id)
            ->delete();

        // Get updated user_ids
        $userIds = DB::table('task_user')
            ->where('task_id', $taskId)
            ->pluck('user_id')
            ->toArray();

        return response()->json([
            'message' => 'User removed successfully',
            'user_ids' => $userIds
        ]);
    }
}
