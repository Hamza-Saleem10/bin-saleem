
<div class="accordion" id="reviewsAccordion">

    
    <div class="accordion-item">

        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBasicInfo">
                <strong>Basic Reviews Information</strong>
            </button>
        </h2>

        <div id="collapseBasicInfo" class="accordion-collapse collapse show" data-bs-parent="#reviewsAccordion">
            <div class="accordion-body">
                <div class="row g-3">
                    
                    <div class="form-group col-md-6">
                        <?php echo Form::label('author', 'Author Name', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::text('author', null, ['class' => 'form-control ' . $errors->first('author', 'error'), 'placeholder' => '', 'required']); ?>

                        <?php echo $errors->first('author', '<label class="error">:message</label>'); ?>

                    </div>

                    
                    <div class="form-group col-md-6">
                        <?php echo Form::label('location', 'Location', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::text('location', null, ['class' => 'form-control ' . $errors->first('location', 'error'), 'placeholder' => 'e.g., Jeddah, Saudi Arabia', 'required']); ?>

                        <?php echo $errors->first('location', '<label class="error">:message</label>'); ?>

                    </div>

                    
                    <div class="form-group col-md-6">
                        <?php echo Form::label('rating', 'Rating', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::select('rating', [
                            '' => '-- Select Rating --',
                            5 => '5 Stars - Excellent',
                            4 => '4 Stars - Very Good',
                            3 => '3 Stars - Good',
                            2 => '2 Stars - Fair',
                            1 => '1 Star - Poor',
                        ], null, ['class' => 'form-control ' . $errors->first('rating', 'error'), 'required']); ?>

                        <?php echo $errors->first('rating', '<label class="error">:message</label>'); ?>

                    </div>

                    
                    <div class="form-group col-md-6">
                        <?php echo Form::label('booking_reference', 'Booking Reference (Optional)', ['class' => 'form-label']); ?>

                        <?php echo Form::text('booking_reference', null, ['class' => 'form-control ' . $errors->first('booking_reference', 'error'), 'placeholder' => 'e.g., BSL-2025-0481']); ?>

                        <?php echo $errors->first('booking_reference', '<label class="error">:message</label>'); ?>

                    </div>
                    
                    <div class="form-group col-md-12">
                        <?php echo Form::label('comment', 'Comment', ['class' => 'form-label required-input']); ?>

                        <?php echo Form::textarea('comment', null, ['class' => 'form-control ' . $errors->first('comment', 'error'), 'rows' => '5', 'required']); ?>

                        <?php echo $errors->first('comment', '<label class="error">:message</label>'); ?>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/jquery.validate.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/jquery.mask.js')); ?>"></script>

<script>
$(document).ready(function () {
    // Initialize form validation
    $('#formValidation').validate();
    $('.cnic-mask').mask('00000-0000000-0');
});
</script>
<?php $__env->stopPush(); ?><?php /**PATH D:\binslaeem\resources\views/reviews/form.blade.php ENDPATH**/ ?>