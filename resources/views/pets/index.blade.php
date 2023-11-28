@extends('layouts.app')

@section('content')
    <h1>Pets</h1>

    <div>
        <label for="statusSelect">Status:</label>
        <select id="statusSelect" name="status" required>
            <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Available</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="sold" {{ request('status') === 'sold' ? 'selected' : '' }}>Sold</option>
        </select>
        <a id="findByStatusBtn" class="btn btn-primary" href="#">Find by Status</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Category Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pets as $pet)
                <tr>
                    @if (isset($pet['category']['name']) && isset($pet['name']) && $pet['category']['name'] !== 'string' && $pet['category']['name'] !== 'ZAP' && $pet['name'] !== 'string')
                        <td>{{ $pet['name'] }}</td>
                        <td>{{ $pet['category']['name'] }}</td>
                    @else
                        <div style="display: none"></div>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#findByStatusBtn').on('click', function() {
                var selectedStatus = $('#statusSelect').val();

                $.ajax({
                    type: 'GET',
                    url: '{{ route("pets.index") }}',
                    data: {status: selectedStatus},
                    success: function(data) {
                        $('tbody').html('');
                        $.each(data, function(index, pet) {
                            if (pet.category && pet.name && pet.category.name !== 'string' && pet.category.name !== 'ZAP' && pet.name !== 'string') {
                                $('tbody').append(`
                                    <tr>
                                        <td>${pet.category.name}</td>
                                        <td>${pet.name}</td>
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
