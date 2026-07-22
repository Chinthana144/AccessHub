<div class="wrapper">
    {{-- main navigation bar for desktops --}}
    <aside id="sidebar">
        <div class="d-flex">
            <button class="toggle-btn" type="button">
                <i class="bx bx-grid-alt"></i>
            </button>
            <div class="sidebar-logo">
                <a href="/camp_portal">TRIZENT</a>
            </div>
        </div>
        <ul class="sidebar-nav">

            @can('view-dashboard')
                <li class="sidebar-item">
                    <a href="/home" class="sidebar-link">
                        <i class="bx bx-home fs-3"></i>
                        <span>Home</span>
                    </a>
                </li>
            @endcan            
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                    data-bs-target="#sheet" aria-expanded="false" aria-controls="auth">
                    <i class="bx bx-key fs-3"></i>
                    <span>Codes</span>
                </a>
                <ul id="sheet" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    @can('view-codeUpload')
                    <li class="sidebar-item">
                        <a href="{{ route('codeUpload.view') }}" class="sidebar-link">Code Upload</a>
                    </li>
                    @endcan
                    @can('view-codes')
                    <li class="sidebar-item">
                        <a href="/codes" class="sidebar-link">Codes</a>
                    </li>
                    @endcan
                    @can('view-codeReset')
                    <li class="sidebar-item">
                        <a href="/reset" class="sidebar-link" target="_blank">Code Reset</a>
                    </li>
                    @endcan
                </ul>
            </li>
        
            @can('view-camps')
            <li class="sidebar-item">
                <a href="/camps" class="sidebar-link">
                    <i class="bx bx-building fs-3"></i>
                    <span>Camps</span>
                </a>
            </li>
            @endcan

            @can('view-sheets')
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                    data-bs-target="#sheet" aria-expanded="false" aria-controls="auth">
                    <i class="bx bx-file fs-3"></i>
                    <span>Sheets</span>
                </a>
                <ul id="sheet" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="/sheets" class="sidebar-link">Sheets</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Sheets</a>
                    </li>
                </ul>
            </li>
            @endcan
            
            @can('view-control')
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                    data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                    <i class="bx bx-slider fs-3"></i>
                    <span>Control</span>
                </a>
                <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="/permissions" class="sidebar-link">User Access</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="/camp_access" class="sidebar-link">Camp Access</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('users.index') }}" class="sidebar-link">Users</a>
                    </li>
                </ul>
            </li>
            @endcan            

            @can('view-reports')
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                    data-bs-target="#report" aria-expanded="false" aria-controls="auth">
                    <i class="bx bx-clipboard fs-3"></i>
                    <span>Reports</span>
                </a>
                <ul id="report" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Sales Reports</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Summary</a>
                    </li>
                </ul>
            </li>
            @endcan
            
            @can('view-profile')
            <li class="sidebar-item">
                <a href="/userProfile" class="sidebar-link">
                    <i class="bx bx-user fs-3"></i>
                    <span>User Profile</span>
                </a>
            </li>    
            @endcan            
        </ul>

        {{-- logout --}}
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button class="sidebar-link"
                    style="background-color: inherit; border:none; color:white; margin-left:10px;">
                    <i class="bx bx-exit fs-3"></i>
                </button>
            </form>
        </div>
    </aside>

    {{---------------------------------------------------
        responsive navigation bar for mobiles and tablets
    -----------------------------------------------------}}

    <div id="div_mobile_menu">
        <div class="mobile-menu">
            <button class="btn_menu_toggle" type="button">
                <i class="bx bx-menu"></i>
                <span>CloudTik</span>
            </button>

            {{-- mobile menu --}}
            <div id="mobile_menu_items" class="mobile_menu_items">
                <ul class="sidebar-nav">

                    @can('access-home')
                        <li class="sidebar-item">
                            <a href="/home" class="sidebar-link">
                                <i class="bx bx-home fs-3"></i>
                                <span>Home</span>
                            </a>
                        </li>
                    @endcan

                    @can('access-invoice')
                        <li class="sidebar-item">
                            <a href="/invoice" class="sidebar-link">
                                <i class="bx bx-receipt fs-3"></i>
                                <span>Invoice</span>
                            </a>
                        </li>
                    @endcan

                    @can('view', App\Models\Customer::class)
                        <li class="sidebar-item">
                            <a href="/customers" class="sidebar-link">
                                <i class="bx bx-group fs-3"></i>
                                <span>Customers</span>
                            </a>
                        </li>
                    @endcan

                    @can('view', App\Models\Package::class)
                        <li class="sidebar-item">
                            <a href="/packages" class="sidebar-link">
                                <i class="bx bx-layer fs-3"></i>
                                <span>Packages</span>
                            </a>
                        </li>
                    @endcan

                    @can('view', App\Models\Subscription::class)
                         <li class="sidebar-item">
                            <a href="/view-subscription" class="sidebar-link">
                                <i class="bx bx-cloud-download fs-3"></i>
                                <span>Subscriptions</span>
                            </a>
                        </li>
                    @endcan


                    @can('access-control')
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                                data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                                <i class="bx bx-slider fs-3"></i>
                                <span>Control</span>
                            </a>
                            <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                                @can('view', App\Models\UserAccess::class)
                                    <li class="sidebar-item">
                                        <a href="/useraccess" class="sidebar-link">User Access</a>
                                    </li>
                                @endcan

                                @can('view',  App\Models\CampUser::class)
                                    <li class="sidebar-item">
                                        <a href="/campusers" class="sidebar-link">Camp Access</a>
                                    </li>
                                @endcan

                            </ul>
                        </li>
                    @endcan

                    {{-- <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                            data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
                            <i class="lni lni-layout"></i>
                            <span>Multi Level</span>
                        </a>
                        <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#multi-two" aria-expanded="false" aria-controls="multi-two">
                                    Two Links
                                </a>
                                <ul id="multi-two" class="sidebar-dropdown list-unstyled collapse">
                                    <li class="sidebar-item">
                                        <a href="#" class="sidebar-link">Link 1</a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="#" class="sidebar-link">Link 2</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li> --}}

                    @can('access-setting')
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                                data-bs-target="#settings" aria-expanded="false" aria-controls="auth">
                                <i class="bx bx-cog fs-3"></i>
                                <span>Settings</span>
                            </a>
                            <ul id="settings" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                                @can('view', App\Models\Camp::class)
                                    <li class="sidebar-item">
                                        <a href="/camps" class="sidebar-link">Camps</a>
                                    </li>
                                @endcan

                                @can('view', App\Models\User::class)
                                    <li class="sidebar-item">
                                        <a href="/users-list" class="sidebar-link">Users</a>
                                    </li>
                                @endcan

                            </ul>
                        </li>
                    @endcan

                    @can('access-reports')
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                                data-bs-target="#reports" aria-expanded="false" aria-controls="reports">
                                <i class="bx bx-file fs-3"></i>
                                <span>Reports</span>
                            </a>
                            <ul id="reports" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                                <li class="sidebar-item">
                                    <a href="/sales_reports" class="sidebar-link">Sales Reports</a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="#" class="sidebar-link">Customer Reports</a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="#" class="sidebar-link">Packages Reports</a>
                                </li>
                            </ul>
                        </li>
                    @endcan

                    @can('access-admin')
                       <li class="sidebar-item">
                            <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                                data-bs-target="#mikrotik" aria-expanded="false" aria-controls="mikrotik">
                                <i class="bx bx-wifi fs-3"></i>
                                <span>Mikrotik</span>
                            </a>
                            <ul id="mikrotik" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                                <li class="sidebar-item">
                                    <a href="/mikrotik" class="sidebar-link">Mikrotik</a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="/add_hotspot_users" class="sidebar-link">Add Users</a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="/manual_subscriptions" class="sidebar-link">Subscription</a>
                                </li>
                            </ul>
                        </li>
                    @endcan

                    <li class="sidebar-item">
                        <a href="/userProfile" class="sidebar-link">
                            <i class="bx bx-user fs-3"></i>
                            <span>User Profile</span>
                        </a>
                    </li>
                </ul>
                {{-- logout --}}
                <div class="sidebar-footer">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="sidebar-link"
                            style="background-color: inherit; border:none; color:white; margin-left:10px;">
                            <i class="bx bx-power-off fs-3"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="main p-2">
        <div id="top_row">
            <div>
                <h5>
                    <b>TRIZENT</b> User Management System
                </h5>
            </div>
            <div>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button
                        style="background-color: inherit; border:none;">
                        <i class="bx bx-power-off fs-2"></i>
                    </button>
                </form>
            </div>
        </div>

        @yield('content')
    </div>
    <div id="footer">
        <p>
            © 2025 Trizent. All rights reserved.
            <br>
            Powered by Trizent Software.
        </p>
    </div>
</div>