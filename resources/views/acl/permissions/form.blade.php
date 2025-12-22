<div class="form-group col-md-6">
    {!! Form::label('permission_group_id', 'Permission Group', ['class' => 'form-label required-input']) !!}
    {!! Form::select('permission_group_id', $groups, null, ['class' => 'form-control ' . $errors->first('permission_group_id', 'error'), 'placeholder' => 'Permission Group']) !!}
    {!! $errors->first('permission_group_id', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('name', 'Name', ['class' => 'form-label required-input']) !!}
    {!! Form::text('name', null, ['class' => 'form-control ' . $errors->first('name', 'error'), 'placeholder' => 'Name', 'maxlength' => '50']) !!}
    {!! $errors->first('name', '<label class="error">:message</label>') !!}
</div>