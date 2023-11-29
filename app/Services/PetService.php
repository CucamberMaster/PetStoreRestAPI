<?php

namespace App\Services;

use App\Exceptions\PetUpdateException;
use App\Http\Responses\ApiGetPetResponse;
use App\Models\Category;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class PetService implements PetServiceInterface
{
    protected string $apiUrl;

    public function __construct(protected Client $httpClient)
    {
        $this->apiUrl = config('api_urls.pet');
    }

    public function getPetsByStatus($status): array
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

    public function createPet($data): bool
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

    public function getPetById(int $id): ApiGetPetResponse
    {
        $response = Http::get("{$this->apiUrl}/{$id}");

        if ($response->successful()) {
            $res = $response->json();
            return new ApiGetPetResponse($res['id'], $res['category']['id'], $res['category']['name'],$res['name'], $res['status']);

        } else {
            throw new \Exception('Failed to fetch pet by ID.');
        }
    }


    public function updatePet($id, $data): ApiGetPetResponse
    {
        $response = Http::put("{$this->apiUrl}", $data);

        if ($response->successful()) {
            $updatedData = $response->json();
            return new ApiGetPetResponse($updatedData['id'],$updatedData['category']['id']  ,$updatedData['category']['name'] ,$updatedData['name'], $updatedData['status'],);
        } else {
            throw new PetUpdateException('Failed to update pet in the external API.');
        }
    }




    public function deletePet($id): bool
    {
        $response = $this->httpClient->delete("{$this->apiUrl}/{$id}");

        if ($response->getStatusCode() == 200) {
            return true;
        } else {
            throw new \Exception('Failed to delete pet in the external API.');
        }
    }
}
