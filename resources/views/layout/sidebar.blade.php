<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('dashboard')}}" class="brand-link">
        <span class="brand-text font-weight-light text-center">{{env("APP_NAME")}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="{{url('dashboard')}}" class="nav-link @if(Request::segment(1) == "dashboard"){{"active"}}@endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{url('employee')}}" class="nav-link @if(Request::segment(1) == "employee"){{"active"}}@endif">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>Employee Management</p>
                    </a>
                </li>

                <li class="nav-item @if(Request::segment(1) == "department" || Request::segment(1) == "country" || Request::segment(1) == "state" || Request::segment(1) == "city"){{"menu-is-opening menu-open"}}@endif">
                    <a href="#" class="nav-link @if(Request::segment(1) == "department" || Request::segment(1) == "country" || Request::segment(1) == "state" || Request::segment(1) == "city"){{"active"}}@endif">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                            System Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('department')}}" class="nav-link @if(Request::segment(1) == "department"){{"active"}}@endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Department</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('country')}}" class="nav-link @if(Request::segment(1) == "country"){{"active"}}@endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Country</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('state')}}" class="nav-link @if(Request::segment(1) == "state"){{"active"}}@endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>State</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('city')}}" class="nav-link @if(Request::segment(1) == "city"){{"active"}}@endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>City</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item @if(Request::segment(1) == "users"){{"menu-is-opening menu-open"}}@endif">
                    <a href="#" class="nav-link @if(Request::segment(1) == "users"){{"active"}}@endif">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            User management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('users')}}" class="nav-link @if(Request::segment(1) == "users"){{"active"}}@endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>User</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>