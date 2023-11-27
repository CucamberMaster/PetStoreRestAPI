@extends('layouts.app')

@section('content')
    <h2>Create a New Pet</h2>

    <form method="POST" action="{{ route('pets.store') }}">
        @csrf

        <label for="category_id">Category ID:</label>
        <input type="number" name="category[id]" required>
        <br>
        <label for="category_name">Category Name:</label>
        <input type="text" name="category[name]" required>
        <br>
        <label for="name">Name:</label>
        <input type="text" name="name" required>
        <br>
        <label for="photoUrls">Photo URLs:</label>
        <input type="text" name="photoUrls[0]" placeholder="Enter photo URL" >
        <br>
        <label for="tags">Tags:</label>
        <div id="tags-container">
            <div class="tag-input">
                <label for="tags_id">Tag ID:</label>
                <input type="text" name="tags[0][id]" required>
                <label for="tags_name">Tag Name:</label>
                <input type="text" name="tags[0][name]" required>
            </div>
        </div>
        <button type="button" id="add-tag">Add Tag</button>
        <br>
        <label for="status">Status:</label>
        <select name="status" required>
            <option value="available">Available</option>
            <option value="pending">Pending</option>
            <option value="sold">Sold</option>
        </select>
        <br>
        <button type="submit">Create Pet</button>
    </form>

    <script>
        document.getElementById('add-tag').addEventListener('click', function() {
            var tagsContainer = document.getElementById('tags-container');
            var tagInput = document.createElement('div');
            tagInput.classList.add('tag-input');
            tagInput.innerHTML = `
                <label for="tags_id">Tag ID:</label>
                <input type="text" name="tags[][id]" required>

                <label for="tags_name">Tag Name:</label>
                <input type="text" name="tags[][name]" required>
            `;
            tagsContainer.appendChild(tagInput);
        });
    </script>
@endsection
