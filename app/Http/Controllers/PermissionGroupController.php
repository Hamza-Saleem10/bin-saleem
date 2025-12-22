<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionGroupRequest;
use App\Models\Permission;
use App\Models\PermissionGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class PermissionGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {

            $permissionGroups = PermissionGroup::query();

            return Datatables::of($permissionGroups)
                ->addColumn('action', function ($permissionGroup) {
                    $statusAction = '   <td>
                                            <div class="overlay-edit">
                                                <a href="'.route('permission-groups.edit', $permissionGroup->uuid).'" class="btn btn-icon btn-secondary"><i class="feather icon-edit-2"></i></a>
                                                <a href="'.route('permission-groups.destroy', $permissionGroup->uuid).'" class="btn btn-icon btn-danger btn-delete"><i class="feather icon-trash-2"></i></a>
                                            </div>
                                        </td>';
                    return $statusAction;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);

        }

        return view('acl.permission-groups.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('acl.permission-groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionGroupRequest $request)
    {
        $permissionData = $request->validated();
        PermissionGroup::create($permissionData);

        Session::flash('success', "Permission group successfully created.");

        return redirect()->route('permission-groups.index');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PermissionGroup $permissionGroup)
    {
        return view('acl.permission-groups.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionGroupRequest $request, PermissionGroup $permissionGroup)
    {
        $permissionGroupData = $request->validated();
        $permissionGroup->update($permissionGroupData);

        // PermissionGroup::where('id', $PermissionGroup->id)->update($request->validated());

        Session::flash('success', "Permission group successfully updated.");

        return redirect()->route('permission-groups.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id) {

            $permissions = Permission::where('permission_group_id', $id)->get();
            if($permissions->isNotEmpty()) {
                return $this->sendResponse(false, "Permission group cannot be deleted because it belongs to some permissions", [], 404);        
            }

            PermissionGroup::where('uuid', '=', $id)->delete();

            return $this->sendResponse(true, "Permission group successfully removed");
        }

        return $this->sendResponse(false, "Permission group not found", [], 404);
    }
}
