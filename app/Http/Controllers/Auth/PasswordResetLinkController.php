<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Notifications\ResetPassword;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Notification;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required'],
        ]);
        
        $username = $request->username;

        $user = User::where('username', $username)->first();
        if ($user) {
            $password = random_int(11111111, 99999999);

            if ($user->mobile == null) {
                sendPasswordMessage(config('app.admin_mobile'), $password);
            } else {
                sendPasswordMessage($user->mobile, $password);
            }

            if ($user->email == null) {
                try {
                    Notification::route('mail', config('app.admin_email'))
                    ->notify(new ResetPassword(['name' => $user->name, 'password' => $password]));
                } catch (\Exception $e) {
                    Log::error('Forgot password email Error: ' . $e->getMessage());
                }
            } else {
                try {
                    $user->notify(new ResetPassword(['name' => $user->name, 'password' => $password]));
                } catch (\Exception $e) {
                    Log::error('Forgot password email Error: ' . $e->getMessage());
                }
            }
            

            $user->password = Hash::make($password);
            $user->save();

        } else {
            return back()->withInput()->withErrors(['username' => 'User not exist against this username']);
        }
        
        Session::flash('username', $username);
        Session::flash('success', 'Password send successfully');

        return redirect()->route('login');

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        // $status = Password::sendResetLink(
        //     $request->only('email')
        // );

        // return $status == Password::RESET_LINK_SENT
        //             ? back()->with('status', __($status))
        //             : back()->withInput($request->only('email'))
        //                     ->withErrors(['email' => __($status)]);
    }
}
