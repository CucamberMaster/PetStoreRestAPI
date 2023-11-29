<?php

namespace App\Http\Controllers;

use App\Exceptions\PetUpdateException;
use App\Http\Requests\PetRequest;
use App\Services\PetServiceInterface;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function __construct(
        protected PetServiceInterface $petService
    ){}

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

    public function store(PetRequest  $request)
    {
        $validatedData = $request->validated();
        //dodac wiadomosc o bledzie na ekranie w view
        try {
            $this->petService->createPet($validatedData);
            return redirect()->route('pets.index')->with('success', 'Pet updated successfully.');
        } catch (PetUpdateException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
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

    public function update( PetRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $id = $validatedData['id'];
            $this->petService->updatePet($id, $validatedData);

            return redirect()->route('pets.index')->with('success', 'Pet updated successfully.');
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
