<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Task;
use Illuminate\Support\Collection;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;

class NotificationService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://notifications-service:8000', // Notification-service port
            'timeout'  => 5.0,
        ]);
    }

    private function headers(string $token): array
    {
        return [
            'Authorization' => "Bearer {$token}",
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json'
        ];
    }

    /** GET /notifications */
    public function getAllNotifications(string $token): Collection
    {
        try {
            $response = $this->client->get('/api/notifications', [
                'headers' => $this->headers($token)
            ]);
            $data = json_decode($response->getBody(), true);
            $data = $data['data'] ?? $data;

            // hydrate notifications
            $notifications = Notification::hydrate($data);

            return $notifications;
        } catch (ConnectException $e) {
            // Service is not available, return empty collection
            Log::warning('Notification service unavailable: ' . $e->getMessage());
            return collect();
        } catch (RequestException $e) {
            // Other HTTP errors, return empty collection
            Log::error('Failed to load notifications: ' . $e->getMessage());
            return collect();
        }
    }

    // Post Send Notifications
    public function sendNotification(string $token, string $message, string $title, int $userId, string $type, int $taskId)
    {
        try {
            $response = $this->client->post('/api/notifications', [
                'headers' => $this->headers($token),
                'json'    => [
                    'user_id' => $userId,
                    'task_id' => $taskId,
                    'title' => $title,
                    'message' => $message,
                    'type' => $type,
                    'is_read' => false
                ],
            ]);

            $notification = Notification::hydrate(json_decode($response->getBody(), true));

            return $notification;
        } catch (ConnectException $e) {
            // Service is not available, log and return false
            Log::warning('Notification service unavailable for sending: ' . $e->getMessage());
            return false;
        } catch (RequestException $e) {
            // Other HTTP errors, log and return false
            Log::error('Failed to send notification: ' . $e->getMessage());
            return false;
        }
    }
}
