<div class="modal fade" id="userAttendanceModal" tabindex="-1" role="dialog" aria-labelledby="userAttendanceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userAttendanceModalLabel">
                    <i class="feather icon-calendar mr-2"></i>
                    <span id="modalUserName"></span> - Attendance Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Month/Year Info -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Month & Year:</label>
                            <input type="text" class="form-control" id="modalMonthYear" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Total Days:</label>
                            <input type="text" class="form-control" id="modalTotalDays" readonly>
                        </div>
                    </div>
                </div>

                <!-- Attendance Summary -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">Summary</h6>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-2 mb-3">
                                        <div class="card bg-primary text-white">
                                            <div class="card-body p-2">
                                                <h6 class="mb-1">Working Days</h6>
                                                <h4 id="summaryWorkingDays" class="mb-0">0</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <div class="card bg-success text-white">
                                            <div class="card-body p-2">
                                                <h6 class="mb-1">Present</h6>
                                                <h4 id="summaryPresent" class="mb-0">0</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <div class="card bg-danger text-white">
                                            <div class="card-body p-2">
                                                <h6 class="mb-1">Absent</h6>
                                                <h4 id="summaryAbsent" class="mb-0">0</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <div class="card bg-info text-white">
                                            <div class="card-body p-2">
                                                <h6 class="mb-1">Late</h6>
                                                <h4 id="summaryLate" class="mb-0">0</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <div class="card bg-warning text-white">
                                            <div class="card-body p-2">
                                                <h6 class="mb-1">Half Day</h6>
                                                <h4 id="summaryHalfDay" class="mb-0">0</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <div class="card bg-secondary text-white">
                                            <div class="card-body p-2">
                                                <h6 class="mb-1">Holidays</h6>
                                                <h4 id="summaryHolidays" class="mb-0">0</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Attendance Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="attendanceDetailsTable">
                        <thead class="thead-dark">
                            <tr>
                                <th width="10%">Date</th>
                                <th width="10%">Day</th>
                                <th width="15%">Check In</th>
                                <th width="15%">Check Out</th>
                                <th width="10%">Status</th>
                                <th width="40%">Location</th>
                            </tr>
                        </thead>
                        <tbody id="attendanceDetailsBody">
                            <!-- Data will be loaded here via JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
    .modal-xl {
        max-width: 95%;
    }
    .day-sunday {
        background-color: #ffeaea !important;
        color: #dc3545;
        font-weight: bold;
    }
    .badge-holiday {
        background-color: #6c757d !important;
    }
</style>
