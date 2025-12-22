<?php

namespace App\Http\Controllers;

use DB;
use Session;

use DataTables;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\Auth\UpdatePasswordRequest;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $users = User::where('id', '>', 1);

            return Datatables::of($users)
                ->addColumn('role', function ($user) {
                    return $user->getRoleNames()->first();
                })
                ->addColumn('action', function ($user) {
                $actions = '';

                if (auth()->user()->can('Update User')) {
                    $actions .= '<a href="' . route('users.edit', $user->uuid) . '" class="btn btn-icon btn-secondary"><i class="feather icon-edit-2"></i></a>
                                 <a href="' . route('users.updateStatus', $user->uuid) . '" class="btn btn-icon ' . ($user->is_active == 1 ? "btn-danger" : "btn-success") . ' btn-status"><i class="feather ' . ($user->is_active == 1 ? "icon-x-circle" : "icon-check-circle") . '"></i></a>';
                }

                $statusAction = '<td>
                <span class="badge ' . ($user->is_active == 1 ? "bg-success" : "bg-danger") . '">' . ($user->is_active == 1 ? "Active" : "Inactive") .
                    '</span>
                        <div class="overlay-edit">
                        ' . $actions . '
                        </div>
                    </td>';
                return $statusAction;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        }
         
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::active()->where('id', '>', 1)->pluck('name', 'id');
        return view('users.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request) {
        
        $userData = $request->validated();
        $userData['mobile'] = str_replace('-', '', $request->mobile);
        $userData['password'] = Hash::make($request->password);
        
        $user = User::create($userData);

        if($user) {

            $role = Role::find($request->role);

            if ($role) {
                $user->assignRole($role);
            }
        }


        Session::flash('success', 'User created successfully');

        return redirect()->route('users.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    public function profile()
    {
        // dd(auth()->user());
        return view('users.profile');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) {
        $roles = Role::active()->pluck('name', 'id');

        $role = $user->roles->first();
        if ($role) {
            $user->role = $role->id;
        } else {
            $user->role = '';
        }
        
        return view('users.edit', get_defined_vars());
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {

        $role = Role::find($request->role);
        if ($role) {
            $user->syncRoles($role);
        }

        $userData = $request->validated();
        $userData['mobile'] = str_replace('-', '', $request->mobile);

        $user->update($userData);

        Session::flash('success', 'User has been updated');
        
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user) {
            //$user->delete();
            return $this->sendResponse(true, 'User deleted successfully.');
        }

        return $this->sendResponse(false, 'User not found.', [], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(User $user)
    {
        if ($user) {
            $user->is_active = !$user->is_active;
            $user->save();
            return $this->sendResponse(true, 'User status updated successfully.');
        }

        return $this->sendResponse(false, 'User not found.', [], 404);
    }

    public function changePassword()
    {
        return view('users.change-password');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user =  User::find(Auth::user()->id);
        $user->password =  Hash::make($request->password);
        $user->save();

        Auth::logout();

        return redirect('/login');
    }


    public function refreshCaptcha(){
        return captcha_src();
    }
}
