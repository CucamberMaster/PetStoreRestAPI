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

            return view('pets.index', compact('pets'));
        } else {
            return response()->json(['error' => 'Failed to fetch pets.'], $response->getStatusCode());
        }
    }

    public function create(Pet $pet)
    {
        return view('pets.create', compact('pet'));
    }
    public function store(PetRequest $request)
    {
        $validatedData = $request->validated();

        // Check if 'id' is present to determine if it's an update or create
        if (isset($validatedData['id'])) {
            $pet = Pet::findOrFail($validatedData['id']);
            $pet->update($validatedData);
        } else {
            $pet = Pet::create($validatedData);
        }

        if (!$pet) {
            return response()->json(['error' => 'Failed to create/update pet locally.'], 500);
        }

        $client = new Client;

        try {
            $response = $client->post($this->apiUrl, [
                'json' => $validatedData,
            ]);

            if ($response->getStatusCode() == 200) {
                return redirect()->route('pets.index')->with('success', 'Pet created/updated successfully.');
            } else {
                return response()->json(['error' => 'Failed to create/update pet in the external API.'], $response->getStatusCode());
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
        $pet->update($request->all());

        return redirect()->route('pets.index')
            ->with('success', 'Pet updated successfully.');
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
