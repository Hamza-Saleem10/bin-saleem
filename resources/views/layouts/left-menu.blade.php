<nav class="pcoded-navbar menupos-fixed ">
    <div class="navbar-wrapper  ">
        <div class="navbar-content scroll-div " >

            <ul class="nav pcoded-inner-navbar ">
                <!--<li class="nav-item pcoded-menu-caption"><label>Navigation</label></li>-->
                @can(['View Dashboard'])
                <li class="nav-item">
                    <a href="{{route('dashboard')}}" class="nav-link ">
                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                        <span class="pcoded-mtext">Dashboard</span>
                    </a>
                </li>
                @endcan

                @can(['Bookings List'])
                    <li class="nav-item">
                        <a href="{{route('bookings.index')}}" class="nav-link ">
                            <span class="pcoded-micon"><i class="fas fa-ticket-alt"></i></span>
                            <span class="pcoded-mtext">Bookings</span>
                        </a>
                    </li>
                @endcan
                @can(['Vehicles List'])
                    <li class="nav-item">
                        <a href="{{route('vehicles.index')}}" class="nav-link ">
                            <span class="pcoded-micon"><i class="fas fa-car"></i></span>
                            <span class="pcoded-mtext">Vehicles</span>
                        </a>
                    </li>
                @endcan
                @can(['Reviews List'])
                    <li class="nav-item">
                        <a href="{{route('reviews.index')}}" class="nav-link ">
                            <span class="pcoded-micon"><i class="fas fa-comments"></i></span>
                            <span class="pcoded-mtext">Reviews</span>
                        </a>
                    </li>
                @endcan
                @can(['Routes List'])
                    <li class="nav-item">
                        <a href="{{route('routes.index')}}" class="nav-link ">
                            <span class="pcoded-micon"><i class="fas fa-road"></i></span>
                            <span class="pcoded-mtext">Routes</span>
                        </a>
                    </li>
                @endcan
                {{-- @can(['Mark Attendance'])
                    <li class="nav-item">
                        <a href="{{route('attendance.markAttendance')}}" class="nav-link ">
                            <span class="pcoded-micon"><i class="fas fa-clipboard-check"></i></span>
                            <span class="pcoded-mtext">Mark Attendance</span>
                        </a>
                    </li>
                @endcan
                @role('Super Admin|Admin')
                    <li class="nav-item">
                        <a href="{{route('attendance.index')}}" class="nav-link ">
                            <span class="pcoded-micon"><i class="fas fa-file-alt"></i></span>
                            <span class="pcoded-mtext">Attendance Report</span>
                        </a>
                    </li>
                @endrole --}}
                @canany(['Mark Attendance', 'Attendance List', 'Attendance Rule List'])
                    <li class="nav-item pcoded-hasmenu {{ setActive(['attendance.*']) }}">
                        <a href="#" class="nav-link">
                            <span class="pcoded-micon">
                                <i class="fas fa-clipboard-check"></i>
                            </span>
                            <span class="pcoded-mtext">Attendance</span>
                        </a>

                        <ul class="pcoded-submenu">
                            @role('Super Admin|Admin')
                                <li>
                                    <a href="{{ route('attendance.index') }}">
                                        Attendance Report
                                    </a>
                                </li>
                            @endrole
                            @can('Attendance Rule List')
                                <li>
                                    <a href="{{ route('attendance-rules.index') }}">
                                        Attendance Rules
                                    </a>
                                </li>
                            @endcan
                            @can('Mark Attendance')
                                <li>
                                    <a href="{{ route('attendance.markAttendance') }}">
                                        Mark Attendance
                                    </a>
                                </li>
                            @endcan
                            
                        </ul>
                    </li>
                @endcanany

                {{-- @canany(['Level1 List', 'Districts List', 'Tehsils List','Villages List'])
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#" class="nav-link ">
                            <span class="pcoded-micon"><i class="fas fa-globe"></i></span>
                            <span class="pcoded-mtext">Geographical Units</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li><a href="{{route('divisions.index')}}">Division</a></li>
                            <li><a href="{{route('districts.index')}}">Districts</a></li>
                            <li><a href="{{route('tehsils.index')}}">Tehsils</a></li>
                            <li><a href="{{route('villages.index')}}">Villages</a></li>
                        </ul>
                    </li>
                @endcanany --}}

                @canany(['Users List', 'Roles List', 'Permissions List'])
                    <li class="nav-item pcoded-hasmenu {{ setActive(['Users Index']) }}">
                        <a href="#" class="nav-link ">
                            <span class="pcoded-micon"><i class="fas fa-cog"></i></span>
                            <span class="pcoded-mtext">Settings</span>
                        </a>
                        <ul class="pcoded-submenu">
                            @can('Settings Index')
                                <li><a href="{{ route('users.index') }}">Users</a></li>
                            @endcan
                            <li><a href="{{route('roles.index')}}">Roles</a></li>
                            <li><a href="{{route('permission-groups.index')}}">Permission Groups</a></li>
                            <li><a href="{{route('permissions.index')}}">Permissions</a></li>
                        </ul>
                    </li>
                @endcanany
                

            </ul>

        </div>
    </div>
</nav>