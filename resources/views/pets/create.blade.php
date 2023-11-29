@extends('layouts.app')

@section('content')
    <h2>Create a New Pet</h2>
    <a href="{{ route('pets.index' )}}" class="routes-buttons btn btn-primary">Back to Main Page</a>

    <form method="POST" action="{{ route('pets.store') }}" id="createPetForm">
        @csrf

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ old('name') }}" >
        <br>

        <label for="category_name">Category Name:</label>
        <input type="text" name="category[name]" value="{{ old('category.name') }}" >
        <br>

        <label for="status">Status:</label>
        <select name="status" >
            <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>Available</option>
            <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="sold" {{ old('status') === 'sold' ? 'selected' : '' }}>Sold</option>
        </select>
        <br>

        <button type="submit" class="btn btn-success">Create Pet</button>
    </form>
    <style>
        form {
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        button {
            padding: 10px;
            margin-top: 10px;
        }
    </style>
@endsection
