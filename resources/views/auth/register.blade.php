<x-register-layout>

    <div class="col-md-6  col-12 d-flex justify-content-center align-items-center vh-100 right-section">
        <div class="form-container">
            <h4 class="text-center text-light mb-4">Register</h4>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <x-input type="text" id="name" name="name" class="form-control form-input mb-3" :value="old('name')"
                    required autofocus placeholder="Owner Name" />
                <x-input type="text" id="cnic" name="cnic" class="form-control form-input mb-3"
                    :value="old('cnic')" required autofocus placeholder="Owner CNIC" />
                <x-input type="email" id="email" name="email" class="form-control form-input mb-3"
                    :value="old('email')" required autofocus placeholder="Email" />
                <x-input type="password" id="password" name="password" class="form-control form-input mb-3"
                    :value="old('password')" required autofocus placeholder="Password" />
                <x-input type="password" id="password_confirmation" name="password_confirmation"
                    class="form-control form-input mb-3" required placeholder="Confirm Password" />


                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-check d-flex align-items-start mb-3">
                    <input class="form-check-input me-2" type="checkbox" id="terms" />
                    <label class="form-check-label small text-light" for="terms">
                        I agree to the Terms & Conditions and Privacy Policy by registering.
                    </label>
                </div>

                <button type="submit" class="btn btn-register">Register</button>

                <div class="text-center mt-3">
                    <span class="text-light">Already Have An Account? </span>
                    <a href="{{ route('login') }}" class="login-link fw-bold">Login</a>
                </div>
            </form>
        </div>
    </div>

    {{-- <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                    required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card> --}}
</x-register-layout>
