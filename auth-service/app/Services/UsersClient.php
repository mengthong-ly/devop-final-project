<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class UsersClient
{
    protected Client $client;
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl =  'http://users-service:8000';

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout'  => 5,
        ]);
    }

    public function getByEmail(string $email)
    {
        try {
            // dd($email);
            $response = $this->client->post('/api/user-by-email', [
                'query' => ['email' => $email]
            ]);


            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return null;
        }
    }


    public function createUser(array $payload)
    {
        try {
            $response = $this->client->post('/api/users', [
                'json' => $payload
            ]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return null;
        }
    }
}
