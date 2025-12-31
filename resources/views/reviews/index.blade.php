{{-- <x-app-layout>
@section('title', 'Reviews')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Customer Reviews</h2>
    <a href="{{ route('reviews.create') }}" class="btn btn-primary">Add Review</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Sr.</th>
            <th>Author</th>
            <th>Location</th>
            <th>Rating</th>
            <th>Comment</th>
            <th>Booking Ref</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($reviews as $review)
            <tr>
                <td>{{ $reviews->firstItem() + $loop->index }}</td>
                <td>{{ $review->author }}</td>
                <td>{{ $review->location }}</td>
                <td>
                    @for($i = 1; $i <= 5; $i++)
                        <i class="bi bi-star-fill text-warning"></i>
                    @endfor
                    ({{ $review->rating }})
                </td>
                <td>{{ Str::limit($review->comment, 50) }}</td>
                <td>{{ $review->booking_reference ?? '—' }}</td>
                <td>
                    <a href="{{ route('reviews.edit', $review) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete review?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center">No reviews yet.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $reviews->links() }}
@endsection
</x-app-layout> --}}
<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <x-breadcrumb title="Reviews" :button="['name' => 'Add', 'allow' => auth()
                ->user()
                ->can('Create Review'), 'link' => route('reviews.create')]" />
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- product profit end -->

                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <x-table :keys="['Author', 'Location',  'Rating', 'Booking Reference','Route Detail', 'Travel Date','Comment','']"></x-table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @include('layouts.dataTablesFiles')
    @push('scripts')
        <script>
            $(document).ready(function() {
                const datatable_url = route('reviews.datatable');
                const datatable_columns = [{
                        data: 'author',
                    },
                    {
                        data: 'location',
                    },
                    {
                        data: 'rating'
                    },
                    {
                        data: 'booking_reference'
                    },
                    {
                        data: 'route_detail'
                    },
                    {
                        data: 'travel_date',
                        // render: formatDate
                    },
                    {
                        data: 'comment'
                    },
                    // {
                    //     data: 'status',
                    //     orderable: false,
                    //     searchable: false
                    // },
                    {
                        data: 'action',
                        width: '10%',
                        orderable: false,
                        searchable: false
                    }
                ];

                create_datatables(datatable_url, datatable_columns);
            });
        </script>
    @endpush
</x-app-layout>