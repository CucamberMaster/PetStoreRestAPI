<!-- resources/views/pets/index.blade.php -->

@extends('layouts.app')

@section('content')
    <h2>Pets</h2>          <a href="{{ route('pets.create')}}">Create</a>

    @foreach($pets as $pet)
        <div class="pet-card">
            <h3>{{ $pet['name'] }}</h3>
            <p>Status: {{ $pet['status'] }}</p>
            <div class="pet-actions">
                <!-- Use the named route with the pet's ID for the edit link -->
                <a href="{{ route('pets.edit', $pet['id']) }}">Edit</a>
                <form action="{{ route('pets.destroy', $pet['id']) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </div>
        </div>
    @endforeach
@endsection
