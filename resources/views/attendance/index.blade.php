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
                                'Total Days',
                                'Holidays',
                                'Working Days',
                                'Present',
                                'Absent',
                                'Status',
                                // 'Location',
                                'd1', 'd2', 'd3', 'd4', 'd5', 'd6', 'd7', 'd8', 'd9', 'd10', 'd11', 'd12', 'd13', 'd14', 'd15', 'd16', 'd17', 'd18', 'd19', 'd20', 'd21', 'd22', 'd23', 'd24', 'd25', 'd26', 'd27', 'd28', 'd29', 'd30', 'd31',
                                ''
                            ]"></x-table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('layouts.dataTablesFiles')
    @push('scripts')
        <script>
            $(document).ready(function () {
                const datatable_url = "{{ route('attendance.datatable') }}";
                const datatable_columns = [
                    { data: 'id' },
                    { data: 'user.name' , width: '15%' },
                    { data: 'total_days', width: '3%' },
                    { data: 'holidays', width: '3%' },
                    { 
                        data: 'working_days', width: '3%'
                    },
                    { 
                        data: 'id', width: '3%'
                    },
                    { 
                        data: 'absent', width: '3%'
                    },
                    { 
                        data: 'status',
                        orderable: false, 
                        searchable: false 
                    },
                    // { 
                    //     data: 'location',
                    //     render: function(data, type, row) {
                    //         return data || 'N/A';
                    //     },
                    //     orderable: false, 
                    //     searchable: false 
                    // },
                    { data: 'action', orderable: false, searchable: false },
                ];

                create_datatables(datatable_url, datatable_columns);
                $('.clear_filters').click(function () {
                    const url = new URL(window.location.href);
                    url.searchParams.delete("s");
                    url.searchParams.delete("m");
                    url.searchParams.delete("t");
                    url.searchParams.delete("d");

                    window.location.href = url.toString();
                });

                $(".month_picker, .district_dropdown, .tehsil_dropdown").change(function () {
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
        .user-profile-list table thead th:nth-child(4),
        .user-profile-list table thead th:nth-child(5),
        .user-profile-list table thead th:nth-child(6),
        .user-profile-list table thead th:nth-child(7),
        .user-profile-list table thead th:nth-child(8) {
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
