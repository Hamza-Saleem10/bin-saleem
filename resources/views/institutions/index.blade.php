<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <x-breadcrumb title="Applications" :button="[
                'name' => 'Create an Application',
                // 'allow' => auth()->user()->can('Create Institution'),
                'allow' => true,
                'link' => route('institutions.create')]" />
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- product profit end -->

                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <x-table :keys="['Name', 'Tehsil', 'School Name', 'School Type', 'School Level', 'School Gender', 'Date & Time of Application','Application Status', 'Fee Status','']"></x-table>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Status Tracking Modal -->
            <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="statusModalLabel">Application Status Tracking</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="statusModalBody">
                            <!-- Content will be loaded via AJAX -->
                            <div class="text-center">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Status Tracking Modal -->
        </div>
    </div>
    
    @include('layouts.dataTablesFiles')
    @push('scripts')
        <script>
            $(document).ready(function() {
                const datatable_url = "{{ route('institutions.datatable') }}";
                const datatable_columns = [{
                        data: 'name',
                    },
                    {
                        data: 'level_3.name'
                    },
                    {
                        data: 'name',
                    },
                    {
                        data: 'institution_type',
                    },
                    {
                        data: 'institution_level',
                    },
                    {
                        data: 'institution_gender',
                    },
                    {
                        data: 'created_at',
                        render: formatDate
                    },
                    {
                        data: 'status',
                        width: '5%',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'fee_status',
                        width: '5%',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        width: '30%',
                        orderable: false,
                        searchable: false
                    }
                ];

                create_datatables(datatable_url, datatable_columns);


                $('.datatable').on('click', '.mark-paid-voucher', function (e) {
                    e.preventDefault();  
                    $datatable = $(this).parents('.datatable');
                    var url= $(this).attr('href');
                    
                    $.confirm({
                        title: 'Confirm!',
                        content: 'Are you sure! You want to Mark as Paid this Challan?',
                        type: 'red',
                        typeAnimated: true,
                        closeIcon: true,
                        buttons: {
                            confirm: function () {
                                $datatable.find("tbody").LoadingOverlay("show");
                                ajaxCall(null , url, 'POST', null, null, function(res) {
                                    $datatable.find("tbody").LoadingOverlay("hide");
                                    if (res.success) {
                                        successMessage(res.message);
                                        reloadDatatable($datatable);
                                    } else {
                                        errorMessage(res.message);
                                    }
                                });
                            },
                            cancel: function () { },
                        }
                    });
                });

                $('.datatable').on('click', '.renewal-request', function(e) {
                    e.preventDefault();
                    $datatable = $(this).parents('.datatable');
                    var url= $(this).attr('href');
                    $.confirm({
                        title: 'Confirm!',
                        content: 'Are you sure you want to submit a renewal request?',
                        type: 'red',
                        typeAnimated: true,
                        closeIcon: true,
                        buttons: {
                            confirm: function () {
                                $datatable.find("tbody").LoadingOverlay("show");
                                ajaxCall(null , url, 'POST', null, null, function(res) {
                                    $datatable.find("tbody").LoadingOverlay("hide");
                                    if (res.success) {
                                        successMessage(res.message);
                                        reloadDatatable($datatable);
                                    } else {
                                        errorMessage(res.message);
                                    }
                                });
                            },
                            cancel: function () { },
                        }
                    });
                }); 
            });
        </script>
       <script>
            function showStatusModal(institutionId) {
                // First, ensure the modal is properly initialized
                $('#statusModal').modal({
                    backdrop: 'static',
                    keyboard: true
                });
                // Show loading spinner
                $('#statusModalBody').html(`
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="mt-2">Loading application status...</p>
                    </div>
                `);
                // Show modal first, then load content
                $('#statusModal').modal('show');
                // Load content via AJAX
                $.ajax({
                    url: '{{ route("institutions.status.modal") }}',
                    type: 'GET',
                    data: {
                        institution_id: institutionId
                    },
                    success: function(response) {
                        $('#statusModalBody').html(response);
                    },
                    error: function(xhr) {
                        $('#statusModalBody').html(`
                            <div class="alert alert-danger">
                                <i class="feather icon-alert-triangle"></i>
                                Error loading application status. Please try again.
                            </div>
                        `);
                    }
                });
            }

                $(document).ready(function() {
                    // Handle modal close button click
                    $(document).on('click', '#statusModal .btn-close, #statusModal .btn-secondary', function() {
                        $('#statusModal').modal('hide');
                    });
                    // Handle ESC key to close modal
                    $(document).on('keydown', function(e) {
                        if (e.key === 'Escape' && $('#statusModal').hasClass('show')) {
                            $('#statusModal').modal('hide');
                        }
                    });
                    // Handle click outside modal (backdrop)
                    $('#statusModal').on('click', function(e) {
                        if (e.target === this) {
                            $(this).modal('hide');
                        }
                    });
                });
        </script>
    @endpush
</x-app-layout>
