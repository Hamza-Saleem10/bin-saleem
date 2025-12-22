
<div class="accordion" id="inspectorsAccordion">

    
    <div class="accordion-item">

        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBasicInfo">
                <strong>Basic Inspector Information</strong>
            </button>
        </h2>

        <div id="collapseBasicInfo" class="accordion-collapse collapse show" data-bs-parent="#inspectorsAccordion">
            <div class="accordion-body">
                <div class="row g-3">

                    
                    <div class="form-group col-md-4">
                        <?php echo Form::label('name', 'Name', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::text('name', null, ['class' => 'form-control ' . $errors->first('name', 'error'),'placeholder' => 'Name','maxlength' => '191','required']); ?>

                        <?php echo $errors->first('name', '<label class="error">:message</label>'); ?>

                    </div>

                    
                    <div class="form-group col-md-4">
                        <?php echo Form::label('cnic', 'CNIC', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::text('cnic', null, ['class' => 'form-control cnic-mask ' . $errors->first('cnic', 'error'),'placeholder' => '00000-0000000-0','maxlength' => '15','required']); ?>

                        <?php echo $errors->first('cnic', '<label class="error">:message</label>'); ?>

                    </div>

                    
                    <div class="form-group col-md-4">
                        <?php echo Form::label('level_3_id', 'Tehsil', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::select('level_3_id',['' => 'Select Tehsil'] + ($tehsils->toArray() ?? []),null,['class' => 'form-control ' . ($errors->has('level_3_id') ? 'error' : ''),'required']); ?>

                        <?php echo $errors->first('level_3_id', '<label class="error">:message</label>'); ?>

                    </div>

                    
                    <div class="form-group col-md-4">
                        <?php echo Form::label('institution_level', 'School Level', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::select('institution_level',['' => 'Select', 'Primary' => 'Primary', 'Elementary' => 'Elementary', 'High' => 'High'],null,['class' => 'form-control ' . $errors->first('institution_level', 'error'),'required']); ?>

                        <?php echo $errors->first('institution_level', '<label class="error">:message</label>'); ?>

                    </div>

                    
                    <div class="form-group col-md-4">
                        <?php echo Form::label('institution_id', 'School Name', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::select('institution_id',['' => 'Select Tehsil and School Level First'],null,['class' => 'form-control ' . $errors->first('institution_id', 'error'),'required','disabled' => true]); ?>

                        <?php echo $errors->first('institution_id', '<label class="error">:message</label>'); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<?php
    $institutionsArray = [];
    foreach ($institutions as $inst) {
        $institutionsArray[] = [
            'id' => $inst->id,
            'name' => $inst->name,
            'level_3_id' => $inst->level_3_id,
            'institution_level' => $inst->institution_level
        ];
    }
?>


<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/jquery.validate.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/jquery.mask.js')); ?>"></script>

<script>
    var institutionsData = <?php echo json_encode($institutionsArray, 15, 512) ?>;

    $(document).ready(function () {

        $('#formValidation').validate();

        $('.cnic-mask').mask('00000-0000000-0');

        // ============================================================
        // FILTER SCHOOL BY TEHSIL + SCHOOL LEVEL
        // ============================================================
        function updateInstitutions() {
            let tehsilId = $('#level_3_id').val();
            let level = $('#institution_level').val();
            let selectedId = "<?php echo e(old('institution_id', $inspector->institution_id ?? '')); ?>";

            let $dropdown = $('#institution_id');
            $dropdown.html('<option value="">Select School</option>').prop('disabled', true);

            if (!tehsilId || !level) return;

            // Filter institutions where both match
            let filtered = institutionsData.filter(function(item) {
                return item.level_3_id == tehsilId && item.institution_level == level;
            });

            if (filtered.length === 0) {
                $dropdown.html('<option value="">No School Found</option>').prop('disabled', true);
                return;
            }

            $.each(filtered, function (i, inst) {
                $dropdown.append(
                    '<option value="' + inst.id + '">' + inst.name + '</option>'
                );
            });

            $dropdown.prop('disabled', false);

            if (selectedId) {
                $dropdown.val(selectedId);
            }
        }
        // Trigger on both field changes
        $('#level_3_id, #institution_level').on('change', updateInstitutions);

        // Initialize edit mode
        updateInstitutions();
    });
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\pepris-gb-web\resources\views/inspectors/form.blade.php ENDPATH**/ ?>