@extends('layouts.app')

@section('content')
    <h2>Pets</h2>
    <a class="btn btn-primary" >Find by Text </a>
    <a class="btn btn-primary" >Find by Status </a>
    <a class="routes-buttons btn btn-primary" href="{{ route('pets.create')}}">Create Pet Slot</a>

    @foreach($pets as $pet)
        <div class="pet-card mt-2">
            @if(isset($pet['name']))
                <h3>{{ $pet['name'] }}</h3>
            @else
                <h3>Unknown Pet</h3>
            @endif

            <p>Status: {{ $pet['status'] }}</p>
            <div class="pet-actions">
                <a href="{{ route('pets.edit', $pet['id']) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('pets.destroy', $pet['id']) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete {{ $pet['name'] ?? 'this pet' }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>

        <style>

            .pet-card {
                color: white;
                background-color: gray;
                border: 1px solid #ddd;
                padding: 15px;
                margin-bottom: 15px;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                position: relative;
            }

            .pet-actions {
                position: absolute;
                top: 15px;
                right: 15px;
            }

            .pet-actions a, .pet-actions button {
                margin-left: 10px;
            }
        </style>
    @endforeach
@endsection
