<aside class="app-sidebar sticky" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="{{ route('dashboard') }}" class="header-logo">
            <img src="{{ asset($settings ? $settings->logo : '') }}" alt="logo">
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="main-menu">

                <!-- Dashboard - Always visible -->
                <li class="slide">
                    <a href="{{ route('dashboard') }}"
                        class="side-menu__item {{ Request::is('admin') ? 'active' : '' }}">
                        <i class="bx bxs-dashboard side-menu__icon"></i>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>


                <!-- Pricing -->
                @can('view packages')
                <li class="slide">
                    <a href="{{ route('admin.pricing.index') }}"
                        class="side-menu__item {{ Request::is('admin/pricing*') ? 'active' : '' }}">
                        <i class="bx bx-package side-menu__icon"></i>
                        <span class="side-menu__label">Pricing List</span>
                    </a>
                </li>
                @endcan


                <!-- Achievement -->
                @can('view developer api')
                <li class="slide">
                    <a href="{{ route('admin.developer-api.index') }}"
                        class="side-menu__item {{ Request::is('admin/developer-api*') ? 'active' : '' }}">
                        <i class="bx bx-code-alt side-menu__icon"></i>
                        <span class="side-menu__label">Developer Api</span>
                    </a>
                </li>
                @endcan


                <!-- SEO Settings -->
                @can('view seo')
                <li class="slide">
                    <a href="{{ route('admin.settings.seo.index') }}" class="side-menu__item {{ Request::is('admin/settings/seo') ? 'active' : '' }}">
                        <i class="bx bx-search-alt-2 side-menu__icon"></i>
                        <span class="side-menu__label">SEO Settings</span>
                    </a>
                </li>
                @endcan

                <!-- Change Password -->
                <li class="slide">
                    <a href="{{ route('password.change') }}"
                        class="side-menu__item {{ Request::is('password/change') ? 'active' : '' }}">
                        <i class="bx bx-lock side-menu__icon"></i>
                        <span class="side-menu__label">Change Password</span>
                    </a>
                </li>


                <!-- Authentication - Only for admin -->
                @canany(['view roles', 'view users'])
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="bx bx-fingerprint side-menu__icon"></i>
                        <span class="side-menu__label">Authentication</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1" data-popper-placement="bottom">
                        @can('view roles')
                        <li class="slide">
                            <a href="{{ route('admin.roles.index') }}" class="side-menu__item">
                                Role & Permission
                            </a>
                        </li>
                        @endcan
                        @can('view users')
                        <li class="slide">
                            <a href="{{ route('admin.users.index') }}" class="side-menu__item">
                                Users Manage
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcanany

                <!-- Settings -->
                @can('view settings')
                <li class="slide">
                    <a href="{{ route('admin.setting.index') }}" class="side-menu__item {{ Request::is('admin/setting*') ? 'active' : '' }}">
                        <i class="bx bxs-cog side-menu__icon"></i>
                        <span class="side-menu__label">Settings</span>
                    </a>
                </li>
                @endcan

            </ul>
            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg>
            </div>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>
