<x-app-layout>
    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">

                    <!-- [ breadcrumb ] start -->
                    <x-breadcrumb title="View Bookings" />
                    <!-- [ breadcrumb ] end -->

                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                <!-- [ basic-table ] start -->
                                <div class="col-xl-12">
                                    <div class="card card-custom gutter-b example example-compact">
                                        <div class="card-body row">
                                            <!--begin::Form-->
                                            @include ('bookings.form')
                                            <!--end::Card-->
                                        </div>
                                    </div>

                                    @can('Update Booking Status')
                                    <div class="card card-custom gutter-b mt-3">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Update Booking Status</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row align-items-end g-3">
                                                <div class="col-md-4">
                                                    <label class="form-label">Current Status</label>
                                                    <div>
                                                        @php
                                                        $statusColors = [
                                                        'pending' => 'bg-warning',
                                                        'confirmed' => 'bg-success',
                                                        'completed' => 'bg-info',
                                                        'cancelled' => 'bg-danger',
                                                        ];
                                                        $badgeClass = $statusColors[strtolower($booking->status ?? '')] ?? 'bg-secondary';
                                                        @endphp
                                                        <span class="badge {{ $badgeClass }} fs-6" id="current-status-badge">
                                                            {{ ucfirst(strtolower($booking->status ?? 'N/A')) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="booking_status_select" class="form-label">New Status</label>
                                                    <select id="booking_status_select" class="form-select">
                                                        <option value="Pending" {{ $booking->status === 'Pending'   ? 'selected' : '' }}>Pending</option>
                                                        <option value="Confirmed" {{ $booking->status === 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                        <option value="Completed" {{ $booking->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                                                        <option value="Cancelled" {{ $booking->status === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" id="btn-update-status" class="btn btn-primary">
                                                        <i class="feather icon-check me-1"></i> Update Status
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endcan
                                </div>
                                <!-- [ basic-table ] end -->
                            </div>
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
    @push('scripts')
    <script>
        $(document).ready(function() {
            $('input, select').not('#booking_status_select').attr('disabled', 'disabled');

            $('#btn-update-status').on('click', function() {
                var newStatus = $('#booking_status_select').val();
                var btn = $(this);

                btn.prop('disabled', true).html('<i class="feather icon-loader me-1"></i> Updating...');

                $.ajax({
                    url: '{{ route("bookings.update-status", $booking->uuid) }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: newStatus
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#current-status-badge')
                                .removeClass('bg-warning bg-success bg-info bg-danger bg-secondary')
                                .html('');

                            var colorMap = {
                                'pending': 'bg-warning',
                                'confirmed': 'bg-success',
                                'completed': 'bg-info',
                                'cancelled': 'bg-danger'
                            };
                            var cls = colorMap[newStatus.toLowerCase()] || 'bg-secondary';
                            $('#current-status-badge').addClass(cls).text(newStatus);

                            toastr.success(response.message || 'Status updated successfully!');
                        } else {
                            toastr.error(response.message || 'Failed to update status.');
                        }
                    },
                    error: function(xhr) {
                        var msg = xhr.responseJSON?.message || 'An error occurred.';
                        toastr.error(msg);
                    },
                    complete: function() {
                        btn.prop('disabled', false).html('<i class="feather icon-check me-1"></i> Update Status');
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout>