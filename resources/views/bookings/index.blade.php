{{-- <x-app-layout>
@section('title', 'Bookings')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Bookings</h2>
        <a href="{{ route('bookings.create') }}" class="btn btn-primary">Add New Booking</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="GET" class="mb-3">

        <div class="row g-2 align-items-end">

            <div class="col-md-2">
                <label>Date</label>
                <input type="date" name="date" value="{{ request()->date }}" class="form-control">
            </div>

            <div class="col-md-2">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="">All Status</option>
                    <option value="pending" {{ request()->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request()->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="completed" {{ request()->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request()->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div class="col-md-3">
                <label>Pickup</label>
                <input type="text" name="pickup" value="{{ request()->pickup }}" class="form-control">
            </div>

            <div class="col-md-3">
                <label>Dropoff</label>
                <input type="text" name="dropoff" value="{{ request()->dropoff }}" class="form-control">
            </div>

            <div class="col-md-1 d-grid">
                <button class="btn btn-primary">Filter</button>
            </div>

            <div class="col-md-1 d-grid">
                <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Clear</a>
            </div>

        </div>

        <div class="row mt-3">
            <div class="col-md-3 ms-auto position-relative">
                <input type="text" name="search" value="{{ request()->search }}"
                    placeholder="Search Name / Email / Contact" class="form-control" id="searchInput">

                @if (request()->search)
                    <span onclick="clearSearch()"
                        style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; font-weight:bold;">
                        ×
                    </span>
                @endif
            </div>
        </div>

    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sr.</th>
                <th>Customer Name</th>
                <th>Customer Email</th>
                <th>Customer Contact</th>
                <th>Vehicle</th>
                <th>Pickup</th>
                <th>Dropoff</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
                <tr>
                    <td>{{ $bookings->firstItem() + $loop->index }}</td>
                    <td>{{ $booking->customer_name }}</td>
                    <td>{{ $booking->customer_email }}</td>
                    <td>{{ $booking->customer_contact }}</td>
                    <td>{{ $booking->vehicle }}</td>
                    <td>{{ $booking->pickup }}</td>
                    <td>{{ $booking->dropoff }}</td>
                    <td>
                        <span
                            class="badge bg-{{ $booking->status == 'pending'
                                ? 'warning'
                                : ($booking->status == 'confirmed'
                                    ? 'info'
                                    : ($booking->status == 'completed'
                                        ? 'success'
                                        : 'danger')) }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('bookings.destroy', $booking) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete this booking?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No bookings found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $bookings->links() }}
@endsection
<script>
    function clearSearch() {
        document.getElementById('searchInput').value = '';
        window.location.href = "{{ route('bookings.index') }}";
    }
</script>
</x-app-layout> --}}
<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <x-breadcrumb title="Bookings" :button="['name' => 'Add', 'allow' => auth()
                ->user()
                ->can('Create Booking'), 'link' => route('bookings.create')]" />
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- product profit end -->

                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <x-table :keys="['Customer Name', 'Email', 'Contact No', 'Vehicle', 'Pick up ', 'Dropoff','Status','Active/In-Active','']"></x-table>
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
                const datatable_url = route('bookings.datatable');
                const datatable_columns = [{
                        data: 'customer_name',
                    },
                    {
                        data: 'customer_email',
                    },
                    {
                        data: 'customer_contact'
                    },
                    {
                        data: 'vehicle'
                    },
                    {
                        data: 'pickup'
                    },
                    {
                        data: 'dropoff'
                    },
                    {
                        data: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'is_active',
                        orderable: false,
                        searchable: false
                    },
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
