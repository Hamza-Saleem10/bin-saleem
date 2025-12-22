{{-- @extends('layouts.admin')
@section('title', 'Vehicles')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Fleet Management</h2>
    <a href="{{ route('vehicles.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add Vehicle
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>Sr.</th>
                <th>Image</th>
                <th>Name</th>
                <th>Seats</th>
                <th>Bags</th>
                <th>Features</th>
                <th>Status</th>
                <th width="120">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($vehicles as $vehicle)
                <tr>
                    <td>{{ $vehicles->firstItem() + $loop->index }}</td>
                    <td>
                        <img src="{{ $vehicle->image_url }}" alt="{{ $vehicle->name }}"
                             class="rounded" style="width: 60px; height: 40px; object-fit: cover;">
                    </td>
                    <td><strong>{{ $vehicle->name }}</strong></td>
                    <td>{{ $vehicle->seats }}</td>
                    <td>{{ $vehicle->bags }}</td>
                    <td>
                        @if($vehicle->features)
                            @foreach((array) $vehicle->features as $feature)
                                <span class="badge bg-info me-1">{{ $feature }}</span>
                            @endforeach
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-{{ $vehicle->is_active ? 'success' : 'secondary' }}">
                            {{ $vehicle->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                            <a href="{{ route('vehicles.edit', $vehicle) }}"
                               class="btn btn-sm btn-warning" title="Edit">
                                Edit
                            </a>
                            <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST"
                                  class="d-inline" onsubmit="return confirm('Delete this vehicle?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                    Delete
                                </button>
                            </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        No vehicles added yet.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $vehicles->links() }}
@endsection
@push('scripts')
@endpush --}}
<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <x-breadcrumb title="Vehicles" :button="['name' => 'Add', 'allow' => auth()
                ->user()
                ->can('Create Vehicle'), 'link' => route('vehicles.create')]" />
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- product profit end -->

                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <x-table :keys="['Vehicle Name', 'Seats', 'Bag Capacity', 'Features', 'Vehicle Image', 'Status','']"></x-table>
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
                const datatable_url = route('vehicles.datatable');
                const datatable_columns = [{
                        data: 'name',
                    },
                    {
                        data: 'seats',
                    },
                    {
                        data: 'bags_capacity'
                    },
                    {
                        data: 'features'
                    },
                    {
                        data: 'vehicle_image'
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
