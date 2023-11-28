<?php

namespace App\Http\Controllers;

use App\Http\Requests\PetRequest;
use App\Models\Pet;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class PetController extends Controller
{
    protected string $apiUrl;

    protected Client $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->apiUrl = Config::get('api_urls.pet');
        $this->httpClient = $httpClient;
    }

    public function index(Request $request)
    {
        $providedStatus = $request->query('status', '');
        $allowedStatuses = ['sold', 'pending', 'available'];
        $status = in_array($providedStatus, $allowedStatuses) ? $providedStatus : 'sold';
        try {
            $pets = $this->getPetsByStatus($status);

            return view('pets.index', compact('pets'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function getPetsByStatus($status)
    {
        $response = Http::get("{$this->apiUrl}/findByStatus", [
            'status' => $status,
        ]);

        if ($response->successful()) {
            $pets = $response->json();
            $pets = array_slice($pets, 0, 5000);

            return $pets;
        } else {
            throw new \Exception('Failed to fetch pets.');
        }
    }


    public function create()
    {
        return view('pets.create');
    }
    public function store(Request $request)
    {
        try {
            $response = $this->httpClient->post($this->apiUrl, [
                'json' => $request->all(),
            ]);

            if ($response->getStatusCode() == 200) {
                return redirect()->route('pets.index')->with('success', 'Pet created successfully.');
            } else {
                return response()->json(['error' => 'Failed to create pet in the external API.'], $response->getStatusCode());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    public function edit(Pet $pet)
    {
        return view('pets.edit', compact('pet'));
    }

    public function update(Request $request, Pet $pet)
    {
        $client = new Client;

        try {
            $response = $client->put("{$this->apiUrl}/{$pet->id}", [
                'json' => $request->all(),
            ]);

            if ($response->getStatusCode() == 200) {
                return redirect()->route('pets.index')->with('success', 'Pet updated successfully.');
            } else {
                return response()->json(['error' => 'Failed to update pet in the external API.'], $response->getStatusCode());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $client = new Client;

        try {
            $response = $client->delete("{$this->apiUrl}/$id");

            if ($response->getStatusCode() == 200) {
                return redirect()->route('pets.index')->with('success', 'Pet deleted successfully.');
            } else {
                return response()->json(['error' => 'Failed to delete pet from the API.'], $response->getStatusCode());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
