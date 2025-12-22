<x-guest-layout>


    <div class="auth-wrapper align-items-stretch aut-bg-img">
        <div class="flex-grow-1">
            <div class="h-100 d-md-flex align-items-center auth-side-img">
                <div class="col-sm-10 auth-content w-auto">
                    <h1 class="text-white my-4">Bin Saleem Umrah Taxi Service</h1>
                    <h4 class="text-white font-weight-normal">Saudi Arabia</h4>
                </div>
            </div>
            <div class="auth-side-form">
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
        
                    <div class="auth-content align-items-center text-center">
                        {{-- <img src="{{asset('images/gb-logo-dark.png')}}" alt="" class="img-fluid mb-4 d-xl-none d-lg-none"> --}}
                        <h3 class="mb-4 f-w-400">Forgot Password</h3>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="feather icon-mail"></i></span>
                            <input id="username" class="form-control @error('username') is-invalid @enderror" placeholder="Username" type="text" name="username" :value="old('username')" maxlength="50" autofocus />
                            @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <button class="btn btn-block btn-primary mt-2 mb-0">Send Password</button>
                        <p class="mb-0 text-muted mt-3">You have an account? <a href="{{ route('login') }}" class="f-w-400">Sign in</a></p>
                        <div class="text-center">
                            <div class="saprator my-4">
                                <span></span>
                            </div>
                            {{-- <img src="{{asset('images/gb-login.png')}}" alt="" class="logo">
                            <img src="{{asset('images/pitb-login.png')}}" alt="" class="logo"> --}}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>




    
</x-guest-layout>
