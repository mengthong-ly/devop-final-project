<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use App\Services\TaskService;
use App\Services\UserService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    private string $token;

    public function __construct(private TaskService $taskService, private UserService $userService, private NotificationService $notificationService)
    {
        $this->token = session('api_token');
    }

    public function index()
    {
        $notificationService = $this->notificationService;
        $notifications = $notificationService->getAllNotifications($this->token);
        return view('admin.notifications.index', compact('notifications'));
    }

    public function show($id)
    {
        // Implementation for showing a specific notification will go here
    }
    public function create()
    {
        // Implementation for creating a notification will go here
    }

    public function store(Request $request)
    {
        // Implementation for storing a new notification will go here
    }

    public function edit($id)
    {
        // Implementation for editing a notification will go here
    }

    public function update(Request $request, $id)
    {
        // Implementation for updating a notification will go here
    }

    public function destroy($id)
    {
        // Implementation for deleting a notification will go here
    }
}
