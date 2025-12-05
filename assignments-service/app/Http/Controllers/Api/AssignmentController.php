<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Assignment;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class AssignmentController extends Controller
{
    public function index()
    {
        return response()->json(Assignment::all());
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'title' => 'required|string|max:255',
        //     'description' => 'nullable|string',
        // ]);

        // $assignment = Assignment::create([
        //     'title' => $request->input('title'),
        //     'description' => $request->input('description'),
        // ]);
        // return response()->json($assignment, 201);

        // Validate User exists
        $user = Http::get("http://users-service:8000/api/users/" . $request->user_id);
        // dd($user);
        if ($user->failed()) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Validate Task exists
        $task = Http::get("http://tasks-service:8000/api/tasks/" . $request->task_id);
        if ($task->failed()) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        $assignment = Assignment::create([
            'user_id' => $request->user_id,
            'task_id' => $request->task_id,
        ]);

        return response()->json($assignment, 201);
    }

    // public function assign(Request $request)
    // {
    //     // Validate User exists
    //     $user = Http::get("http://users-service:8001/api/users/" . $request->user_id);
    //     if ($user->failed()) {
    //         return response()->json(['error' => 'User not found'], 404);
    //     }

    //     // Validate Task exists
    //     $task = Http::get("http://tasks-service:8002/api/tasks/" . $request->task_id);
    //     if ($task->failed()) {
    //         return response()->json(['error' => 'Task not found'], 404);
    //     }

    //     return Assignment::create([
    //         'user_id' => $request->user_id,
    //         'task_id' => $request->task_id,
    //     ]);
    // }

    public function show($id)
    {
        return response()->json(Assignment::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
        ]);

        $assignment = Assignment::findOrFail($id);
        $assignment->update($request->only(['title', 'description']));

        return response()->json($assignment);
    }

    public function destroy($id)
    {
        $assignemnt = Assignment::find($id);

        if (!$assignemnt) {
            return response()->json(['message' => 'Assignemnt not found'], 404);
        }

        $assignemnt->delete();

        return response()->json(['message' => 'Assignemnt deleted successfully']);
    }
}
