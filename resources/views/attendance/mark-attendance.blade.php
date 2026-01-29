<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <x-breadcrumb title="Mark Attendance" />
            
            <div class="attendance-dashboard">
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

                <!-- Monthly Attendance Section -->
                <div class="monthly-attendance-section">
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3><i class="fas fa-calendar-alt"></i> Monthly Attendance</h3>
                            <div class="month-selector">
                                <button id="prevMonth" class="month-nav-btn">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <select id="monthSelect" class="month-select">
                                    @php
                                        $currentMonth = date('n');
                                    @endphp
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ $i == $currentMonth ? 'selected' : '' }}>
                                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                        </option>
                                    @endfor
                                </select>
                                <select id="yearSelect" class="year-select">
                                    @php
                                        $currentYear = date('Y');
                                    @endphp
                                    @for($i = date('Y') - 2; $i <= date('Y'); $i++)
                                        <option value="{{ $i }}" {{ $i == $currentYear ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                                <button id="nextMonth" class="month-nav-btn">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="monthly-stats">
                                <div class="stat-card">
                                    <i class="fas fa-calendar-check"></i>
                                    <div>
                                        <span class="stat-value" id="presentDays">0</span>
                                        <span class="stat-label">Total Present</span>
                                    </div>
                                </div>
                                <div class="stat-card">
                                    <i class="fas fa-calendar-times"></i>
                                    <div>
                                        <span class="stat-value" id="absentDays">0</span>
                                        <span class="stat-label">Total Absent</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="monthly-calendar" id="monthlyCalendar">
                                <div class="calendar-header">
                                    @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                                        <div class="calendar-day-header">{{ $day }}</div>
                                    @endforeach
                                </div>
                                <div class="calendar-grid" id="calendarGrid">
                                    <!-- Calendar days will be populated by JavaScript -->
                                    <div class="calendar-loading">
                                        <i class="fas fa-spinner fa-spin"></i>
                                        <span>Loading calendar...</span>
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
    <script>
    class AttendanceSystem {
        constructor() {
            this.currentLocation = null;
            this.watchId = null;
            this.statusIcons = {
                loading: 'fa-sync fa-spin',
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle'
            };
            this.currentMonth = new Date().getMonth() + 1;
            this.currentYear = new Date().getFullYear();
            this.init();
        }

        init() {
            this.loadTodayAttendance();
            this.getLocation();
            this.loadMonthlyAttendance();
            
            // Event listeners
            $('#btnCheckIn').click(() => this.markAttendance('check_in'));
            $('#btnCheckOut').click(() => this.markAttendance('check_out'));
            $('#monthSelect').change(() => this.changeMonth());
            $('#yearSelect').change(() => this.changeMonth());
            $('#prevMonth').click(() => this.navigateMonth(-1));
            $('#nextMonth').click(() => this.navigateMonth(1));
        }

        getLocation() {
            if (!navigator.geolocation) return this.updateLocationStatus('error', 'Not supported');
            
            this.updateLocationStatus('loading', 'Getting location...');
            
            navigator.geolocation.getCurrentPosition(
                pos => this.onLocationSuccess(pos),
                err => this.onLocationError(err),
                { enableHighAccuracy: true, timeout: 10000 }
            );
            
            this.watchId = navigator.geolocation.watchPosition(
                pos => this.onLocationSuccess(pos),
                err => console.error('Location error:', err),
                { enableHighAccuracy: true }
            );
        }

        onLocationSuccess(pos) {
            this.currentLocation = pos;
            this.updateLocationInfo(pos);
            this.updateLocationStatus('success', 'Active');
            $('#btnCheckIn').prop('disabled', false);
        }

        onLocationError(err) {
            const messages = {1:'Permission denied',2:'Position unavailable',3:'Request timeout'};
            this.updateLocationStatus('error', 'Unavailable');
            $('#currentAddress').text(messages[err.code] || 'Location error');
        }

        updateLocationStatus(status, msg) {
            $('#locationStatus').html(`<i class="fas ${this.statusIcons[status]}"></i><span>${msg}</span>`);
        }

        updateLocationInfo(pos) {
            const c = pos.coords;
            $('#latitudeValue').text(c.latitude.toFixed(6));
            $('#longitudeValue').text(c.longitude.toFixed(6));
            $('#accuracyValue').text(`${c.accuracy.toFixed(1)} m`);
            this.reverseGeocode(c.latitude, c.longitude);
        }

        reverseGeocode(lat, lng) {
            $.ajax({
                url: 'https://nominatim.openstreetmap.org/reverse',
                data: { format: 'json', lat, lon: lng, zoom: 18 },
                headers: { 'User-Agent': 'AttendanceSystem/1.0' },
                success: res => $('#currentAddress').text(
                    res.display_name ? 
                    res.display_name.split(',').slice(0,3).join(',') : 
                    'Address unavailable'
                ),
                error: () => $('#currentAddress').text('Address unavailable')
            });
        }

        async markAttendance(type) {
            if (!this.currentLocation) return this.showAlert('Enable location services', 'error');
            
            const btn = $(`#btn${type === 'check_in' ? 'CheckIn' : 'CheckOut'}`);
            const original = btn.html();
            
            btn.html(`<i class="fas fa-spinner fa-spin"></i><span>Processing...</span>`).prop('disabled', true);
            
            try {
                const res = await $.ajax({
                    url: '/api/attendance/mark',
                    method: 'POST',
                    data: { 
                        type, 
                        latitude: this.currentLocation.coords.latitude, 
                        longitude: this.currentLocation.coords.longitude, 
                        _token: '{{ csrf_token() }}' 
                    }
                });
                
                res.success ? 
                    this.showAlert(res.message, 'success') : 
                    this.showAlert(res.message || 'Error', 'error');
                
                if (res.success) {
                    btn.addClass('pulse').removeClass('pulse', 600);
                    this.loadTodayAttendance();
                    this.loadMonthlyAttendance();
                }
            } catch (err) {
                this.showAlert(err.responseJSON?.message || 'Network error', 'error');
            } finally {
                btn.html(original);
            }
        }

        loadTodayAttendance() {
            $.ajax({
                url: '{{ route("attendance.today") }}',
                success: res => res.success ? this.updateStatus(res.data) : this.updateStatus(null),
                error: () => this.updateStatus(null)
            });
        }

        updateStatus(attendance) {
            const statusDiv = $('#todayStatus');
            
            if (!attendance?.check_in && !attendance?.check_out) {
                statusDiv.html(`
                    <div class="status-item not-checked">
                        <i class="fas fa-user-clock"></i>
                        <div><h4>Not Checked In</h4><p>Ready to start</p></div>
                    </div>
                `);
                $('#btnCheckIn').prop('disabled', !this.currentLocation);
                $('#btnCheckOut').prop('disabled', true);
                return;
            }
            
            let html = '';
            const statusConfig = {
                check_in: { icon: 'fa-check-circle', class: 'checked-in', label: 'Checked In' },
                check_out: { icon: 'fa-flag-checkered', class: 'checked-out', label: 'Checked Out' }
            };
            
            ['check_in', 'check_out'].forEach(key => {
                if (attendance[key]) {
                    const time = this.formatDateTime(attendance[key]).time;
                    const cfg = statusConfig[key];
                    html += `
                        <div class="status-item ${cfg.class}">
                            <i class="fas ${cfg.icon}"></i>
                            <div><h4>${cfg.label}</h4><p>${time}</p></div>
                        </div>
                    `;
                }
            });
            
            statusDiv.html(html);
            $('#btnCheckIn').prop('disabled', !!attendance.check_in);
            $('#btnCheckOut').prop('disabled', !attendance.check_in || !!attendance.check_out);
        }

        formatDateTime(dt) {
            try {
                // If dt is just time (HH:MM:SS), add current date
                if (dt && dt.match(/^\d{1,2}:\d{2}:\d{2}$/)) {
                    const today = new Date();
                    const [hours, minutes, seconds] = dt.split(':');
                    const date = new Date(today.getFullYear(), today.getMonth(), today.getDate(), hours, minutes, seconds);
                    return {
                        time: date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}),
                        date: today.toLocaleDateString(),
                        datetime: date
                    };
                }
                
                // If dt includes date, parse normally
                const date = new Date(dt.replace(' ', 'T'));
                return isNaN(date.getTime()) ? 
                    { time: '--:--', date: '--' } :
                    {
                        time: date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}),
                        date: date.toLocaleDateString(),
                        datetime: date
                    };
            } catch {
                return { time: '--:--', date: '--', datetime: null };
            }
        }

        formatTimeOnly(dt) {
            try {
                const date = new Date(dt.replace(' ', 'T'));
                return isNaN(date.getTime()) ? 
                    '--:--' :
                    date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            } catch {
                return '--:--';
            }
        }

        loadMonthlyAttendance() {
            const month = $('#monthSelect').val();
            const year = $('#yearSelect').val();
            
            $('#calendarGrid').html(`
                <div class="calendar-loading">
                    <i class="fas fa-spinner fa-spin"></i>
                    <span>Loading calendar...</span>
                </div>
            `);
            
            $.ajax({
                url: '{{ route("attendance.monthly") }}',
                method: 'GET',
                data: { month, year },
                success: res => {
                    if (res.success) {
                        this.renderCalendar(res.data, month, year);
                        this.updateMonthlyStats(res.data, month, year);
                    } else {
                        $('#calendarGrid').html(`
                            <div class="calendar-error">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span>${res.message || 'Unable to load attendance data'}</span>
                            </div>
                        `);
                    }
                },
                error: (xhr, status, error) => {
                    console.error('Error loading monthly attendance:', error);
                    $('#calendarGrid').html(`
                        <div class="calendar-error">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Error loading data. Please try again.</span>
                        </div>
                    `);
                }
            });
        }

        renderCalendar(attendanceData, month, year) {
    const firstDay = new Date(year, month - 1, 1);
    const lastDay = new Date(year, month, 0);
    const daysInMonth = lastDay.getDate();
    const startingDay = firstDay.getDay();
    
    let html = '';
    
    // Empty cells for days before the first day of month
    for (let i = 0; i < startingDay; i++) {
        html += '<div class="calendar-day empty"></div>';
    }
    
    // Days of the month
    for (let day = 1; day <= daysInMonth; day++) {
        const dateStr = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        const dayAttendance = attendanceData[dateStr] || {};
        const currentDate = new Date(year, month - 1, day);
        const isToday = new Date().toDateString() === currentDate.toDateString();
        const isSunday = currentDate.getDay() === 0;
        
        let dayClass = 'calendar-day';
        let statusIcon = '';
        let tooltip = `Date: ${dateStr}\n`;
        let checkInTime = '--:--';
        let checkOutTime = '--:--';
        
        // Format check-in and check-out times
        if (dayAttendance.check_in) {
            checkInTime = this.formatTimeForDisplay(dayAttendance.check_in);
        }
        if (dayAttendance.check_out) {
            checkOutTime = this.formatTimeForDisplay(dayAttendance.check_out);
        }
        
        // Build tooltip
        tooltip += `Check In: ${checkInTime}\nCheck Out: ${checkOutTime}`;
        
        // Determine day status
        if (isSunday) {
            dayClass += ' holiday';
            statusIcon = '<i class="fas fa-glass-cheers"></i>';
            tooltip = 'Holiday (Sunday)\n' + tooltip;
        } else if (dayAttendance.check_in && dayAttendance.check_out) {
            dayClass += ' present';
            statusIcon = '<i class="fas fa-check-circle"></i>';
            tooltip = 'Present\n' + tooltip;
        } else if (dayAttendance.check_in && !dayAttendance.check_out) {
            dayClass += ' partial';
            statusIcon = '<i class="fas fa-exclamation-circle"></i>';
            tooltip = 'Partial Attendance (No Check Out)\n' + tooltip;
        } else if (dayAttendance.status === 'leave' || dayAttendance.status === 'Leave') {
            dayClass += ' leave';
            statusIcon = '<i class="fas fa-umbrella-beach"></i>';
            tooltip = 'On Leave\n' + tooltip;
        } else if (dayAttendance.status === 'holiday') {
            dayClass += ' holiday';
            statusIcon = '<i class="fas fa-glass-cheers"></i>';
            tooltip = 'Holiday\n' + tooltip;
        } else if (isToday && !dayAttendance.check_in) {
            dayClass += ' today';
            statusIcon = '<i class="fas fa-calendar-day"></i>';
            tooltip = 'Today\n' + tooltip;
        } else {
            dayClass += ' absent';
            statusIcon = '<i class="fas fa-times-circle"></i>';
            tooltip = 'Absent\n' + tooltip;
        }
        
        if (isToday) dayClass += ' today';
        
        html += `
            <div class="${dayClass}" data-date="${dateStr}" title="${tooltip}">
                <div class="day-number">${day}</div>
                <div class="day-status">${statusIcon}</div>
                <div class="day-times">
                    <div class="check-in-time">
                        <small><i class="fas fa-sign-in-alt"></i> ${checkInTime}</small>
                    </div>
                    <div class="check-out-time">
                        <small><i class="fas fa-sign-out-alt"></i> ${checkOutTime}</small>
                    </div>
                </div>
            </div>
        `;
    }
    
    $('#calendarGrid').html(html);
}

