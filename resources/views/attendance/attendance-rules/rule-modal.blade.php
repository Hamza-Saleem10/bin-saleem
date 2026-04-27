<!-- Add/Edit Rule Modal -->
<div class="modal fade" id="ruleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Attendance Rule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="ruleForm">
                <div class="modal-body">
                    <input type="hidden" name="uuid" id="rule_uuid">
                    <input type="hidden" name="_method" id="form_method" value="POST">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Rule Name *</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       placeholder="e.g., Morning Shift, Evening Shift" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="is_active">Status</label>
                                <select class="form-control" id="is_active" name="is_active">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="check_in_time">Check In Time *</label>
                                <input type="time" class="form-control" id="check_in_time" 
                                       name="check_in_time" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="check_out_time">Check Out Time *</label>
                                <input type="time" class="form-control" id="check_out_time" 
                                       name="check_out_time" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="late_threshold">Late Threshold (minutes) *</label>
                                <input type="number" class="form-control" id="late_threshold" 
                                       name="late_threshold" min="0" value="10" required>
                                <small class="text-muted">Grace period after check-in time</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="location_radius">Location Radius (meters) *</label>
                                <input type="number" class="form-control" id="location_radius" 
                                       name="location_radius" min="0" value="100" required>
                                <small class="text-muted">Allowed distance from designated locations</small>
                            </div>
                        </div>
                    </div>

                    <!-- Allowed Location -->
                    <div class="form-group">
                        <label>Allowed Location</label>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="allowed_locations_name" 
                                       name="allowed_locations_name" placeholder="Location name">
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="latitude" 
                                       name="latitude" placeholder="Latitude" step="any">
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="longitude" 
                                       name="longitude" placeholder="Longitude" step="any">
                            </div>
                        </div>
                        <small class="text-muted">Enter the designated location coordinates for attendance</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Rule</button>
                </div>
            </form>
        </div>
    </div>
</div>