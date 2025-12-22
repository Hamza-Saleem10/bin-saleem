<header class="navbar pcoded-header navbar-expand-lg navbar-light headerpos-fixed header-indigogreen">


    <div class="m-header">
        <a class="mobile-menu" id="mobile-collapse" href="#"><span></span></a>
        <a href="#" class="b-brand">
            <!-- <h3 style="color: white;">EMIS GB</h3> -->
            <!-- ========   change your logo hear   ============ -->
            <img src="<?php echo e(asset('images/gb-logo.png')); ?>" alt="" class="logo">
            <img src="<?php echo e(asset('images/logo-icon.png')); ?>" alt="" class="logo-thumb">
        </a>
        <a href="#" class="mob-toggler">
            <i class="feather icon-more-vertical"></i>
        </a>
    </div>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <a href="#" class="full-screen" onclick="javascript:toggleFullScreen()"><i class="feather icon-maximize"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto">
            <li>
                <div class="dropdown drp-user">
                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fas fa-user-circle" style="font-size: 30px; position: absolute;top: 50%;left: 100%;transform: translate(-50%,-50%);"></i>
                        <!-- <img src="<?php echo e(asset('images/avatar-1.png')); ?>" class="img-radius wid-40" alt="User-Profile-Image"> -->
                    </a>
                    <div class="dropdown-menu dropdown-menu-end profile-notification">
                        <div class="pro-head">
                        <i class="fas fa-user-circle"></i>
                            <!-- <img src="<?php echo e(asset('images/avatar-1.png')); ?>" class="img-radius" alt="User-Profile-Image"> -->
                            <span><?php echo e(Auth::user()->name); ?></span>
                        </div>
                        <ul class="pro-body">
                            <li><a href="<?php echo e(route('profile')); ?>" class="dropdown-item"><i class="feather icon-user"></i> Profile</a></li>
                            <li><a href="<?php echo e(route('users.changePassword')); ?>" class="dropdown-item"><i class="feather icon-unlock"></i> Change Passowrd</a></li>
                            <li><a href="<?php echo e(route('logout')); ?>" class="dropdown-item"><i class="feather icon-power"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>


</header><?php /**PATH C:\xampp\htdocs\pepris-gb-web\resources\views/layouts/top-bar.blade.php ENDPATH**/ ?>