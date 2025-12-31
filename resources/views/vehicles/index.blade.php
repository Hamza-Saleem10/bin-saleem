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
                        data: 'image_url',
                        render: function(data, type, full, meta) {
                            if (data) {
                                return `<img src="${data}" alt="Vehicle Image" width="70" height="50" style="object-fit: cover; border-radius: 4px;">`;
                            }
                            return '<span class="text-muted">No image</span>';
                        },
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
