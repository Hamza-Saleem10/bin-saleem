<div class="form-group col-md-4">
    {!! Form::label('name', 'Name', ['class' => 'form-label required-input']) !!}
    {!! Form::text('name', null, ['class' => 'form-control ' . $errors->first('name', 'error'), 'placeholder' => 'Name', 'maxlength' => '50', 'required']) !!}
    {!! $errors->first('name', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-4">
    {!! Form::label('username', 'Username', ['class' => 'form-label required-input']) !!}
    {!! Form::text('username', null, ['class' => 'form-control ' . $errors->first('username', 'error'), 'placeholder' => 'Username', 'maxlength' => '50', 'required']) !!}
    {!! $errors->first('username', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-4">
    {!! Form::label('email', 'Email', ['class' => 'form-label required-input']) !!}
    {!! Form::email('email', null, ['class' => 'form-control ' . $errors->first('email', 'error'), 'placeholder' => 'Email', 'maxlength' => '150', 'required']) !!}
    {!! $errors->first('email', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-4">
    {!! Form::label('mobile', 'Mobile', ['class' => 'form-label required-input']) !!}
    {!! Form::text('mobile', @$user->mobile, ['class' => 'form-control mobile-mask ' . $errors->first('mobile', 'error'), 'placeholder' => '03xx-xxxxxxx', 'maxlength' => '15', 'required']) !!}
    {!! $errors->first('mobile', '<label class="error">:message</label>') !!}
</div>
@if(@$user)
@else
<div class="form-group col-md-4">
    {!! Form::label('password', 'Password', ['class' => 'form-label required-input']) !!}
    {!! Form::password('password', ['class' => 'form-control ' . $errors->first('password', 'error'), 'placeholder' => 'Password', 'required']) !!}
    {!! $errors->first('password', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-4">
    {!! Form::label('password_confirmation', 'Confirm Password', ['class' => 'form-label required-input']) !!}
    {!! Form::password('password_confirmation', ['class' => 'form-control ' . $errors->first('password_confirmation', 'error'), 'placeholder' => 'Confirm Password', 'required']) !!}
    {!! $errors->first('password_confirmation', '<label class="error">:message</label>') !!}
</div>
@endif
<div class="form-group col-md-4">
    {!! Form::label('role', 'Role', ['class' => 'form-label required-input']) !!}
    {!! Form::select('role', $roles, null, ['class' => 'form-control ' . $errors->first('role', 'error'), 'placeholder' => 'Select Role', 'required']) !!}
    {!! $errors->first('role', '<label class="error">:message</label>') !!}
</div>

<div class="form-group col-md-4 division d-none">
    {!! Form::label('level_1_id', 'Division', ['class' => 'form-label required-input']) !!}
    {!! Form::select('level_1_id', $divisions, null, ['class' => 'form-select select2 ' . $errors->first('level_1_id', 'error'),  'placeholder' => 'Select Division']) !!}
    {!! $errors->first('level_1_id', '<label class="error">:message</label>') !!}
</div>

<div class="form-group col-md-4 district d-none">
    {!! Form::label('level_2_id', 'District', ['class' => 'form-label required-input']) !!}
    {!! Form::select('level_2_id', $districts, null, ['class' => 'form-select select2 ' . $errors->first('level_2_id', 'error'),  'placeholder' => 'Select District']) !!}
    {!! $errors->first('level_2_id', '<label class="error">:message</label>') !!}
</div>

<div class="form-group col-md-4 tehsil d-none">
    {!! Form::label('level_3_id', 'Tehsil', ['class' => 'form-label required-input']) !!}
    {!! Form::select('level_3_id', ['' => 'Select Tehsil'], null, [
        'class' => 'form-select select2 ' . $errors->first('level_3_id', 'error'), 
        'data-selectedid' => @$user->level_3_id,
        'data-url' => route('tehsils.getDropDownOptions')
    ]) !!}
    {!! $errors->first('level_3_id', '<label class="error">:message</label>') !!}
</div>


@push('scripts')    
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/jquery.mask.js') }}"></script>
    <script type="text/javascript">
        $('document').ready(function () {
            $('#formValidation').validate();
            $('.cnic-mask').mask('00000-0000000-0');
            $('.mobile-mask').mask('0000-0000000');

            $('select[name=role]').on('change', function() {
                const role = $(this).find('option:selected').text();
                if(role == 'DEO'){
                    $('.district, .tehsil').removeClass('d-none');
                    $('select[name=level_2_id], select[name=level_3_id]').attr('required', true);

                    $('.division').addClass('d-none');
                    $('select[name=level_1_id]').attr('required', false).val('').change();
                }else if(role == 'DED'){
                    $('.division').removeClass('d-none');
                    $('select[name=level_1_id]').attr('required', true);

                    $('.district, .tehsil').addClass('d-none');
                    $('select[name=level_2_id], select[name=level_3_id]').attr('required', false).val('').change();
                }else{
                    $('.district, .tehsil, .division').addClass('d-none');
                    $('select[name=level_2_id], select[name=level_3_id], select[name=level_1_id]').attr('required', false).val('').change();
                }
            });

            $('select[name=level_2_id]').on('change', function() {
                $('select[name=level_3_id]').attr('data-otheridvalue', $(this).val());
                loadDropdown('select[name=level_3_id]', true);
            });

            @if (@$user || $errors->any())
                $('select[name=role]').change();
                $('select[name=level_2_id]').change();
            @endif
        });
    </script>
    @endpush