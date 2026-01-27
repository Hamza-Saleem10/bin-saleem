<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">

            <x-breadcrumb title="Attendance Rules" :links="[
                ['name' => 'Dashboard', 'url' => route('dashboard')],
                ['name' => 'Attendance Rules']
            ]" />
            <!-- Add Rule Button -->
             @can('Create Attendance Rule')
            <div class="row mb-3">
                <div class="col-12 text-end">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addRuleModal">Add</button>
                </div>
            </div>
            @endcan

            <!-- Rules Table -->
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <x-table :keys="[
                                'Rule Name',
                                'Check In Time',
                                'Check Out Time',
                                'Late Threshold',
                                'Location Radius',
                                'Assigned Users',
                                'Status',
                                'Actions'
                            ]"></x-table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('attendance.attendance-rules.rule-modal')
    @include('layouts.dataTablesFiles')
    
    @push('scripts')
    <script>
        $(document).ready(function () {
            const datatable_url = "{{ route('attendance-rules.datatable') }}";
            const datatable_columns = [
                { data: 'name' },
                { data: 'check_in_display' },
                { data: 'check_out_display' },
                { data: 'late_threshold' },
                { data: 'location_radius' },
                { data: 'users_count' },
                { data: 'status_badge', orderable: false, searchable: false },
                { data: 'action', orderable: false, searchable: false }
            ];

            create_datatables(datatable_url, datatable_columns);

            // Add location field
            let locationCount = 1;
            $('#add-location').click(function() {
                const html = `
                    <div class="location-item mb-2">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="allowed_locations[${locationCount}][name]" 
                                       placeholder="Location name" required>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="allowed_locations[${locationCount}][latitude]" 
                                       placeholder="Latitude" required>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="allowed_locations[${locationCount}][longitude]" 
                                       placeholder="Longitude" required>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger remove-location">
                                    <i class="feather icon-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                $('#locations-container').append(html);
                locationCount++;
            });

            // Remove location field
            $(document).on('click', '.remove-location', function() {
                if ($('.location-item').length > 1) {
                    $(this).closest('.location-item').remove();
                }
            });

            // Edit rule
            $(document).on('click', '.btn-edit-rule', function() {
                const rule = $(this).data();
                
                $('#rule_uuid').val(rule.uuid);
                $('#form_method').val('PUT');
                $('#name').val(rule.name);
                $('#check_in_time').val(rule.checkInTime);
                $('#check_out_time').val(rule.checkOutTime);
                $('#late_threshold').val(rule.lateThreshold);
                $('#location_radius').val(rule.locationRadius);
                $('#is_active').val(rule.isActive ? '1' : '0');
                
                // Clear and populate locations
                $('#locations-container').empty();
                
                // rule.allowedLocations is already an object/array, no need to parse
                const locations = rule.allowedLocations || [];
                locationCount = 0;
                
                if (locations.length > 0) {
                    locations.forEach((loc, index) => {
                        const html = `
                            <div class="location-item mb-2">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="allowed_locations[${index}][name]" 
                                            value="${loc.name || ''}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="allowed_locations[${index}][latitude]" 
                                            value="${loc.latitude || ''}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="allowed_locations[${index}][longitude]" 
                                            value="${loc.longitude || ''}" required>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger remove-location">
                                            <i class="feather icon-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                        $('#locations-container').append(html);
                        locationCount = index + 1;
                    });
                } else {
                    // Add one empty location
                    const html = `
                        <div class="location-item mb-2">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="allowed_locations[0][name]" 
                                        placeholder="Location name" required>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="allowed_locations[0][latitude]" 
                                        placeholder="Latitude" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="allowed_locations[0][longitude]" 
                                        placeholder="Longitude" required>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger remove-location">
                                        <i class="feather icon-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#locations-container').append(html);
                    locationCount = 1;
                }
                
                $('#ruleModal').modal('show');
            });

            // Add new rule
            $('[data-target="#addRuleModal"]').click(function() {
                $('#ruleForm')[0].reset();
                $('#rule_uuid').val('');
                $('#form_method').val('POST');
                $('#locations-container').empty();
                
                // Add one empty location
                const html = `
                    <div class="location-item mb-2">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="allowed_locations[0][name]" 
                                       placeholder="Location name" required>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="allowed_locations[0][latitude]" 
                                       placeholder="Latitude" required>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="allowed_locations[0][longitude]" 
                                       placeholder="Longitude" required>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger remove-location">
                                    <i class="feather icon-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                $('#locations-container').append(html);
                locationCount = 1;
                
                $('#ruleModal').modal('show');
            });

            // Submit form
            $('#ruleForm').submit(function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const method = $('#form_method').val();
                const uuid = $('#rule_uuid').val();
                const url = uuid ? `/attendance-rules/${uuid}` : '/attendance-rules';
                
                $.ajax({
                    url: url,
                    type: method === 'PUT' ? 'POST' : 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-HTTP-Method-Override': method
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#ruleModal').modal('hide');
                            toastr.success(response.message);
                            $('.dataTable').DataTable().ajax.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let errorHtml = '<ul>';
                            for (const key in errors) {
                                errorHtml += `<li>${errors[key][0]}</li>`;
                            }
                            errorHtml += '</ul>';
                            toastr.error(errorHtml);
                        } else {
                            toastr.error('An error occurred. Please try again.');
                        }
                    }
                });
            });
        });
    </script>
    @endpush
    
</x-app-layout>