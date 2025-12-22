<x-app-layout>
    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    
                    <!-- [ breadcrumb ] start -->
                    <x-breadcrumb title="{{ $role->name }} - Permissions" />
                    <!-- [ breadcrumb ] end -->
                    
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                <!-- [ basic-table ] start -->
                                <div class="col-xl-12">
                                    <div class="card card-custom gutter-b example example-compact">
                                        <!--begin::Form-->
                                        {!! Form::model($role, ['method' => 'post', 'route' => ['roles.permissions',  $role->uuid]]) !!}
                                            <div class="card-body row">


                                                @foreach ($permissionGroups as $group)
                                                    <h2 class="formsEduHeading2 mb-0 rounded-1 py-2 px-3 mb-4" style="font-size: 18px;">{{ $group->name }}</h2>

                                                    <div class="row formsEduInputDiv align-items-end">

                                                        @foreach($group->permissions as $permission)
                                                            <div class="col-3">
                                                                <div class="form-group">
                                                                    <div class="checkbox checkbox-fill d-inline">
                                                                        {!! Form::checkbox("permissions[]", $permission->name, $role->hasPermissionTo($permission->name), ["id" => "cb-".$permission->id]) !!}
                                                                        <label for="cb-{{ $permission->id }}" class="cr">{{ ucwords($permission->name) }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach






                                                



                                            </div>
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                                <button type="button" onclick="window.location='{{ URL::previous() }}'" class="btn btn-secondary">Cancel</button>
                                            </div>
                                        {!! Form::close() !!}        <!--end::Card-->
                                    </div>
                                </div>
                                <!-- [ basic-table ] end -->
                            </div>
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->


    @push('scripts')    
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript">
        $('document').ready(function () {
            $('#formValidation').validate();
        });
    </script>
    @endpush

</x-app-layout>