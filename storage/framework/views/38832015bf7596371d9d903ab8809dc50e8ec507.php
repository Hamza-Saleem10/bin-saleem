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

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(['Institutions List'])): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('institutions.index')); ?>" class="nav-link ">
                            <span class="pcoded-micon"><i class="fas fa-school"></i></span>
                            <span class="pcoded-mtext">Applications</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(['Inspectors List'])): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('inspectors.index')); ?>" class="nav-link ">
                            <span class="pcoded-micon"><i class="fas fa-user-tie"></i></span>
                            <span class="pcoded-mtext">Inspectors</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(['Fee Structures List'])): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('feestructures.index')); ?>" class="nav-link ">
                            <span class="pcoded-micon"><i class="fas fa-money-bill-wave"></i></span>
                            <span class="pcoded-mtext">Fee Structures</span>
                        </a>
                    </li>
                <?php endif; ?>


                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['Level1 List', 'Districts List', 'Tehsils List','Villages List'])): ?>
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#" class="nav-link ">
                            <span class="pcoded-micon"><i class="fas fa-globe"></i></span>
                            <span class="pcoded-mtext">Geographical Units</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li><a href="<?php echo e(route('divisions.index')); ?>">Division</a></li>
                            <li><a href="<?php echo e(route('districts.index')); ?>">Districts</a></li>
                            <li><a href="<?php echo e(route('tehsils.index')); ?>">Tehsils</a></li>
                            <li><a href="<?php echo e(route('villages.index')); ?>">Villages</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['Users Index', 'Roles/Index', 'Permissions/Index'])): ?>
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
</nav><?php /**PATH C:\xampp\htdocs\pepris-gb-web\resources\views/layouts/left-menu.blade.php ENDPATH**/ ?>