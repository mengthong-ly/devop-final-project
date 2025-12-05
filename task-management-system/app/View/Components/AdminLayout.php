<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AdminLayout extends Component
{
    public $crumps;
    public string $token;

    /**
     * Create a new component instance.
     */
    public function __construct($crumps = [], private \App\Services\NotificationService $notificationService)
    {
        $this->crumps = $crumps;
        $this->token = session('api_token');
    }



    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $notificationService = $this->notificationService;
        $notifications = $notificationService->getAllNotifications($this->token);
        return view('layouts.admin', ['crumps' => $this->crumps, 'notifications' => $notifications]);
    }
}
