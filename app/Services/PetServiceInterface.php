<?php

namespace App\Services;

interface PetServiceInterface
{
    public function getPetsByStatus(string $status);

    public function createPet(array $data);

    public function getPetById(int $id);

    public function updatePet(int $id, array $data);

    public function deletePet(int $id);
}
