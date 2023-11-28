

@extends('layouts.app')

@section('content')
    <h2>Edit Pet</h2>
    <a href="{{ route('pets.index' )}}" class="btn btn-primary">Comeback to main Page </a>
    <form method="POST" action="{{ route('pets.update', $pet->id) }}">
        @csrf
        @method('PUT')



        <label for="name">Name:</label>
        <input type="text" name="name" required>
        <br>
        <label for="category_name">Category Name:</label>
        <input type="text" name="category[name]" required>
        <br>
        <label for="status">Status:</label>
        <select name="status" required>
            <option value="available">Available</option>
            <option value="pending">Pending</option>
            <option value="sold">Sold</option>
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
