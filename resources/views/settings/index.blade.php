<x-app-layout>
    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">

                    <!-- [ breadcrumb ] start -->
                    <x-breadcrumb title="Settings" :breadcrumbs="[['name' => 'General Settings', 'allow' => true, 'link' => '#']]" />
                    <!-- [ breadcrumb ] end -->

                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                <!-- [ basic-table ] start -->
                                <div class="col-xl-12">
                                    <div class="card card-custom gutter-b example example-compact">
                                        <!--begin::Form-->
                                        {!! Form::open(['route' => 'settings.update', 'id' => 'formValidation']) !!}
                                        <div class="card-body row">
                                            <div class="form-group col-4">
                                                {!! Form::label('app_version_name', 'APP Version Name', ['class' => 'form-label required-input']) !!}
                                                {!! Form::text('app_version_name', @$settings['app_version_name'], [
                                                    'class' => 'form-control',
                                                    'required'
                                                ]) !!}
                                            </div>
                                            <div class="form-group col-4">
                                                {!! Form::label('app_version_code', 'APP Version Code', ['class' => 'form-label required-input']) !!}
                                                {!! Form::number('app_version_code', @$settings['app_version_code'], [
                                                    'class' => 'form-control',
                                                    'min' => 1,
                                                    'step' => 1,
                                                    'required'
                                                ]) !!}
                                            </div>
                                        </div>

                                        @if(auth()->user()->can('Settings Update'))
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary mr-2">Save</button>
                                            <button type="button" onclick="window.location='{{ URL::previous() }}'"
                                                class="btn btn-secondary">Cancel</button>
                                        </div>
                                        @endif
                                        {!! Form::close() !!}
                                        <!--end::Card-->
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
    @include('layouts.validator')
    <script type="text/javascript">

        $(document).ready(function() {
            $('#formValidation').validate();
        });
    </script>
@endpush

</x-app-layout>
