<?php

namespace App\Services;

use App\Exceptions\PetUpdateException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class PetService implements PetServiceInterface
{
    protected string $apiUrl;
    protected Client $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->apiUrl = config('api_urls.pet');
        $this->httpClient = $httpClient;
    }

    public function getPetsByStatus($status)
    {
        $response = Http::get("{$this->apiUrl}/findByStatus", [
            'status' => $status,
        ]);

        if ($response->successful()) {
            return array_slice($response->json(), 0, 5000);
        } else {
            throw new \Exception('Failed to fetch pets.');
        }
    }

    public function createPet($data)
    {
        $response = $this->httpClient->post($this->apiUrl, [
            'json' => $data,
        ]);

        if ($response->getStatusCode() == 200) {
            return true;
        } else {
            throw new \Exception('Failed to create pet in the external API.');
        }
    }
    public function getPetById(int $id)
    {
        $response = Http::get("{$this->apiUrl}/{$id}");

        if ($response->successful()) {
            return json_decode($response->body());
        } else {
            throw new \Exception('Failed to fetch pet by ID.');
        }
    }


    public function updatePet($id, $data)
    {
        $response = $this->httpClient->put("{$this->apiUrl}", [
            'json' => $data,
        ]);


        if ($response->getStatusCode() == 200) {
            return $data;
        } else {
            throw new PetUpdateException('Failed to update pet in the external API.');
        }
    }

    public function deletePet($id)
    {
        $response = $this->httpClient->delete("{$this->apiUrl}/{$id}");

        if ($response->getStatusCode() == 200) {
            return true;
        } else {
            throw new \Exception('Failed to delete pet in the external API.');
        }
    }
}
