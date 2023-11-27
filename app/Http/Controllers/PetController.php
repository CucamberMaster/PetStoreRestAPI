<?php

namespace App\Http\Controllers;

use App\Http\Requests\PetRequest;
use App\Models\Pet;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class PetController extends Controller
{
    protected string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = Config::get('api_urls.pet');
    }

    public function index(Request $request)
    {
        $status = $request->query('status', 'available');

        $client = new Client;

        $response = $client->get("{$this->apiUrl}/findByStatus", [
            'query' => ['status' => $status],
        ]);

        if ($response->getStatusCode() == 200) {
            $pets = json_decode($response->getBody(), true);
            $pets = array_slice($pets, 0, 5);

            return view('pets.index', compact('pets'));
        } else {
            return response()->json(['error' => 'Failed to fetch pets.'], $response->getStatusCode());
        }
    }
    public function create()
    {
        return view('pets.create');
    }

    public function store(PetRequest $request)
    {
        $validatedData = $request->validated();

        $client = new Client;

        try {
            // Create the pet locally
            $pet = Pet::create($validatedData);
            echo $pet;
            if (!$pet) {
                return response()->json(['error' => 'Failed to create pet locally.'], 500);
            }

            // Create the pet in the external API
            $response = $client->post($this->apiUrl, [
                'json' => $validatedData,
            ]);

            if ($response->getStatusCode() == 200) {
                echo($response);
                return redirect()->route('pets.index')->with('success', 'Pet created successfully.');
            } else {
                // If the external API request fails, delete the locally created pet
                $pet->delete();
                return response()->json(['error' => 'Failed to create pet in the external API.'], $response->getStatusCode());
            }
        } catch (\Exception $e) {
            // If an exception occurs, delete the locally created pet
            $pet->delete();
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
                return response()->json(['error' => 'Failed to delete pet from the external API.'], $response->getStatusCode());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
