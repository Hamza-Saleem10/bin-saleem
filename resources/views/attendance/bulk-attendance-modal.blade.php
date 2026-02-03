<div class="modal fade" id="addattendanceModal" tabindex="-1" role="dialog" aria-labelledby="addattendanceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addattendanceModalLabel">Attendance Bulk Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Search and Filter Section -->
                <div class="row align-items-center mb-3">
                    <div class="col-md-3">
                        <input type="date" id="bulkDate" class="form-control">
                    </div>
                
                    <div class="col-md-3">
                        <input type="time" id="bulkCheckInTime" class="form-control">
                    </div>
                
                    <div class="col-md-3">
                        <input type="time" id="bulkCheckOutTime" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <input type="text" id="bulkSearch" class="form-control" placeholder="Search by Code, Name...">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                                    <i class="feather icon-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
               
                <!-- Status Options -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="font-weight-bold mb-3">Status <small class="text-muted">(Select to apply to all checked users)</small></label>
                            <div class="btn-group-toggle btn-group-wrap d-flex flex-wrap" data-toggle="buttons">
                                <label class="btn btn-status btn-present m-1">
                                    <input type="radio" name="bulkStatus" value="Present" autocomplete="off">
                                    Present
                                </label>
                                <label class="btn btn-status btn-absent m-1">
                                    <input type="radio" name="bulkStatus" value="Absent" autocomplete="off">
                                    Absent
                                </label>
                                <label class="btn btn-status btn-late m-1">
                                    <input type="radio" name="bulkStatus" value="Late" autocomplete="off">
                                    Late
                                </label>
                                <label class="btn btn-status btn-leave m-1">
                                    <input type="radio" name="bulkStatus" value="Leave" autocomplete="off">
                                    Leave
                                </label>
                                <label class="btn btn-status btn-holiday m-1">
                                    <input type="radio" name="bulkStatus" value="Holiday" autocomplete="off">
                                    Holiday
                                </label>
                                <label class="btn btn-status btn-unmarked m-1">
                                    <input type="radio" name="bulkStatus" value="Unmarked" autocomplete="off">
                                    Unmarked
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Status (Select to apply to all checked users)</label>
                            <div class="d-flex flex-wrap">
                                <div class="custom-control custom-radio mr-3">
                                    <input type="radio" id="statusPresent" name="bulkStatus" class="custom-control-input" value="Present">
                                    <label class="custom-control-label" for="statusPresent">Present</label>
                                </div>
                                <div class="custom-control custom-radio mr-3">
                                    <input type="radio" id="statusAbsent" name="bulkStatus" class="custom-control-input" value="Absent">
                                    <label class="custom-control-label" for="statusAbsent">Absent</label>
                                </div>
                                <div class="custom-control custom-radio mr-3">
                                    <input type="radio" id="statusLate" name="bulkStatus" class="custom-control-input" value="Late">
                                    <label class="custom-control-label" for="statusLate">Late</label>
                                </div>
                                <div class="custom-control custom-radio mr-3">
                                    <input type="radio" id="statusLeave" name="bulkStatus" class="custom-control-input" value="Leave">
                                    <label class="custom-control-label" for="statusLeave">Leave</label>
                                </div>
                                <div class="custom-control custom-radio mr-3">
                                    <input type="radio" id="statusHoliday" name="bulkStatus" class="custom-control-input" value="Holiday">
                                    <label class="custom-control-label" for="statusHoliday">Holiday</label>
                                </div>
                                <div class="custom-control custom-radio mr-3">
                                    <input type="radio" id="statusUnmarked" name="bulkStatus" class="custom-control-input" value="Unmarked">
                                    <label class="custom-control-label" for="statusUnmarked">Unmarked</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                
                <!-- Select All Checkbox -->
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="selectAllUsers">
                            <label class="custom-control-label" for="selectAllUsers">Select All Users</label>
                        </div>
                    </div>
                </div>
                
                <!-- Attendance Table -->
                <div class="table-responsive">
                    <table class="table table-bordered" id="bulkAttendanceTable">
                        <thead>
                            <tr>
                                <th width="10%">
                                    <input type="checkbox" id="selectAllCheckbox">
                                </th>
                                <th width="10%">Code</th>
                                <th width="30%">Name</th>
                                <th width="15%">Check-IN</th>
                                <th width="15%">Check-OUT</th>
                                <th width="20%">Status</th>
                            </tr>
                        </thead>
                        <tbody id="bulkAttendanceBody">
                            <!-- Will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-between w-100">
                    <div>
                        <button type="button" class="btn btn-danger" id="deleteSelected">
                            <i class="feather icon-trash"></i> Delete
                        </button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="markAttendance">
                            <i class="feather icon-check"></i> Mark Attendance
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>