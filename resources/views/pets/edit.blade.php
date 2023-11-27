<!-- resources/views/pets/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <h2>Edit Pet</h2>

    <form method="POST" action="{{ route('pets.update', $pet->id) }}">
        @csrf
        @method('PUT')

        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ old('name', $pet->name) }}" required>
        <br>

        <label for="category_id">Category ID:</label>
        <input type="number" name="category[id]" value="{{ old('category.id', $pet->category_id) }}" required>
        <br>

        <label for="category_name">Category Name:</label>
        <input type="text" name="category[name]" value="{{ old('category.name', $pet->category_name) }}" required>
        <br>

        <label for="photoUrls">Photo URLs:</label>
        <input type="text" name="photoUrls[0]" value="{{ old('photoUrls.0', $pet->photoUrls[0] ?? '') }}" placeholder="Enter photo URL" required>
        <!-- Add more input fields for multiple photo URLs if needed -->
        <br>

        <label for="tags">Tags:</label>
        <div id="tags-container">
            @if (old('tags'))
                @foreach (old('tags') as $tag)
                    <div class="tag-input">
                        <label for="tags_id">Tag ID:</label>
                        <input type="text" name="tags[{{ $loop->index }}][id]" value="{{ $tag['id'] }}" required>

                        <label for="tags_name">Tag Name:</label>
                        <input type="text" name="tags[{{ $loop->index }}][name]" value="{{ $tag['name'] }}" required>
                    </div>
                @endforeach
            @elseif ($pet->tags)
                @foreach ($pet->tags as $tag)
                    <div class="tag-input">
                        <label for="tags_id">Tag ID:</label>
                        <input type="text" name="tags[{{ $loop->index }}][id]" value="{{ $tag->id }}" required>

                        <label for="tags_name">Tag Name:</label>
                        <input type="text" name="tags[{{ $loop->index }}][name]" value="{{ $tag->name }}" required>
                    </div>
                @endforeach
            @endif
        </div>
        <button type="button" id="add-tag">Add Tag</button>
        <!-- Add more input fields for multiple tags if needed -->
        <br>

        <label for="status">Status:</label>
        <select name="status" required>
            <option value="available" {{ old('status', $pet->status) === 'available' ? 'selected' : '' }}>Available</option>
            <option value="pending" {{ old('status', $pet->status) === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="sold" {{ old('status', $pet->status) === 'sold' ? 'selected' : '' }}>Sold</option>
        </select>
        <br>

        <button type="submit">Update Pet</button>
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
