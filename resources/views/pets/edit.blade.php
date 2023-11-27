<!-- resources/views/pets/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <h2>Edit Pet</h2>

    <form method="POST" action="{{ route('pets.update', $pet['id']) }}">
        @csrf
        @method('PUT')

        <!-- Include form fields for each attribute -->
        <!-- Example: -->
        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ $pet['name'] }}" required>
        <br>

        <!-- Add more fields as needed -->

        <button type="submit">Update Pet</button>
    </form>
@endsection
