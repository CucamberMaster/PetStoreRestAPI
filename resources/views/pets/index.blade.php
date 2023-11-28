@extends('layouts.app')

@section('content')
    <div>
        <h1>Pets</h1>
        <label for="statusSelect">Status:</label>
        <select id="statusSelect" name="status" required>
            <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Available</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="sold" {{ request('status') === 'sold' ? 'selected' : '' }}>Sold</option>
        </select>
        <button id="findByStatusBtn" class="btn btn-primary">Find by Status</button>
        <a class="btn btn-primary" href="{{ route('pets.create')}}">Create Pet Slot</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Category Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pets as $pet)

                <tr>
                    @if (isset($pet['category']['name']) && isset($pet['name']) && $pet['category']['name'] !== 'string' && $pet['category']['name'] !== 'ZAP' && $pet['name'] !== 'string')
                        <td>{{ $pet['name'] }}</td>
                        <td>{{ $pet['category']['name'] }}</td>
                        <td>
                            <a href="{{ route('pets.edit', ['id' => $pet['id']]) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('pets.destroy', $pet['id']) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete {{ $pet['name'] ?? 'this pet' }}?')"
                            >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    @else

                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#findByStatusBtn').on('click', function(event) {
                event.preventDefault();

                var selectedStatus = $('#statusSelect').val();
                console.log('Selected status:', selectedStatus);

                $.ajax({
                    type: 'GET',
                    url: '{{ route("pets.index") }}',
                    data: {status: selectedStatus},
                    success: function(data) {
                        var newUrl = window.location.pathname + '?status=' + selectedStatus;
                        window.history.pushState({path: newUrl}, '', newUrl);
                        window.location.reload();
                        $('tbody').html('');
                        $.each(data, function(index, pet) {
                            if (pet.category && pet.name && pet.category.name !== 'string' && pet.category.name !== 'ZAP' && pet.name !== 'string') {
                                $('tbody').append(`
                            <tr>
                                <td>${pet.category.name}</td>
                                <td>${pet.name}</td>
                                <td>
                                    <a href="{{ route('pets.edit', '') }}/${pet.id}" class="btn btn-primary">Edit</a>
                                    <form action="{{ route('pets.destroy', '') }}/${pet.id}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete ${pet.name ?? 'this pet'}?')">
                                        @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
`);
                            }
                        });
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
@endsection

<style>
    .pet-actions a,
    .pet-actions button {
        margin-left: 10px;
    }
</style>
