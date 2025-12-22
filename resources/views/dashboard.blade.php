<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <x-breadcrumb title="Dashboard" />
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->

            <!-- Bookings Analytics Graph Section -->
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h5 class="fw-bold mb-0">Bookings Analytics</h5>
                                    <p class="text-muted mb-0">Monthly booking trends and performance metrics</p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <div class="row g-2 justify-content-end">
                                        <div class="col-md-5">
                                            <select id="analytics-month" class="form-select form-select-sm">
                                                @php
                                                    $months = [
                                                        1 => 'January', 2 => 'February', 3 => 'March',
                                                        4 => 'April', 5 => 'May', 6 => 'June',
                                                        7 => 'July', 8 => 'August', 9 => 'September',
                                                        10 => 'October', 11 => 'November', 12 => 'December'
                                                    ];
                                                @endphp
                                                @foreach($months as $key => $month)
                                                    <option value="{{ $key }}" {{ $key == date('n') ? 'selected' : '' }}>
                                                        {{ $month }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <select id="analytics-year" class="form-select form-select-sm">
                                                @php
                                                    $currentYear = date('Y');
                                                    for ($year = $currentYear; $year >= $currentYear - 5; $year--) {
                                                        echo "<option value='$year' " . ($year == $currentYear ? 'selected' : '') . ">$year</option>";
                                                    }
                                                @endphp
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <button id="apply-analytics-filter" class="btn btn-primary btn-sm w-100">
                                                <i class="fas fa-filter me-1"></i> Apply
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Chart Container -->
                            <div class="row">
                                <div class="col-xl-8 col-md-7">
                                    <div class="chart-container" style="position: relative; height: 350px;">
                                        <canvas id="bookings-analytics-chart"></canvas>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-5">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <h6 class="fw-bold mb-4 text-center">Monthly Summary</h6>
                                            <div class="d-flex flex-column gap-3">
                                                <div class="d-flex justify-content-between align-items-center p-3 border rounded bg-light">
                                                    <div>
                                                        <span class="fw-medium">Total Bookings</span>
                                                        <p class="text-muted small mb-0">This month</p>
                                                    </div>
                                                    <span class="fs-5 fw-bold stats-monthly-total-bookings">0</span>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center p-3 border rounded bg-success bg-opacity-10">
                                                    <div>
                                                        <span class="fw-medium">Confirmed</span>
                                                        <p class="text-muted small mb-0">Bookings</p>
                                                    </div>
                                                    <span class="fs-5 fw-bold text-success stats-monthly-confirmed">0</span>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center p-3 border rounded bg-primary bg-opacity-10">
                                                    <div>
                                                        <span class="fw-medium">Completed</span>
                                                        <p class="text-muted small mb-0">Bookings</p>
                                                    </div>
                                                    <span class="fs-5 fw-bold text-primary stats-monthly-completed">0</span>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center p-3 border rounded bg-warning bg-opacity-10">
                                                    <div>
                                                        <span class="fw-medium">Pending</span>
                                                        <p class="text-muted small mb-0">Bookings</p>
                                                    </div>
                                                    <span class="fs-5 fw-bold text-warning stats-monthly-pending">0</span>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center p-3 border rounded bg-danger bg-opacity-10">
                                                    <div>
                                                        <span class="fw-medium">Cancelled</span>
                                                        <p class="text-muted small mb-0">Bookings</p>
                                                    </div>
                                                    <span class="fs-5 fw-bold text-danger stats-monthly-cancelled">0</span>
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

            <!-- Bookings tab -->
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <h4 class="text-center fw-bold">Bookings</h4>
                            <p  class="text-center"> Total Bookings - <span class="stats-total-bookings">0</span></p>
                            <div class="row justify-content-center g-3">
                                <div class="col-xl-2 col-md-6">
                                    <div class="card prod-p-card bg-c-blue">
                                        <div class="card-body">
                                            <div class="row align-items-center m-b-0">
                                                <div class="col">
                                                    <h6 class="m-b-5 text-white">New </br> Bookings</h6>
                                                    <h3 class="m-b-0 text-white stats-new-bookings">0</h3>
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
                                                    <h6 class="m-b-5 text-white">Pending </br> Bookings</h6>
                                                    <h3 class="m-b-0 text-white stats-pending-bookings">0</h3>
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
                                                    <h6 class="m-b-5 text-white">Confirmed </br> Bookings</h6>
                                                    <h3 class="m-b-0 text-white stats-confirmed-bookings">0</h3>
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
                                                    <h6 class="m-b-5 text-white">Completed </br> Bookings</h6>
                                                    <h3 class="m-b-0 text-white stats-completed-bookings">0</h3>
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
                                                    <h6 class="m-b-5 text-white">Cancelled </br> Bookings</h6>
                                                    <h3 class="m-b-0 text-white stats-cancelled-bookings">0</h3>
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

            <!-- Vehicles tab -->
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <h4 class="text-center fw-bold">Vehicles</h4>
                            <p  class="text-center"> Total Vehicles - <span class="stats-total-bvehicles">0</span></p>
                            <div class="row justify-content-center g-3">
                                <div class="col-xl-3 col-md-6">
                                    <div class="card prod-p-card bg-c-purple">
                                        <div class="card-body">
                                            <div class="row align-items-center m-b-0">
                                                <div class="col">
                                                    <h6 class="m-b-5 text-white">Active Vehicles</h6>
                                                    <h3 class="m-b-0 text-white stats-active-vehicles">0</h3>
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
                                                    <h6 class="m-b-5 text-white">In-Active Vehicles</h6>
                                                    <h3 class="m-b-0 text-white stats-inactive-vehicles">0</h3>
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
                                                    <h6 class="m-b-5 text-white">Under Maintenance</h6>
                                                    <h3 class="m-b-0 text-white stats-under-maintenance-vehicles">0</h3>
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
            // Global chart instance
            let bookingsChart = null;
            
            $(document).ready(function () {
                getStats();
                initializeChart();
                getMonthlyAnalytics();
                
                // Refresh stats every 30 seconds
                setInterval(getStats, 30000);
                
                // Apply analytics filter button click
                $('#apply-analytics-filter').on('click', function() {
                    getMonthlyAnalytics();
                });
                
                // Enter key on filter inputs
                $('#analytics-month, #analytics-year').on('keypress', function(e) {
                    if (e.which === 13) {
                        getMonthlyAnalytics();
                    }
                });
            });
            
            /**
             * Initialize Chart.js
             */
            const initializeChart = () => {
                const ctx = document.getElementById('bookings-analytics-chart').getContext('2d');
                
                // Destroy existing chart if it exists
                if (bookingsChart) {
                    bookingsChart.destroy();
                }
                
                bookingsChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [],
                        datasets: [
                            {
                                label: 'Confirmed Bookings',
                                data: [],
                                borderColor: '#28a745',
                                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4
                            },
                            {
                                label: 'Completed Bookings',
                                data: [],
                                borderColor: '#007bff',
                                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4
                            },
                            {
                                label: 'Pending Bookings',
                                data: [],
                                borderColor: '#ffc107',
                                backgroundColor: 'rgba(255, 193, 7, 0.1)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4
                            },
                            {
                                label: 'Cancelled Bookings',
                                data: [],
                                borderColor: '#dc3545',
                                backgroundColor: 'rgba(220, 53, 69, 0.1)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    font: {
                                        size: 11
                                    },
                                    padding: 20,
                                    usePointStyle: true,
                                }
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                                titleFont: {
                                    size: 12
                                },
                                bodyFont: {
                                    size: 12
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                title: {
                                    display: true,
                                    text: 'Days of Month',
                                    font: {
                                        size: 12,
                                        weight: 'bold'
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                },
                                title: {
                                    display: true,
                                    text: 'Number of Bookings',
                                    font: {
                                        size: 12,
                                        weight: 'bold'
                                    }
                                },
                                grid: {
                                    borderDash: [2, 2]
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'nearest'
                        }
                    }
                });
            };
            
            /**
             * Get Dashboard Stats
             */
            const getStats = () => {
                simpleAjaxCall(route('dashboard.getStats'), "POST", null, null, callbackFuncStats);
            }
            
            /**
             * Get Monthly Analytics Data
             */
            const getMonthlyAnalytics = () => {
                const month = $('#analytics-month').val();
                const year = $('#analytics-year').val();
                
                const data = {
                    month: month,
                    year: year
                };
                
                simpleAjaxCall(
                    route('dashboard.getMonthlyAnalytics'), 
                    "POST", 
                    data, 
                    null, 
                    callbackFuncAnalytics
                );
            }
            
            /**
             * Stats Callback
             * @param response
             */
            const callbackFuncStats = response => {
                if (response.status) {
                    const stats = response.stats;
                    $.each(stats, function(index, value) {
                        const _element = $(`.stats-${index}`);
                        if (_element.length) {
                            // Stop existing animation if any
                            if (_element.data('countTo')) {
                                _element.data('countTo').stop();
                            }
                            
                            _element.countTo({
                                from: parseFloat(_element.text().replace(/,/g, '')) || 0,
                                to: (value > 0) ? value : 0,
                                speed: 1000,
                                formatter: function (value, options) {
                                    return (value > 0) ? value.toFixed(options.decimals).replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 0;
                                },
                            });
                        }
                    });
                }
            }
            
            /**
             * Analytics Callback
             * @param response
             */
            const callbackFuncAnalytics = response => {
                if (response.status) {
                    const data = response.data;
                    
                    // Update chart data
                    if (bookingsChart) {
                        bookingsChart.data.labels = data.dates;
                        bookingsChart.data.datasets[0].data = data.confirmed;
                        bookingsChart.data.datasets[1].data = data.completed;
                        bookingsChart.data.datasets[2].data = data.pending;
                        bookingsChart.data.datasets[3].data = data.cancelled;
                        bookingsChart.update();
                    }
                    
                    // Update monthly summary statistics
                    const monthlyStats = data.summary;
                    $.each(monthlyStats, function(key, value) {
                        const _element = $(`.stats-monthly-${key}`);
                        if (_element.length) {
                            // Stop existing animation if any
                            if (_element.data('countTo')) {
                                _element.data('countTo').stop();
                            }
                            
                            _element.countTo({
                                from: parseFloat(_element.text().replace(/,/g, '')) || 0,
                                to: (value > 0) ? value : 0,
                                speed: 800,
                                formatter: function (value, options) {
                                    return (value > 0) ? value.toFixed(options.decimals).replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 0;
                                },
                            });
                        }
                    });
                }
            }
        </script>
    @endpush
</x-app-layout>