<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request = filterRequestData($request);

        $request->validate([
            'name' => 'required|string|max:255',
            'cnic' => 'required|min:13|max:13|unique:users,cnic',
            'email' => 'required|string|email|max:255|unique:users',
            // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'password' => ['required', 'confirmed', Rules\Password::min(8)->numbers()->letters()->mixedCase()->symbols()]
        ]);
 
        $user = User::create([
            'name' => $request->name,
            'cnic' => filterRequestData($request->cnic),
            'username' => filterRequestData($request->cnic),
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // $user->assignRole('School Owner');
        // $user->syncRoles(['School Owner']);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
