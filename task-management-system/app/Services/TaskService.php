<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Collection;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Services\UserService;

class TaskService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://tasks-service:8000', // task-service port
            'timeout'  => 5.0,
        ]);
    }

    private function headers(string $token): array
    {
        return [
            'Authorization' => "Bearer {$token}",
            'Accept'        => 'application/json'
        ];
    }

    /** GET /tasks */
    public function getAllTasks(string $token): Collection
    {
        try {
            $response = $this->client->get('/api/tasks', [
                'headers' => $this->headers($token)
            ]);

            $data = json_decode($response->getBody(), true);
            $data = $data['data'] ?? $data;

            // hydrate tasks
            $tasks = Task::hydrate($data);

            return $tasks;
        } catch (RequestException $e) {
            throw new \Exception("Failed to load tasks: " . $e->getMessage());
        }
    }

    /** GET /tasks/{id} */
    public function getTaskById(string $token, int $id): ?Task
    {
        try {
            $response = $this->client->get("/api/tasks/$id", [
                'headers' => $this->headers($token)
            ]);

            $data = json_decode($response->getBody(), true);

            // hydrate single task
            $task = Task::hydrate([$data])->first();

            // attach related users
            $user_ids = $data['user_ids'] ?? [];
            $users = [];

            if (!empty($user_ids)) {
                $userService = new UserService();

                foreach ($user_ids as $user_id) {
                    try {
                        $user = $userService->getUserById($token, $user_id);
                        if ($user) {
                            $users[] = $user;
                        }
                    } catch (\Exception $e) {
                        logger()->warning("Failed to fetch user {$user_id} for task {$id}: " . $e->getMessage());
                    }
                }
            }

            // Attach users to the task
            $task->users = $users;

            return $task;
        } catch (RequestException $e) {
            return null;
        }
    }

    /** POST /tasks */
    public function createTask(string $token, array $payload): Task
    {
        try {
            $response = $this->client->post('/api/tasks', [
                'headers' => $this->headers($token),
                'json'    => $payload
            ]);

            $data = json_decode($response->getBody(), true);

            $task = Task::hydrate([$data])->first();
            $task->users = $data['users'] ?? [];

            return $task;
        } catch (RequestException $e) {
            throw new \Exception("Failed to create task: " . $e->getMessage());
        }
    }

    /** PUT /tasks/{id} */
    public function updateTask(string $token, int $id, array $payload): Task
    {
        try {
            $response = $this->client->put("/api/tasks/$id", [
                'headers' => $this->headers($token),
                'json'    => $payload
            ]);

            $data = json_decode($response->getBody(), true);

            $task = Task::hydrate([$data])->first();
            $task->users = $data['users'] ?? [];

            return $task;
        } catch (RequestException $e) {
            throw new \Exception("Failed to update task: " . $e->getMessage());
        }
    }

    /** DELETE /tasks/{id} */
    public function deleteTask(string $token, int $id): bool
    {
        try {
            $response = $this->client->delete("/api/tasks/$id", [
                'headers' => $this->headers($token)
            ]);

            return $response->getStatusCode() === 204;
        } catch (RequestException $e) {
            return false;
        }
    }

    /** Many-to-many relationship */
    public function getTasksForUser(string $token, int $userId): Collection
    {
        try {
            $response = $this->client->get("/api/users/$userId/tasks", [
                'headers' => $this->headers($token)
            ]);

            $data = json_decode($response->getBody(), true);
            $data = $data['data'] ?? $data;

            $tasks = Task::hydrate($data);

            foreach ($tasks as $index => $task) {
                $task->users = $data[$index]['users'] ?? [];
            }

            return $tasks;
        } catch (RequestException $e) {
            throw new \Exception("Failed to load user tasks");
        }
    }

    /** Assign users to task */
    public function assignUsersToTask(string $token, int $taskId, array $userIds): bool
    {
        try {
            $response = $this->client->post("/api/tasks/$taskId/assign", [
                'headers' => $this->headers($token),
                'json'    => ['user_ids' => $userIds],
            ]);

            $notificationService = new NotificationService();

            foreach ($userIds as $user_id) {
                $notificationService->sendNotification($token, message: "You have been assigned a new task with ID: {$taskId}", title: 'New Task Assigned', userId: $user_id, type: 'task_assignment', taskId: $taskId);
            }

            return $response->getStatusCode() === 200;
        } catch (RequestException $e) {
            return false;
        }
    }

    public function unassignUsersFromTask(string $token, int $taskId, int $user_id): bool
    {
        try {
            $response = $this->client->post("/api/tasks/$taskId/unassign", [
                'headers' => $this->headers($token),
                'json'    => ['user_id' => $user_id],
            ]);

            $notificationService = new NotificationService();

            $notificationService->sendNotification($token, message: "You have been Unassigned from task with ID: {$taskId}", title: 'Remove From Task', userId: $user_id, type: 'task_assignment', taskId: $taskId);

            return $response->getStatusCode() === 200;
        } catch (RequestException $e) {
            logger()->error("Unassign failed: " . $e->getMessage());
            return false;
        }
    }
}
