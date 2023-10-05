<div id="kt_header" class="header flex-column  header-fixed " >
	<div class="header-top">
        <div class=" container ">
			<div class="d-none d-lg-flex align-items-center mr-3">
				<a href="{{ url('admin-cms') }}" class="mr-10">
					<img alt="Logo" src="{{ asset('public/backend/media/logos/cibes_logo.svg') }}" class="max-h-35px"/>
				</a>
            </div>

            <div class="topbar">
                <div class="dropdown">
                    <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                        <div class="btn btn-icon btn-dropdown w-auto d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                            <div class="d-flex text-right pr-3">
                                <span class="text-white opacity-50 font-weight-bold font-size-sm d-none d-md-inline mr-1">Hi,</span>
                                <span class="text-white font-weight-bolder font-size-sm d-none d-md-inline">{{ Auth::user()->name }}</span>
                            </div>
                            <span class="symbol symbol-35">
                                <span class="symbol-label font-size-h5 font-weight-bold text-white bg-white-o-15">{{ substr(strtoupper(Auth::user()->name), 0, 1) }}</span>
                            </span>
                        </div>
                    </div>

                    <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
                        <div class="row row-paddingless">
                            <div class="col-6">
                                <a href="#" class="d-block py-10 px-5 text-center bg-hover-light border-right border-bottom">
                                    <span class="svg-icon svg-icon-3x svg-icon-success"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <path d="M7.62302337,5.30262097 C8.08508802,5.000107 8.70490146,5.12944838 9.00741543,5.59151303 C9.3099294,6.05357769 9.18058801,6.67339112 8.71852336,6.97590509 C7.03468892,8.07831239 6,9.95030239 6,12 C6,15.3137085 8.6862915,18 12,18 C15.3137085,18 18,15.3137085 18,12 C18,9.99549229 17.0108275,8.15969002 15.3875704,7.04698597 C14.9320347,6.73472706 14.8158858,6.11230651 15.1281448,5.65677076 C15.4404037,5.20123501 16.0628242,5.08508618 16.51836,5.39734508 C18.6800181,6.87911023 20,9.32886071 20,12 C20,16.418278 16.418278,20 12,20 C7.581722,20 4,16.418278 4,12 C4,9.26852332 5.38056879,6.77075716 7.62302337,5.30262097 Z" fill="#000000" fill-rule="nonzero"/>
                                            <rect fill="#000000" opacity="0.3" x="11" y="3" width="2" height="10" rx="1"/>
                                        </g>
                                    </svg></span>
                                    <span class="d-block text-dark-75 font-weight-bold font-size-h6 mt-2 mb-1">Logout</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="header-bottom">
        <div class=" container ">
			<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
				<div id="kt_header_menu" class="header-menu header-menu-left header-menu-mobile  header-menu-layout-default " >
					<ul class="menu-nav ">
                        <li class="menu-item {{ request()->is('admin-cms') ? 'menu-item-active' : '' }}"  aria-haspopup="true"><a  href="{{ url('admin-cms') }}" class="menu-link "><span class="menu-text">Dashboard</span></a></li>

                        <li class="menu-item menu-item-submenu menu-item-rel {{ request()->is('admin-cms/content/*') ? 'menu-item-active' : '' }}" data-menu-toggle="click" aria-haspopup="true"><a  href="javascript:;" class="menu-link menu-toggle">
                            <span class="menu-text">Content</span><span class="menu-desc"></span><i class="menu-arrow"></i></a>
                            <div class="menu-submenu menu-submenu-classic menu-submenu-left" >
                                <ul class="menu-subnav">
                                    <li class="menu-item {{ (request()->is('admin-cms/content/header-banner/*') || request()->is('admin-cms/content/header-banner')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                        <a href="{{ url('admin-cms/content/header-banner') }}" class="menu-link ">
                                            <i class="flaticon2-analytics-2 menu-icon"></i>
                                            <span class="menu-text">Header Banner</span>
                                        </a>
                                    </li>

                                    <li class="menu-item menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
                                        <a href="javascript:;" class="menu-link menu-toggle">
                                            <i class="flaticon2-information menu-icon"></i>
                                            <span class="menu-text">Faq</span><i class="menu-arrow"></i>
                                        </a>

                                        <div class="menu-submenu menu-submenu-classic menu-submenu-right" data-hor-direction="menu-submenu-right">
                                            <ul class="menu-subnav">
                                                <li class="menu-item " aria-haspopup="true"><a href="{{ url('admin-cms/content/faq/categories') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Categories</span></a></li>

                                                <li class="menu-item " aria-haspopup="true"><a href="{{ url('admin-cms/content/faq/questions') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Questions</span></a></li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="menu-item menu-item-submenu menu-item-rel {{ request()->is('admin-cms/products/*') ? 'menu-item-active' : '' }}" data-menu-toggle="click" aria-haspopup="true">
                            <a  href="javascript:;" class="menu-link menu-toggle">
                                <i class="flaticon2-tools-and-utensils                                menu-icon"></i>
                                <span class="menu-text">Products</span><span class="menu-desc"></span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="menu-submenu menu-submenu-classic menu-submenu-left" >
                                <ul class="menu-subnav">
                                    {{-- <li class="menu-item {{ (request()->is('admin-cms/products/groups/*') || request()->is('admin-cms/products/groups')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                        <a href="{{ url('admin-cms/products/groups') }}" class="menu-link ">
                                            <span class="menu-text">Groups</span>
                                        </a>
                                    </li> --}}
                                    <li class="menu-item {{ (request()->is('admin-cms/products/categories/*') || request()->is('admin-cms/products/categories')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                        <a href="{{ url('admin-cms/products/categories') }}" class="menu-link ">
                                            <span class="menu-text">Categories</span>
                                        </a>
                                    </li>
                                    <li class="menu-item {{ (request()->is('admin-cms/products/properties/*') || request()->is('admin-cms/products/properties')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                        <a href="{{ url('admin-cms/products/properties') }}" class="menu-link ">
                                            <span class="menu-text">Properties</span>
                                        </a>
                                    </li>
                                    <li class="menu-item {{ (request()->is('admin-cms/products/products/*') || request()->is('admin-cms/products/products')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                        <a href="{{ url('admin-cms/products/products') }}" class="menu-link ">
                                            <span class="menu-text">Products</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="menu-item menu-item-submenu menu-item-rel {{ request()->is('admin-cms/settings/*') ? 'menu-item-active' : '' }}" data-menu-toggle="click" aria-haspopup="true"><a  href="javascript:;" class="menu-link menu-toggle">
                            <i class="flaticon2-gear menu-icon"></i><span class="menu-text">Settings</span><span class="menu-desc"></span><i class="menu-arrow"></i></a>
                            <div class="menu-submenu menu-submenu-classic menu-submenu-left" >
                                <ul class="menu-subnav">
                                    <li class="menu-item {{ (request()->is('admin-cms/settings/roles/*') || request()->is('admin-cms/settings/roles')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                        <a href="{{ url('admin-cms/settings/roles') }}" class="menu-link ">
                                            <span class="menu-text">Roles</span>
                                        </a>
                                    </li>

                                    <li class="menu-item {{ (request()->is('admin-cms/settings/users/*') || request()->is('admin-cms/settings/users')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                        <a href="{{ url('admin-cms/settings/users') }}" class="menu-link ">
                                            <span class="menu-text">Users</span>
                                        </a>
                                    </li>

                                    <li class="menu-item {{ (request()->is('admin-cms/settings/pages/*') || request()->is('admin-cms/settings/pages')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                        <a href="{{ url('admin-cms/settings/pages') }}" class="menu-link ">
                                            <span class="menu-text">Pages</span>
                                        </a>
                                    </li>

                                    <li class="menu-item {{ (request()->is('admin-cms/settings/navbar/*') || request()->is('admin-cms/settings/navbar')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                        <a href="{{ url('admin-cms/settings/navbar') }}" class="menu-link ">
                                            <span class="menu-text">Navbar</span>
                                        </a>
                                    </li>

                                    <li class="menu-item {{ (request()->is('admin-cms/settings/translations/*') || request()->is('admin-cms/settings/translations')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                        <a href="{{ url('admin-cms/settings/translations') }}" class="menu-link ">
                                            <span class="menu-text">Translations</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
