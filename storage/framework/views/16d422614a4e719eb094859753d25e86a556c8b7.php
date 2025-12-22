<nav class="pcoded-navbar menupos-fixed ">
    <div class="navbar-wrapper  ">
        <div class="navbar-content scroll-div " >

            <ul class="nav pcoded-inner-navbar ">
                <!--<li class="nav-item pcoded-menu-caption"><label>Navigation</label></li>-->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(['Dashboard'])): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('dashboard')); ?>" class="nav-link ">
                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                        <span class="pcoded-mtext">Dashboard</span>
                    </a>
                </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(['Bookings List'])): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('bookings.index')); ?>" class="nav-link ">
                            <span class="pcoded-micon"><i class="fas fa-ticket-alt"></i></span>
                            <span class="pcoded-mtext">Bookings</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(['Vehicles List'])): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('vehicles.index')); ?>" class="nav-link ">
                            <span class="pcoded-micon"><i class="fas fa-car"></i></span>
                            <span class="pcoded-mtext">Vehicles</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(['Reviews List'])): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('reviews.index')); ?>" class="nav-link ">
                            <span class="pcoded-micon"><i class="fas fa-comments"></i></span>
                            <span class="pcoded-mtext">Reviews</span>
                        </a>
                    </li>
                <?php endif; ?>

                

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['Users List', 'Roles List', 'Permissions List'])): ?>
                    <li class="nav-item pcoded-hasmenu <?php echo e(setActive(['Users Index'])); ?>">
                        <a href="#" class="nav-link ">
                            <span class="pcoded-micon"><i class="fas fa-cog"></i></span>
                            <span class="pcoded-mtext">Settings</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Settings Index')): ?>
                                <li><a href="<?php echo e(route('users.index')); ?>">Users</a></li>
                            <?php endif; ?>
                            <li><a href="<?php echo e(route('roles.index')); ?>">Roles</a></li>
                            <li><a href="<?php echo e(route('permission-groups.index')); ?>">Permission Groups</a></li>
                            <li><a href="<?php echo e(route('permissions.index')); ?>">Permissions</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
                

            </ul>

        </div>
    </div>
</nav><?php /**PATH D:\binslaeem\resources\views/layouts/left-menu.blade.php ENDPATH**/ ?>