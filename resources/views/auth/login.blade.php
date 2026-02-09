<x-guest-layout>
    <div class="container-fluid  g-0">
        <div class="row mobile_web g-0">
            <div class="col-lg-7 col-12 signup_banner_wrapper">
                {{-- <div class="left-heading d-flex flex-column justify-content-center align-items-center ">
                    <img src="{{ asset('public_theme/images/main-logo.png') }}" class="img-fluid login_banner"
                        alt="E-School Logo" />
                    <h1 class="text-light mt-3 mb-0 main-heading">Umrah Taxi</h1>
                    <h2 class="text-light main-heading1">Saudi Arbia</h2>
                </div> --}}
            </div>

            <div class="col-lg-5 col-12 left_area d-flex justify-content-center align-items-center">
                <div class="login_area justify-content-center">
                    <div class="sign_in text-center mb-3">
                        <h1>Login</h1>
                    </div>

                    <form action="{{ route('login') }}" method="POST" class="register-form">
                        @csrf
                        <div class="contanier-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <input id="username"
                                            class="form-control @error('username') is-invalid @enderror"
                                            placeholder="Username" type="username" name="username"
                                            value="{{ old('username', session()->get('username')) }}" maxlength="50"
                                            autofocus />
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group position-relative mb-3">
                                        <input id="password"
                                            class="form-control  pwd-hide-show_input @error('password') is-invalid @enderror"
                                            type="password" name="password" autocomplete="current-password"
                                            placeholder="Password" style="padding-right: 40px;"/>
                                            <button type="button" class="btn btn-link position-absolute top-50 end-0 translate-middle-y" id="togglePassword" style="z-index: 10; color: #6c757d; background: none; border: none; outline: none;">
                                                <i class='bx bx-hide'></i>
                                            </button>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <!---capcha start---->
                                <div class="col-12">
                                    <div class="d-flex align-items-center">

                                        <div class="form-group mb-3 me-3" id="captch-container">
                                            {!! captcha_img() !!}
                                        </div>

                                        <div class="form-group mb-3">
                                            <button type="button" id="btn-refresh" class="btn btn-primary btn-auth">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-12"></div>
                                    <div class="form-group mb-3">
                                        <input id="captcha" class="form-control @error('captcha') is-invalid @enderror"
                                        placeholder="Enter Captcha" type="text" name="captcha" tabindex="3" />
                                        @error('captcha')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <!-------end------------>
                                <div class="col-12 d-flex justify-content-between align-items-center">
                                    <div class="form-check custom-checkbox">
                                        <input class="form-check-input" type="checkbox" id="remember">
                                        <label class="form-check-label" for="remember">Remember me</label>
                                    </div>
                                    <a href="#" class="forgot-password">Forgot Password?</a>
                                </div>


                            </div>
                            <div class="col-sm-12 mt-3 text-center">
                                <button class="btn btn-block btn-primary btn-login w-100 login_btn">Login</button>
                                <small class="d-block text-center text-primary mt-3">Don’t have account? <a
                                        href="{{ route('register') }}"
                                        target="_self"><strong>Register</strong></a></small>
                            </div>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).on("click", "#btn-refresh", function() {
                $.ajax({
                    url: "{{route('refresh-captcha')}}",
                    data:{

                        '_token':"{{csrf_token()}}"
                    },
                    type:"POST",
                    cache: false,
                    success: function(html) {
                        $("#captch-container").find('img').attr('src', html);
                    }
                });
            });

            // Add show/hide password functionality
            $(document).ready(function() {
                const $toggleBtn = $('#togglePassword');
                const $passwordInput = $('#password');
                const $icon = $toggleBtn.find('i');
                
                $toggleBtn.on('click', function(e) {
                    e.preventDefault();
                    
                    // Toggle password visibility
                    const isPassword = $passwordInput.attr('type') === 'password';
                    $passwordInput.attr('type', isPassword ? 'text' : 'password');
                    
                    // Toggle eye icon
                    $icon.toggleClass('bx-show bx-hide');
                    $passwordInput.trigger('focus');
                });
            });
        </script>
    @endpush
</x-guest-layout>
