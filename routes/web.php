<?php

use App\Http\Controllers\PetController;
use Illuminate\Support\Facades\Route;

Route::get('/pets/create', [PetController::class, 'create'])->name('pets.create');
Route::post('/pets', [PetController::class, 'store'])->name('pets.store');

Route::delete('/pets/{pet}', [PetController::class, 'destroy'])->name('pets.destroy');

Route::get('/pets/edit', [PetController::class, 'edit'])->name('pets.edit');
Route::put('/pets/update', [PetController::class, 'update'])->name('pets.update');


Route::get('/', [PetController::class, 'index'])->name('pets.index');
