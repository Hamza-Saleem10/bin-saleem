<x-guest-layout>

    <div class="container-fluid  g-0">
        <div class="row mobile_web g-0">
            <div class="col-lg-7 col-12 signup_banner_wrapper">
                {{-- <div class="left-heading d-flex flex-column justify-content-center align-items-center ">
                    <img src="{{ asset('public_theme/images/main-logo.png') }}" class="img-fluid login_banner" alt="E-School Logo" />
                    <h1 class="text-light mt-3 mb-0 main-heading">e-school</h1>
                    <h2 class="text-light main-heading1">Gilgit Baltistan</h2>
                </div> --}}
            </div>
            <div class="col-lg-5 col-12 left_area d-flex justify-content-center align-items-center">
                <div class="login_area justify-content-center">
                    <div class="sign_in text-center mb-3">
                        <h1>Enter New Password</h1>
                    </div>

                    @if (Session::get('error') && Session::get('error') != null)
                        <div style="color:red">{{ Session::get('error') }}</div>
                        @php
                            Session::put('error', null);
                        @endphp
                    @endif
                    @if (Session::get('success') && Session::get('success') != null)
                        <div style="color:green">{{ Session::get('success') }}</div>
                        @php
                            Session::put('success', null);
                        @endphp
                    @endif
                    {!! Form::open(['route' => 'users.updatePassword', 'id' => 'formValidation', 'class' => 'register-form']) !!}
                    <div class="contanier-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    {{-- <input type="text" class="form-control" placeholder="New Password" /> --}}
                                    {!! Form::password('password', [
                                        'class' => 'form-control ' . $errors->first('password', 'error'),
                                        'placeholder' => 'Password',
                                    ]) !!}
                                    {!! $errors->first('password', '<label class="error">:message</label>') !!}
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group p-relative mb-3">
                                    {{-- <input type="password" class="form-control pwd-hide-show_input" placeholder="Confirm Password" /> --}}
                                    {!! Form::password('password_confirmation', [
                                        'class' => 'form-control ' . $errors->first('password_confirmation', 'error'),
                                        'placeholder' => 'Confirm Password',
                                    ]) !!}
                                    {!! $errors->first('password_confirmation', '<label class="error">:message</label>') !!}
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-12 mt-3 text-center">
                            {{-- <button class="btn btn-primary btn-login btn-block w-100 login_btn" data-bs-toggle="modal" data-bs-target="#myModal">
                                Submit
                            </button> --}}
                            <button type="submit" class="btn btn-primary btn-login btn-block w-100 login_btn">Submit</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!} <!--end::Card-->
            </div>
        </div>
    </div>

    
    {{-- <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">

                    
                    <x-breadcrumb title="Change Password" />
                    
                    <div class="main-body">
                        <div class="page-wrapper">

                            <div class="row">
                                
                                <div class="col-xl-12">
                                    <div class="card card-custom gutter-b example example-compact">
                                        @if (Session::get('error') && Session::get('error') != null)
                                            <div style="color:red">{{ Session::get('error') }}</div>
                                            @php
                                                Session::put('error', null);
                                            @endphp
                                        @endif
                                        @if (Session::get('success') && Session::get('success') != null)
                                            <div style="color:green">{{ Session::get('success') }}</div>
                                            @php
                                                Session::put('success', null);
                                            @endphp
                                        @endif
                                        
                                        {!! Form::open(['route' => 'users.updatePassword', 'id' => 'formValidation']) !!}
                                        <div class="card-body row">
                                            <div class="form-group col-md-4">
                                                {!! Form::label('password', 'Password', ['class' => 'form-label required-input']) !!}
                                                {!! Form::password('password', [
                                                    'class' => 'form-control ' . $errors->first('password', 'error'),
                                                    'placeholder' => 'Password',
                                                ]) !!}
                                                {!! $errors->first('password', '<label class="error">:message</label>') !!}
                                            </div>
                                            <div class="form-group col-md-4">
                                                {!! Form::label('password_confirmation', 'Confirm Password', ['class' => 'form-label required-input']) !!}
                                                {!! Form::password('password_confirmation', [
                                                    'class' => 'form-control ' . $errors->first('password_confirmation', 'error'),
                                                    'placeholder' => 'Confirm Password',
                                                ]) !!}
                                                {!! $errors->first('password_confirmation', '<label class="error">:message</label>') !!}
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                            <button type="button" onclick="window.location='{{ URL::previous() }}'"
                                                class="btn btn-secondary">Cancel</button>
                                        </div>
                                        {!! Form::close() !!} 
                                    </div>
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    


    @push('scripts')
        <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
        <script type="text/javascript">
            $('document').ready(function() {
                $('#formValidation').validate();
            });
        </script>
    @endpush

</x-guest-layout>
