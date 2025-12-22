<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <!-- <x-breadcrumb title="Profile" /> -->
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- product profit end -->

                <div class="col-xl-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Profile</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="username">Username</label>
                                <div class="col-sm-9">
                                    <input type="text" readonly="" class="form-control-plaintext" id="username" value="{{ auth()->user()->username }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="username">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" readonly="" class="form-control-plaintext" id="username" value="{{ auth()->user()->name }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="email">Email</label>
                                <div class="col-sm-9">
                                    <input type="text" readonly="" class="form-control-plaintext" id="email" value="{{ auth()->user()->email }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="mobile">Mobile #</label>
                                <div class="col-sm-9">
                                    <input type="text" readonly="" class="form-control-plaintext" id="mobile" value="{{ auth()->user()->mobile }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
</x-app-layout>
