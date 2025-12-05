<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TaskService;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Services\UserService;

class TaskController extends Controller
{
    private string $token;

    public function __construct(private TaskService $taskService, private UserService $userService)
    {
        $this->token = session('api_token');
    }

    public function index()
    {
        $tasks = $this->taskService->getAllTasks($this->token);

        return view('tasks.index', compact('tasks'));
    }

    public function show($id)
    {
        $task = $this->taskService->getTaskById($this->token, $id);

        return view('tasks.show', compact('task'));
    }

    public function create()
    {
        return view('tasks.create', ['task' => new Task()]);
    }

    public function store(Request $request)
    {
        $payload = $request->validate([
            'title'       => 'required',
            'description' => 'nullable',
            'status'      => 'required',
            'due_date'    => 'nullable|date'
        ]);

        $this->taskService->createTask($this->token, $payload);

        return redirect()->route('admin.tasks.index')->with('success', 'Task created');
    }

    public function edit($id)
    {
        $task = $this->taskService->getTaskById($this->token, $id);

        // Fetch all users for assignment UI
        $allUsers = $this->userService->getAllUsers($this->token);

        // Attach all users to task object for modal
        $task->all_users = $allUsers;

        return view('tasks.edit', compact('task'));
    }


    public function update(Request $request, $id)
    {
        $payload = $request->validate([
            'title'       => 'required',
            'description' => 'nullable',
            'status'      => 'required',
            'due_date'    => 'nullable|date'
        ]);

        $this->taskService->updateTask($this->token, $id, $payload);

        return redirect()->route('admin.tasks.index')->with('success', 'Task updated');
    }

    public function destroy($id)
    {
        $this->taskService->deleteTask($this->token, $id);

        return redirect()->route('admin.tasks.index')->with('success', 'Task deleted');
    }

    /** Many-to-many */
    public function tasksByUser($userId)
    {
        $tasks = $this->taskService->getTasksForUser($this->token, $userId);

        return view('tasks.user-tasks', compact('tasks'));
    }

    public function assign(Request $request, $taskId)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'integer'
        ]);

        $success = $this->taskService->assignUsersToTask($this->token, $taskId, $request->user_ids);

        if (!$success) {
            return back()->with('error', 'Failed to assign users.');
        }

        return back()->with('success', 'Users assigned successfully.');
    }

    public function checkAuth()
    {
        if (!$this->token) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }
        return null;
    }

    public function unassign(Request $request, $taskId)
    {
        $request->validate([
            'user_id' => 'required|integer'
        ]);

        try {
            $response = $this->taskService->unassignUsersFromTask($this->token, $taskId, $request->user_id);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to remove users: ' . $e->getMessage());
        }

        return back()->with('success', 'Users removed successfully.');
    }
}
