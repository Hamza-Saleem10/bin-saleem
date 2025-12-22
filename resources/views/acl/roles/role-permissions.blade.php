<x-app-layout>
    <div class="dashboard-app">
        <div class="dashboard-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 mb-3">
                        <h4 class="page-head">{{ $role->name }} <small>Permissions</small></h4>
                    </div>
                </div>

                <div class="card--- shadow-none border-0">
                    <div class="card-body border-0">
                        {!! Form::model($role, ['method' => 'PUT', 'route' => ['roles.permissions', $role->uuid], 'id' => 'role_permissions_form']) !!}

                        @foreach ($permissionGroups as $group)
                            <h2 class="formsEduHeading2 mb-0 rounded-1 py-2 px-3 mb-4">{{ $group->name }}</h2>

                            <div class="row formsEduInputDiv align-items-end">


                                @foreach ($group->permissions as $permission)
                                    <div class="col-xl-3 col-md-4 col-sm-6">
                                        <div class="form-group rp-permission">
                                            <div class="checkbox checkbox-fill d-inline">
                                                {!! Form::checkbox('permissions[]', $permission->name, $role->hasPermissionTo($permission->name), [
                                                    'id' => 'cb-' . $permission->id,
                                                ]) !!}
                                                <label for="cb-{{ $permission->id }}"
                                                    class="cr">{{ ucwords($permission->name) }}</label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        @endforeach



                        <div class="row pt-4">
                            <div class="col-12 d-flex align-items-center justify-content-end">
                                <button type="submit" class="btn saveFormEduBtn me-3">Save</button>
                                <button class="btn cancelFormEduBtn">Cancel</button>
                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
