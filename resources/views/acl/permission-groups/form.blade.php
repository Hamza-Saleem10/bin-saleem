<div class="form-group col-md-6">
    {!! Form::label('name', 'Name', ['class' => 'form-label required-input']) !!}
    {!! Form::text('name', null, ['class' => 'form-control ' . $errors->first('name', 'error'), 'placeholder' => 'Name', 'maxlength' => '50']) !!}
    {!! $errors->first('name', '<label class="error">:message</label>') !!}
</div>