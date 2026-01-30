<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">

            <x-breadcrumb title="Attendance Report" />

            @can('Create Attendance')
            <div class="row mb-3">
                <div class="col-12 text-end">
                    <button type="button" class="btn btn-primary" id="openBulkAttendanceModal">Add</button>
                </div>
            </div>
            @endcan
            <!-- Table -->
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <div class="tableFilter d-md-flex">
                                <button type="button" class="btn btn-sm btn-warning clear_filters"
                                        style="height: 35px;margin-right: 10px">
                                    Clear
                                </button>
                                {!! Form::input('month', 'month', request()->m, ['class' => 'form-control month_picker','style' => 'width: 200px !important; margin-left: 10px;',]) !!}
                            </div>
                            <x-table :keys="[
                                'Employee ID',
                                'Name',
                                'Check In',
                                'Check Out',
                                'Status',
                                'Location',
                                'Total Days',
                                'Holidays',
                                'Working Days',
                                'Present',
                                'Absent',
                                ''
                            ]"></x-table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @include('attendance.user-attendance-modal')
    @include('attendance.bulk-attendance-modal')
    @include('layouts.dataTablesFiles')
    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script> --}}
        <script>
            $(document).ready(function () {
                const datatable_url = "{{ route('attendance.datatable') }}";
                const datatable_columns = [
                    { data: 'id' },
                    { data: 'name' , width: '15%' },
                    { data: 'check_in' },
                    { data: 'check_out' },
                    { 
                        data: 'status',
                        orderable: false, 
                        searchable: false 
                    },
                    { 
                        data: 'location',
                        render: function(data, type, row) {
                            return data || 'N/A';
                        },
                        orderable: false, 
                        searchable: false 
                    },
                    { 
                        data: 'total_days', 
                        width: '3%',
                        className: 'text-center',
                        render: function(data) {
                            return '<strong>' + data + '</strong>';
                        }
                    },
                    { 
                        data: 'holidays', 
                        width: '3%',
                        className: 'text-center',
                        render: function(data) {
                            return '<span class="text-danger">' + data + '</span>';
                        }
                    },
                    { 
                        data: 'working_days', 
                        width: '3%',
                        className: 'text-center',
                        render: function(data) {
                            return '<strong>' + data + '</strong>';
                        }
                    },
                    { 
                        data: 'present', 
                        width: '3%',
                        className: 'text-center',
                        render: function(data) {
                            return '<span class="text-success">' + data + '</span>';
                        }
                    },
                    { 
                        data: 'absent', 
                        width: '3%',
                        className: 'text-center',
                        render: function(data) {
                            return '<span class="text-danger">' + data + '</span>';
                        }
                    },
                    { data: 'action', orderable: false, searchable: false },
                ];

                create_datatables(datatable_url, datatable_columns);
                
                $(document).on('click', '.btn-view-attendance', function() {
                    const userId = $(this).data('user-id');
                    const userName = $(this).data('user-name');
                    const selectedMonth = $(".month_picker").val() || "{{ date('Y-m') }}";
                    
                    loadUserAttendanceDetails(userId, userName, selectedMonth);
                });
                
                // Load user attendance details function
                function loadUserAttendanceDetails(userId, userName, month) {
                    // Show loading state
                    $('#attendanceDetailsBody').html(`
                        <tr>
                            <td colspan="6" class="text-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <p class="mt-2">Loading attendance details...</p>
                            </td>
                        </tr>
                    `);
                    
                    // Show modal with user name
                    $('#modalUserName').text(userName + "'s");
                    
                    // Format month-year for display
                    const monthYear = moment(month, "YYYY-MM").format("MMMM YYYY");
                    $('#modalMonthYear').val(monthYear);
                    
                    // Make AJAX request
                    $.ajax({
                        url: "{{ route('attendance.user.details') }}",
                        type: "GET",
                        data: {
                            user_id: userId,
                            m: month
                        },
                        success: function(response) {
                            if (response.success) {
                                populateAttendanceDetails(response.data);
                            } else {
                                $('#attendanceDetailsBody').html(`
                                    <tr>
                                        <td colspan="6" class="text-center text-danger">
                                            <i class="feather icon-alert-triangle"></i>
                                            ${response.message || 'Failed to load attendance details'}
                                        </td>
                                    </tr>
                                `);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error loading attendance details:', error);
                            $('#attendanceDetailsBody').html(`
                                <tr>
                                    <td colspan="6" class="text-center text-danger">
                                        <i class="feather icon-alert-circle"></i>
                                        Error loading attendance details. Please try again.
                                    </td>
                                </tr>
                            `);
                        }
                    });
                    
                    // Show the modal
                    $('#userAttendanceModal').modal('show');
                }
                
                // Function to populate attendance details
                function populateAttendanceDetails(data) {
                    const tbody = $('#attendanceDetailsBody');
                    tbody.empty();
                    
                    // Update summary
                    $('#modalTotalDays').val(data.total_days);
                    $('#summaryWorkingDays').text(data.working_days);
                    $('#summaryPresent').text(data.present_count);
                    $('#summaryAbsent').text(data.absent_count);
                    $('#summaryLate').text(data.late_count);
                    $('#summaryHalfDay').text(data.half_day_count);
                    $('#summaryHolidays').text(data.holidays);
                    
                    // Populate daily attendance
                    if (data.attendance.length === 0) {
                        tbody.html(`
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    <i class="feather icon-info"></i>
                                    No attendance records found for this month
                                </td>
                            </tr>
                        `);
                        return;
                    }
                    
                    data.attendance.forEach(item => {
                        const date = moment(item.date).format('DD-MM-YYYY');
                        const day = moment(item.date).format('ddd');
                        const isSunday = moment(item.date).day() === 0;
                        
                        let checkIn = 'N/A';
                        let checkOut = 'N/A';
                        
                        if (item.check_in) {
                            if (item.check_in.includes(':')) {
                                const dateTimeStr = `${item.date} ${item.check_in}`;
                                checkIn = moment(dateTimeStr).format('hh:mm A');
                            } else {
                                checkIn = moment(item.check_in).format('hh:mm A');
                            }
                        }
                        
                        if (item.check_out) {
                            if (item.check_out.includes(':')) {
                                const dateTimeStr = `${item.date} ${item.check_out}`;
                                checkOut = moment(dateTimeStr).format('hh:mm A');
                            } else {
                                checkOut = moment(item.check_out).format('hh:mm A');
                            }
                        }
                        
                        let location = item.location_name || 'N/A';
                        
                        // Determine status
                        let status = item.status || 'Absent';
                        if (isSunday) {
                            status = 'Holiday';
                        }
                        
                        // Status badge
                        let statusBadge = getStatusBadge(status);
                        
                        // Row class for Sundays
                        const rowClass = isSunday ? 'day-sunday' : '';
                        
                        tbody.append(`
                            <tr class="${rowClass}">
                                <td>${date}</td>
                                <td>${day}</td>
                                <td>${checkIn}</td>
                                <td>${checkOut}</td>
                                <td>${statusBadge}</td>
                                <td>${location}</td>
                            </tr>
                        `);
                    });
                }
                
                // Function to get status badge HTML
                function getStatusBadge(status) {
                    const statusLower = status.toLowerCase();
                    let badgeClass = 'badge-light';
                    
                    if (statusLower === 'present') {
                        badgeClass = 'badge bg-success';
                    } else if (statusLower === 'absent') {
                        badgeClass = 'badge bg-danger';
                    } else if (statusLower === 'late') {
                        badgeClass = 'badge bg-warning';
                    } else if (statusLower === 'halfday' || statusLower === 'half_day') {
                        badgeClass = 'badge bg-info';
                    } else if (statusLower === 'holiday') {
                        badgeClass = 'badge badge-holiday';
                    } else if (statusLower === 'leave') {
                        badgeClass = 'badge bg-primary';
                    }
                    
                    return `<span class="${badgeClass}">${status}</span>`;
                }
                
                // Clear filters function
                $('.clear_filters').click(function () {
                    const url = new URL(window.location.href);
                    url.searchParams.delete("s");
                    url.searchParams.delete("m");
                    url.searchParams.delete("t");
                    url.searchParams.delete("d");
                    window.location.href = url.toString();
                });
                
                // Month picker change function
                $(".month_picker").change(function () {
                    const month = $(".month_picker").val();
                    var url = new URL(window.location.href);
                    if (month) {
                        url.searchParams.set("m", month);
                    } else {
                        url.searchParams.delete("m");
                    }
                    window.location.href = url.toString();
                });
                
                // Bulk Attendance Modal Functionality
                let allUsers = [];
                let existingAttendance = {};

                // Open modal and load users
                $('#openBulkAttendanceModal').click(function(e) {
                    e.preventDefault();
                    // Clear all radio buttons
                    $('input[name="bulkStatus"]').prop('checked', false);
                    // Clear date and time fields
                    $('#bulkDate').val('');
                    $('#bulkCheckInTime').val('');
                    $('#bulkCheckOutTime').val('');
                    // Show the modal FIRST
                    $('#addattendanceModal').modal('show');
                    // Then load users
                    loadUsersForBulkAttendance();
                });

                // Load users for bulk attendance
                function loadUsersForBulkAttendance() {
                    // Show loading state
                    $('#bulkAttendanceBody').html(`
                        <tr>
                            <td colspan="6" class="text-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <p class="mt-2">Loading users...</p>
                            </td>
                        </tr>
                    `);

                    // Load active users
                    $.ajax({
                        url: "{{ route('attendance.get.active.users') }}",
                        type: "GET",
                        success: function(response) {
                            if (response.success) {
                                allUsers = response.users;
                                populateUsersTable(allUsers);
                            } else {
                                showError('Failed to load users');
                            }
                        },
                        error: function() {
                            showError('Error loading users');
                        }
                    });
                }

                // Load existing attendance for selected date
                function loadExistingAttendanceForDate() {
                    const selectedDate = $('#bulkDate').val();
                    
                    if (!selectedDate) {
                        // If no date selected, show all users with empty fields
                        populateUsersTable(allUsers);
                        return;
                    }

                    $.ajax({
                        url: "{{ route('attendance.get.existing') }}",
                        type: "GET",
                        data: {
                            date: selectedDate
                        },
                        success: function(response) {
                            if (response.success) {
                                existingAttendance = response.attendance;
                                populateUsersTable(allUsers);
                            } else {
                                existingAttendance = {};
                                populateUsersTable(allUsers);
                            }
                        },
                        error: function() {
                            existingAttendance = {};
                            populateUsersTable(allUsers);
                        }
                    });
                }

                // Populate users table
                function populateUsersTable(users) {
                    const tbody = $('#bulkAttendanceBody');
                    tbody.empty();

                    if (users.length === 0) {
                        tbody.html(`
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    <i class="feather icon-users"></i>
                                    No active users found
                                </td>
                            </tr>
                        `);
                        return;
                    }

                    const selectedDate = $('#bulkDate').val();
                    const bulkCheckIn = $('#bulkCheckInTime').val();
                    const bulkCheckOut = $('#bulkCheckOutTime').val();
                    const bulkStatus = $('input[name="bulkStatus"]:checked').val();

                    users.forEach(user => {
                        const existing = existingAttendance[user.id] || {};
                        
                        // Get values (existing first, then bulk defaults)
                        const checkInTime = existing.check_in ? formatTimeForInput(existing.check_in) : (bulkCheckIn || '');
                        const checkOutTime = existing.check_out ? formatTimeForInput(existing.check_out) : (bulkCheckOut || '');
                        const status = existing.status || (bulkStatus || '');

                        tbody.append(`
                            <tr data-user-id="${user.id}" data-attendance-id="${existing.id || ''}">
                                <td class="text-center">
                                    <input type="checkbox" class="user-checkbox" ${existing.id ? 'checked' : ''}>
                                </td>
                                <td>${user.id}</td>
                                <td>${user.name}</td>
                                <td>
                                    <input type="time" class="form-control form-control-sm check-in-time" 
                                        value="${checkInTime}" 
                                        placeholder="--:--" 
                                        ${existing.id ? 'data-original="${checkInTime}"' : ''}>
                                </td>
                                <td>
                                    <input type="time" class="form-control form-control-sm check-out-time" 
                                        value="${checkOutTime}" 
                                        placeholder="--:--"
                                        ${existing.id ? 'data-original="${checkOutTime}"' : ''}>
                                </td>
                                <td>
                                    <select class="form-control form-control-sm status-select">
                                        <option value="">-- Select --</option>
                                        <option value="Present" ${status === 'Present' ? 'selected' : ''}>Present</option>
                                        <option value="Absent" ${status === 'Absent' ? 'selected' : ''}>Absent</option>
                                        <option value="Late" ${status === 'Late' ? 'selected' : ''}>Late</option>
                                        <option value="Leave" ${status === 'Leave' ? 'selected' : ''}>Leave</option>
                                        <option value="Holiday" ${status === 'Holiday' ? 'selected' : ''}>Holiday</option>
                                        <option value="Unmarked" ${status === 'Unmarked' ? 'selected' : ''}>Unmarked</option>
                                    </select>
                                </td>
                            </tr>
                        `);
                    });

                    updateSelectAllCheckbox();
                }

                // Format time for input[type="time"]
                function formatTimeForInput(timeString) {
                    if (!timeString) return '';
                    
                    // If time is already in HH:MM format
                    if (timeString.match(/^\d{2}:\d{2}$/)) {
                        return timeString;
                    }
                    
                    // If time is in HH:MM:SS format
                    if (timeString.match(/^\d{2}:\d{2}:\d{2}$/)) {
                        return timeString.substring(0, 5);
                    }
                    
                    // If time is in 12-hour format
                    if (timeString.match(/^\d{1,2}:\d{2}\s?[AP]M$/i)) {
                        const time = moment(timeString, ['h:mm A', 'hh:mm A']);
                        return time.isValid() ? time.format('HH:mm') : '';
                    }
                    
                    return '';
                }

                // Select All functionality
                $('#selectAllCheckbox').change(function() {
                    const isChecked = $(this).prop('checked');
                    $('.user-checkbox').prop('checked', isChecked);
                    $('#selectAllUsers').prop('checked', isChecked);
                });

                $('#selectAllUsers').change(function() {
                    const isChecked = $(this).prop('checked');
                    $('.user-checkbox').prop('checked', isChecked);
                    $('#selectAllCheckbox').prop('checked', isChecked);
                });

                // Update select all checkbox when individual checkboxes change
                $(document).on('change', '.user-checkbox', function() {
                    updateSelectAllCheckbox();
                });

                function updateSelectAllCheckbox() {
                    const totalCheckboxes = $('.user-checkbox').length;
                    const checkedCheckboxes = $('.user-checkbox:checked').length;
                    
                    $('#selectAllCheckbox').prop('checked', totalCheckboxes > 0 && totalCheckboxes === checkedCheckboxes);
                    $('#selectAllUsers').prop('checked', totalCheckboxes > 0 && totalCheckboxes === checkedCheckboxes);
                }

                // Apply bulk filters to all checked rows
                $('#bulkDate').change(function() {
                    loadExistingAttendanceForDate();
                });

                $('#bulkCheckInTime, #bulkCheckOutTime').change(function() {
                    applyBulkTimeToSelected();
                });

                $('input[name="bulkStatus"]').change(function() {
                    applyBulkStatusToSelected();
                });

                function applyBulkTimeToSelected() {
                    const bulkCheckIn = $('#bulkCheckInTime').val();
                    const bulkCheckOut = $('#bulkCheckOutTime').val();
                    
                    $('.user-checkbox:checked').each(function() {
                        const row = $(this).closest('tr');
                        if (bulkCheckIn) {
                            row.find('.check-in-time').val(bulkCheckIn);
                        }
                        if (bulkCheckOut) {
                            row.find('.check-out-time').val(bulkCheckOut);
                        }
                    });
                }

                function applyBulkStatusToSelected() {
                    const bulkStatus = $('input[name="bulkStatus"]:checked').val();
                    
                    if (bulkStatus) {
                        $('.user-checkbox:checked').each(function() {
                            const row = $(this).closest('tr');
                            row.find('.status-select').val(bulkStatus);
                        });
                    }
                }

                // Search functionality
                $('#bulkSearch').on('keyup', function() {
                    const searchTerm = $(this).val().toLowerCase();
                    
                    $('#bulkAttendanceBody tr').each(function() {
                        const row = $(this);
                        const text = row.text().toLowerCase();
                        
                        if (text.includes(searchTerm)) {
                            row.show();
                        } else {
                            row.hide();
                        }
                    });
                });

                // Mark Attendance button
                $('#markAttendance').click(function() {
                    const attendanceData = [];
                    const selectedDate = $('#bulkDate').val();
                    
                    if (!selectedDate) {
                        alert('Please select a date');
                        return;
                    }

                    // Collect data from checked rows
                    $('.user-checkbox:checked').each(function() {
                        const row = $(this).closest('tr');
                        const userId = row.data('user-id');
                        const attendanceId = row.data('attendance-id');
                        const checkIn = row.find('.check-in-time').val();
                        const checkOut = row.find('.check-out-time').val();
                        const status = row.find('.status-select').val();
                        
                        // Validate required fields
                        if (!status) {
                            alert(`Please select status for user ${userId}`);
                            return false;
                        }

                        attendanceData.push({
                            attendance_id: attendanceId || null,
                            user_id: userId,
                            date: selectedDate,
                            check_in: checkIn || null,
                            check_out: checkOut || null,
                            status: status,
                        });
                    });

                    if (attendanceData.length === 0) {
                        alert('Please select at least one user');
                        return;
                    }

                    // Show loading
                    $(this).prop('disabled', true).html('<i class="feather icon-loader spinner"></i> Saving...');

                    // Submit to server
                    $.ajax({
                        url: "{{ route('attendance.bulk.save') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            attendance: attendanceData
                        },
                        success: function(response) {
                            if (response.success) {
                                alert(response.message || 'Attendance marked successfully!');
                                $('#addattendanceModal').modal('hide');
                                // Reload the main datatable
                                $('.dataTable').DataTable().ajax.reload();
                            } else {
                                alert(response.message || 'Failed to save attendance');
                            }
                        },
                        error: function(xhr) {
                            alert('Error saving attendance: ' + (xhr.responseJSON?.message || 'Please try again'));
                        },
                        complete: function() {
                            $('#markAttendance').prop('disabled', false).html('<i class="feather icon-check"></i> Mark Attendance');
                        }
                    });
                });

                // Delete selected attendance
                $('#deleteSelected').click(function() {
                    if (!confirm('Are you sure you want to delete attendance for selected users?')) {
                        return;
                    }

                    const deleteData = [];
                    const selectedDate = $('#bulkDate').val();
                    
                    if (!selectedDate) {
                        alert('Please select a date first');
                        return;
                    }
                    
                    $('.user-checkbox:checked').each(function() {
                        const row = $(this).closest('tr');
                        const userId = row.data('user-id');
                        const attendanceId = row.data('attendance-id');
                        
                        if (attendanceId) {
                            deleteData.push({
                                attendance_id: attendanceId,
                                user_id: userId,
                                date: selectedDate
                            });
                        }
                    });

                    if (deleteData.length === 0) {
                        alert('No attendance records to delete');
                        return;
                    }

                    $(this).prop('disabled', true).html('<i class="feather icon-loader spinner"></i> Deleting...');

                    $.ajax({
                        url: "{{ route('attendance.bulk.delete') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            delete_data: deleteData
                        },
                        success: function(response) {
                            if (response.success) {
                                alert(response.message || 'Attendance deleted successfully!');
                                // Reload the table to show updated data
                                loadExistingAttendanceForDate();
                            } else {
                                alert(response.message || 'Failed to delete attendance');
                            }
                        },
                        error: function() {
                            alert('Error deleting attendance');
                        },
                        complete: function() {
                            $('#deleteSelected').prop('disabled', false).html('<i class="feather icon-trash"></i> Delete');
                        }
                    });
                });

                function showError(message) {
                    $('#bulkAttendanceBody').html(`
                        <tr>
                            <td colspan="6" class="text-center text-danger">
                                <i class="feather icon-alert-circle"></i>
                                ${message}
                            </td>
                        </tr>
                    `);
                }
                // Clear search when modal closes
                $('#addattendanceModal').on('hidden.bs.modal', function () {
                    $('#bulkSearch').val('');
                    // Reset filtered rows to show all
                    $('#bulkAttendanceBody tr').show();
                });
            });
        </script>
    @endpush
    @push('styles')
        <style>
        .user-profile-list table thead th:nth-child(8),
        .user-profile-list table thead th:nth-child(9),
        .user-profile-list table thead th:nth-child(10),
        .user-profile-list table thead th:nth-child(11),
        .user-profile-list table thead th:nth-child(12) {
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            text-align: center;
            vertical-align: middle;
            height: 90px;
            white-space: nowrap;
            padding: 4px 2px;
            font-size: 13px;
        }
        /* Bulk Attendance Modal Styles */
        #bulkAttendanceTable th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        #bulkAttendanceTable tbody tr:hover {
            background-color: #f5f5f5;
        }

        .user-checkbox:checked {
            background-color: #007bff;
            border-color: #007bff;
        }

        .spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .badge-holiday {
            background-color: #ffc107;
            color: #212529;
        }

        .day-sunday {
            background-color: #fff3cd !important;
        }
        </style>
    @endpush
    
</x-app-layout>
