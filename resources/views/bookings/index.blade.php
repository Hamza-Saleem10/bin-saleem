<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <x-breadcrumb title="Bookings" :button="['name' => 'Add', 'allow' => auth()
                ->user()
                ->can('Create Booking'), 'link' => route('bookings.create')]" />
            <!-- [ breadcrumb ] end -->
            <div class="modal fade" id="statusChangeModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Change Booking Status</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {!! Form::open(['id' => 'statusChangeForm']) !!}
                                {!! Form::hidden('booking_uuid', null, ['id' => 'booking_uuid']) !!}
                                <div class="form-group">
                                    {!! Form::label('status', 'Select Status', ['class' => 'form-label required-input']) !!}
                                    {!! Form::select('status',
                                        [
                                            'Pending'   => 'Pending',
                                            'Confirmed' => 'Confirmed',
                                            'Completed' => 'Completed',
                                            'Cancelled' => 'Cancelled',
                                        ],old('status'),['class' => 'form-control ' . $errors->first('status', 'error'), 'id' => 'status', 'required']) !!}
                                    {!! $errors->first('status', '<label class="error">:message</label>') !!}
                                </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="saveStatusBtn">Update Status</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- product profit end -->

                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <x-table :keys="['Voucher No','Customer Name','Contact No', 'Vehicle', 'Pick & Drop ', 'Pick Up Date','Pick Up Time','Status','']"></x-table>
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
                        data: 'booking.voucher_number',
                    },
                    {
                        data: 'booking.customer_name',
                    },
                    
                    {
                        data: 'booking.customer_contact'
                    },
                    {
                        data: 'vehicle.name'
                    },
                    {
                        data: 'pick_up'
                    },
                    {
                        data: 'pickup_date'
                    },
                    {
                        data: 'pickup_time'
                    },
                    {
                        data: 'status',
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
                // Handle Status Change Button Click
                $(document).on('click', '.btn-change-status', function() {
                    const bookingUuid = $(this).data('booking-uuid');
                    const currentStatus = $(this).data('current-status');
                    
                    $('#booking_uuid').val(bookingUuid);
                    $('#status').val(currentStatus);
                    
                    $('#statusChangeModal').modal('show');
                });
                
                // Handle Save Status
                $('#saveStatusBtn').click(function() {
                    const uuid = $('#booking_uuid').val();
                    const status = $('#status').val();
                    const notes = $('#status_notes').val();
                    
                    if (!uuid || !status) {
                        toastr.error('Please select a status');
                        return;
                    }
                    
                    $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Updating...');
                    
                    $.ajax({
                        url: route('bookings.update-status', uuid),
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            status: status,
                            status_notes: notes
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                $('#statusChangeModal').modal('hide');
                                
                                // Reset form
                                $('#statusChangeForm')[0].reset();
                                
                                // Update the status in the table without reloading
                                table.ajax.reload(null, false);
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(xhr) {
                            let errorMessage = 'An error occurred';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            toastr.error(errorMessage);
                        },
                        complete: function() {
                            $('#saveStatusBtn').prop('disabled', false).html('Update Status');
                        }
                    });
                });
                
                // Reset form when modal is closed
                $('#statusChangeModal').on('hidden.bs.modal', function() {
                    $('#statusChangeForm')[0].reset();
                });
            });
        </script>
    @endpush
</x-app-layout>
