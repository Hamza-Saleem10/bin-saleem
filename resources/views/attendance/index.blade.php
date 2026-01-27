<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">

            <x-breadcrumb title="Attendance Report" />

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
    @include('layouts.dataTablesFiles')
    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
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
                    // { data: 'd1',  orderable: false, searchable: false, width: '30px' },
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
                        
                        let checkIn = item.check_in ? moment(item.check_in).format('hh:mm A') : 'N/A';
                        let checkOut = item.check_out ? moment(item.check_out).format('hh:mm A') : 'N/A';
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
        </style>
    @endpush
    
</x-app-layout>
