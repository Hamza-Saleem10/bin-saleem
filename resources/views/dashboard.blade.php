<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <x-breadcrumb title="Dashboard" />
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->

            <!-- Appliocations tab -->
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <h4 class="text-center fw-bold">Applications</h4>
                            <p  class="text-center"> Total Applications - <span class="stats-total-applications">0</span></p>
                            <div class="row justify-content-center g-3">
                                <div class="col-xl-2 col-md-6">
                                    <div class="card prod-p-card bg-c-blue">
                                        <div class="card-body">
                                            <div class="row align-items-center m-b-0">
                                                <div class="col">
                                                    <h6 class="m-b-5 text-white">New </br> Applications</h6>
                                                    <h3 class="m-b-0 text-white stats-new-applications">0</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-6">
                                    <div class="card prod-p-card bg-c-purple">
                                        <div class="card-body">
                                            <div class="row align-items-center m-b-0">
                                                <div class="col">
                                                    <h6 class="m-b-5 text-white">Renew </br> Applications</h6>
                                                    <h3 class="m-b-0 text-white stats-renew-applications">0</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-6">
                                    <div class="card prod-p-card bg-c-green">
                                        <div class="card-body">
                                            <div class="row align-items-center m-b-0">
                                                <div class="col">
                                                    <h6 class="m-b-5 text-white">Approved </br> Applications</h6>
                                                    <h3 class="m-b-0 text-white stats-approved-applications">0</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-6">
                                    <div class="card prod-p-card bg-c-red">
                                        <div class="card-body">
                                            <div class="row align-items-center m-b-0">
                                                <div class="col">
                                                    <h6 class="m-b-5 text-white">Rejected </br> Applications</h6>
                                                    <h3 class="m-b-0 text-white stats-rejected-applications">0</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-6">
                                    <div class="card prod-p-card bg-c-yellow">
                                        <div class="card-body">
                                            <div class="row align-items-center m-b-0">
                                                <div class="col">
                                                    <h6 class="m-b-5 text-white">Ready </br> For Review</h6>
                                                    <h3 class="m-b-0 text-white stats-under-review-applications">0</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Schools tab -->
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <h4 class="text-center fw-bold">Schools</h4>
                            <p  class="text-center"> Total Schools - <span class="stats-total-schools">0</span></p>
                            <div class="row justify-content-center g-3">
                                <div class="col-xl-3 col-md-6">
                                    <div class="card prod-p-card bg-c-purple">
                                        <div class="card-body">
                                            <div class="row align-items-center m-b-0">
                                                <div class="col">
                                                    <h6 class="m-b-5 text-white">Total Schools Created</h6>
                                                    <h3 class="m-b-0 text-white stats-created-schools">0</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card prod-p-card bg-c-green">
                                        <div class="card-body">
                                            <div class="row align-items-center m-b-0">
                                                <div class="col">
                                                    <h6 class="m-b-5 text-white">Registered Schools</h6>
                                                    <h3 class="m-b-0 text-white stats-registered-schools">0</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card prod-p-card bg-c-red">
                                        <div class="card-body">
                                            <div class="row align-items-center m-b-0">
                                                <div class="col">
                                                    <h6 class="m-b-5 text-white">Closed Schools</h6>
                                                    <h3 class="m-b-0 text-white stats-closed-schools">0</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue tab -->
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <h4 class="text-center fw-bold">Revenue</h4>
                            <p  class="text-center"> Total Revenue - <span class="stats-total-fees">0</span></p>
                            <div class="row justify-content-center g-3">
                                <div class="col-xl-3 col-md-6">
                                    <div class="card prod-p-card bg-c-blue">
                                        <div class="card-body">
                                            <div class="row align-items-center m-b-0">
                                                <div class="col">
                                                    <h6 class="m-b-5 text-white">Total Challan Generated</h6>
                                                    <h3 class="m-b-0 text-white stats-total-challans">0</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card prod-p-card bg-c-green">
                                        <div class="card-body">
                                            <div class="row align-items-center m-b-0">
                                                <div class="col">
                                                    <h6 class="m-b-5 text-white">Total Fee Collected</h6>
                                                    <h3 class="m-b-0 text-white stats-collected-fees">0</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card prod-p-card bg-c-yellow">
                                        <div class="card-body">
                                            <div class="row align-items-center m-b-0">
                                                <div class="col">
                                                    <h6 class="m-b-5 text-white">Pending Fee</h6>
                                                    <h3 class="m-b-0 text-white stats-pending-fees">0</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Licenses tab -->
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <h4 class="text-center fw-bold">Licenses</h4>
                            <p  class="text-center"> Total Licenses Issues - <span class="stats-total-licenses">0</span></p>
                            <div class="row justify-content-center g-3">
                                <div class="col-xl-3 col-md-6">
                                    <div class="card prod-p-card bg-c-purple">
                                        <div class="card-body">
                                            <div class="row align-items-center m-b-0">
                                                <div class="col">
                                                    <h6 class="m-b-5 text-white">Total License Issued</h6>
                                                    <h3 class="m-b-0 text-white stats-total-licenses">0</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card prod-p-card bg-c-blue">
                                        <div class="card-body">
                                            <div class="row align-items-center m-b-0">
                                                <div class="col">
                                                    <h6 class="m-b-5 text-white">New School License</h6>
                                                    <h3 class="m-b-0 text-white stats-new-license">0</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card prod-p-card bg-c-yellow">
                                        <div class="card-body">
                                            <div class="row align-items-center m-b-0">
                                                <div class="col">
                                                    <h6 class="m-b-5 text-white">Renewal License</h6>
                                                    <h3 class="m-b-0 text-white stats-renew-license">0</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
    @push('scripts')
        <script src="{{ asset('js/jquery.countTo.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                getStats();
            });

            /**
             * Get Stats
             */
            const getStats = () => {
                simpleAjaxCall(route('dashboard.getStats'), "POST", null, null, callbackFuncStats);
            }
    
            /**
             * Callback
             * @param response
             */
            const callbackFuncStats = response => {
                if (response.status) {
                    const stats = response.stats;
                    $.each(stats, function(index, value) {
                        const _element = $(`.stats-${index}`);
                        console
                        _element.countTo({
                            from: 0,
                            to: (value > 0) ? value : 0,
                            speed: 1000,
                            formatter: function (value, options) {
                                return (value > 0) ? value.toFixed(options.decimals).replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 0;
                            },
                        });
                    });
                }
            }
        </script>
    @endpush
</x-app-layout>
