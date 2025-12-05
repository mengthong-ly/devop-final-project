<?php

namespace App\Services;

use App\Models\User; // Eloquent model for hydration
use Illuminate\Support\Collection;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class UserService
{
    private Client $client;
    private string $baseUrl;

    public function __construct()
    {
        // Correct base URL — no /users here
        $this->baseUrl = 'http://users-service:8000';

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout'  => 5.0,
        ]);
    }

    private function headers(string $token): array
    {
        return [
            'Authorization' => "Bearer {$token}",
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
        ];
    }

    /**
     * GET /users
     */
    public function getAllUsers(string $token): Collection
    {
        try {
            $response = $this->client->get('/api/users', [
                'headers' => $this->headers($token)
            ]);

            $data = json_decode($response->getBody(), true);

            return User::hydrate($data);
        } catch (RequestException $e) {
            dd($e->getMessage());
            logger()->error("UserService::getAllUsers → " . $e->getMessage());
            throw new \Exception("Failed to fetch users");
        }
    }

    /**
     * GET /users/{id}
     */
    public function getUserById(string $token, int $id): User|null
    {
        try {
            $response = $this->client->get("/api/users/{$id}", [
                'headers' => $this->headers($token)
            ]);

            $data = json_decode($response->getBody(), true);

            return User::hydrate([$data])->first();
        } catch (RequestException $e) {
            logger()->error("UserService::getUserById → " . $e->getMessage());
            return null;
        }
    }

    /**
     * POST /users
     */
    public function createUser(string $token, array $payload): User
    {
        try {
            $response = $this->client->post('/api/users', [
                'headers' => $this->headers($token),
                'json'    => $payload,
            ]);

            $data = json_decode($response->getBody(), true);

            return User::hydrate([$data])->first();
        } catch (RequestException $e) {
            logger()->error("UserService::createUser → " . $e->getMessage());
            throw new \Exception("Failed to create user");
        }
    }

    /**
     * PUT /users/{id}
     */
    public function updateUser(string $token, int $id, array $payload): User|null
    {
        try {
            $response = $this->client->put("/api/users/{$id}", [
                'headers' => $this->headers($token),
                'json'    => $payload,
            ]);

            $data = json_decode($response->getBody(), true);

            return User::hydrate([$data])->first();
        } catch (RequestException $e) {
            logger()->error("UserService::updateUser → " . $e->getMessage());
            throw new \Exception("Failed to update user");
        }
    }

    /**
     * DELETE /users/{id}
     */
    public function deleteUser(string $token, int $id): bool
    {
        try {
            $response = $this->client->delete("/api/users/{$id}", [
                'headers' => $this->headers($token)
            ]);

            return $response->getStatusCode() === 204;
        } catch (RequestException $e) {
            logger()->error("UserService::deleteUser → " . $e->getMessage());
            return false;
        }
    }
}
