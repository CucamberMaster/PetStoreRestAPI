@extends('layouts.app')

@section('content')
    <h2>Create a New Pet</h2>
    <a href="{{ route('pets.index' )}}" class=" routes-buttons btn btn-primary">Back to Main Page</a>

    <form method="POST" action="{{ route('pets.store') }}" id="createPetForm">
        @csrf


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

        <button type="submit" class="btn btn-success">Create Pet</button>
    </form>

    <script>
        document.getElementById('createPetForm').addEventListener('submit', function(event) {
            var nameField = document.getElementsByName('name')[0];
            if (nameField.value.trim() === '') {
                alert('Name cannot be empty');
                event.preventDefault();
            }
        });
    </script>
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

        #tags-container {
            margin-bottom: 15px;
        }


        .tag-input {
            margin-bottom: 10px;
        }


        .alert {
            margin-top: 10px;
            padding: 10px;
            background-color: #f44336;
            color: #fff;
            border-radius: 5px;
        }
    </style>
@endsection
