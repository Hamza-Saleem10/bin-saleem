
<div class="accordion" id="registrationAccordion">
    <?php
        $institution = $institution ?? null;
        $owner = $institution?->ownerDetail ?? auth()->user();
        $principal = $institution?->principalDetail ?? null;
        $oldBoard = old('board_of_directors');
        $boardMembers = $oldBoard ?? (isset($institution) ? $institution->boardOfDirectorsOwners->toArray() : []);
        $hasBoard = old('board_of_directors_owners', isset($institution) ? (bool)$institution->board_of_directors_owners : false);
        $enrollment = $institution?->enrollmentCounts?->first();
        $infrastructure = $institution?->infrastructure ?? null;
        $transparency = $institution?->transparencyPublicDisclosure ?? null;

    ?>
    
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBasicInfo">
                <strong>Basic Institution Information</strong>
            </button>
        </h2>
        <div id="collapseBasicInfo" class="accordion-collapse collapse show" data-bs-parent="#registrationAccordion">
            <div class="accordion-body">
                <div class="row g-3">
                    <div class="form-group col-md-4">
                        <?php echo Form::label('name', 'Name of Institution', ['for' => 'name', 'class' => 'form-label required-input']); ?>

                        <?php echo Form::text('name', old('name', $institution->name ?? null), ['id' => 'name','class' => 'form-control ' . $errors->first('name', 'error'),'placeholder' => 'Name of Institution','maxlength' => '191','required']); ?>

                        <?php echo $errors->first('name', '<label class="error">:message</label>'); ?>

                    </div>

                    <div class="form-group col-md-4">
                        <?php echo Form::label('level_2_id', 'District', ['for' => 'level_2_id', 'class' => 'form-label required-input']); ?>

                        <?php echo Form::select('level_2_id',['' => 'Select District'] + $districts->toArray(), old('level_2_id', $selectedDistrict ?? null),['class' => 'form-control ' . ($errors->has('level_2_id') ? 'error' : ''),'id' => 'level_2_id','required']); ?>

                        <?php echo $errors->first('level_2_id', '<label class="error">:message</label>'); ?>

                    </div>

                    <div class="form-group col-md-4">
                        <?php echo Form::label('level_3_id', 'Tehsil', ['for' => 'level_3_id', 'class' => 'form-label required-input']); ?>

                        <?php echo Form::select('level_3_id',['' => 'Select Tehsil'] + ($tehsils->toArray() ?? []), old('level_3_id', $selectedTehsil ?? null),['class' => 'form-control ' . ($errors->has('level_3_id') ? 'error' : ''),'id' => 'level_3_id','required','disabled' => empty($tehsils)]); ?>

                        <?php echo $errors->first('level_3_id', '<label class="error">:message</label>'); ?>

                    </div>

                    <div class="form-group col-md-4">
                        <?php echo Form::label('level_4_id', 'Village', ['for' => 'level_4_id', 'class' => 'form-label required-input']); ?>

                        <?php echo Form::select('level_4_id', ['' => 'Select Village'] + ($villages->toArray() ?? []), old('level_4_id', $selectedVillage ?? null), ['class' => 'form-control ' . ($errors->has('level_4_id') ? 'error' : ''), 'id' => 'level_4_id','disabled' => empty($villages),'required']); ?>

                        <?php echo $errors->first('level_4_id', '<label class="error">:message</label>'); ?>

                    </div>

                    <div class="form-group col-md-4">
                        <?php echo Form::label('institution_nature', 'Nature of School', ['for' => 'institution_nature','class' => 'form-label required-input']); ?>

                        <?php echo Form::select('institution_nature',['' => 'Select', 'Individual' => 'Individual', 'Branch' => 'Branch', 'Franchise' => 'Franchise'], old('institution_nature', $institution->institution_nature ?? null),['class' => 'form-control ' . $errors->first('institution_nature', 'error'),'id' => 'institution_nature','required']); ?>

                        <?php echo $errors->first('institution_nature', '<label class="error">:message</label>'); ?>

                    </div>

                    <div class="form-group col-md-4">
                        <?php echo Form::label('institution_level', 'School Level', ['for' => 'institution_level','class' => 'form-label required-input']); ?>

                        <?php echo Form::select('institution_level',['' => 'Select', 'Primary' => 'Primary', 'Elementary' => 'Elementary', 'High' => 'High'], old('institution_level', $institution->institution_level ?? null),['class' => 'form-control ' . $errors->first('institution_level', 'error'),'id' => 'institution_level','required']); ?>

                        <?php echo $errors->first('institution_level', '<label class="error">:message</label>'); ?>

                    </div>

                    <div class="form-group col-md-4">
                        <?php echo Form::label('management_nature', 'Nature of Management', ['for' => 'management_nature','class' => 'form-label required-input']); ?>

                        <?php echo Form::select('management_nature',['' => 'Select','Association of Person' => 'Association of Person','Corporate Body' => 'Corporate Body','Educational Society Individual' => 'Educational Society Individual'], old('management_nature', $institution->management_nature ?? null),['class' => 'form-control ' . $errors->first('management_nature', 'error'),'id' => 'management_nature','required']); ?>

                        <?php echo $errors->first('management_nature', '<label class="error">:message</label>'); ?>

                    </div>

                    <div class="form-group col-md-4">
                        <?php echo Form::label('institution_type', 'Type of Institution', ['for' => 'institution_type','class' => 'form-label required-input']); ?>

                        <?php echo Form::select('institution_type',['' => 'Select', 'School' => 'School','ECD Centre' => 'ECD Centre','Day-care Centre' => 'Day-care Centre','Tuition Centre' => 'Tuition Centre'], old('institution_type', $institution->institution_type ?? null),['class' => 'form-control ' . $errors->first('institution_type', 'error'),'id' => 'institution_type','required']); ?>

                        <?php echo $errors->first('institution_type', '<label class="error">:message</label>'); ?>

                    </div>

                    <div class="form-group col-md-4">
                        <?php echo Form::label('teaching_level', 'Teaching Level', ['for' => 'teaching_level','class' => 'form-label required-input']); ?>

                        <?php echo Form::select('teaching_level',['' => 'Select','Pre-Primary' => 'Pre-Primary','Primary' => 'Primary','Middle Secondary' => 'Middle Secondary','High Secondary or equivalent' => 'High Secondary or equivalent'], old('teaching_level', $institution->teaching_level ?? null),['class' => 'form-control ' . $errors->first('teaching_level', 'error'), 'id' => 'teaching_level','required']); ?>

                        <?php echo $errors->first('teaching_level', '<label class="error">:message</label>'); ?>

                    </div>

                    <div class="form-group col-md-4">
                        <?php echo Form::label('institution_medium', 'Medium of Instruction', ['for' => 'institution_medium','class' => 'form-label required-input']); ?>

                        <?php echo Form::select('institution_medium',['' => 'Select', 'English' => 'English', 'Urdu' => 'Urdu', 'Both' => 'Both'], old('institution_medium', $institution->institution_medium ?? null),['class' => 'form-control ' . $errors->first('institution_medium', 'error'),'id' => 'institution_medium','required']); ?>

                        <?php echo $errors->first('institution_medium', '<label class="error">:message</label>'); ?>

                    </div>

                    <div class="form-group col-md-4">
                        <?php echo Form::label('institution_gender', 'Gender of Institution', ['for' => 'institution_gender','class' => 'form-label required-input']); ?>

                        <?php echo Form::select('institution_gender',['' => 'Select', 'Boys Campus' => 'Boys Campus', 'Girls Campus' => 'Girls Campus', 'Co-Education' => 'Co-Education'], old('institution_gender', $institution->institution_gender ?? null),['class' => 'form-control ' . $errors->first('institution_gender', 'error'),'id' => 'institution_gender','required']); ?>

                        <?php echo $errors->first('institution_gender', '<label class="error">:message</label>'); ?>

                    </div>

                    <div class="form-group col-md-4">
                        <?php echo Form::label('latitude', 'Latitude', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::number('latitude', old('latitude', $institution->latitude ?? null), ['id' => 'latitude', 'class' => 'form-control '.$errors->first('latitude','error'), 'placeholder' => 'Enter Latitude (e.g. 31.5204)', 'required', 'step' => 'any', 'min' => '-90', 'max' => '90']); ?>

                        <?php echo $errors->first('latitude', '<label class="error">:message</label>'); ?>

                    </div>

                    <div class="form-group col-md-4">
                        <?php echo Form::label('longitude', 'Longitude', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::number('longitude', old('longitude', $institution->longitude ?? null), ['id' => 'longitude', 'class' => 'form-control '.$errors->first('longitude','error'), 'placeholder' => 'Enter Longitude (e.g. 74.3587)', 'required', 'step' => 'any', 'min' => '-180','max' => '180']); ?>

                        <?php echo $errors->first('longitude', '<label class="error">:message</label>'); ?>

                    </div>

                    <div class="form-group col-md-4">
                        <?php echo Form::label('institution_official_web_url', 'Official Website', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::url('institution_official_web_url', old('institution_official_web_url', $institution->institution_official_web_url ?? null), ['id' => 'institution_official_web_url','class' => 'form-control ' . $errors->first('institution_official_web_url', 'error'),'placeholder' => 'https://example.com','maxlength' => '128','required']); ?>

                        <?php echo $errors->first('institution_official_web_url', '<label class="error">:message</label>'); ?>

                    </div>

                    <div class="form-group col-md-4">
                        <?php echo Form::label('institution_official_email', 'Official Email', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::email('institution_official_email', old('institution_official_email', $institution->institution_official_email ?? null), ['id' => 'institution_official_email','class' => 'form-control ' . $errors->first('institution_official_email', 'error'),'placeholder' => 'info@example.com','maxlength' => '128','required']); ?>

                        <?php echo $errors->first('institution_official_email', '<label class="error">:message</label>'); ?>

                    </div>

                    <div class="form-group col-md-12">
                        <?php echo Form::label('address', 'Address', ['class' => 'form-label']); ?>

                        <?php echo Form::text('address', old('address', $institution->address ?? null), ['id' => 'address','class' => 'form-control ' . $errors->first('address', 'error'),'placeholder' => 'Enter Institution Address','maxlength' => '256','required']); ?>

                        <?php echo $errors->first('address', '<label class="error">:message</label>'); ?>

                    </div>

                    <h5 class="mt-4 col-12">Contact Details</h5>
                    <div class="form-group col-md-4">
                        <?php echo Form::label('institution_phone', 'Phone', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::text('institution_phone', old('institution_phone', $institution->institution_phone ?? null), ['class' => 'form-control mobile-mask ' . $errors->first('institution_phone', 'error'), 'maxlength' => 20, 'placeholder' => 'Phone','required']); ?>

                        <?php echo $errors->first('institution_phone', '<label class="error">:message</label>'); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo Form::label('institution_fax', 'Institution Fax', ['class' => 'form-label']); ?>

                        <?php echo Form::text('institution_fax', old('institution_fax', $institution->institution_fax ?? null), ['class' => 'form-control ' . $errors->first('institution_fax', 'error'), 'maxlength' => 20, 'placeholder' => 'Institution Fax Number','required']); ?>

                        <?php echo $errors->first('institution_fax', '<label class="error">:message</label>'); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo Form::label('institution_public_email', 'Public Email', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::email('institution_public_email', old('institution_public_email', $institution->institution_public_email ?? null), ['class' => 'form-control ' . $errors->first('institution_public_email', 'error'),'maxlength' => 30,'placeholder' => 'Public Email','required']); ?>

                        <?php echo $errors->first('institution_public_email', '<label class="error">:message</label>'); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOwner">
                <strong>Owner Details</strong>
            </button>
        </h2>
        <div id="collapseOwner" class="accordion-collapse collapse" data-bs-parent="#registrationAccordion">
            <div class="accordion-body">
                <h5>Owner Details</h5>
                <div class="row g-3">

                    
                    <div class="form-group col-md-4">
                        <?php echo Form::label('owner[name]', 'Owner Name', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::text('owner[name]', old('owner.name', $owner->name ?? null), ['class' => 'form-control ' . $errors->first('owner.name', 'error'),'placeholder' => 'Owner Name','maxlength' => '64','required', 'readonly']); ?>

                        <?php echo $errors->first('owner.name', '<label class="error">:message</label>'); ?>

                    </div>

                    
                    <div class="form-group col-md-4">
                        <?php echo Form::label('owner[designation]', 'Designation', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::text('owner[designation]', old('owner.designation', $owner->designation ?? null), ['class' => 'form-control ' . $errors->first('owner.designation', 'error'),'placeholder' => 'Designation','maxlength' => '64','required']); ?>

                        <?php echo $errors->first('owner.designation', '<label class="error">:message</label>'); ?>

                    </div>

                    
                    <div class="form-group col-md-4">
                        <?php echo Form::label('owner[mobile]', 'Mobile', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::text('owner[mobile]', old('owner.mobile', $owner->mobile ?? null), ['class' => 'form-control mobile-mask ' . $errors->first('owner.mobile', 'error'),'placeholder' => 'Mobile Number','maxlength' => '20','required']); ?>

                        <?php echo $errors->first('owner.mobile', '<label class="error">:message</label>'); ?>

                    </div>

                    
                    <div class="form-group col-md-4">
                        <?php echo Form::label('owner[phone]', 'Phone', ['class' => 'form-label']); ?>

                        <?php echo Form::text('owner[phone]', old('owner.phone', $owner->phone ?? null), ['class' => 'form-control ptcl-mask','placeholder' => 'Phone Number','maxlength' => '20','required']); ?>

                    </div>

                    
                    <div class="form-group col-md-4">
                        <?php echo Form::label('owner[fax]', 'Fax', ['class' => 'form-label']); ?>

                        <?php echo Form::text('owner[fax]', old('owner.fax', $owner->fax ?? null), ['class' => 'form-control','placeholder' => 'Fax Number','maxlength' => '20','required']); ?>

                    </div>

                    
                    <div class="form-group col-md-4">
                        <?php echo Form::label('owner[email]', 'Email', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::email('owner[email]', old('owner.email', $owner->email ?? null), ['class' => 'form-control ' . $errors->first('owner.email', 'error'),'placeholder' => 'Email Address','maxlength' => '64','required', 'readonly']); ?>

                        <?php echo $errors->first('owner.email', '<label class="error">:message</label>'); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePrincipal">
                <strong>Principal Details</strong>
            </button>
        </h2>
    
        <div id="collapsePrincipal" class="accordion-collapse collapse" data-bs-parent="#registrationAccordion">
            <div class="accordion-body">
                <h5>Principal Details</h5>
                <div class="row g-3">
    
                    
                    <div class="form-group col-md-4">
                        <?php echo Form::label('principal[name]', 'Principal Name', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::text('principal[name]', old('principal.name', $principal?->name), ['class' => 'form-control ' . $errors->first('principal.name', 'error'),'placeholder' => 'Principal Name','maxlength' => '64','required']); ?>

                        <?php echo $errors->first('principal.name', '<label class="error">:message</label>'); ?>

                    </div>
    
                    
                    <div class="form-group col-md-4">
                        <?php echo Form::label('principal[designation]', 'Designation', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::text('principal[designation]', old('principal.designation', $principal?->designation), ['class' => 'form-control ' . $errors->first('principal.designation', 'error'),'placeholder' => 'Designation','maxlength' => '64','required']); ?>

                        <?php echo $errors->first('principal.designation', '<label class="error">:message</label>'); ?>

                    </div>
    
                    
                    <div class="form-group col-md-4">
                        <?php echo Form::label('principal[mobile]', 'Mobile', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::text('principal[mobile]', old('principal.mobile', $principal?->mobile), ['class' => 'form-control mobile-mask ' . $errors->first('principal.mobile', 'error'),'placeholder' => 'Mobile Number','maxlength' => '20','required']); ?>

                        <?php echo $errors->first('principal.mobile', '<label class="error">:message</label>'); ?>

                    </div>
    
                    
                    <div class="form-group col-md-4">
                        <?php echo Form::label('principal[phone]', 'Phone', ['class' => 'form-label']); ?>

                        <?php echo Form::text('principal[phone]', old('principal.phone', $principal?->phone), ['class' => 'form-control ptcl-mask','placeholder' => 'Phone Number','maxlength' => '20','required']); ?>

                    </div>
    
                    
                    <div class="form-group col-md-4">
                        <?php echo Form::label('principal[fax]', 'Fax', ['class' => 'form-label']); ?>

                        <?php echo Form::text('principal[fax]', old('principal.fax', $principal?->fax), ['class' => 'form-control','placeholder' => 'Fax Number','maxlength' => '20','required']); ?>

                    </div>
    
                    
                    <div class="form-group col-md-4">
                        <?php echo Form::label('principal[email]', 'Email', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::text('principal[email]', old('principal.email', $principal?->email), ['class' => 'form-control ' . $errors->first('principal.email', 'error'),'placeholder' => 'Email Address','maxlength' => '64','required']); ?>

                        <?php echo $errors->first('principal.email','<label class="error">:message</label>'); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBoard">
                <strong>Board of Directors / Owners</strong>
            </button>
        </h2>
        <div id="collapseBoard" class="accordion-collapse collapse" data-bs-parent="#registrationAccordion">
            <div class="accordion-body">
                <div class="form-group mt-3">
                    <div class="form-check">
                        
                        <?php echo Form::hidden('board_of_directors_owners', 0); ?>

                        <?php echo Form::checkbox('board_of_directors_owners', 1, $hasBoard, ['class' => 'form-check-input', 'id' => 'has_board_of_directors']); ?>

                        <?php echo Form::label('has_board_of_directors', 'Has Board of Directors / Owners?', ['class' => 'form-check-label']); ?>

                    </div>
    
                    <div id="board-container" style="display: <?php echo e($hasBoard ? 'block' : 'none'); ?>; margin-top: 10px;">
                        
                        <button type="button" class="btn btn-sm btn-secondary mb-2" id="add-board-btn">Add Board Member</button>
                        <div id="board-list">
                            <?php if(count($boardMembers) > 0): ?>
                                <?php $__currentLoopData = $boardMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $director): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="board-member d-flex align-items-center mb-2" data-index="<?php echo e($i); ?>">
                                        <?php echo Form::text("board_of_directors[{$i}][name]", $director['name'] ?? null, ['placeholder' => 'Name','class' => 'form-control me-2 ' . ($errors->has("board_of_directors.$i.name") ? 'is-invalid' : ''),'style' => 'flex: 1;','maxlength' => 64,'required']); ?>

                                        <?php echo $errors->first("board_of_directors.$i.name", '<label class="error mt-1 d-block">:message</label>'); ?>

                                        <?php echo Form::text("board_of_directors[{$i}][designation]", $director['designation'] ?? null, ['placeholder' => 'Designation','class' => 'form-control me-2 ' . ($errors->has("board_of_directors.$i.designation") ? 'is-invalid' : ''),'style' => 'flex: 1;','maxlength' => 64,]); ?>

                                        <?php echo $errors->first("board_of_directors.$i.designation", '<label class="error mt-1 d-block">:message</label>'); ?>

    
                                        <button type="button" class="btn btn-danger btn-sm remove-board-member">Remove</button>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="board-member d-flex align-items-center mb-2" data-index="0">
                                    <?php echo Form::text('board_of_directors[0][name]', null, ['placeholder' => 'Name','class' => 'form-control me-2 ' . ($errors->has('board_of_directors.0.name') ? 'is-invalid' : ''),'style' => 'flex: 1;','maxlength' => 64,]); ?>

                                    <?php echo $errors->first('board_of_directors.0.name', '<label class="error mt-1 d-block">:message</label>'); ?>

                                    <?php echo Form::text('board_of_directors[0][designation]', null, ['placeholder' => 'Designation','class' => 'form-control me-2 ' . ($errors->has('board_of_directors.0.designation') ? 'is-invalid' : ''),'style' => 'flex: 1;','maxlength' => 64,]); ?>

                                    <?php echo $errors->first('board_of_directors.0.designation', '<label class="error mt-1 d-block">:message</label>'); ?>

    
                                    <button type="button" class="btn btn-danger btn-sm remove-board-member">Remove</button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php echo $errors->first('board_of_directors_owners', '<label class="error">:message</label>'); ?>

                </div>
            </div>
        </div>
    </div>

    
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaculty">
                <strong>Faculty Information</strong>
            </button>
        </h2>
        <div id="collapseFaculty" class="accordion-collapse collapse" data-bs-parent="#registrationAccordion">
            <div class="accordion-body">
    
                <?php
                    $qualificationOptions = [
                        'Graduation (BSc/ BA)' => 'Graduation (BSc/ BA)',
                        'Graduation (BS 4 Years)' => 'Graduation (BS 4 Years)',
                        'Post-Graduation (MA/ MSc etc.)' => 'Post-Graduation (MA/ MSc etc.)',
                        'MS/ M.Phil' => 'MS/ M.Phil',
                        'PhD' => 'PhD',
                    ];
                    $facultyRows = old('faculty') ?? ($facultyData ?? []);
                    if (empty($facultyRows)) {
                        $facultyRows = [0 => ['name' => '', 'cnic' => '', 'qualification' => '']];
                    }
                ?>
                

                <div class="d-flex align-items-center mb-2">
                    <h5 class="mb-0">Faculty Info</h5>
                    <button type="button" class="btn btn-sm btn-secondary ms-2" id="add-faculty-btn">
                        Add Faculty Member
                    </button>
                </div>

                <div id="faculty-list">
                    <?php $__currentLoopData = $facultyRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $faculty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="faculty-member d-flex align-items-center mb-2" data-index="<?php echo e($i); ?>">
                            <div class="d-flex flex-column me-2" style="flex: 2;">
                                <?php echo Form::text("faculty[{$i}][name]", $faculty['name'] ?? null, ['placeholder' => 'Name','class' => 'form-control' . ($errors->has("faculty.{$i}.name") ? ' is-invalid' : ''),'maxlength' => 64,'required' => true,]); ?>

                                <label class="error mt-1" data-error-for="faculty[<?php echo e($i); ?>][name]">
                                    <?php echo $errors->first("faculty.{$i}.name"); ?>

                                </label>
                            </div>

                            <div class="d-flex flex-column me-2" style="flex: 1.5;">
                                <?php echo Form::text("faculty[{$i}][cnic]", $faculty['cnic'] ?? null, ['placeholder' => 'CNIC','class' => 'form-control cnic-mask' . ($errors->has("faculty.{$i}.cnic") ? ' is-invalid' : ''),'required' => true,]); ?>

                                <label class="error mt-1" data-error-for="faculty[<?php echo e($i); ?>][cnic]">
                                    <?php echo $errors->first("faculty.{$i}.cnic"); ?>

                                </label>
                            </div>

                            <div class="d-flex flex-column me-2" style="flex: 2;">
                                <?php echo Form::select("faculty[{$i}][qualification]",['' => 'Qualification'] + $qualificationOptions, $faculty['qualification'] ?? '', ['class' => 'form-control' . ($errors->has("faculty.{$i}.qualification") ? ' is-invalid' : ''),'required' => true,]); ?>

                                <label class="error mt-1" data-error-for="faculty[<?php echo e($i); ?>][qualification]">
                                    <?php echo $errors->first("faculty.{$i}.qualification"); ?>

                                </label>
                            </div>

                            <div class="d-flex flex-column me-2" style="flex: 2;">
                                <?php echo Form::file("faculty[{$i}][cv]", ['class' => 'form-control' . ($errors->has("faculty.{$i}.cv") ? ' is-invalid' : ''),'accept' => '.pdf,.doc,.docx','required' => !isset($faculty['id']),]); ?>

                                <label class="error mt-1" data-error-for="faculty[<?php echo e($i); ?>][cv]">
                                    <?php echo $errors->first("faculty.{$i}.cv"); ?>

                                </label>
                                
                                <?php if(!empty($faculty['id']) && !empty($faculty['cv_path'] ?? null)): ?>
                                    <small><a href="<?php echo e(asset('storage/' . $faculty['cv_path'])); ?>" target="_blank">View uploaded CV</a></small>
                                <?php endif; ?>
                            </div>
                            
                            <?php if($i !== 0): ?>
                                <button type="button" class="btn btn-danger btn-sm remove-faculty-member">Remove</button>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <hr class="my-3">

                
                <div class="row g-3">
                    <div class="form-group col-md-4">
                        <?php echo Form::label('male_faculty', 'Male Faculty', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::number('male_faculty', old('male_faculty', $institution->male_faculty ?? null), ['id' => 'male_faculty','class' => 'form-control','required', 'min' => 0]); ?>

                    </div>

                    <div class="form-group col-md-4">
                        <?php echo Form::label('female_faculty', 'Female Faculty', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::number('female_faculty', old('female_faculty', $institution->female_faculty ?? null), ['id' => 'female_faculty','class' => 'form-control','required', 'min' => 0]); ?>

                    </div>

                    <div class="form-group col-md-4">
                        <?php echo Form::label('total_faculty', 'Total Faculty', ['class' => 'form-label']); ?>

                        <?php echo Form::number('total_faculty', old('total_faculty', $institution->total_faculty ?? null), ['id' => 'total_faculty','class' => 'form-control','readonly', 'min' => 0]); ?>

                    </div>
                </div>

            </div>
        </div>
    </div>

    
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStudents">
                <strong>Student Enrollment</strong>
            </button>
        </h2>
        <div id="collapseStudents" class="accordion-collapse collapse" data-bs-parent="#registrationAccordion">
            <div class="accordion-body">
                <h5>Student’s Enrolment in the Institution</h5>
                <div class="row g-3 mt-3">
                    <div class="form-group col-md-4">
                        <?php echo Form::label('grade_id', 'Grade', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::select('grade_id', $grades, old('grade_id', $selectedGradeId ?? null), ['id' => 'grade_id','class' => 'form-control ' . $errors->first('grade_id', 'error'),'placeholder' => 'Choose Grade','required' => true]); ?>

                        <?php echo $errors->first('grade_id', '<label class="error">:message</label>'); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo Form::label('male_students', 'Male Students', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::number('male_students', old('male_students', $enrollment->male_students ?? null), ['id' => 'male_students','class' => 'form-control ' . $errors->first('male_students', 'error'),'min' => 0,'required' => true]); ?>

                        <?php echo $errors->first('male_students', '<label class="error">:message</label>'); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo Form::label('female_students', 'Female Students', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::number('female_students', old('female_students', $enrollment->female_students ?? null), ['id' => 'female_students','class' => 'form-control ' . $errors->first('female_students', 'error'),'min' => 0,'required' => true]); ?>

                        <?php echo $errors->first('female_students', '<label class="error">:message</label>'); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo Form::label('total_students', 'Total Students', ['class' => 'form-label']); ?>

                        <?php echo Form::number('total_students', old('total_students', $enrollment->total_students ?? null), ['id' => 'total_students','class' => 'form-control','readonly','placeholder' => 'Auto calculated']); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo Form::label('institution_str', 'Student–Teacher Ratio (STR)', ['class' => 'form-label']); ?>

                        <?php echo Form::text('institution_str', old('institution_str', $institution->institution_str ?? null), ['id' => 'institution_str','class' => 'form-control ' . $errors->first('institution_str', 'error'),'readonly','placeholder' => 'Auto calculated']); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsecurriculum">
                <strong>Curriculum Assessment & Types</strong>
            </button>
        </h2>
        <div id="collapsecurriculum" class="accordion-collapse collapse" data-bs-parent="#registrationAccordion">
            <div class="accordion-body">
                <div class="form-group col-md-4">
                    <?php echo Form::label('examination_board', 'Examination Board', ['for' => 'examination_board','class' => 'form-label required-input']); ?>

                    <?php echo Form::select('examination_board', ['' => 'Select Examination Board','BISE' => 'BISE','CIE' => 'CIE','PLC' => 'PLC'], old('examination_board', $institution->examination_board ?? null), ['id' => 'examination_board','class' => 'form-control ' . $errors->first('examination_board', 'error'),'required' => true]); ?>

                    <?php echo $errors->first('examination_board', '<label class="error">:message</label>'); ?>

                </div>
                <hr>
                <h5 class="mt-3">Type of Curriculum Adopted</h5>
                <div class="row g-3">
                    <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gradeId => $gradeName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-4 mb-3">
                            <?php echo Form::label("curriculums[$gradeId]", "Curriculum for $gradeName", ['class' => 'form-label']); ?>

                            <?php echo Form::select("curriculums[$gradeId]", ['' => '-- Select Curriculum --','National Curriculum' => 'National Curriculum','CIE' => 'CIE','PLC' => 'PLC'], old("curriculums.$gradeId", $selectedCurriculums[$gradeId] ?? null), ['class' => 'form-select', 'id' => "curriculum_$gradeId",'required' => true]); ?>

                            <?php if($errors->has("curriculums.$gradeId")): ?>
                            <label class="text-danger"><?php echo e($errors->first("curriculums.$gradeId")); ?></label>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="form-group col-md-12 mt-4">
                    <?php echo Form::label('national_education_policy_adherence', 'Adherence to National Education Policy', ['for' => 'national_education_policy_adherence', 'class' => 'form-label required-input']); ?>

                    <?php echo Form::textarea('national_education_policy_adherence', old('national_education_policy_adherence', $institution->national_education_policy_adherence ?? null), ['id' => 'national_education_policy_adherence','class' => 'form-control ' . $errors->first('national_education_policy_adherence', 'error'),'rows' => 3,'placeholder' => 'Describe briefly how your institution follows the National Education Policy','required' => true]); ?>

                    <?php echo $errors->first('national_education_policy_adherence', '<label class="error">:message</label>'); ?>

                </div>
            </div>
        </div>
    </div>

    
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInfrastructure">
                <strong>Infrastructure & Allied Facilities</strong>
            </button>
        </h2>
        <div id="collapseInfrastructure" class="accordion-collapse collapse" data-bs-parent="#registrationAccordion">
            <div class="accordion-body">
                <h5 class="mt-3">Infrastructure</h5>
                <div class="row g-3">
                    <div class="form-group col-md-4">
                        <?php echo Form::label('infrastructure[building_type]', 'Type of Building', ['for' => 'infrastructure_building_type','class' => 'form-label required-input']); ?>

                        <?php echo Form::select('infrastructure[building_type]', ['' => 'Select', 'Purpose Built' => 'Purpose Built','Residential' => 'Residential','Commercial' => 'Commercial'], old('infrastructure.building_type',$infrastructure?->building_type ?? null), ['id' => 'infrastructure_building_type','class' => 'form-control ' . $errors->first('infrastructure.building_type', 'error'),'required' => true]); ?>

                        <?php echo $errors->first('infrastructure.building_type', '<label class="error">:message</label>'); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo Form::label('infrastructure[building_possession]', 'Status of Property Possession', ['for' => 'infrastructure_building_possession','class' => 'form-label required-input']); ?>

                        <?php echo Form::select('infrastructure[building_possession]', ['' => 'Select', 'Owned' => 'Owned','Leased' => 'Leased','Rented' => 'Rented'], old('infrastructure.building_possession', $infrastructure?->building_possession ?? null), ['id' => 'infrastructure_building_possession','class' => 'form-control ' . $errors->first('infrastructure.building_possession', 'error'),'required' => true]); ?>

                        <?php echo $errors->first('infrastructure.building_possession', '<label class="error">:message</label>'); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo Form::label('infrastructure[area_in_kanal]', 'Total Area (In Kanal)', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::number('infrastructure[area_in_kanal]', old('infrastructure.area_in_kanal',$infrastructure?->area_in_kanal ?? null), ['class' => 'form-control ' . $errors->first('infrastructure.area_in_kanal', 'error'),'step' => '0.01','min' => '0','required' => true]); ?>

                        <?php echo $errors->first('infrastructure.area_in_kanal', '<label class="error">:message</label>'); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo Form::label('infrastructure[area_in_marla]', 'Total Area (In Marla)', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::number('infrastructure[area_in_marla]', old('infrastructure.area_in_marla',$infrastructure?->area_in_marla ?? null), ['class' => 'form-control ' . $errors->first('infrastructure.area_in_marla', 'error'),'step' => '0.01','min' => '0','required' => true]); ?>

                        <?php echo $errors->first('infrastructure.area_in_marla', '<label class="error">:message</label>'); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo Form::label('infrastructure[no_of_classrooms]', 'Number of Classrooms', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::number('infrastructure[no_of_classrooms]', old('infrastructure.no_of_classrooms',$infrastructure?->no_of_classrooms ?? null), ['class' => 'form-control ' . $errors->first('infrastructure.no_of_classrooms', 'error'),'min' => '0','required' => true]); ?>

                        <?php echo $errors->first('infrastructure.no_of_classrooms', '<label class="error">:message</label>'); ?>

                    </div>
                    <?php
                        // Safe access to facility record (null on create)
                        $facilityRecord = optional(optional($institution)->institutionFacility);

                        // Get old input for radio or fallback to DB value
                        $oldRadio = old('other_allied_facilities');
                        if ($oldRadio !== null) {
                            $isOtherYes = ($oldRadio === 'Yes');
                        } else {
                            $dbVal = optional($institution)->other_allied_facilities;
                            $isOtherYes = ($dbVal === 'Yes' || $dbVal === '1' || $dbVal === 1);
                        }
                        

                        // Helper for checkbox checked state (old input has priority)
                        function fac($key, $facilityRecord) {
                            $old = old("facilities.$key");
                            if ($old !== null) {
                                return (int)$old === 1;
                            }
                            if (!$facilityRecord) {
                                return false;
                            }
                            return (int)($facilityRecord->$key ?? 0) === 1;
                        }
                        // Show/hide "other facilities" textbox based on checkbox state
                        $showOtherText = fac('has_other', $facilityRecord) ? 'block' : 'none';
                        // Value of other facilities text input
                        $otherText = old('facilities.other_facilities', $facilityRecord->other_facilities ?? '');
                    ?>
                    <h5 class="mt-3">Allied Facilities</h5>
                    <div class="form-group">
                        <?php echo Form::label('other_allied_facilities', 'Other Allied Facilities', ['class' => 'form-label required-input']); ?>

                        <div>
                            <?php echo Form::radio('other_allied_facilities', 'Yes', $isOtherYes, ['id' => 'other_allied_yes', 'required']); ?>

                            <?php echo Form::label('other_allied_yes', 'Yes'); ?>

                            <?php echo Form::radio('other_allied_facilities', 'No', !$isOtherYes, ['id' => 'other_allied_no', 'required']); ?>

                            <?php echo Form::label('other_allied_no', 'No'); ?>

                        </div>
                        <?php echo $errors->first('other_allied_facilities', '<label class="error">:message</label>'); ?>

                    </div>

                    <div id="alliedFacilitiesOptions" style="display: <?php echo e($isOtherYes ? 'block' : 'none'); ?>; margin-top: 10px;">

                        <div class="form-check">
                            <?php echo Form::checkbox('facilities[has_auditorium]', 1, fac('has_auditorium', $facilityRecord), ['id' => 'has_auditorium', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('has_auditorium', 'Auditorium', ['class' => 'form-check-label']); ?>

                        </div>

                        <div class="form-check">
                            <?php echo Form::checkbox('facilities[has_conference_room]', 1, fac('has_conference_room', $facilityRecord), ['id' => 'has_conference_room', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('has_conference_room', 'Conference Room', ['class' => 'form-check-label']); ?>

                        </div>

                        <div class="form-check">
                            <?php echo Form::checkbox('facilities[has_tutorial_room]', 1, fac('has_tutorial_room', $facilityRecord), ['id' => 'has_tutorial_room', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('has_tutorial_room', 'Tutorial Room', ['class' => 'form-check-label']); ?>

                        </div>

                        <div class="form-check">
                            <?php echo Form::checkbox('facilities[has_examination_hall]', 1, fac('has_examination_hall', $facilityRecord), ['id' => 'has_examination_hall', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('has_examination_hall', 'Examination Hall', ['class' => 'form-check-label']); ?>

                        </div>

                        <div class="form-check">
                            <?php echo Form::checkbox('facilities[has_other]', 1, fac('has_other', $facilityRecord), ['id' => 'has_other', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('has_other', 'Others', ['class' => 'form-check-label']); ?>

                        </div>

                        <div id="otherFacilitiesText" style="display: <?php echo e($showOtherText); ?>; margin-top: 0.5rem;">
                            <?php echo Form::label('facilities_other_facilities', 'Please specify other facilities', ['class' => 'form-label']); ?>

                            <?php echo Form::text('facilities[other_facilities]', $otherText, ['class' => 'form-control', 'maxlength' => 191]); ?>

                            <?php echo $errors->first('facilities.other_facilities', '<label class="error">:message</label>'); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLibrary">
                <strong>Library & Resources and Instructional Material </strong>
            </button>
        </h2>
        <div id="collapseLibrary" class="accordion-collapse collapse" data-bs-parent="#registrationAccordion">
            <div class="accordion-body">
                <h5 class="mt-4">School Library</h5>
                    <div class="form-group">
                        <label class="form-label required-input">School Library</label><br> 
                        
                        <?php
                            $facilityData = isset($institution) ? $institution->institutionFacility : null;
                            
                            // Convert database 1/0 values for form display
                            $convertToYesNo = function($value) {
                                if ($value === 1 || $value === '1') return '1';
                                if ($value === 0 || $value === '0') return '0';
                                return $value;
                            };
                        ?>
                                    
                        <?php echo Form::radio('library[has_library]', 1, (old('library.has_library', $convertToYesNo($facilityData->has_library ?? null)) === '1'), ['id' => 'library_yes', 'required']); ?>

                        <?php echo Form::label('library_yes', 'Yes'); ?> 
                        <?php echo Form::radio('library[has_library]', 0, (old('library.has_library', $convertToYesNo($facilityData->has_library ?? null)) === '0'), ['id' => 'library_no', 'required']); ?>

                        <?php echo Form::label('library_no', 'No'); ?>

                        <div>
                            <?php echo $errors->first('library.has_library', '<label class="error">:message</label>'); ?>

                        </div>
                    </div>

                    <div id="library_details" class="align-items-center" style="display: none; margin-top:10px;">
                        <div class="form-group me-2" style="flex: 2;">
                            <?php echo Form::label('library[no_of_books]', 'Number of available Books', ['class' => 'form-label']); ?>

                            <?php echo Form::number('library[no_of_books]', old('library.no_of_books', $facilityData->no_of_books ?? null), ['class' => 'form-control ' . ($errors->has('library.no_of_books') ? 'is-invalid' : ''), 'min' => 0, 'max' => 100000]); ?>

                            <?php echo $errors->first('library.no_of_books', '<label class="error">:message</label>'); ?>

                        </div>

                        <div class="form-group me-2" style="flex: 2;">
                            <?php echo Form::label('library[no_of_subscription_e_library]', 'Subscription to ELibrary', ['class' => 'form-label']); ?>

                            <?php echo Form::number('library[no_of_subscription_e_library]',old('library.no_of_subscription_e_library', $facilityData->no_of_subscription_e_library ?? null),['class' => 'form-control ' . ($errors->has('library.no_of_subscription_e_library') ? 'is-invalid' : ''),'min' => 0]); ?>

                            <?php echo $errors->first('library.no_of_subscription_e_library', '<label class="error">:message</label>'); ?>

                        </div>

                        <div class="form-group" style="flex: 2;">
                            <?php echo Form::label('library[no_of_subscription_e_journals]', 'Subscription to Journals (including EJournals)', ['class' => 'form-label']); ?>

                            <?php echo Form::number('library[no_of_subscription_e_journals]',old('library.no_of_subscription_e_journals', $facilityData->no_of_subscription_e_journals ?? null),['class' => 'form-control ' . ($errors->has('library.no_of_subscription_e_journals') ? 'is-invalid' : ''),'min' => 0]); ?>

                            <?php echo $errors->first('library.no_of_subscription_e_journals', '<label class="error">:message</label>'); ?>

                        </div>
                    </div>
                    <h5 class="mt-4">Resources and Instructional Material</h5>
                    <div class="form-group">
                        <label class="form-label required-input">Other Resources and Instructional Material</label><br>
                        
                        <?php
                            $facilityData = isset($institution) ? $institution->institutionFacility : null;
                            
                            $convertToYesNo = function($value) {
                                if ($value === 1 || $value === '1') return '1';
                                if ($value === 0 || $value === '0') return '0';
                                return $value;
                            };
                        ?>
                        
                        <?php echo Form::radio('other_resources[other_instructional_material]', 1,(old('other_resources.other_instructional_material', $convertToYesNo($facilityData->other_instructional_material ?? null)) === '1'),['id' => 'other_resources_yes', 'required']); ?>

                        <?php echo Form::label('other_resources_yes', 'Yes'); ?>                    
                        <?php echo Form::radio('other_resources[other_instructional_material]', 0,(old('other_resources.other_instructional_material', $convertToYesNo($facilityData->other_instructional_material ?? null)) === '0'),['id' => 'other_resources_no', 'required']); ?>

                        <?php echo Form::label('other_resources_no', 'No'); ?>             
                        <div>
                            <?php echo $errors->first('other_resources.other_instructional_material', '<label class="error">:message</label>'); ?>

                        </div>
                    </div>
                    
                    <div id="other_resources_options" style="display: none; margin-top:10px;">
                        
                        <?php echo Form::hidden('other_resources[has_atlas]', 0); ?>

                        <?php echo Form::hidden('other_resources[has_dictionaries]', 0); ?>

                        <?php echo Form::hidden('other_resources[has_encyclopedia]', 0); ?>

                        <?php echo Form::hidden('other_resources[has_daily_newspaper]', 0); ?>

                        <?php echo Form::hidden('other_resources[has_magazines]', 0); ?>

                        
                        <div class="form-check">
                            <?php echo Form::checkbox('other_resources[has_atlas]', 1,old('other_resources.has_atlas', $facilityData->has_atlas ?? false),['id' => 'has_atlas', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('has_atlas', 'Atlas', ['class' => 'form-check-label']); ?>

                        </div>
                        <div class="form-check">
                            <?php echo Form::checkbox('other_resources[has_dictionaries]', 1,old('other_resources.has_dictionaries', $facilityData->has_dictionaries ?? false),['id' => 'has_dictionaries', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('has_dictionaries', 'Dictionaries', ['class' => 'form-check-label']); ?>

                        </div>
                        <div class="form-check">
                            <?php echo Form::checkbox('other_resources[has_encyclopedia]', 1,old('other_resources.has_encyclopedia', $facilityData->has_encyclopedia ?? false),['id' => 'has_encyclopedia', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('has_encyclopedia', 'Encyclopedia', ['class' => 'form-check-label']); ?>

                        </div>
                        <div class="form-check">
                            <?php echo Form::checkbox('other_resources[has_daily_newspaper]', 1,old('other_resources.has_daily_newspaper', $facilityData->has_daily_newspaper ?? false),['id' => 'has_daily_newspaper', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('has_daily_newspaper', 'Daily Newspaper', ['class' => 'form-check-label']); ?>

                        </div>
                        <div class="form-check">
                            <?php echo Form::checkbox('other_resources[has_magazines]', 1,old('other_resources.has_magazines', $facilityData->has_magazines ?? false),['id' => 'has_magazines', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('has_magazines', 'Magazines', ['class' => 'form-check-label']); ?>

                        </div>
                    </div>
            </div>
        </div>
    </div>

    
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLaboratories">
                <strong>Science & Computer Laboratories</strong>
            </button>
        </h2>
        <div id="collapseLaboratories" class="accordion-collapse collapse" data-bs-parent="#registrationAccordion">
            <div class="accordion-body">
                <h5 class="mt-4">Science Laboratories</h5>
                
                <?php
                    $labData = isset($institution) ? $institution->laboratoryDetails->first() : null;
                    $convertToYesNo = function($value) {
                        if ($value === 1 || $value === '1') return 'yes';
                        if ($value === 0 || $value === '0') return 'no';
                        return $value;
                    };
                ?>
    
                
                <div class="form-group col-md-12 mt-3">
                    <?php echo Form::label('science_laboratories', 'Science Laboratories Available?', ['class' => 'form-label required-input']); ?>

                    <div>
                        <?php echo Form::radio('science_laboratories', 'yes', (old('science_laboratories', $convertToYesNo($labData->science_laboratories ?? null)) === 'yes'), ['id' => 'science_yes', 'class' => 'science-lab-radio', 'required']); ?>

                        <?php echo Form::label('science_yes', 'Yes'); ?>

                        <?php echo Form::radio('science_laboratories', 'no', (old('science_laboratories', $convertToYesNo($labData->science_laboratories ?? null)) === 'no'), ['id' => 'science_no', 'class' => 'science-lab-radio', 'required']); ?>

                        <?php echo Form::label('science_no', 'No'); ?>

                    </div>
                    <?php echo $errors->first('science_laboratories', '<label class="error">:message</label>'); ?>

                </div>
                
                
                <div id="science_details" style="display:none; margin-left:20px;">
                    
                    
                    <div class="form-group col-md-12 mt-3">
                        <?php echo Form::label('physic_laboratories', 'Physics Laboratory Available?', ['class' => 'form-label required-input']); ?>

                        <div>
                            <?php echo Form::radio('physic_laboratories', 'yes', (old('physic_laboratories', $convertToYesNo($labData->physic_laboratories ?? null)) === 'yes'), ['id' => 'physics_yes', 'class' => 'physics-lab-radio']); ?>

                            <?php echo Form::label('physics_yes', 'Yes'); ?>

                            <?php echo Form::radio('physic_laboratories', 'no', (old('physic_laboratories', $convertToYesNo($labData->physic_laboratories ?? null)) === 'no'), ['id' => 'physics_no', 'class' => 'physics-lab-radio']); ?>

                            <?php echo Form::label('physics_no', 'No'); ?>

                        </div>
                        <?php echo $errors->first('physic_laboratories', '<label class="error">:message</label>'); ?>

                    </div>
                
                    
                    <div id="physics_details" style="display:none; margin-left:20px;">
                        <div class="form-group col-md-6">
                            <?php echo Form::label('no_of_physic_laboratory_staff', 'Number of laboratory staff in Physics lab:', ['class' => 'form-label']); ?>

                            <?php echo Form::number('no_of_physic_laboratory_staff', 
                                old('no_of_physic_laboratory_staff', $labData->no_of_physic_laboratory_staff ?? null), ['class' => 'form-control physics-staff-input', 'min' => 0]); ?>

                            <?php echo $errors->first('no_of_physic_laboratory_staff', '<label class="error">:message</label>'); ?>

                        </div>
                        
                        
                        <h6>Physics Equipment:</h6>
                        <div class="form-check">
                            <?php echo Form::hidden('has_bunsen_burner', 0); ?>

                            <?php echo Form::checkbox('has_bunsen_burner', 1, old('has_bunsen_burner', $labData->has_bunsen_burner ?? false), ['id' => 'has_bunsen_burner', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('has_bunsen_burner', 'Bunsen Burner', ['class' => 'form-check-label']); ?>

                        </div>
                        <div class="form-check">
                            <?php echo Form::hidden('has_test_tubes', 0); ?>

                            <?php echo Form::checkbox('has_test_tubes', 1, old('has_test_tubes', $labData->has_test_tubes ?? false), ['id' => 'has_test_tubes', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('has_test_tubes', 'Test Tubes', ['class' => 'form-check-label']); ?>

                        </div>
                        <div class="form-check">
                            <?php echo Form::hidden('physic_has_microscope', 0); ?>

                            <?php echo Form::checkbox('physic_has_microscope', 1, old('physic_has_microscope', $labData->physic_has_microscope ?? false), ['id' => 'physic_has_microscope', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('physic_has_microscope', 'Microscope', ['class' => 'form-check-label']); ?>

                        </div>
                        <div class="form-check">
                            <?php echo Form::hidden('has_funnels', 0); ?>

                            <?php echo Form::checkbox('has_funnels', 1, old('has_funnels', $labData->has_funnels ?? false), ['id' => 'has_funnels', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('has_funnels', 'Funnels', ['class' => 'form-check-label']); ?>

                        </div>
    
                        
                        <h6 class="mt-3">Physics Safety Equipment:</h6>
                        <div class="form-check">
                            <?php echo Form::hidden('physics_has_eye_wash', 0); ?>

                            <?php echo Form::checkbox('physics_has_eye_wash', 1, old('physics_has_eye_wash', $labData->physics_has_eye_wash ?? false), ['id' => 'physics_has_eye_wash', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('physics_has_eye_wash', 'Eye Wash', ['class' => 'form-check-label']); ?>

                        </div>
                        <div class="form-check">
                            <?php echo Form::hidden('physics_has_fume_hood', 0); ?>

                            <?php echo Form::checkbox('physics_has_fume_hood', 1, old('physics_has_fume_hood', $labData->physics_has_fume_hood ?? false), ['id' => 'physics_has_fume_hood', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('physics_has_fume_hood', 'Fume Hood', ['class' => 'form-check-label']); ?>

                        </div>
                        <div class="form-check">
                            <?php echo Form::hidden('physics_has_disposable_masks', 0); ?>

                            <?php echo Form::checkbox('physics_has_disposable_masks', 1, old('physics_has_disposable_masks', $labData->physics_has_disposable_masks ?? false), ['id' => 'physics_has_disposable_masks', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('physics_has_disposable_masks', 'Disposable Masks', ['class' => 'form-check-label']); ?>

                        </div>
                        <div class="form-check">
                            <?php echo Form::hidden('physics_has_lab_coat', 0); ?>

                            <?php echo Form::checkbox('physics_has_lab_coat', 1, old('physics_has_lab_coat', $labData->physics_has_lab_coat ?? false), ['id' => 'physics_has_lab_coat', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('physics_has_lab_coat', 'Lab Coat', ['class' => 'form-check-label']); ?>

                        </div>
                    </div>
                
                    
                    <div class="form-group col-md-12 mt-3">
                        <?php echo Form::label('bio_laboratories', 'Bio Laboratory Available?', ['class' => 'form-label required-input']); ?>

                        <div>
                            <?php echo Form::radio('bio_laboratories', 'yes', (old('bio_laboratories', $convertToYesNo($labData->bio_laboratories ?? null)) === 'yes'), ['id' => 'bio_yes', 'class' => 'bio-lab-radio']); ?>

                            <?php echo Form::label('bio_yes', 'Yes'); ?>

                            <?php echo Form::radio('bio_laboratories', 'no', (old('bio_laboratories', $convertToYesNo($labData->bio_laboratories ?? null)) === 'no'), ['id' => 'bio_no', 'class' => 'bio-lab-radio']); ?>

                            <?php echo Form::label('bio_no', 'No'); ?>

                        </div>
                        <?php echo $errors->first('bio_laboratories', '<label class="error">:message</label>'); ?>

                    </div>
                
                    
                    <div id="bio_details" style="display:none; margin-left:20px;">
                        <div class="form-group col-md-6">
                            <?php echo Form::label('no_of_bio_laboratory_staff', 'Number of laboratory staff in Bio lab:', ['class' => 'form-label']); ?>

                            <?php echo Form::number('no_of_bio_laboratory_staff', old('no_of_bio_laboratory_staff', $labData->no_of_bio_laboratory_staff ?? null), ['class' => 'form-control bio-staff-input', 'min' => 0]); ?>

                            <?php echo $errors->first('no_of_bio_laboratory_staff', '<label class="error">:message</label>'); ?>

                        </div>
                        
                        
                        <h6>Bio Equipment:</h6>
                        <div class="form-check">
                            <?php echo Form::hidden('has_siring', 0); ?>

                            <?php echo Form::checkbox('has_siring', 1, old('has_siring', $labData->has_siring ?? false), ['id' => 'has_siring', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('has_siring', 'Siring', ['class' => 'form-check-label']); ?>

                        </div>
                        <div class="form-check">
                            <?php echo Form::hidden('has_dropper', 0); ?>

                            <?php echo Form::checkbox('has_dropper', 1, old('has_dropper', $labData->has_dropper ?? false), ['id' => 'has_dropper', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('has_dropper', 'Dropper', ['class' => 'form-check-label']); ?>

                        </div>
                        <div class="form-check">
                            <?php echo Form::hidden('has_retort', 0); ?>

                            <?php echo Form::checkbox('has_retort', 1, old('has_retort', $labData->has_retort ?? false), ['id' => 'has_retort', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('has_retort', 'Retort', ['class' => 'form-check-label']); ?>

                        </div>
                        <div class="form-check">
                            <?php echo Form::hidden('has_beaker', 0); ?>

                            <?php echo Form::checkbox('has_beaker', 1, old('has_beaker', $labData->has_beaker ?? false), ['id' => 'has_beaker', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('has_beaker', 'Beaker', ['class' => 'form-check-label']); ?>

                        </div>
    
                        
                        <h6 class="mt-3">Bio Safety Equipment:</h6>
                        <div class="form-check">
                            <?php echo Form::hidden('bio_has_eye_wash', 0); ?>

                            <?php echo Form::checkbox('bio_has_eye_wash', 1, old('bio_has_eye_wash', $labData->bio_has_eye_wash ?? false), ['id' => 'bio_has_eye_wash', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('bio_has_eye_wash', 'Eye Wash', ['class' => 'form-check-label']); ?>

                        </div>
                        <div class="form-check">
                            <?php echo Form::hidden('bio_has_fume_hood', 0); ?>

                            <?php echo Form::checkbox('bio_has_fume_hood', 1, old('bio_has_fume_hood', $labData->bio_has_fume_hood ?? false), ['id' => 'bio_has_fume_hood', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('bio_has_fume_hood', 'Fume Hood', ['class' => 'form-check-label']); ?>

                        </div>
                        <div class="form-check">
                            <?php echo Form::hidden('bio_has_disposable_masks', 0); ?>

                            <?php echo Form::checkbox('bio_has_disposable_masks', 1, old('bio_has_disposable_masks', $labData->bio_has_disposable_masks ?? false), ['id' => 'bio_has_disposable_masks', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('bio_has_disposable_masks', 'Disposable Masks', ['class' => 'form-check-label']); ?>

                        </div>
                        <div class="form-check">
                            <?php echo Form::hidden('bio_has_lab_coat', 0); ?>

                            <?php echo Form::checkbox('bio_has_lab_coat', 1, old('bio_has_lab_coat', $labData->bio_has_lab_coat ?? false), ['id' => 'bio_has_lab_coat', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('bio_has_lab_coat', 'Lab Coat', ['class' => 'form-check-label']); ?>

                        </div>
                    </div>
                
                    
                    <div class="form-group col-md-12 mt-3">
                        <?php echo Form::label('chemistry_laboratories', 'Chemistry Laboratory Available?', ['class' => 'form-label required-input']); ?>

                        <div>
                            <?php echo Form::radio('chemistry_laboratories', 'yes', (old('chemistry_laboratories', $convertToYesNo($labData->chemistry_laboratories ?? null)) === 'yes'), ['id' => 'chemistry_yes', 'class' => 'chemistry-lab-radio']); ?>

                            <?php echo Form::label('chemistry_yes', 'Yes'); ?>

                            <?php echo Form::radio('chemistry_laboratories', 'no', (old('chemistry_laboratories', $convertToYesNo($labData->chemistry_laboratories ?? null)) === 'no'), ['id' => 'chemistry_no', 'class' => 'chemistry-lab-radio']); ?>

                            <?php echo Form::label('chemistry_no', 'No'); ?>

                        </div>
                        <?php echo $errors->first('chemistry_laboratories', '<label class="error">:message</label>'); ?>

                    </div>
                
                    
                    <div id="chemistry_details" style="display:none; margin-left:20px;">
                        <div class="form-group col-md-6">
                            <?php echo Form::label('no_of_chemistry_laboratory_staff', 'Number of laboratory staff in Chemistry lab:', ['class' => 'form-label']); ?>

                            <?php echo Form::number('no_of_chemistry_laboratory_staff', old('no_of_chemistry_laboratory_staff', $labData->no_of_chemistry_laboratory_staff ?? null), ['class' => 'form-control chemistry-staff-input', 'min' => 0]); ?>

                            <?php echo $errors->first('no_of_chemistry_laboratory_staff', '<label class="error">:message</label>'); ?>

                        </div>
                        
                        
                        <h6>Chemistry Equipment:</h6>
                        <div class="form-check">
                            <?php echo Form::hidden('has_ph_strip', 0); ?>

                            <?php echo Form::checkbox('has_ph_strip', 1, old('has_ph_strip', $labData->has_ph_strip ?? false), ['id' => 'has_ph_strip', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('has_ph_strip', 'PH Strip', ['class' => 'form-check-label']); ?>

                        </div>
                        <div class="form-check">
                            <?php echo Form::hidden('has_hot_plate', 0); ?>

                            <?php echo Form::checkbox('has_hot_plate', 1, old('has_hot_plate', $labData->has_hot_plate ?? false), ['id' => 'has_hot_plate', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('has_hot_plate', 'Hot Plate', ['class' => 'form-check-label']); ?>

                        </div>
                        <div class="form-check">
                            <?php echo Form::hidden('has_centrifuge', 0); ?>

                            <?php echo Form::checkbox('has_centrifuge', 1, old('has_centrifuge', $labData->has_centrifuge ?? false), ['id' => 'has_centrifuge', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('has_centrifuge', 'Centrifuge', ['class' => 'form-check-label']); ?>

                        </div>
                        <div class="form-check">
                            <?php echo Form::hidden('chemistry_has_microscope', 0); ?>

                            <?php echo Form::checkbox('chemistry_has_microscope', 1, old('chemistry_has_microscope', $labData->chemistry_has_microscope ?? false), ['id' => 'chemistry_has_microscope', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('chemistry_has_microscope', 'Microscope', ['class' => 'form-check-label']); ?>

                        </div>
    
                        
                        <h6 class="mt-3">Chemistry Safety Equipment:</h6>
                        <div class="form-check">
                            <?php echo Form::hidden('chemistry_has_eye_wash', 0); ?>

                            <?php echo Form::checkbox('chemistry_has_eye_wash', 1, old('chemistry_has_eye_wash', $labData->chemistry_has_eye_wash ?? false), ['id' => 'chemistry_has_eye_wash', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('chemistry_has_eye_wash', 'Eye Wash', ['class' => 'form-check-label']); ?>

                        </div>
                        <div class="form-check">
                            <?php echo Form::hidden('chemistry_has_fume_hood', 0); ?>

                            <?php echo Form::checkbox('chemistry_has_fume_hood', 1, old('chemistry_has_fume_hood', $labData->chemistry_has_fume_hood ?? false), ['id' => 'chemistry_has_fume_hood', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('chemistry_has_fume_hood', 'Fume Hood', ['class' => 'form-check-label']); ?>

                        </div>
                        <div class="form-check">
                            <?php echo Form::hidden('chemistry_has_disposable_masks', 0); ?>

                            <?php echo Form::checkbox('chemistry_has_disposable_masks', 1, old('chemistry_has_disposable_masks', $labData->chemistry_has_disposable_masks ?? false), ['id' => 'chemistry_has_disposable_masks', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('chemistry_has_disposable_masks', 'Disposable Masks', ['class' => 'form-check-label']); ?>

                        </div>
                        <div class="form-check">
                            <?php echo Form::hidden('chemistry_has_lab_coat', 0); ?>

                            <?php echo Form::checkbox('chemistry_has_lab_coat', 1, old('chemistry_has_lab_coat', $labData->chemistry_has_lab_coat ?? false), ['id' => 'chemistry_has_lab_coat', 'class' => 'form-check-input']); ?>

                            <?php echo Form::label('chemistry_has_lab_coat', 'Lab Coat', ['class' => 'form-check-label']); ?>

                        </div>
                    </div>
                </div>
                
                
                <h5 class="mt-4">Computer Laboratory</h5>
                <div class="form-group col-md-12 mt-3">
                    <?php echo Form::label('computer_laboratories', 'Computer Laboratory Available?', ['class' => 'form-label required-input']); ?>

                    <div>
                        <?php echo Form::radio('computer_laboratories', 'yes', (old('computer_laboratories', $convertToYesNo($labData->computer_laboratories ?? null)) === 'yes'), ['id' => 'computer_yes', 'class' => 'computer-lab-radio', 'required']); ?>

                        <?php echo Form::label('computer_yes', 'Yes'); ?>

                        <?php echo Form::radio('computer_laboratories', 'no', (old('computer_laboratories', $convertToYesNo($labData->computer_laboratories ?? null)) === 'no'), ['id' => 'computer_no', 'class' => 'computer-lab-radio', 'required']); ?>

                        <?php echo Form::label('computer_no', 'No'); ?>

                    </div>
                    <?php echo $errors->first('computer_laboratories', '<label class="error">:message</label>'); ?>

                </div>
            
                
                <div id="computer_details" style="display:none; margin-left:20px;">
                    <div class="form-group col-md-6">
                        <?php echo Form::label('no_of_computers', 'Number of Computers available:', ['class' => 'form-label']); ?>

                        <?php echo Form::number('no_of_computers', old('no_of_computers', $labData->no_of_computers ?? null), ['class' => 'form-control computer-count-input', 'min' => 0]); ?>

                        <?php echo $errors->first('no_of_computers', '<label class="error">:message</label>'); ?>

                    </div>
                    
                    
                    <h6>Computer Equipment:</h6>
                    <div class="form-check">
                        <?php echo Form::hidden('has_computer', 0); ?>

                        <?php echo Form::checkbox('has_computer', 1, old('has_computer', $labData->has_computer ?? false), ['id' => 'has_computer', 'class' => 'form-check-input']); ?>

                        <?php echo Form::label('has_computer', 'Computer', ['class' => 'form-check-label']); ?>

                    </div>
                    <div class="form-check">
                        <?php echo Form::hidden('has_modems', 0); ?>

                        <?php echo Form::checkbox('has_modems', 1, old('has_modems', $labData->has_modems ?? false), ['id' => 'has_modems', 'class' => 'form-check-input']); ?>

                        <?php echo Form::label('has_modems', 'Modems', ['class' => 'form-check-label']); ?>

                    </div>
                    <div class="form-check">
                        <?php echo Form::hidden('has_printer', 0); ?>

                        <?php echo Form::checkbox('has_printer', 1, old('has_printer', $labData->has_printer ?? false), ['id' => 'has_printer', 'class' => 'form-check-input']); ?>

                        <?php echo Form::label('has_printer', 'Printer', ['class' => 'form-check-label']); ?>

                    </div>
                    <div class="form-check">
                        <?php echo Form::hidden('has_scanner', 0); ?>

                        <?php echo Form::checkbox('has_scanner', 1, old('has_scanner', $labData->has_scanner ?? false), ['id' => 'has_scanner', 'class' => 'form-check-input']); ?>

                        <?php echo Form::label('has_scanner', 'Scanner', ['class' => 'form-check-label']); ?>

                    </div>
                    <div class="form-check">
                        <?php echo Form::hidden('has_laptops', 0); ?>

                        <?php echo Form::checkbox('has_laptops', 1, old('has_laptops', $labData->has_laptops ?? false), ['id' => 'has_laptops', 'class' => 'form-check-input']); ?>

                        <?php echo Form::label('has_laptops', 'Laptops', ['class' => 'form-check-label']); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTransparency">
                <strong>Transparency & Public Disclosures </strong>
            </button>
        </h2>
        <div id="collapseTransparency" class="accordion-collapse collapse" data-bs-parent="#registrationAccordion">
            <div class="accordion-body">
                <h5 class="mt-4">Transparency & Public Disclosures</h5>
    
                
                <?php
                    $transparencyData = isset($transparency) ? $transparency : null;
                    
                    // Convert database 1/0 values to yes/no for form display
                    $convertToYesNo = function($value) {
                        if ($value === 1 || $value === '1') return 'yes';
                        if ($value === 0 || $value === '0') return 'no';
                        return $value;
                    };
                ?>
    
                
                <div class="mb-3">
                    <label class="form-label">
                        Whether the School/ Institution has made public its fee structure and policy for annual increase
                    </label>
                    <div>
                        <?php echo Form::radio('fee_structure_public', 'yes', (old('fee_structure_public', $convertToYesNo($transparencyData->fee_structure_public ?? null)) === 'yes'), ['id' => 'fee_structure_public_yes', 'required']); ?>

                        <?php echo Form::label('fee_structure_public_yes', 'Yes'); ?>                
                        <?php echo Form::radio('fee_structure_public', 'no', (old('fee_structure_public', $convertToYesNo($transparencyData->fee_structure_public ?? null)) === 'no'), ['id' => 'fee_structure_public_no', 'required']); ?>

                        <?php echo Form::label('fee_structure_public_no', 'No'); ?>

                    </div>
                    <?php echo $errors->first('fee_structure_public', '<label class="error">:message</label>'); ?>

                </div>
    
                
                <div class="mb-3">
                    <label class="form-label"> Whether the School/ Institution has devised and made public its Scholarship Policy </label>
                    <div>
                        <?php echo Form::radio('scholarship_policy_public', 'yes', (old('scholarship_policy_public', $convertToYesNo($transparencyData->scholarship_policy_public ?? null)) === 'yes'), ['id' => 'scholarship_policy_public_yes', 'required']); ?>

                        <?php echo Form::label('scholarship_policy_public_yes', 'Yes'); ?>                       
                        <?php echo Form::radio('scholarship_policy_public', 'no', (old('scholarship_policy_public', $convertToYesNo($transparencyData->scholarship_policy_public ?? null)) === 'no'), ['id' => 'scholarship_policy_public_no', 'required']); ?>

                        <?php echo Form::label('scholarship_policy_public_no', 'No'); ?>

                    </div>
                    <?php echo $errors->first('scholarship_policy_public', '<label class="error">:message</label>'); ?>

                </div>
    
                
                <div class="mb-3">
                    <label class="form-label"> Whether the School/ Institution has any other source of income </label>
                    <div>
                        <?php echo Form::radio('other_income_source', 'yes', (old('other_income_source', $convertToYesNo($transparencyData->other_income_source ?? null)) === 'yes'), ['id' => 'other_income_source_yes', 'required']); ?>

                        <?php echo Form::label('other_income_source_yes', 'Yes'); ?>                        
                        <?php echo Form::radio('other_income_source', 'no', (old('other_income_source', $convertToYesNo($transparencyData->other_income_source ?? null)) === 'no'), ['id' => 'other_income_source_no', 'required']); ?>

                        <?php echo Form::label('other_income_source_no', 'No'); ?>

                    </div>
                    <?php echo $errors->first('other_income_source', '<label class="error">:message</label>'); ?>

                </div>
    
                
                <div class="mb-3">
                    <label class="form-label"> Whether the School has maintained a record of its income and expenditure </label>
                    <div>
                        <?php echo Form::radio('record_income_expenditure', 'yes', (old('record_income_expenditure', $convertToYesNo($transparencyData->record_income_expenditure ?? null)) === 'yes'), ['id' => 'record_income_expenditure_yes', 'required']); ?>

                        <?php echo Form::label('record_income_expenditure_yes', 'Yes'); ?>

                        <?php echo Form::radio('record_income_expenditure', 'no', (old('record_income_expenditure', $convertToYesNo($transparencyData->record_income_expenditure ?? null)) === 'no'), ['id' => 'record_income_expenditure_no', 'required']); ?>

                        <?php echo Form::label('record_income_expenditure_no', 'No'); ?>

                    </div>
                    <?php echo $errors->first('record_income_expenditure', '<label class="error">:message</label>'); ?>

                </div>
    
                
                <div class="mb-3">
                    <label class="form-label"> Whether the financial accounts of the School/ Institution are properly audited by a certified auditor </label>
                    <div>
                        <?php echo Form::radio('financial_accounts_audited', 'yes', (old('financial_accounts_audited', $convertToYesNo($transparencyData->financial_accounts_audited ?? null)) === 'yes'), ['id' => 'financial_accounts_audited_yes', 'required']); ?>

                        <?php echo Form::label('financial_accounts_audited_yes', 'Yes'); ?>                     
                        <?php echo Form::radio('financial_accounts_audited', 'no', (old('financial_accounts_audited', $convertToYesNo($transparencyData->financial_accounts_audited ?? null)) === 'no'), ['id' => 'financial_accounts_audited_no', 'required']); ?>

                        <?php echo Form::label('financial_accounts_audited_no', 'No'); ?>

                    </div>
                    <?php echo $errors->first('financial_accounts_audited', '<label class="error">:message</label>'); ?>

                </div>
    
                
                <div class="mb-3">
                    <label class="form-label"> Whether the School/ Institution has formulated and made public its academic calendar on prospectus and website </label>
                    <div>
                        <?php echo Form::radio('academic_calendar_public', 'yes', (old('academic_calendar_public', $convertToYesNo($transparencyData->academic_calendar_public ?? null)) === 'yes'), ['id' => 'academic_calendar_public_yes', 'required']); ?>

                        <?php echo Form::label('academic_calendar_public_yes', 'Yes'); ?>         
                        <?php echo Form::radio('academic_calendar_public', 'no', (old('academic_calendar_public', $convertToYesNo($transparencyData->academic_calendar_public ?? null)) === 'no'), ['id' => 'academic_calendar_public_no', 'required']); ?>

                        <?php echo Form::label('academic_calendar_public_no', 'No'); ?>

                    </div>
                    <?php echo $errors->first('academic_calendar_public', '<label class="error">:message</label>'); ?>

                </div>
            </div>
        </div>
    </div>

    
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOverallstrength">
                <strong>Overall Strength & Extra-Curricular Facilities </strong>
            </button>
        </h2>
        <div id="collapseOverallstrength" class="accordion-collapse collapse" data-bs-parent="#registrationAccordion">
            <div class="accordion-body">
                <h5 class="mt-4">Overall Strength & Extra-Curricular Facilities</h5>
                <div class="form-group">
                    <?php echo Form::label('faculty_to_admin_staff_ratio', 'Faculty to Administrative Staff Ratio'); ?>

                    <?php echo Form::text('faculty_to_admin_staff_ratio', old('transparency.faculty_to_admin_staff_ratio',$transparency?->faculty_to_admin_staff_ratio ?? null), ['class' => 'form-control ' . $errors->first('faculty_to_admin_staff_ratio', 'error'),'required' => true]); ?>

                    <?php echo $errors->first('faculty_to_admin_staff_ratio', '<label class="error">:message</label>'); ?>

                </div>
                
                <div class="form-group">
                    <?php echo Form::label('extra_curricular_activities', 'Extra Curricular Activities Conducted'); ?>

                    <?php echo Form::textarea('extra_curricular_activities', old('transparency.extra_curricular_activities',$transparency?->extra_curricular_activities ?? null), ['class' => 'form-control ' . $errors->first('extra_curricular_activities', 'error'), 'required' => true]); ?>

                    <?php echo $errors->first('extra_curricular_activities', '<label class="error">:message</label>'); ?>

                </div>
                
                <div class="form-group">
                    <?php echo Form::label('extracurricular_facilities', 'Extracurricular Facilities Available'); ?>

                    <?php echo Form::textarea('extracurricular_facilities', old('transparency.extracurricular_facilities',$transparency?->extracurricular_facilities ?? null), ['class' => 'form-control ' . $errors->first('extracurricular_facilities','error'), 'required' =>true ]); ?>

                    <?php echo $errors->first('extracurricular_facilities', '<label class="error">:message</label>'); ?>

                </div>
            </div>
        </div>
    </div>

</div>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('js/jquery.validate.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jquery.mask.js')); ?>"></script>
    <script type="text/javascript">
        $('document').ready(function() {
            $('#formValidation').validate({
                rules: {
                    other_allied_facilities: "required",
                    "library[has_library]": "required",
                    "other_resources[other_instructional_material]": "required",
                    science_laboratories: "required",
                    physic_laboratories: {
                        required: function(element) {
                            return $("input[name='science_laboratories']:checked").val() === 'yes';
                        }
                    },
                    bio_laboratories: {
                        required: function(element) {
                            return $("input[name='science_laboratories']:checked").val() === 'yes';
                        }
                    },
                    chemistry_laboratories: {
                        required: function(element) {
                            return $("input[name='science_laboratories']:checked").val() === 'yes';
                        }
                    },
                    computer_laboratories: "required",
                    fee_structure_public: "required",
                    scholarship_policy_public: "required",
                    other_income_source: "required",
                    record_income_expenditure: "required",
                    financial_accounts_audited: "required",
                    academic_calendar_public: "required"
                },
                messages: {
                    other_allied_facilities: "Select between yes/no is required",
                    "library[has_library]": "Select between yes/no is required",
                    "other_resources[other_instructional_material]": "Select between yes/no is required",
                    science_laboratories: "Select between yes/no is required",
                    physic_laboratories: "Select between yes/no is required",
                    bio_laboratories: "Select between yes/no is required",
                    chemistry_laboratories: "Select between yes/no is required",
                    computer_laboratories: "Select between yes/no is required",
                    fee_structure_public: "Select between yes/no is required",
                    scholarship_policy_public: "Select between yes/no is required",
                    other_income_source: "Select between yes/no is required",
                    record_income_expenditure: "Select between yes/no is required",
                    financial_accounts_audited: "Select between yes/no is required",
                    academic_calendar_public: "Select between yes/no is required"
                },
                errorPlacement: function(error, element) {
                    if (element.is(":radio")) {
                        error.appendTo(element.closest('div'));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
            
            $('#formValidation').validate();
            $('.cnic-mask').mask('00000-0000000-0');
            $('.mobile-mask').mask('0000-0000000');
            $('.ptcl-mask').mask('000-0000000');
            $('.regester-mask').mask('00-000-00000');
        });
        
        //////// Expand form when client side valdition error appear
        document.addEventListener('DOMContentLoaded', function () {
        
            const form = document.getElementById('formValidation');
        
            if (!form) return;
        
            form.addEventListener('submit', function (event) {
        
                // If browser finds invalid fields
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
        
                    const invalidFields = form.querySelectorAll(':invalid');
        
                    // Open each accordion section containing an invalid field
                    invalidFields.forEach(field => {
                        openAccordionSection(field);
                    });
        
                    // Focus and scroll to first invalid field
                    if (invalidFields.length > 0) {
                        const first = invalidFields[0];
                        first.focus({ preventScroll: true });
        
                        first.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                }
        
                form.classList.add('was-validated');
            });
        
                // Function: open accordion section for the field
                function openAccordionSection(field) {
                    const collapse = field.closest('.accordion-collapse');
            
                    if (collapse && !collapse.classList.contains('show')) {
                        collapse.classList.add('show');
            
                        const button = collapse.previousElementSibling
                                            .querySelector('.accordion-button');
            
                        if (button) {
                            button.classList.remove('collapsed');
                            button.setAttribute('aria-expanded', 'true');
                        }
                    }
                }
        });

        // Function to expand accordion section for a given element
        function expandAccordionSection(element) {
            const collapse = element.closest('.accordion-collapse');
            if (collapse) {
                collapse.classList.add('show');
                const button = collapse.previousElementSibling.querySelector('.accordion-button');
                if (button) {
                    button.classList.remove('collapsed');
                    button.setAttribute('aria-expanded', 'true');
                }
            }
        }

        // On page load: Check for server-side errors and expand sections
        window.addEventListener('load', function() {
            const errors = document.querySelectorAll('label.error');
            errors.forEach(error => {
                const collapse = error.closest('.accordion-collapse');
                if (collapse && collapse.id !== 'collapseFaculty') {
                expandAccordionSection(error);
            }
            });
        });
    </script>
    <script>
        ///////////// District & Tehsil & Village dropdown
        document.addEventListener('DOMContentLoaded', function() {
            const districtSelect = document.getElementById('level_2_id');
            const tehsilSelect = document.getElementById('level_3_id');
            const villageSelect = document.getElementById('level_4_id');

            // Get current values for edit mode
            const currentTehsilId = tehsilSelect.value;
            const currentVillageId = villageSelect.value;

            function resetSelect(select, placeholder) {
                select.innerHTML = '';
                const option = document.createElement('option');
                option.value = '';
                option.textContent = placeholder;
                select.appendChild(option);
                select.disabled = true;
            }

            function populateSelect(select, items, placeholder, selectedId = null) {
                resetSelect(select, placeholder);
                if (items && items.length > 0) {
                    items.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.name;
                        select.appendChild(option);
                    });
                    select.disabled = false;
                    if (selectedId) {
                        select.value = selectedId;
                    }
                }
            }

            // Initialize
            resetSelect(tehsilSelect, 'Select Tehsil');
            resetSelect(villageSelect, 'Select Village');

            // If editing and district is selected, load tehsils
            if (districtSelect.value && currentTehsilId) {
                loadTehsils(districtSelect.value, currentTehsilId);
            }

            districtSelect.addEventListener('change', function() {
                const districtId = this.value;
                resetSelect(tehsilSelect, 'Select Tehsil');
                resetSelect(villageSelect, 'Select Village');
                
                if (districtId) {
                    loadTehsils(districtId);
                }
            });

            tehsilSelect.addEventListener('change', function() {
                const tehsilId = this.value;
                resetSelect(villageSelect, 'Select Village');
                
                if (tehsilId) {
                    loadVillages(tehsilId);
                }
            });

            function loadTehsils(districtId, selectedTehsilId = null) {
                fetch(route('api.tehsils', { district_id: districtId }))
                    .then(res => res.json())
                    .then(tehsils => {
                        populateSelect(tehsilSelect, tehsils, 'Select Tehsil', selectedTehsilId);
                        
                        // If we have a selected tehsil and it's valid, load villages
                        if (selectedTehsilId && tehsils.some(t => t.id == selectedTehsilId)) {
                            loadVillages(selectedTehsilId, currentVillageId);
                        }
                    })
                    .catch(console.error);
            }

            function loadVillages(tehsilId, selectedVillageId = null) {
                fetch(route('api.villages', { tehsil_id: tehsilId }))
                    .then(res => res.json())
                    .then(villages => {
                        populateSelect(villageSelect, villages, 'Select Village', selectedVillageId);
                    })
                    .catch(console.error);
            }
        });

        ///////////// Board of directors owner
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('has_board_of_directors');
            const boardContainer = document.getElementById('board-container');
            const boardList = document.getElementById('board-list');
            const addBtn = document.getElementById('add-board-btn');

            function toggleBoardContainer() {
                if (checkbox.checked) {
                    boardContainer.style.display = 'block';
                    boardList.querySelectorAll('input[name$="[name]"]').forEach(input => {
                        input.required = true;
                    });
                } else {
                    boardContainer.style.display = 'none';
                    boardList.querySelectorAll('input[name$="[name]"]').forEach(input => {
                        input.required = false;
                    });
                }
            }
            toggleBoardContainer();

            checkbox.addEventListener('change', () => {
                toggleBoardContainer();
            });

            addBtn.addEventListener('click', () => {
                let index = boardList.children.length;
                const div = document.createElement('div');
                div.classList.add('board-member', 'd-flex', 'align-items-center', 'mb-2');
                div.dataset.index = index;

                div.innerHTML = `
                    <input type="text" name="board_of_directors[${index}][name]" placeholder="Name" class="form-control me-2" style="flex: 1;" required maxlength="64">
                    <input type="text" name="board_of_directors[${index}][designation]" placeholder="Designation" class="form-control me-2" style="flex: 1;" maxlength="64">
                    <button type="button" class="btn btn-danger btn-sm remove-board-member">Remove</button>`;

                boardList.appendChild(div);
            });

            boardList.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-board-member')) {
                    e.target.closest('.board-member').remove();
                }
            });
        });

        ///////////// Faculty info
        document.addEventListener('DOMContentLoaded', () => {

            const facultyList = document.getElementById('faculty-list');
            const addBtn = document.getElementById('add-faculty-btn');

            const qualificationOptions = `
                <option value="" disabled selected>Qualification</option>
                <option>Graduation (BSc/ BA)</option>
                <option>Graduation (BS 4 Years)</option>
                <option>Post-Graduation (MA/ MSc etc.)</option>
                <option>MS/ M.Phil</option>
                <option>PhD</option>`;

            // Create new row (removable)
            const createFacultyMember = (index) => {
                const div = document.createElement('div');
                div.className = 'faculty-member d-flex align-items-center mb-2';
                div.dataset.index = index;

                div.innerHTML = `
                    <div class="d-flex flex-column me-2" style="flex: 2;">
                        <input type="text" name="faculty[${index}][name]" class="form-control" placeholder="Name" maxlength="64" required>
                        <label class="error mt-1" data-error-for="faculty[${index}][name]"></label>
                    </div>
                    <div class="d-flex flex-column me-2" style="flex: 1.5;">
                        <input type="text" name="faculty[${index}][cnic]" class="form-control cnic-mask" placeholder="CNIC" required>
                        <label class="error mt-1" data-error-for="faculty[${index}][cnic]"></label>
                    </div>
                    <div class="d-flex flex-column me-2" style="flex: 2;">
                        <select name="faculty[${index}][qualification]" class="form-control" required>
                            ${qualificationOptions}
                        </select>
                        <label class="error mt-1" data-error-for="faculty[${index}][qualification]"></label>
                    </div>
                    <div class="d-flex flex-column me-2" style="flex: 2;">
                        <input type="file" name="faculty[${index}][cv]" class="form-control" accept=".pdf,.doc,.docx" required>
                        <label class="error mt-1" data-error-for="faculty[${index}][cv]"></label>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm remove-faculty-member">Remove</button>`;

                return div;
            };

            // Update indexes of all dynamic rows (starting from 1)
            const updateIndices = () => {
                const rows = [...facultyList.children];
                rows.forEach((row, i) => {
                    if (i === 0) return; // skip first (non-removable row)

                    row.dataset.index = i;

                    row.querySelectorAll('input, select').forEach(input => {
                        input.name = input.name.replace(/faculty\[\d+]/, `faculty[${i}]`);
                    });

                    row.querySelectorAll('label.error').forEach(label => {
                        const errFor = label.getAttribute('data-error-for');
                        label.setAttribute('data-error-for', errFor.replace(/faculty\[\d+]/, `faculty[${i}]`));
                    });
                });
            };

            addBtn.onclick = () => {
                const newIndex = facultyList.children.length;
                const newRow = createFacultyMember(newIndex);
                facultyList.appendChild(newRow);

                // Reapply CNIC mask for newly added row if you use a mask plugin
                if (typeof $('.cnic-mask').mask === 'function') {
                    $('.cnic-mask').mask('00000-0000000-0');
                }
            };

            facultyList.onclick = e => {
                if (e.target.classList.contains('remove-faculty-member')) {
                    e.target.closest('.faculty-member').remove();
                    updateIndices();
                }
            };

            // Laravel validation errors injection (same as before)
            const errors = <?php echo json_encode($errors->toArray(), 15, 512) ?>;

            const dotToBracket = str =>
                str.replace(/\.(\d+)\./g, '[$1][')
                .replace(/\.(\d+)$/g, '[$1]')
                .replace(/\./g, '[') + ']';

            Object.entries(errors).forEach(([field, msgs]) => {
                const label = document.querySelector(`label[data-error-for="${dotToBracket(field)}"]`);
                if (label) label.textContent = msgs[0];
            });
        });

        ///////////// Faculty count
        document.addEventListener('DOMContentLoaded', function() {
            const maleInput = document.getElementById('male_faculty');
            const femaleInput = document.getElementById('female_faculty');
            const totalInput = document.getElementById('total_faculty');

            function calculateTotal() {
                const male = parseInt(maleInput.value) || 0;
                const female = parseInt(femaleInput.value) || 0;
                totalInput.value = male + female;
            }

            maleInput.addEventListener('input', calculateTotal);
            femaleInput.addEventListener('input', calculateTotal);
            // Initialize total on page load
            calculateTotal();
        });

        ///////////// Student Enrollment 
        document.addEventListener('DOMContentLoaded', function() {
            const maleFaculty = document.getElementById('male_faculty');
            const femaleFaculty = document.getElementById('female_faculty');
            const totalFaculty = document.getElementById('total_faculty');

            const maleStudents = document.getElementById('male_students');
            const femaleStudents = document.getElementById('female_students');
            const totalStudents = document.getElementById('total_students');

            const strInput = document.getElementById('institution_str');

            function calculateFacultyTotal() {
                const male = parseInt(maleFaculty.value) || 0;
                const female = parseInt(femaleFaculty.value) || 0;
                totalFaculty.value = male + female;
                calculateSTR();
            }

            function calculateStudentTotal() {
                const male = parseInt(maleStudents.value) || 0;
                const female = parseInt(femaleStudents.value) || 0;
                totalStudents.value = male + female;
                calculateSTR();
            }

            function calculateSTR() {
                const totalStud = parseInt(totalStudents.value) || 0;
                const totalTeach = parseInt(totalFaculty.value) || 0;
                strInput.value = totalTeach > 0 ? (totalStud / totalTeach).toFixed(2) : '';
            }

            maleFaculty.addEventListener('input', calculateFacultyTotal);
            femaleFaculty.addEventListener('input', calculateFacultyTotal);
            maleStudents.addEventListener('input', calculateStudentTotal);
            femaleStudents.addEventListener('input', calculateStudentTotal);

            calculateFacultyTotal();
            calculateStudentTotal();
        });

        ///////////// For other allied facilities
        document.addEventListener('DOMContentLoaded', function () {
            function el(id) { return document.getElementById(id); }

            var alliedFacilitiesOptions = el('alliedFacilitiesOptions');
            var otherFacilitiesText = el('otherFacilitiesText');

            // Show/hide options based on radio selection
            document.querySelectorAll('input[name="other_allied_facilities"]').forEach(function(radio) {
                radio.addEventListener('change', function() {
                    if (this.value === 'Yes') {
                        alliedFacilitiesOptions.style.display = 'block';
                    } else {
                        alliedFacilitiesOptions.style.display = 'none';

                        // Uncheck all checkboxes
                        alliedFacilitiesOptions.querySelectorAll('input[type="checkbox"]').forEach(function(chk) {
                            chk.checked = false;
                        });

                        // Clear text input
                        var otherInput = document.querySelector('input[name="facilities[other_facilities]"]');
                        if (otherInput) otherInput.value = '';

                        if (otherFacilitiesText) otherFacilitiesText.style.display = 'none';
                    }
                });
            });

            // Show/hide other facilities text input based on "Others" checkbox
            el('has_other')?.addEventListener('change', function() {
                if (this.checked) {
                    otherFacilitiesText.style.display = 'block';
                } else {
                    otherFacilitiesText.style.display = 'none';
                    var otherInput = document.querySelector('input[name="facilities[other_facilities]"]');
                    if (otherInput) otherInput.value = '';
                }
            });
        });

        ///////////// Library
        document.addEventListener('DOMContentLoaded', function() {
            const yesRadio = document.getElementById('library_yes');
            const noRadio = document.getElementById('library_no');
            const detailsDiv = document.getElementById('library_details');

            // Function to check current radio state and stored data
            function getLibraryState() {
                return {
                    hasLibrary: yesRadio.checked || (<?php echo e($facilityData->has_library ?? 0); ?> == 1 && !noRadio.checked)
                };
            }

            function toggleLibraryDetails() {
                const currentState = getLibraryState();
                
                if (currentState.hasLibrary) {
                    detailsDiv.style.display = 'flex';
                } else {
                    detailsDiv.style.display = 'none';
                    // Only clear inputs if they don't have stored data
                    if (!<?php echo e($facilityData->has_library ?? 0); ?>) {
                        detailsDiv.querySelectorAll('input').forEach(input => input.value = '');
                    }
                }
            }

            // Initialize based on current data
            function initializeLibrarySection() {
                const storedHasLibrary = <?php echo e($facilityData->has_library ?? 0); ?>;
                
                if (storedHasLibrary == 1) {
                    detailsDiv.style.display = 'block';
                } else {
                    detailsDiv.style.display = 'none';
                }
            }

            yesRadio.addEventListener('change', toggleLibraryDetails);
            noRadio.addEventListener('change', toggleLibraryDetails);

            // Initialize on page load
            initializeLibrarySection();
            toggleLibraryDetails();
        });

        ///////////// Other Resource Material
        document.addEventListener('DOMContentLoaded', function() {
            const yesRadio = document.getElementById('other_resources_yes');
            const noRadio = document.getElementById('other_resources_no');
            const optionsDiv = document.getElementById('other_resources_options');

            // Function to check current radio state and stored data
            function getResourcesState() {
                return {
                    hasResources: yesRadio.checked || (<?php echo e($facilityData->other_instructional_material ?? 0); ?> == 1 && !noRadio.checked)
                };
            }

            function toggleOtherResources() {
                const currentState = getResourcesState();
                
                if (currentState.hasResources) {
                    optionsDiv.style.display = 'block';
                } else {
                    optionsDiv.style.display = 'none';
                    // Only clear checkboxes if they don't have stored data
                    if (!<?php echo e($facilityData->other_instructional_material ?? 0); ?>) {
                        optionsDiv.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
                    }
                }
            }

            // Initialize based on current data
            function initializeResourcesSection() {
                const storedHasResources = <?php echo e($facilityData->other_instructional_material ?? 0); ?>;
                
                if (storedHasResources == 1) {
                    optionsDiv.style.display = 'block';
                } else {
                    optionsDiv.style.display = 'none';
                }
            }

            yesRadio.addEventListener('change', toggleOtherResources);
            noRadio.addEventListener('change', toggleOtherResources);

            // Initialize on page load
            initializeResourcesSection();
            toggleOtherResources();
        });

        ///////////// Laboratories
        document.addEventListener('DOMContentLoaded', function() {
            // Function to check if a radio button is checked
            function isRadioChecked(radioName) {
                const radios = document.querySelectorAll(`input[name="${radioName}"]`);
                return Array.from(radios).some(radio => radio.checked && radio.value === 'yes');
            }

            // Function to get stored data from database (for edit mode)
            function getStoredData() {
                return {
                    science_laboratories: isRadioChecked('science_laboratories'),
                    physic_laboratories: isRadioChecked('physic_laboratories'),
                    bio_laboratories: isRadioChecked('bio_laboratories'),
                    chemistry_laboratories: isRadioChecked('chemistry_laboratories'),
                    computer_laboratories: isRadioChecked('computer_laboratories')
                };
            }

            // Toggle science laboratories section
            function toggleScienceLabs() {
                const scienceYes = document.getElementById('science_yes');
                const scienceDetails = document.getElementById('science_details');
                const storedData = getStoredData();
                
                // Show science details if yes is checked OR if we have stored data with yes
                if (scienceYes.checked || storedData.science_laboratories) {
                    scienceDetails.style.display = 'block';
                } else {
                    scienceDetails.style.display = 'none';
                    // Reset all science lab sections
                    resetScienceLabSections();
                }
            }

            // Reset all science lab sections when science lab is set to no
            function resetScienceLabSections() {
                const sections = ['physics_details', 'bio_details', 'chemistry_details'];
                sections.forEach(sectionId => {
                    const section = document.getElementById(sectionId);
                    if (section) {
                        section.style.display = 'none';
                    }
                });

                // Uncheck all science lab radios
                const scienceLabRadios = document.querySelectorAll('.physics-lab-radio, .bio-lab-radio, .chemistry-lab-radio');
                scienceLabRadios.forEach(radio => {
                    if (!radio.checked) radio.checked = false;
                });

                // Clear all science lab inputs only if they're not from stored data
                const storedData = getStoredData();
                if (!storedData.physic_laboratories) {
                    const physicsInput = document.querySelector('.physics-staff-input');
                    if (physicsInput && !physicsInput.value) physicsInput.value = '';
                }
                if (!storedData.bio_laboratories) {
                    const bioInput = document.querySelector('.bio-staff-input');
                    if (bioInput && !bioInput.value) bioInput.value = '';
                }
                if (!storedData.chemistry_laboratories) {
                    const chemistryInput = document.querySelector('.chemistry-staff-input');
                    if (chemistryInput && !chemistryInput.value) chemistryInput.value = '';
                }
            }

            // Toggle individual lab sections
            function toggleLabSection(labYesId, labNoId, detailsId, staffInputClass) {
                const labYes = document.getElementById(labYesId);
                const labNo = document.getElementById(labNoId);
                const details = document.getElementById(detailsId);
                const staffInput = document.querySelector(`.${staffInputClass}`);
                const storedData = getStoredData();

                function updateSection() {
                    const shouldShow = labYes.checked || 
                        (storedData[labYes.name] && !labNo.checked); // Show if stored data says yes and no is not explicitly checked
                    
                    if (shouldShow) {
                        details.style.display = 'block';
                        if (staffInput) {
                            staffInput.setAttribute('required', 'required');
                        }
                    } else {
                        details.style.display = 'none';
                        if (staffInput) {
                            staffInput.removeAttribute('required');
                            // Only clear value if it's not from stored data
                            if (!storedData[labYes.name]) {
                                staffInput.value = '';
                            }
                        }
                    }
                }

                if (labYes) labYes.addEventListener('change', updateSection);
                if (labNo) labNo.addEventListener('change', updateSection);
                updateSection(); // Initialize
            }

            // Toggle computer lab section
            function toggleComputerLab() {
                const computerYes = document.getElementById('computer_yes');
                const computerNo = document.getElementById('computer_no');
                const computerDetails = document.getElementById('computer_details');
                const computerCountInput = document.querySelector('.computer-count-input');
                const storedData = getStoredData();

                function updateComputerSection() {
                    const shouldShow = computerYes.checked || 
                        (storedData.computer_laboratories && !computerNo.checked);
                        
                    if (shouldShow) {
                        computerDetails.style.display = 'block';
                        if (computerCountInput) {
                            computerCountInput.setAttribute('required', 'required');
                        }
                    } else {
                        computerDetails.style.display = 'none';
                        if (computerCountInput) {
                            computerCountInput.removeAttribute('required');
                            // Only clear value if it's not from stored data
                            if (!storedData.computer_laboratories) {
                                computerCountInput.value = '';
                            }
                        }
                    }
                }

                if (computerYes) computerYes.addEventListener('change', updateComputerSection);
                if (computerNo) computerNo.addEventListener('change', updateComputerSection);
                updateComputerSection(); // Initialize
            }

            // Initialize all sections based on current data (for edit mode)
            function initializeSections() {
                const storedData = getStoredData();
                
                // Initialize science labs
                toggleScienceLabs();
                
                // Initialize individual labs
                if (storedData.physic_laboratories) {
                    document.getElementById('physics_details').style.display = 'block';
                    const physicsInput = document.querySelector('.physics-staff-input');
                    if (physicsInput) physicsInput.setAttribute('required', 'required');
                }
                
                if (storedData.bio_laboratories) {
                    document.getElementById('bio_details').style.display = 'block';
                    const bioInput = document.querySelector('.bio-staff-input');
                    if (bioInput) bioInput.setAttribute('required', 'required');
                }
                
                if (storedData.chemistry_laboratories) {
                    document.getElementById('chemistry_details').style.display = 'block';
                    const chemistryInput = document.querySelector('.chemistry-staff-input');
                    if (chemistryInput) chemistryInput.setAttribute('required', 'required');
                }
                
                if (storedData.computer_laboratories) {
                    document.getElementById('computer_details').style.display = 'block';
                    const computerInput = document.querySelector('.computer-count-input');
                    if (computerInput) computerInput.setAttribute('required', 'required');
                }
            }

            // Initialize all event listeners
            function initializeLabToggles() {
                // Science lab toggle
                const scienceRadios = document.querySelectorAll('.science-lab-radio');
                scienceRadios.forEach(radio => {
                    radio.addEventListener('change', toggleScienceLabs);
                });

                // Individual lab toggles
                toggleLabSection('physics_yes', 'physics_no', 'physics_details', 'physics-staff-input');
                toggleLabSection('bio_yes', 'bio_no', 'bio_details', 'bio-staff-input');
                toggleLabSection('chemistry_yes', 'chemistry_no', 'chemistry_details', 'chemistry-staff-input');
                
                // Computer lab toggle
                toggleComputerLab();

                // Initialize sections based on current data
                initializeSections();
            }

            // Run initialization after a short delay to ensure DOM is fully loaded
            setTimeout(initializeLabToggles, 100);
        });

        ///////////// Radio unchecked
        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('click', function(e) {
                if (this.wasChecked) {
                    this.checked = false;
                }
                // Save the current checked state
                this.wasChecked = this.checked;
            });
        });
        
    </script>
<?php $__env->stopPush(); ?><?php /**PATH C:\xampp\htdocs\pepris-gb-web\resources\views/institutions/form.blade.php ENDPATH**/ ?>