// Add this new method to format time for display
formatTimeForDisplay(timeStr) {
    if (!timeStr) return '--:--';
    
    try {
        // If time is already in HH:MM:SS format
        if (typeof timeStr === 'string' && timeStr.includes(':')) {
            const parts = timeStr.split(':');
            if (parts.length >= 2) {
                const hours = parseInt(parts[0]);
                const minutes = parseInt(parts[1]);
                
                // Format to 12-hour or 24-hour format
                const formattedHours = hours % 12 || 12;
                const ampm = hours >= 12 ? 'PM' : 'AM';
                
                // Return in 12-hour format (e.g., 09:30 AM)
                // Or you can use 24-hour format: return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
                return `${String(formattedHours).padStart(2, '0')}:${String(minutes).padStart(2, '0')} ${ampm}`;
            }
        }
        
        // Try to parse as Date object
        const date = new Date(timeStr);
        if (!isNaN(date.getTime())) {
            return date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        }
        
        return '--:--';
    } catch {
        return '--:--';
    }
}

        updateMonthlyStats(attendanceData, month, year) {
            let presentDays = 0;
            let absentDays = 0;
            
            const firstDay = new Date(year, month - 1, 1);
            const lastDay = new Date(year, month, 0);
            const daysInMonth = lastDay.getDate();
            
            // Count Sundays (holidays)
            let holidayCount = 0;
            for (let day = 1; day <= daysInMonth; day++) {
                const currentDate = new Date(year, month - 1, day);
                if (currentDate.getDay() === 0) {
                    holidayCount++;
                }
            }
            
            // Calculate working days (excluding Sundays)
            const workingDays = daysInMonth - holidayCount;
            
            // Count present days from attendance data
            Object.values(attendanceData).forEach(day => {
                if (day.check_in && day.check_out) {
                    presentDays++;
                } else if (day.status === 'present' || day.status === 'Present') {
                    presentDays++;
                } else if (day.status === 'late' || day.status === 'Late') {
                    presentDays++; // Late is also considered present
                } else if (day.status === 'halfday' || day.status === 'Halfday' || day.status === 'half_day') {
                    presentDays += 0.5; // Half day counts as 0.5
                }
            });
            
            // Calculate absent days (working days - present days)
            absentDays = Math.max(0, workingDays - presentDays);
            
            $('#presentDays').text(Math.floor(presentDays));
            $('#absentDays').text(Math.floor(absentDays));
        }

        changeMonth() {
            this.currentMonth = $('#monthSelect').val();
            this.currentYear = $('#yearSelect').val();
            this.loadMonthlyAttendance();
        }

        navigateMonth(direction) {
            let month = parseInt($('#monthSelect').val());
            let year = parseInt($('#yearSelect').val());
            
            month += direction;
            
            if (month > 12) {
                month = 1;
                year++;
                // Update year select if needed
                if (year > new Date().getFullYear()) {
                    $('#yearSelect').append(`<option value="${year}">${year}</option>`);
                }
            } else if (month < 1) {
                month = 12;
                year--;
            }
            
            $('#monthSelect').val(month);
            $('#yearSelect').val(year);
            this.changeMonth();
        }

        showAlert(msg, type) {
            const icon = type === 'success' ? 'check' : 'exclamation';
            const alert = $(`
                <div class="alert ${type}">
                    <i class="fas fa-${icon}-circle"></i>
                    <span>${msg}</span>
                    <button class="close"><i class="fas fa-times"></i></button>
                </div>
            `).appendTo('.attendance-dashboard');
            
            setTimeout(() => alert.addClass('show'), 10);
            setTimeout(() => alert.removeClass('show').delay(300).remove(), 5000);
            alert.find('.close').click(() => alert.removeClass('show').delay(300).remove());
        }
    }

    $(() => window.attendanceSystem = new AttendanceSystem());
    $(window).on('beforeunload', () => {
        if (window.attendanceSystem?.watchId) {
            navigator.geolocation.clearWatch(window.attendanceSystem.watchId);
        }
    });
    </script>
    @endpush
    
    @push('styles')
    <style>
    .attendance-dashboard { max-width: 1200px; margin: auto; padding: 20px; }
    .dashboard-section { display: grid; grid-template-columns: repeat(3,1fr); gap: 20px; margin-bottom: 25px; }
    @media (max-width: 992px) { .dashboard-section { grid-template-columns: 1fr; } }
    
    .dashboard-card { background: white; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.08); border: 1px solid #eef2f7; }
    .card-header { background: #f8fafc; padding: 20px; border-bottom: 1px solid #eef2f7; display: flex; justify-content: space-between; align-items: center; }
    .card-header h3 { margin: 0; font-size: 16px; font-weight: 600; color: #2d3748; display: flex; align-items: center; gap: 10px; }
    .card-body { padding: 25px; }
    
    .status-item { display: flex; align-items: center; gap: 15px; padding: 15px; background: #f8fafc; border-radius: 8px; border-left: 4px solid; }
    .status-item i { font-size: 24px; }
    .status-item h4 { margin: 0 0 5px; font-size: 14px; font-weight: 600; color: #2d3748; }
    .status-item p { margin: 0; font-size: 12px; color: #718096; }
    
    .checked-in { border-left-color: #48bb78; } 
    .checked-out { border-left-color: #9f7aea; }
    .not-checked { border-left-color: #ed8936; }
    .checked-in i { color: #48bb78; } 
    .checked-out i { color: #9f7aea; } 
    .not-checked i { color: #ed8936; }
    
    .controls-grid { display: grid; gap: 15px; }
    .control-btn { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 25px 15px; 
        border: none; border-radius: 10px; color: white; font-size: 16px; font-weight: 500; cursor: pointer; transition: all 0.3s; }
    .control-btn:disabled { opacity: 0.5; cursor: not-allowed; }
    .control-btn:not(:disabled):hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
    .control-btn i { font-size: 32px; margin-bottom: 10px; }
    .control-btn small { font-size: 12px; opacity: 0.9; margin-top: 5px; }
    .checkin { background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); }
    .checkout { background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%); }
    .pulse { animation: pulse 0.6s; }
    @keyframes pulse { 0%,100% { transform: scale(1); } 50% { transform: scale(1.05); } }
    
    .location-status { display: flex; align-items: center; gap: 8px; font-size: 12px; color: #718096; }
    .coordinates { display: grid; grid-template-columns: repeat(3,1fr); gap: 15px; margin-bottom: 20px; }
    .coordinates > div { text-align: center; padding: 12px; background: #f8fafc; border-radius: 8px; }
    .coordinates label { display: block; font-size: 11px; color: #718096; margin-bottom: 5px; text-transform: uppercase; }
    .coordinates div > div { font-size: 14px; font-weight: 600; color: #2d3748; font-family: 'Courier New', monospace; }
    .address { display: flex; align-items: center; gap: 15px; padding: 15px; background: #f8fafc; border-radius: 8px; border-left: 4px solid #4299e1; }
    .address i { color: #4299e1; font-size: 20px; }
    .address div { flex: 1; font-size: 13px; line-height: 1.5; color: #2d3748; }
    
    /* Monthly Attendance Styles */
    .monthly-attendance-section { margin-top: 30px; }
    .month-selector { display: flex; align-items: center; gap: 10px; }
    .month-select, .year-select { 
        padding: 8px 12px; 
        border: 1px solid #e2e8f0; 
        border-radius: 6px; 
        background: white; 
        color: #2d3748;
        font-size: 14px;
        cursor: pointer;
    }
    .month-nav-btn { 
        padding: 8px 12px; 
        border: 1px solid #e2e8f0; 
        background: white; 
        border-radius: 6px; 
        color: #4a5568; 
        cursor: pointer;
        transition: all 0.2s;
    }
    .month-nav-btn:hover { background: #f7fafc; border-color: #cbd5e0; }
    
    .monthly-stats { 
        display: grid; 
        grid-template-columns: repeat(2, 1fr); 
        gap: 15px; 
        margin-bottom: 25px;
    }
    @media (max-width: 768px) {
        .monthly-stats { grid-template-columns: 1fr; }
    }
    .stat-card { 
        background: #f8fafc; 
        padding: 15px; 
        border-radius: 8px; 
        display: flex; 
        align-items: center; 
        gap: 15px;
        border-left: 4px solid #4299e1;
    }
    .stat-card i { 
        font-size: 24px; 
        color: #4299e1; 
        width: 40px; 
        height: 40px; 
        display: flex; 
        align-items: center; 
        justify-content: center;
        background: white;
        border-radius: 8px;
    }
    .stat-value { 
        display: block; 
        font-size: 24px; 
        font-weight: 700; 
        color: #2d3748; 
        line-height: 1.2;
    }
    .stat-label { 
        display: block; 
        font-size: 13px; 
        color: #718096; 
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .monthly-calendar { margin-bottom: 25px; }
    .calendar-header { 
        display: grid; 
        grid-template-columns: repeat(7, 1fr); 
        gap: 5px; 
        margin-bottom: 10px;
    }
    .calendar-day-header { 
        text-align: center; 
        padding: 10px 0; 
        font-size: 12px; 
        font-weight: 600; 
        color: #4a5568;
        text-transform: uppercase;
    }
    .calendar-grid { 
        display: grid; 
        grid-template-columns: repeat(7, 1fr); 
        gap: 5px;
    }
    .calendar-day { 
        aspect-ratio: 1; 
        padding: 8px;
        border-radius: 8px; 
        background: #f8fafc; 
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
        border: 2px solid transparent;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    .calendar-day:hover { background: #edf2f7; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    .calendar-day.selected { border-color: #4299e1; background: #ebf8ff; }
    .calendar-day.empty { background: transparent; cursor: default; }
    .calendar-day.empty:hover { background: transparent; transform: none; box-shadow: none; }
    .calendar-day.present { background: #f0fff4; border-color: #c6f6d5; }
    .calendar-day.partial { background: #fffaf0; border-color: #fed7d7; }
    .calendar-day.leave { background: #faf5ff; border-color: #e9d8fd; }
    .calendar-day.holiday { background: #fff5f5; border-color: #fed7d7; }
    .calendar-day.absent { background: #fed7d7; opacity: 0.7; }
    .calendar-day.today { border-color: #ed8936; background: #fffaf0; }
    .day-number { 
        font-size: 14px; 
        font-weight: 600; 
        color: #2d3748; 
        margin-bottom: 5px;
        align-self: flex-start;
    }
    .day-status { 
        position: absolute; 
        top: 5px; 
        right: 5px; 
        font-size: 12px;
    }
    .calendar-day.present .day-times {
        background: rgba(255, 255, 255, 0.8);
    }

    .calendar-day.partial .day-times {
        background: rgba(255, 255, 255, 0.8);
    }

    .calendar-day.absent .day-times,
    .calendar-day.holiday .day-times,
    .calendar-day.leave .day-times {
        background: rgba(255, 255, 255, 0.6);
    }

    .calendar-day.today .day-times {
        background: rgba(255, 255, 255, 0.9);
    }
    
    .day-times {
        margin-top: auto;
        font-size: 15px;
        line-height: 1.2;
        background: rgba(255, 255, 255, 0.7);
        border-radius: 4px;
        padding: 2px;
        backdrop-filter: blur(2px);
    }
    .check-in-time, .check-out-time {
        display: flex;
        align-items: center;
        gap: 3px;
        justify-content: center;
    }
    .check-in-time i {
        color: #48bb78;
        font-size: 15px;
    }

    .check-out-time i {
        color: #ed8936;
        font-size: 15px;
    }

    .check-in-time small, .check-out-time small {
        color: #2d3748;
        font-weight: 600;
        white-space: nowrap;
    }
    .calendar-day.absent .check-in-time small,
    .calendar-day.absent .check-out-time small,
    .calendar-day.holiday .check-in-time small,
    .calendar-day.holiday .check-out-time small,
    .calendar-day.leave .check-in-time small,
    .calendar-day.leave .check-out-time small {
        color: #718096;
    }
    
    .calendar-loading, .calendar-error { 
        grid-column: 1 / -1; 
        text-align: center; 
        padding: 40px; 
        color: #718096;
    }
    .calendar-loading i, .calendar-error i {
        font-size: 24px;
        margin-bottom: 10px;
        display: block;
    }
    
    .alert { position: fixed; top: 30px; right: 30px; background: white; padding: 15px 20px; border-radius: 8px; 
        box-shadow: 0 10px 30px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 12px; transform: translateX(100%); 
        opacity: 0; transition: all 0.3s; z-index: 10000; border-left: 4px solid; }
    .alert.show { transform: translateX(0); opacity: 1; }
    .alert.success { border-left-color: #48bb78; } 
    .alert.error { border-left-color: #f56565; }
    .alert i { font-size: 18px; } 
    .alert.success i { color: #48bb78; } 
    .alert.error i { color: #f56565; }
    .alert span { flex: 1; font-size: 14px; color: #2d3748; }
    .alert .close { background: none; border: none; color: #a0aec0; cursor: pointer; font-size: 14px; }
    .alert .close:hover { color: #f56565; }
    
    /* Tooltip styling */
    .calendar-day {
        position: relative;
    }
    .calendar-day:hover::after {
        content: attr(title);
        position: absolute;
        bottom: calc(100% + 10px);
        left: 50%;
        transform: translateX(-50%);
        background: #2d3748;
        color: white;
        padding: 8px 12px;
        border-radius: 4px;
        font-size: 11px;
        white-space: pre-line;
        z-index: 1000;
        min-width: 150px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .calendar-day:hover::before {
        content: '';
        position: absolute;
        bottom: calc(100% + 2px);
        left: 50%;
        transform: translateX(-50%);
        border: 5px solid transparent;
        border-top-color: #2d3748;
        z-index: 1000;
    }
    </style>
    @endpush
</x-app-layout>