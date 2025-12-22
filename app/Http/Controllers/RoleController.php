<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\PermissionGroup;

use Illuminate\Http\Request;

use Session;
use DataTables;
use DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            
            $roles = Role::query();            

            return Datatables::of($roles)
                ->addColumn('action', function ($role) {
                    $statusAction = '   <td>
                                            <span class="badge '.($role->is_active == 1 ? "bg-success" : "bg-danger").'">'.($role->is_active == 1 ? "Active" : "Inactive").'</span>
                                            <div class="overlay-edit">
                                            <a href="'.route('roles.getPermissions', $role->uuid).'" class="btn btn-icon btn-success"><i class="fas fa-key"></i></a>
                                            <a href="'.route('roles.edit', $role->uuid).'" class="btn btn-icon btn-secondary"><i class="feather icon-edit-2"></i></a>
                                            <a href="'.route('roles.updateStatus', $role->uuid).'" class="btn btn-icon '.($role->is_active == 1 ? "btn-danger" : "btn-success").' btn-status"><i class="feather '.($role->is_active == 1 ? "icon-eye-off" : "icon-eye").'"></i></a>
                                            <a href="'.route('roles.destroy', $role->uuid).'" class="btn btn-icon btn-danger btn-delete"><i class="feather icon-trash-2"></i></a>
                                            </div>
                                        </td>';
                    return $statusAction;
                    
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        }
        
        return view('acl.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        
        return view('acl.roles.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        $roleData = $request->validated();

        Role::create($roleData);

        Session::flash('success', "Role successfully created.");

        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('acl.roles.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRoleRequest $request, Role $role) {

        $roleData = $request->validated();

        $role->update($roleData);

        Session::flash('success', "Role successfully updated.");

        return redirect()->route('roles.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if ($role) {
            $role->delete();
            return $this->sendResponse(true, "Role successfully removed.");
        }

        return $this->sendResponse(false, "Role not found", [], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Role $role) {

        if($role) {

            $role->is_active = !$role->is_active;
            $role->save();

            return $this->sendResponse(true, __('messages.role_updated'));
        }

        return $this->sendResponse(false, __('messages.role_not_found'), [], 404);
    }

    /**
     * Get role permissions.
     *
     * @param  \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function getRolePermissions(Role $role)
    {
       $permissionGroups = PermissionGroup::with('permissions')->orderBy('order', 'ASC')->get();
       
       return view('acl.roles.permissions', get_defined_vars());
    //    return view('acl.roles.role-permissions', get_defined_vars());
    }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function updateRolePermission($id, Request $request)
   {
       $permissions = $request->permissions;
       $role = Role::uuid($id)->firstOrFail();

       DB::table('role_has_permissions')->where('role_id', $role->id)->delete();

       $role->syncPermissions($permissions);

       Session::flash('success', __('Permissions updated!'));
       return redirect()->route('roles.index');
    }

}
