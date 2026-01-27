<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <x-breadcrumb title="Dashboard Overview" />
            <!-- [ breadcrumb ] end -->

            <!-- Quick Stats Row -->
            <div class="row mb-4">
                <!-- Total Bookings -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                                        Total Bookings
                                    </div>
                                    <div class="h5 mb-0 fw-bold stats-total-bookings">0</div>
                                    <div class="text-xs text-muted mt-1">
                                        <i class="fas fa-clock me-1"></i>
                                        <span id="stats-updated-time">Just now</span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Today's Revenue -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs fw-bold text-success text-uppercase mb-1">
                                        Today's Revenue
                                    </div>
                                    <div class="h5 mb-0 fw-bold">$<span class="stats-today-revenue">0</span></div>
                                    <div class="text-xs text-muted mt-1">
                                        <i class="fas fa-arrow-up text-success me-1"></i>
                                        <span class="revenue-trend">12%</span> from yesterday
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Vehicles -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs fw-bold text-info text-uppercase mb-1">
                                        Active Vehicles
                                    </div>
                                    <div class="h5 mb-0 fw-bold stats-active-vehicles">0</div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="text-xs fw-bold text-muted mt-1">
                                                <span class="stats-available-vehicles">0</span> available
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-car fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Monthly Revenue -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs fw-bold text-warning text-uppercase mb-1">
                                        Monthly Revenue
                                    </div>
                                    <div class="h5 mb-0 fw-bold">$<span class="stats-monthly-revenue">0</span></div>
                                    <div class="text-xs text-muted mt-1">
                                        <i class="fas fa-calendar me-1"></i>
                                        Current month
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Analytics Section -->
            <div class="row mb-4">
                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 fw-bold text-primary">
                                <i class="fas fa-chart-line me-2"></i>
                                Booking Performance Analytics
                            </h6>
                            <div class="dropdown no-arrow">
                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" 
                                        id="chartTypeDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-chart-bar me-1"></i> Chart Type
                                </button>
                                <div class="dropdown-menu dropdown-menu-end shadow animated--fade-in" 
                                     aria-labelledby="chartTypeDropdown">
                                    <a class="dropdown-item chart-type-btn active" href="#" data-type="line">
                                        <i class="fas fa-chart-line me-2"></i> Line Chart
                                    </a>
                                    <a class="dropdown-item chart-type-btn" href="#" data-type="bar">
                                        <i class="fas fa-chart-bar me-2"></i> Bar Chart
                                    </a>
                                    <a class="dropdown-item chart-type-btn" href="#" data-type="mixed">
                                        <i class="fas fa-chart-area me-2"></i> Mixed Chart
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Chart Controls -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </span>
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
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </span>
                                        <select id="analytics-year" class="form-select form-select-sm">
                                            @php
                                                $currentYear = date('Y');
                                                for ($year = $currentYear; $year >= $currentYear - 10; $year--) {
                                                    echo "<option value='$year' " . ($year == $currentYear ? 'selected' : '') . ">$year</option>";
                                                }
                                            @endphp
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="btn-group btn-group-sm w-100" role="group">
                                        <button type="button" class="btn btn-outline-primary active" data-period="month">
                                            <i class="fas fa-calendar me-1"></i> Monthly
                                        </button>
                                        <button type="button" class="btn btn-outline-primary" data-period="quarter">
                                            <i class="fas fa-chart-pie me-1"></i> Quarterly
                                        </button>
                                        <button type="button" class="btn btn-outline-primary" data-period="year">
                                            <i class="fas fa-chart-line me-1"></i> Yearly
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Chart Container -->
                            <div class="chart-container" style="position: relative; height: 320px;">
                                <canvas id="performanceChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Distribution & Summary -->
                <div class="col-xl-4 col-lg-5">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 fw-bold text-primary">
                                <i class="fas fa-chart-pie me-2"></i>
                                Status Distribution
                            </h6>
                        </div>
                        <div class="card-body">
                            <!-- Pie Chart -->
                            <div class="chart-container" style="position: relative; height: 200px; margin-bottom: 20px;">
                                <canvas id="statusPieChart"></canvas>
                            </div>
                            
                            <!-- Monthly Summary -->
                            <div class="mt-4">
                                <h6 class="fw-bold text-dark mb-3" id="current-month-title">
                                    {{ date('F Y') }} Summary
                                </h6>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="border-start border-3 border-primary ps-3">
                                            <div class="small text-muted">Total Bookings</div>
                                            <div class="fw-bold fs-5 stats-monthly-total">0</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="border-start border-3 border-success ps-3">
                                            <div class="small text-muted">Revenue</div>
                                            <div class="fw-bold fs-5">$<span class="stats-monthly-revenue-summary">0</span></div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="border-start border-3 border-info ps-3">
                                            <div class="small text-muted">Confirmed</div>
                                            <div class="fw-bold fs-5 text-info stats-monthly-confirmed">0</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="border-start border-3 border-warning ps-3">
                                            <div class="small text-muted">Pending</div>
                                            <div class="fw-bold fs-5 text-warning stats-monthly-pending">0</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Trend Indicators -->
                                <div class="mt-4 pt-3 border-top">
                                    <h6 class="fw-bold text-dark mb-2">Performance Trends</h6>
                                    <div class="d-flex justify-content-between">
                                        <div class="text-center">
                                            <div class="small text-muted">Confirmed Trend</div>
                                            <div class="fw-bold">
                                                <span id="confirmed-trend" class="text-success">0%</span>
                                                <i class="fas fa-arrow-up text-success ms-1"></i>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <div class="small text-muted">Revenue Trend</div>
                                            <div class="fw-bold">
                                                <span id="revenue-trend-summary" class="text-success">0%</span>
                                                <i class="fas fa-arrow-up text-success ms-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Statistics Section -->
            <div class="row">
                <!-- Bookings Statistics -->
                <div class="col-xl-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 fw-bold text-primary">
                                <i class="fas fa-bookmark me-2"></i>
                                Bookings Statistics
                            </h6>
                            <span class="badge bg-primary">Real-time</span>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <div class="text-center p-3 border rounded-3 bg-primary bg-opacity-10">
                                        <div class="text-primary mb-2">
                                            <i class="fas fa-bell fa-2x"></i>
                                        </div>
                                        <div class="fw-bold fs-4 stats-new-bookings">0</div>
                                        <div class="small text-muted">New Today</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center p-3 border rounded-3 bg-success bg-opacity-10">
                                        <div class="text-success mb-2">
                                            <i class="fas fa-check-circle fa-2x"></i>
                                        </div>
                                        <div class="fw-bold fs-4 stats-confirmed-bookings">0</div>
                                        <div class="small text-muted">Confirmed</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center p-3 border rounded-3 bg-warning bg-opacity-10">
                                        <div class="text-warning mb-2">
                                            <i class="fas fa-clock fa-2x"></i>
                                        </div>
                                        <div class="fw-bold fs-4 stats-pending-bookings">0</div>
                                        <div class="small text-muted">Pending</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-center p-3 border rounded-3 bg-info bg-opacity-10">
                                        <div class="text-info mb-2">
                                            <i class="fas fa-flag-checkered fa-2x"></i>
                                        </div>
                                        <div class="fw-bold fs-4 stats-completed-bookings">0</div>
                                        <div class="small text-muted">Completed</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-center p-3 border rounded-3 bg-danger bg-opacity-10">
                                        <div class="text-danger mb-2">
                                            <i class="fas fa-times-circle fa-2x"></i>
                                        </div>
                                        <div class="fw-bold fs-4 stats-cancelled-bookings">0</div>
                                        <div class="small text-muted">Cancelled</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vehicles Statistics -->
                <div class="col-xl-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 fw-bold text-primary">
                                <i class="fas fa-car me-2"></i>
                                Vehicles Fleet Status
                            </h6>
                            <span class="badge bg-primary">Total: <span class="stats-total-vehicles">0</span></span>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <div class="text-center p-3 border rounded-3 bg-success bg-opacity-25">
                                        <div class="text-success mb-2">
                                            <i class="fas fa-check fa-2x"></i>
                                        </div>
                                        <div class="fw-bold fs-4 stats-active-vehicles-detailed">0</div>
                                        <div class="small text-muted">Active</div>
                                        <div class="progress mt-2" style="height: 5px;">
                                            <div class="progress-bar bg-success" role="progressbar" 
                                                 id="active-vehicles-progress" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center p-3 border rounded-3 bg-secondary bg-opacity-25">
                                        <div class="text-secondary mb-2">
                                            <i class="fas fa-pause fa-2x"></i>
                                        </div>
                                        <div class="fw-bold fs-4 stats-inactive-vehicles">0</div>
                                        <div class="small text-muted">Inactive</div>
                                        <div class="progress mt-2" style="height: 5px;">
                                            <div class="progress-bar bg-secondary" role="progressbar" 
                                                 id="inactive-vehicles-progress" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center p-3 border rounded-3 bg-warning bg-opacity-25">
                                        <div class="text-warning mb-2">
                                            <i class="fas fa-wrench fa-2x"></i>
                                        </div>
                                        <div class="fw-bold fs-4 stats-under-maintenance-vehicles">0</div>
                                        <div class="small text-muted">Maintenance</div>
                                        <div class="progress mt-2" style="height: 5px;">
                                            <div class="progress-bar bg-warning" role="progressbar" 
                                                 id="maintenance-vehicles-progress" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Vehicle Status Breakdown -->
                            <div class="mt-4 pt-3 border-top">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="small text-muted">Available Vehicles</span>
                                    <span class="fw-bold stats-available-vehicles-detailed">0</span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-success" role="progressbar" 
                                         id="available-vehicles-progress" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Bookings Section -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card shadow">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 fw-bold text-primary">
                                <i class="fas fa-history me-2"></i>
                                Recent Bookings
                            </h6>
                            <button class="btn btn-sm btn-outline-primary" id="refresh-recent-bookings">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="recent-bookings-table">
                                    <thead>
                                        <tr>
                                            <th>Voucher No</th>
                                            <th>Customer</th>
                                            <th>Vehicle</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Booking Date</th>
                                            <th>Created By</th>
                                            <th>Action</th>
                                        </tr>   
                                    </thead>
                                    <tbody id="recent-bookings-body">
                                        <!-- Will be populated by JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('js/jquery.countTo.js') }}"></script>
        <script src="{{ asset('plugins/highcharts/exporting.js') }}"></script>

        <script type="text/javascript">

            // Global variables
            let performanceChart = null;
            let statusPieChart = null;
            let currentChartType = 'line';

            // Check if Chart.js is loaded
            console.log('Chart.js loaded:', typeof Chart !== 'undefined');

            $(document).ready(function () {
                console.log('Dashboard loaded, initializing charts...');
                
                // Check if canvas elements exist
                console.log('performanceChart canvas:', document.getElementById('performanceChart'));
                console.log('statusPieChart canvas:', document.getElementById('statusPieChart'));
                
                // Initial data load
                getStats();
                getMonthlyAnalytics();
                
                // Set up intervals for real-time updates
                setInterval(getStats, 15000);
                
                // Event Listeners
                $('.chart-type-btn').on('click', function(e) {
                    e.preventDefault();
                    $('.chart-type-btn').removeClass('active');
                    $(this).addClass('active');
                    currentChartType = $(this).data('type');
                    updateChartType();
                });
                
                // Period buttons
                $('[data-period]').on('click', function() {
                    $('[data-period]').removeClass('active');
                    $(this).addClass('active');
                    getMonthlyAnalytics();
                });

                // Month/year change listeners
                $('#analytics-month, #analytics-year').on('change', function() {
                    getMonthlyAnalytics();
                });
            });

            /**
             * Get Dashboard Statistics
             */
            function getStats() {
                console.log('Fetching stats from:', '{{ route("dashboard.getStats") }}');
                
                $.ajax({
                    url: '{{ route("dashboard.getStats") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('Stats response:', response);
                        updateStats(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching stats:', error);
                        console.log('Status:', status);
                        console.log('Response:', xhr.responseText);
                    }
                });
            }

            /**
            * Get Monthly Analytics
            */
            function getMonthlyAnalytics() {
                const month = $('#analytics-month').val();
                const year = $('#analytics-year').val();
                
                console.log('Fetching analytics for month:', month, 'year:', year);
                
                $.ajax({
                    url: '{{ route("dashboard.getMonthlyAnalytics") }}',
                    method: 'POST',
                    data: {
                        month: month,
                        year: year,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('Analytics response:', response);
                        updateAnalytics(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching analytics:', error);
                        console.log('Status:', status);
                        console.log('Response:', xhr.responseText);
                    }
                });
            }

            /**
            * Update Statistics Display
            */
            function updateStats(response) {
                console.log('updateStats called with:', response);
                if (response.status) {
                    const stats = response.stats;
                    
                    // Update all stat elements
                    $('.stats-total-bookings').text(stats['total-bookings'] || 0);
                    $('.stats-today-revenue').text(stats['today-revenue'] || 0);
                    $('.stats-active-vehicles').text(stats['active-vehicles'] || 0);
                    $('.stats-available-vehicles').text(stats['available-vehicles'] || 0);
                    $('.stats-monthly-revenue').text(stats['monthly-revenue'] || 0);
                    $('.stats-new-bookings').text(stats['new-bookings'] || 0);
                    $('.stats-confirmed-bookings').text(stats['confirmed-bookings'] || 0);
                    $('.stats-pending-bookings').text(stats['pending-bookings'] || 0);
                    $('.stats-completed-bookings').text(stats['completed-bookings'] || 0);
                    $('.stats-cancelled-bookings').text(stats['cancelled-bookings'] || 0);
                    $('.stats-total-vehicles').text(stats['total-vehicles'] || 0);
                    $('.stats-active-vehicles-detailed').text(stats['active-vehicles'] || 0);
                    $('.stats-inactive-vehicles').text(stats['inactive-vehicles'] || 0);
                    $('.stats-available-vehicles-detailed').text(stats['available-vehicles'] || 0);
                    
                    // Update timestamp
                    $('#stats-updated-time').text('Just now');
                }
            }

            /**
            * Update Analytics Charts and Summary
            */
            function updateAnalytics(response) {
                console.log('updateAnalytics called with:', response);
                if (response.status) {
                    const data = response.data;
                    console.log('Analytics data:', data);
                    
                    // Update month title
                    $('#current-month-title').text(data.month_name || 'Summary');
                    
                    // Update performance chart
                    updatePerformanceChart(data);
                    
                    // Update pie chart
                    updateStatusPieChart(data);
                    
                    // Update summary statistics
                    updateSummaryStats(data);
                    
                    // Update trends
                    if (data.trends) {
                        updateTrendIndicators(data.trends);
                    }
                }
            }

            /**
            * Update Performance Chart
            */
            function updatePerformanceChart(data) {
                const ctx = document.getElementById('performanceChart');
                
                if (!ctx) {
                    console.error('performanceChart canvas not found!');
                    return;
                }
                
                console.log('Creating performance chart with data:', data);
                
                // Destroy existing chart
                if (performanceChart) {
                    console.log('Destroying existing performance chart');
                    performanceChart.destroy();
                }
                
                try {
                    // Create new chart
                    performanceChart = new Chart(ctx, {
                        type: currentChartType === 'bar' ? 'bar' : 'line',
                        data: {
                            labels: data.dates.map((d, i) => `Day ${d}`),
                            datasets: [
                                {
                                    label: 'Confirmed',
                                    data: data.confirmed || [],
                                    borderColor: '#4e73df',
                                    backgroundColor: currentChartType === 'bar' ? 
                                        'rgba(78, 115, 223, 0.7)' : 'rgba(78, 115, 223, 0.1)',
                                    tension: 0.4,
                                    fill: currentChartType !== 'bar'
                                },
                                {
                                    label: 'Completed',
                                    data: data.completed || [],
                                    borderColor: '#1cc88a',
                                    backgroundColor: currentChartType === 'bar' ? 
                                        'rgba(28, 200, 138, 0.7)' : 'rgba(28, 200, 138, 0.1)',
                                    tension: 0.4,
                                    fill: currentChartType !== 'bar'
                                },
                                {
                                    label: 'Pending',
                                    data: data.pending || [],
                                    borderColor: '#f6c23e',
                                    backgroundColor: currentChartType === 'bar' ? 
                                        'rgba(246, 194, 62, 0.7)' : 'rgba(246, 194, 62, 0.1)',
                                    tension: 0.4,
                                    fill: currentChartType !== 'bar'
                                },
                                {
                                    label: 'Cancelled',
                                    data: data.cancelled || [],
                                    borderColor: '#e74a3b',
                                    backgroundColor: currentChartType === 'bar' ? 
                                        'rgba(231, 74, 59, 0.7)' : 'rgba(231, 74, 59, 0.1)',
                                    tension: 0.4,
                                    fill: currentChartType !== 'bar'
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'top',
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0
                                    }
                                }
                            }
                        }
                    });
                    console.log('Performance chart created successfully');
                } catch (error) {
                    console.error('Error creating performance chart:', error);
                }
            }

            /**
            * Update Status Pie Chart
            */
            function updateStatusPieChart(data) {
                const ctx = document.getElementById('statusPieChart');
                
                if (!ctx) {
                    console.error('statusPieChart canvas not found!');
                    return;
                }
                
                console.log('Creating status pie chart with data:', data.summary);
                
                if (statusPieChart) {
                    console.log('Destroying existing status pie chart');
                    statusPieChart.destroy();
                }
                
                try {
                    statusPieChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Confirmed', 'Completed', 'Pending', 'Cancelled'],
                            datasets: [{
                                data: [
                                    data.summary.confirmed || 0,
                                    data.summary.completed || 0,
                                    data.summary.pending || 0,
                                    data.summary.cancelled || 0
                                ],
                                backgroundColor: [
                                    '#4e73df',
                                    '#1cc88a',
                                    '#f6c23e',
                                    '#e74a3b'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                }
                            }
                        }
                    });
                    console.log('Status pie chart created successfully');
                } catch (error) {
                    console.error('Error creating status pie chart:', error);
                }
            }

            /**
            * Update Summary Statistics
            */
            function updateSummaryStats(data) {
                const summary = data.summary;
                console.log('Updating summary stats:', summary);
                
                // Update summary elements
                $('.stats-monthly-total').text(summary.total || 0);
                $('.stats-monthly-revenue-summary').text(summary.revenue || 0);
                $('.stats-monthly-confirmed').text(summary.confirmed || 0);
                $('.stats-monthly-pending').text(summary.pending || 0);
            }

            /**
            * Update Trend Indicators
            */
            function updateTrendIndicators(trends) {
                console.log('Updating trend indicators:', trends);
                updateTrendElement('#confirmed-trend', trends.confirmed_trend);
                updateTrendElement('#revenue-trend-summary', trends.revenue_trend);
            }

            /**
            * Update Trend Element
            */
            function updateTrendElement(selector, value) {
                const element = $(selector);
                element.text(value > 0 ? `+${value}%` : `${value}%`);
                
                // Update color based on value
                if (value > 0) {
                    element.removeClass('text-danger text-muted').addClass('text-success');
                    element.next('i').removeClass('fa-arrow-down text-danger').addClass('fa-arrow-up text-success');
                } else if (value < 0) {
                    element.removeClass('text-success text-muted').addClass('text-danger');
                    element.next('i').removeClass('fa-arrow-up text-success').addClass('fa-arrow-down text-danger');
                } else {
                    element.removeClass('text-success text-danger').addClass('text-muted');
                }
            }

            /**
            * Update Chart Type
            */
            function updateChartType() {
                console.log('Updating chart type to:', currentChartType);
                if (performanceChart) {
                    getMonthlyAnalytics();
                }
            }
            
            $(document).ready(function() {
                // Function to load recent bookings
                function loadRecentBookings() {
                    $.ajax({
                        url: '{{ route("dashboard.getRecentBookings") }}',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            _token: '{{ csrf_token() }}',
                            limit: 10
                        },
                        beforeSend: function() {
                            // Show loading indicator
                            $('#recent-bookings-body').html(
                                '<tr><td colspan="8" class="text-center">' +
                                '<div class="spinner-border spinner-border-sm" role="status">' +
                                '<span class="visually-hidden">Loading...</span>' +
                                '</div> Loading bookings...' +
                                '</td></tr>'
                            );
                        },
                        success: function(response) {
                            if (response.status && response.bookings.length > 0) {
                                let html = '';
                                response.bookings.forEach(function(booking) {
                                    html += `
                                        <tr>
                                            <td>${booking.voucher_number}</td>
                                            <td>${booking.customer_name}</td>
                                            <td>${booking.vehicle_name}</td>
                                            <td>${formatCurrency(booking.total_amount)}</td>
                                            <td>
                                                ${formatStatusBadge(booking.status)}
                                            </td>
                                            <td>${booking.created_at}</td>
                                            <td>${booking.created_by_name}</td>
                                            <td>
                                                <a href="/bookings/${booking.id}" class="btn btn-sm btn-outline-primary" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    `;
                                });
                                $('#recent-bookings-body').html(html);
                            } else {
                                $('#recent-bookings-body').html(
                                    '<tr><td colspan="8" class="text-center text-muted">No bookings found</td></tr>'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error loading recent bookings:', error);
                            $('#recent-bookings-body').html(
                                '<tr><td colspan="8" class="text-center text-danger">' +
                                'Error loading bookings. Please try again.' +
                                '</td></tr>'
                            );
                        }
                    });
                }

                // Format currency function
                // function formatCurrency(amount) {
                //     return '₹' + parseFloat(amount).toFixed(2); // Change currency symbol as needed
                // }
                function formatCurrency(amount) {
                    return new Intl.NumberFormat('en-SA', {
                        style: 'currency',
                        currency: 'SAR'
                    }).format(amount);
                }

                // Load bookings on page load
                loadRecentBookings();

                // Refresh button click event
                $('#refresh-recent-bookings').click(function() {
                    loadRecentBookings();
                    
                    // Add rotation animation to refresh icon
                    const icon = $(this).find('i');
                    icon.css('transform', 'rotate(360deg)');
                    icon.css('transition', 'transform 0.5s ease');
                    
                    setTimeout(() => {
                        icon.css('transform', 'rotate(0deg)');
                    }, 500);
                });

                // Optional: Auto-refresh every 30 seconds
                setInterval(loadRecentBookings, 30000);
            });
            function formatStatusBadge(status) {
                const statusLower = status.toLowerCase();
                let badgeClass = 'bg-secondary';
                let statusText = status.charAt(0).toUpperCase() + status.slice(1);
                
                switch(statusLower) {
                    case 'pending':
                        badgeClass = 'bg-warning';
                        break;
                    case 'confirmed':
                        badgeClass = 'bg-success';
                        break;
                    case 'completed':
                        badgeClass = 'bg-info';
                        break;
                    case 'cancelled':
                        badgeClass = 'bg-danger';
                        break;
                    default:
                        badgeClass = 'bg-secondary';
                }
                
                return `<span class="badge ${badgeClass}">${statusText}</span>`;
            }
        </script>
    @endpush
</x-app-layout>