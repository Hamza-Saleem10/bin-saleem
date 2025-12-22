<div class="form-group col-md-6">
    <?php echo Form::label('permission_group_id', 'Permission Group', ['class' => 'form-label required-input']); ?>

    <?php echo Form::select('permission_group_id', $groups, null, ['class' => 'form-control ' . $errors->first('permission_group_id', 'error'), 'placeholder' => 'Permission Group']); ?>

    <?php echo $errors->first('permission_group_id', '<label class="error">:message</label>'); ?>

</div>
<div class="form-group col-md-6">
    <?php echo Form::label('name', 'Name', ['class' => 'form-label required-input']); ?>

    <?php echo Form::text('name', null, ['class' => 'form-control ' . $errors->first('name', 'error'), 'placeholder' => 'Name', 'maxlength' => '50']); ?>

    <?php echo $errors->first('name', '<label class="error">:message</label>'); ?>

</div><?php /**PATH C:\xampp\htdocs\pepris-gb-web\resources\views/acl/permissions/form.blade.php ENDPATH**/ ?>