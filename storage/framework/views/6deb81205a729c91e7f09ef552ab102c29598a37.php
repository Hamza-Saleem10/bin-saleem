<div class="row g-3">
    
    <div class="form-group col-md-3">
        <?php echo Form::label('fee_type', 'Fee Type', ['class' => 'form-label required-input']); ?>

        <?php echo Form::select('fee_type', $feeTypes, null, ['class' => 'form-control ' . $errors->first('fee_type', 'error'),'placeholder' => 'Select Fee Type','required']); ?>

        <?php echo $errors->first('fee_type', '<label class="error">:message</label>'); ?>

    </div>

    
    <div class="form-group col-md-3">
        <?php echo Form::label('payment_method', 'Payment Method', ['class' => 'form-label required-input']); ?>

        <?php echo Form::select('payment_method', $paymentMethods, null, ['class' => 'form-control ' . $errors->first('payment_method', 'error'),'placeholder' => 'Select Payment Method','required']); ?>

        <?php echo $errors->first('payment_method', '<label class="error">:message</label>'); ?>

    </div>

    
    <div class="form-group col-md-3">
        <?php echo Form::label('primary_fee', 'Primary School Fee', ['class' => 'form-label required-input']); ?>

        <?php echo Form::number('primary_fee', null, ['class' => 'form-control ' . $errors->first('primary_fee', 'error'),'min' => 0,'step' => '0.01','required']); ?>

        <?php echo $errors->first('primary_fee', '<label class="error">:message</label>'); ?>

    </div>

    
    <div class="form-group col-md-3">
        <?php echo Form::label('middle_fee', 'Middle School Fee', ['class' => 'form-label required-input']); ?>

        <?php echo Form::number('middle_fee', null, ['class' => 'form-control ' . $errors->first('middle_fee', 'error'),'min' => 0,'step' => '0.01','required']); ?>

        <?php echo $errors->first('middle_fee', '<label class="error">:message</label>'); ?>

    </div>

    
    <div class="form-group col-md-3">
        <?php echo Form::label('high_fee', 'High School Fee', ['class' => 'form-label required-input']); ?>

        <?php echo Form::number('high_fee', null, ['class' => 'form-control ' . $errors->first('high_fee', 'error'),'min' => 0,'step' => '0.01','required']); ?>

        <?php echo $errors->first('high_fee', '<label class="error">:message</label>'); ?>

    </div>

    
    <div class="form-group col-md-3">
        <?php echo Form::label('payment_deadline_days', 'Payment Deadline<small class="text-muted tiny-text">(Days allowed for payment)</small>', ['class' => 'form-label required-input'],false); ?>

        <?php echo Form::number('payment_deadline_days',  null, ['class' => 'form-control ' . $errors->first('payment_deadline_days', 'error'),'min' => 1,'max' => 365,'required']); ?>

        <?php echo $errors->first('payment_deadline_days', '<label class="error">:message</label>'); ?>

    </div>
    
    <div class="form-group col-md-3">
        <?php echo Form::label('academic_year_start', 'Academic Year Start', ['class' => 'form-label required-input']); ?>

        <?php echo Form::text('academic_year_start', null, ['class' => 'form-control monthpicker' . $errors->first('academic_year_start', 'error'),'maxlength' => 15,'required', 'readonly']); ?>

        <?php echo $errors->first('academic_year_start', '<label class="error">:message</label>'); ?>

    </div>
    
    <div class="form-group col-md-3">
        <?php echo Form::label('academic_year_end', 'Academic Year End', ['class' => 'form-label required-input']); ?>

        <?php echo Form::text('academic_year_end', null, ['class' => 'form-control monthpicker' . $errors->first('academic_year_end', 'error'),'required','maxlength' => 15, 'readonly']); ?>

        <?php echo $errors->first('academic_year_end', '<label class="error">:message</label>'); ?>

    </div>
    
    <div class="form-group col-md-12">
        <?php echo Form::label('description', 'Description', ['class' => 'form-label']); ?>

        <?php echo Form::textarea('description', null, ['class' => 'form-control ' . $errors->first('description', 'error'),'rows' => 3,'placeholder' => 'Description explaining the fee type...']); ?>

        <?php echo $errors->first('description', '<label class="error">:message</label>'); ?>

    </div>
</div>
<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/jquery.validate.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/jquery.mask.js')); ?>"></script>
<script type="text/javascript">
    $('document').ready(function () {
        $('#formValidation').validate();
        $('#academic_year_start , #academic_year_end').monthpicker({dateFormat: "MM yy"});
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH C:\xampp\htdocs\pepris-gb-web\resources\views/feestructures/form.blade.php ENDPATH**/ ?>