<?php

namespace App\Http\Controllers;

use App\Exceptions\PetUpdateException;
use App\Services\PetServiceInterface;
use Illuminate\Http\Request;

class PetController extends Controller
{
    protected PetServiceInterface $petService;

    public function __construct(PetServiceInterface $petService)
    {
        $this->petService = $petService;
    }

    public function index(Request $request)
    {
        $providedStatus = $request->query('status', '');
        $allowedStatuses = ['sold', 'pending', 'available'];
        $status = in_array($providedStatus, $allowedStatuses) ? $providedStatus : 'available';

        try {
            $pets = $this->petService->getPetsByStatus($status);
            return view('pets.index', compact('pets'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function create()
    {
        return view('pets.create');
    }

    public function store(Request $request)
    {
        try {
            $this->petService->createPet($request->all());
            return redirect()->route('pets.index')->with('success', 'Pet created successfully.');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        try {
            $pet = $this->petService->getPetById($id);
            return view('pets.edit', compact('pet'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $id = $request->input('id');

            return redirect()->route('pets.index')->with('success', 'Pet created successfully.');
        } catch (PetUpdateException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->petService->deletePet($id);
            return redirect()->route('pets.index')->with('success', 'Pet deleted successfully.');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
