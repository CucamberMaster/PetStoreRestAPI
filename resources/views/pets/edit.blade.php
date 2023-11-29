@extends('layouts.app')

@section('content')
    <h2>Edit Pet</h2>
    <a href="{{ route('pets.index') }}" class="btn btn-primary">Comeback to main Page</a>
    <form method="POST" action="{{ route('pets.update', $pet->id) }}">

        @method('PUT')
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
        <input type="hidden" name="id" value="{{ old('id', $pet->id)}} " style="display:none;">
        <input type="hidden" name="id" value="{{ old('id', $pet->category->id)}}">
        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ old('name', $pet->name) }}" >
        <br>

        <label for="category_name">Category Name:</label>
        <input type="text" name="category[name]" value="{{ old('category.name', $pet->category->name) }}" >
        <br>

        <label for="status">Status:</label>
        <select name="status">
            <option value="available" {{ old('status', $pet->status) === 'available' ? 'selected' : '' }}>Available</option>
            <option value="pending" {{ old('status', $pet->status) === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="sold" {{ old('status', $pet->status) === 'sold' ? 'selected' : '' }}>Sold</option>
        </select>
        <br>

        <button type="submit" class="btn btn-success">Edit Pet</button>
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
