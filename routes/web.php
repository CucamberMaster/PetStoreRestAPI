<?php

use App\Http\Controllers\PetController;
use Illuminate\Support\Facades\Route;

Route::post('/pets/create', [PetController::class, 'create'])->name('pets.create');
Route::delete('/pets/{pet}', [PetController::class, 'destroy'])->name('pets.destroy');

Route::resource('pets', PetController::class)->except(['create', 'index']);

Route::get('/', [PetController::class, 'index'])->name('pets.index');
