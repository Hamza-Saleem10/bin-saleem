<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <x-breadcrumb title="Mark Attendance" />
            
            <div class="attendance-dashboard">
                <!-- Header -->
                {{-- <div class="dashboard-header">
                    <div class="header-title">
                        <h1><i class="fas fa-clock"></i> Attendance System</h1>
                        <p>Professional Time & Location Tracking</p>
                    </div>
                    <div class="header-time" id="currentTime"></div>
                </div> --}}

                <!-- Status & Controls -->
                <div class="dashboard-section">
                    <div class="dashboard-card status-card">
                        <div class="card-header">
                            <h3><i class="fas fa-chart-line"></i> Today's Status</h3>
                        </div>
                        <div class="card-body" id="todayStatus">
                            <div class="status-loading">
                                <i class="fas fa-spinner fa-spin"></i>
                                <span>Loading status...</span>
                            </div>
                        </div>
                    </div>

                    <div class="dashboard-card controls-card">
                        <div class="card-header">
                            <h3><i class="fas fa-user-check"></i> Attendance Controls</h3>
                        </div>
                        <div class="card-body">
                            <div class="controls-grid">
                                <button id="btnCheckIn" class="control-btn checkin" disabled>
                                    <i class="fas fa-sign-in-alt"></i>
                                    <span>Check In</span>
                                    <small>Start your workday</small>
                                </button>
                                <button id="btnCheckOut" class="control-btn checkout" disabled>
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Check Out</span>
                                    <small>End your workday</small>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="dashboard-card location-card">
                        <div class="card-header">
                            <h3><i class="fas fa-map-marker-alt"></i> Location</h3>
                            <div class="location-status" id="locationStatus">
                                <i class="fas fa-sync fa-spin"></i>
                                <span>Getting location...</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="location-info">
                                <div class="coordinates">
                                    <div>
                                        <label>Latitude</label>
                                        <div id="latitudeValue">--.--</div>
                                    </div>
                                    <div>
                                        <label>Longitude</label>
                                        <div id="longitudeValue">--.--</div>
                                    </div>
                                    <div>
                                        <label>Accuracy</label>
                                        <div id="accuracyValue">-- m</div>
                                    </div>
                                </div>
                                <div class="address">
                                    <i class="fas fa-building"></i>
                                    <div id="currentAddress">Waiting for location...</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attendance History -->
                <div class="dashboard-card history-card">
                    <div class="card-header">
                        <h3><i class="fas fa-history"></i> Today's Records</h3>
                        <button id="refreshAttendance" class="refresh-btn">
                            <i class="fas fa-redo"></i> Refresh
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="attendanceTable">
                                <thead>
                                    <tr>
                                        <th>Time</th>
                                        <th>Type</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="attendanceBody">
                                    <tr>
                                        <td colspan="4" class="empty-state">
                                            <i class="far fa-calendar-times"></i>
                                            <span>No attendance records today</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            class AttendanceSystem {
                constructor() {
                    this.currentLocation = null;
                    this.watchId = null;
                    this.init();
                }

                init() {
                    this.updateTime();
                    setInterval(() => this.updateTime(), 1000);
                    
                    this.loadTodayAttendance();
                    this.getLocation();
                    
                    $('#btnCheckIn').click(() => this.markAttendance('check_in'));
                    $('#btnCheckOut').click(() => this.markAttendance('check_out'));
                    $('#refreshAttendance').click(() => this.loadTodayAttendance());
                }

                updateTime() {
                    const now = new Date();
                    $('#currentTime').html(`
                        <div class="time">${now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</div>
                        <div class="date">${now.toLocaleDateString([], {weekday: 'long', month: 'long', day: 'numeric'})}</div>
                    `);
                }

                getLocation() {
                    if (!navigator.geolocation) return this.updateLocationStatus('error', 'Not supported');
                    
                    this.updateLocationStatus('loading', 'Getting location...');
                    
                    navigator.geolocation.getCurrentPosition(
                        position => this.onLocationSuccess(position),
                        error => this.onLocationError(error),
                        { enableHighAccuracy: true, timeout: 10000 }
                    );
                    
                    this.watchId = navigator.geolocation.watchPosition(
                        position => this.onLocationSuccess(position),
                        error => console.error('Location watch error:', error),
                        { enableHighAccuracy: true, timeout: 10000 }
                    );
                }

                onLocationSuccess(position) {
                    this.currentLocation = position;
                    this.updateLocationInfo(position);
                    this.updateLocationStatus('success', 'Active');
                    $('#btnCheckIn').prop('disabled', false);
                }

                onLocationError(error) {
                    const messages = {
                        1: "Permission denied",
                        2: "Position unavailable",
                        3: "Request timeout",
                        0: "Unknown error"
                    };
                    this.updateLocationStatus('error', 'Unavailable');
                    $('#currentAddress').text(messages[error.code] || "Location error");
                }

                updateLocationStatus(status, message) {
                    const icons = { 
                        loading: 'fa-sync fa-spin', 
                        success: 'fa-check-circle', 
                        error: 'fa-exclamation-circle' 
                    };
                    $('#locationStatus').html(`<i class="fas ${icons[status]}"></i><span>${message}</span>`);
                }

                updateLocationInfo(position) {
                    const coords = position.coords;
                    $('#latitudeValue').text(coords.latitude.toFixed(6));
                    $('#longitudeValue').text(coords.longitude.toFixed(6));
                    $('#accuracyValue').text(`${coords.accuracy.toFixed(1)} m`);
                    this.reverseGeocode(coords.latitude, coords.longitude);
                }

                reverseGeocode(lat, lng) {
                    $.ajax({
                        url: 'https://nominatim.openstreetmap.org/reverse',
                        method: 'GET',
                        data: { format: 'json', lat, lon: lng, zoom: 18, addressdetails: 1 },
                        headers: { 'User-Agent': 'AttendanceSystem/1.0' },
                        success: response => {
                            const address = response.display_name ? 
                                response.display_name.split(',').slice(0, 3).join(',') : 
                                'Address unavailable';
                            $('#currentAddress').text(address);
                        },
                        error: () => $('#currentAddress').text('Address unavailable')
                    });
                }

                async markAttendance(type) {
                    if (!this.currentLocation) return this.showAlert('Enable location services', 'error');
                    
                    const btn = $(`#btn${type === 'check_in' ? 'CheckIn' : 'CheckOut'}`);
                    const original = btn.html();
                    
                    btn.html(`<i class="fas fa-spinner fa-spin"></i><span>Processing...</span>`).prop('disabled', true);
                    
                    try {
                        const response = await $.ajax({
                            url: '/api/attendance/mark',
                            method: 'POST',
                            data: { 
                                type, 
                                latitude: this.currentLocation.coords.latitude, 
                                longitude: this.currentLocation.coords.longitude, 
                                _token: '{{ csrf_token() }}' 
                            }
                        });
                        
                        if (response.success) {
                            this.showAlert(response.message, 'success');
                            btn.addClass('pulse');
                            setTimeout(() => btn.removeClass('pulse'), 600);
                        } else {
                            this.showAlert(response.message || 'Error', 'error');
                        }
                    } catch (xhr) {
                        console.error('Attendance error:', xhr.responseJSON);
                        this.showAlert(xhr.responseJSON?.message || 'Network error', 'error');
                    } finally {
                        btn.html(original);
                        this.loadTodayAttendance();
                    }
                }

                loadTodayAttendance() {
                    $.ajax({
                        url: '{{ route("attendance.today") }}',
                        method: 'GET',
                        beforeSend: () => {
                            $('#attendanceBody').html(`
                                <tr><td colspan="4" class="loading-state">
                                    <i class="fas fa-spinner fa-spin"></i>
                                    <span>Loading...</span>
                                </td></tr>
                            `);
                        },
                        success: response => {
                            if (response.success) {
                                this.updateAttendanceTable(response.data);
                                this.updateStatus(response.data);
                            } else {
                                this.updateAttendanceTable(null);
                                this.updateStatus(null);
                            }
                        },
                        error: () => {
                            $('#attendanceBody').html(`
                                <tr><td colspan="4" class="error-state">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <span>Load error</span>
                                </td></tr>
                            `);
                            this.updateStatus(null);
                        }
                    });
                }

                updateAttendanceTable(attendance) {
                    const tbody = $('#attendanceBody');
                    
                    if (!attendance || (!attendance.check_in && !attendance.check_out)) {
                        tbody.html(`<tr><td colspan="4" class="empty-state">
                            <i class="far fa-calendar-times"></i>
                            <span>No attendance records today</span>
                        </td></tr>`);
                        return;
                    }
                    
                    tbody.empty();
                    
                    if (attendance.check_in) {
                        this.addAttendanceRow(tbody, attendance.check_in, 'CHECK IN', attendance);
                    }
                    
                    if (attendance.check_out) {
                        this.addAttendanceRow(tbody, attendance.check_out, 'CHECK OUT', attendance);
                    }
                }

                addAttendanceRow(tbody, datetime, type, attendance) {
                    const time = this.formatDateTime(datetime);
                    const locationName = attendance.location?.location_name || 'Office';
                    const typeClass = type === 'CHECK IN' ? 'type-in' : 'type-out';
                    
                    tbody.append(`
                        <tr>
                            <td>
                                <div class="record-time">${time.time}</div>
                                <div class="record-date">${time.date}</div>
                            </td>
                            <td><span class="badge ${typeClass}">${type}</span></td>
                            <td>${locationName}</td>
                            <td><span class="badge status-${attendance.status?.toLowerCase() || 'pending'}">${attendance.status?.toUpperCase() || 'PENDING'}</span></td>
                        </tr>
                    `);
                }

                updateStatus(attendance) {
                    const statusDiv = $('#todayStatus');
                    
                    if (!attendance || (!attendance.check_in && !attendance.check_out)) {
                        statusDiv.html(`
                            <div class="status-item not-checked">
                                <i class="fas fa-user-clock"></i>
                                <div>
                                    <h4>Not Checked In</h4>
                                    <p>Ready to start</p>
                                </div>
                            </div>
                        `);
                        $('#btnCheckIn').prop('disabled', !this.currentLocation);
                        $('#btnCheckOut').prop('disabled', true);
                        return;
                    }
                    
                    let html = '';
                    
                    if (attendance.check_in) {
                        const checkInTime = this.formatDateTime(attendance.check_in);
                        html += `
                            <div class="status-item checked-in">
                                <i class="fas fa-check-circle"></i>
                                <div>
                                    <h4>Checked In</h4>
                                    <p>${checkInTime.time} • ${attendance.status || 'Present'}</p>
                                </div>
                            </div>
                        `;
                        
                        $('#btnCheckIn').prop('disabled', true);
                        $('#btnCheckOut').prop('disabled', !!attendance.check_out);
                    }
                    
                    if (attendance.check_out) {
                        const checkOutTime = this.formatDateTime(attendance.check_out);
                        html += `
                            <div class="status-item checked-out">
                                <i class="fas fa-flag-checkered"></i>
                                <div>
                                    <h4>Checked Out</h4>
                                    <p>${checkOutTime.time}</p>
                                </div>
                            </div>
                        `;
                        
                        $('#btnCheckIn').prop('disabled', true);
                        $('#btnCheckOut').prop('disabled', true);
                    }
                    
                    statusDiv.html(html);
                }

                formatDateTime(dateTimeString) {
                    if (!dateTimeString) return { time: '--:--', date: '--' };
                    
                    try {
                        // Handle various date formats
                        const date = new Date(dateTimeString);
                        
                        // Check if date is valid
                        if (isNaN(date.getTime())) {
                            // Try parsing as ISO string with timezone
                            const isoDate = new Date(dateTimeString.replace(' ', 'T'));
                            if (!isNaN(isoDate.getTime())) {
                                return {
                                    time: isoDate.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}),
                                    date: isoDate.toLocaleDateString()
                                };
                            }
                            return { time: '--:--', date: '--' };
                        }
                        
                        return {
                            time: date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}),
                            date: date.toLocaleDateString()
                        };
                    } catch (error) {
                        console.error('Date formatting error:', error);
                        return { time: '--:--', date: '--' };
                    }
                }

                showAlert(message, type) {
                    const alert = $(`
                        <div class="alert ${type}">
                            <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle"></i>
                            <span>${message}</span>
                            <button class="close"><i class="fas fa-times"></i></button>
                        </div>
                    `).appendTo('.attendance-dashboard');
                    
                    setTimeout(() => alert.addClass('show'), 10);
                    
                    setTimeout(() => {
                        alert.removeClass('show');
                        setTimeout(() => alert.remove(), 300);
                    }, 5000);
                    
                    alert.find('.close').click(() => {
                        alert.removeClass('show');
                        setTimeout(() => alert.remove(), 300);
                    });
                }
            }

            $(document).ready(() => new AttendanceSystem());
            
            $(window).on('beforeunload', () => {
                if (window.attendanceSystem?.watchId) {
                    navigator.geolocation.clearWatch(window.attendanceSystem.watchId);
                }
            });
        </script>
    @endpush
    
    @push('styles')
        <style>
            .attendance-dashboard { max-width: 1200px; margin: 0 auto; padding: 20px; }

            .dashboard-header {
                background: linear-gradient(135deg, #91a0e4 0%, #b994df 100%);
                color: white; padding: 25px 30px; border-radius: 15px;
                margin-bottom: 25px; display: flex; justify-content: space-between;
                align-items: center; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
            }
            .header-title h1 { margin: 0; font-size: 28px; font-weight: 300; display: flex; align-items: center; gap: 12px; }
            .header-title p { margin: 5px 0 0; opacity: 0.9; font-size: 14px; }
            .header-time .time { font-size: 32px; font-weight: 300; letter-spacing: 1px; }
            .header-time .date { font-size: 14px; opacity: 0.9; margin-top: 5px; }

            .dashboard-section { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 25px; }
            @media (max-width: 992px) { .dashboard-section { grid-template-columns: 1fr; } }

            .dashboard-card {
                background: white; border-radius: 12px; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
                border: 1px solid #eef2f7; overflow: hidden;
            }
            .card-header { background: #f8fafc; padding: 20px; border-bottom: 1px solid #eef2f7;
                display: flex; justify-content: space-between; align-items: center; }
            .card-header h3 { margin: 0; font-size: 16px; font-weight: 600; color: #2d3748;
                display: flex; align-items: center; gap: 10px; }
            .card-body { padding: 25px; }

            .status-item { display: flex; align-items: center; gap: 15px; padding: 15px;
                background: #f8fafc; border-radius: 8px; border-left: 4px solid #4299e1; }
            .checked-in { border-left-color: #48bb78; } .checked-out { border-left-color: #9f7aea; }
            .not-checked { border-left-color: #ed8936; }
            .status-item i { font-size: 24px; color: #4299e1; }
            .checked-in i { color: #48bb78; } .checked-out i { color: #9f7aea; } .not-checked i { color: #ed8936; }
            .status-item h4 { margin: 0 0 5px; font-size: 14px; font-weight: 600; color: #2d3748; }
            .status-item p { margin: 0; font-size: 12px; color: #718096; }

            .controls-grid { display: grid; gap: 15px; }
            .control-btn { display: flex; flex-direction: column; align-items: center; justify-content: center;
                padding: 25px 15px; border: none; border-radius: 10px; color: white; font-size: 16px;
                font-weight: 500; cursor: pointer; transition: all 0.3s; position: relative; overflow: hidden; }
            .control-btn:disabled { opacity: 0.5; cursor: not-allowed; }
            .control-btn:not(:disabled):hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); }
            .checkin { background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); }
            .checkout { background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%); }
            .control-btn i { font-size: 32px; margin-bottom: 10px; }
            .control-btn small { font-size: 12px; opacity: 0.9; margin-top: 5px; }
            .pulse { animation: pulse 0.6s; }
            @keyframes pulse { 0% { transform: scale(1); } 50% { transform: scale(1.05); } 100% { transform: scale(1); } }

            .location-status { display: flex; align-items: center; gap: 8px; font-size: 12px; color: #718096; }
            .coordinates { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px; }
            .coordinates > div { text-align: center; padding: 12px; background: #f8fafc; border-radius: 8px; }
            .coordinates label { display: block; font-size: 11px; color: #718096; margin-bottom: 5px;
                text-transform: uppercase; letter-spacing: 0.5px; }
            .coordinates div > div { font-size: 14px; font-weight: 600; color: #2d3748; font-family: 'Courier New', monospace; }
            .address { display: flex; align-items: center; gap: 15px; padding: 15px;
                background: #f8fafc; border-radius: 8px; border-left: 4px solid #4299e1; }
            .address i { color: #4299e1; font-size: 20px; }
            .address div { flex: 1; font-size: 13px; line-height: 1.5; color: #2d3748; }

            .history-card { margin-top: 25px; }
            .refresh-btn { background: #4299e1; color: white; border: none; padding: 8px 15px;
                border-radius: 6px; font-size: 13px; cursor: pointer; display: flex;
                align-items: center; gap: 8px; transition: background 0.3s; }
            .refresh-btn:hover { background: #3182ce; }
            
            table { width: 100%; border-collapse: collapse; }
            thead th { background: #f8fafc; padding: 15px; text-align: left; font-size: 13px;
                font-weight: 600; color: #4a5568; border-bottom: 2px solid #e2e8f0;
                text-transform: uppercase; letter-spacing: 0.5px; }
            tbody td { padding: 15px; border-bottom: 1px solid #e2e8f0; font-size: 14px; }
            tbody tr:hover { background: #f8fafc; }
            .record-time { font-weight: 600; color: #2d3748; }
            .record-date { font-size: 12px; color: #718096; margin-top: 3px; }
            
            .badge { display: inline-block; padding: 6px 12px; border-radius: 20px;
                font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
            .type-in { background: rgba(72, 187, 120, 0.1); color: #38a169; border: 1px solid rgba(72, 187, 120, 0.2); }
            .type-out { background: rgba(237, 137, 54, 0.1); color: #dd6b20; border: 1px solid rgba(237, 137, 54, 0.2); }
            .status-present { background: rgba(72, 187, 120, 0.1); color: #38a169; border: 1px solid rgba(72, 187, 120, 0.2); }
            .status-late { background: rgba(237, 137, 54, 0.1); color: #dd6b20; border: 1px solid rgba(237, 137, 54, 0.2); }
            .status-absent { background: rgba(245, 101, 101, 0.1); color: #e53e3e; border: 1px solid rgba(245, 101, 101, 0.2); }
            
            .empty-state, .loading-state, .error-state { text-align: center; padding: 40px 20px; color: #a0aec0; }
            .empty-state i, .loading-state i, .error-state i { font-size: 32px; margin-bottom: 15px; display: block; }
            .loading-state i { color: #4299e1; } .error-state i { color: #f56565; }
            
            .alert { position: fixed; top: 30px; right: 30px; background: white; padding: 15px 20px;
                border-radius: 8px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); display: flex;
                align-items: center; gap: 12px; transform: translateX(100%); opacity: 0;
                transition: all 0.3s; z-index: 10000; border-left: 4px solid #4299e1; }
            .alert.show { transform: translateX(0); opacity: 1; }
            .alert.success { border-left-color: #48bb78; } .alert.error { border-left-color: #f56565; }
            .alert i { font-size: 18px; } .alert.success i { color: #48bb78; } .alert.error i { color: #f56565; }
            .alert span { flex: 1; font-size: 14px; color: #2d3748; }
            .alert .close { background: none; border: none; color: #a0aec0; cursor: pointer; font-size: 14px; }
            .alert .close:hover { color: #f56565; }
        </style>
    @endpush
</x-app-layout>