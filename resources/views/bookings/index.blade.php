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
                        data: 'voucher_number',
                    },
                    {
                        data: 'customer_name',
                    },
                    
                    {
                        data: 'customer_contact'
                    },
                    {
                        data: 'vehicle'
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
            });
        </script>
    @endpush
</x-app-layout>
