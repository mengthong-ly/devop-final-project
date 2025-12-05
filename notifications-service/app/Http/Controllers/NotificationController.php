<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

use function Pest\Laravel\json;

class NotificationController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required',
            'title' => 'required',
            'message' => 'required',
            'type' => 'nullable'
        ]);

        $noitification = Notification::create($data);
        return response()->json($noitification);
    }
    public function index()
    {
        $noitifications =  Notification::all();
        return response()->json($noitifications);
    }

    public function getNotificationsUser($id)
    {
        $noitifications =  Notification::where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($noitifications);
    }

    public function show($id)
    {
        $notification = Notification::findOrFail($id);
        return response()->json($notification);
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['is_read' => true]);

        return response()->json(['message' => 'Marked as read']);
    }

    public function destroy($id)
    {
        Notification::destroy($id);
        return response()->json(['message' => 'Notification deleted']);
    }
}
