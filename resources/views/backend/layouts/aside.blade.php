<div class="aside aside-left  aside-fixed  d-flex flex-column flex-row-auto"  id="kt_aside">
    <div class="brand flex-column-auto " id="kt_brand">
		<a href="{{ url('admin-cms') }}" class="brand-logo">
            <img alt="Logo" src="{{ asset('public/backend/media/logos/cibes_logo.svg') }}" class="max-h-35px"/>
        </a>
    </div>

    <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
        <div id="kt_aside_menu" class="aside-menu my-4 " data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500" >
            <ul class="menu-nav ">
                <li class="menu-item {{ request()->is('admin-cms') ? 'menu-item-active' : '' }}"  aria-haspopup="true">
                    <a  href="{{ url('admin-cms') }}" class="menu-link ">
                        <span class="menu-icon la la-dashboard icon-xl"></span>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>

                <li class="menu-section ">
                    <h4 class="menu-text">Content</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>

                <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="menu-icon la la-home icon-xl"></span>
                        <span class="menu-text">Home</span>

                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu " kt-hidden-height="200" style="">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li class="menu-item  menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">Home</span>
                                </span>
                            </li>

                            <li class="menu-item " aria-haspopup="true"><a href="{{ url('admin-cms/content/home/header-banner') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Header Banner</span></a></li>

                            <li class="menu-item " aria-haspopup="true"><a href="{{ url('admin-cms/content/home/video') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Video</span></a></li>

                            <li class="menu-item " aria-haspopup="true"><a href="{{ url('admin-cms/content/home/home-menu-section') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Menu Section</span></a></li>

                            <li class="menu-item " aria-haspopup="true"><a href="{{ url('admin-cms/content/home/why-cibes') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Why Cibes</span></a></li>

                            <li class="menu-item " aria-haspopup="true"><a href="{{ url('admin-cms/content/home/company-vision') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Company Vision</span></a></li>

                            <li class="menu-item " aria-haspopup="true"><a href="{{ url('admin-cms/content/home/testimonial') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Testimonial</span></a></li>
                        </ul>
                    </div>
                </li>

                <li class="menu-item menu-item-submenu menu-item-open" aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="menu-icon la la-building icon-xl"></span>
                        <span class="menu-text">About Us</span>

                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu " kt-hidden-height="200" style="">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li class="menu-item  menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">About Us</span>
                                </span>
                            </li>

                            <li class="menu-item " aria-haspopup="true"><a href="{{ url('admin-cms/content/about-us/history') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">History</span></a></li>

                            <li class="menu-item " aria-haspopup="true"><a href="{{ url('admin-cms/content/about-us/nation') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Nation</span></a></li>

                            <li class="menu-item " aria-haspopup="true"><a href="{{ url('admin-cms/content/about-us/manufacture') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Manufacture</span></a></li>

                            <li class="menu-item " aria-haspopup="true"><a href="{{ url('admin-cms/content/about-us/highlight') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Highlight</span></a></li>

                            <li class="menu-item " aria-haspopup="true"><a href="{{ url('admin-cms/content/about-us/banner') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Banner</span></a></li>

                            <li class="menu-item " aria-haspopup="true"><a href="{{ url('admin-cms/content/about-us/showroom') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Showroom</span></a></li>

                            <li class="menu-item new-item-popup" data-toggle="tooltip" data-placement="top" title="Check me for new updates!" aria-haspopup="true"><a href="{{ url('admin-cms/content/about-us/aftersales') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Aftersales</span></a></li>
                        </ul>
                    </div>
                </li>

                <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="menu-icon la la-question icon-xl"></span>
                        <span class="menu-text">FAQ</span>

                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu " kt-hidden-height="200" style="">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li class="menu-item  menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">FAQ</span>
                                </span>
                            </li>

                            <li class="menu-item " aria-haspopup="true"><a href="{{ url('admin-cms/content/faq/categories') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Categories</span></a></li>

                            <li class="menu-item " aria-haspopup="true"><a href="{{ url('admin-cms/content/faq/questions') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Questions</span></a></li>
                        </ul>
                    </div>
                </li>

                <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="menu-icon la la-newspaper-o icon-xl"></span>
                        <span class="menu-text">News</span>

                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu " kt-hidden-height="200" style="">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li class="menu-item  menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">News</span>
                                </span>
                            </li>

                            <li class="menu-item " aria-haspopup="true"><a href="{{ url('admin-cms/content/news/categories') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Categories</span></a></li>

                            <li class="menu-item " aria-haspopup="true"><a href="{{ url('admin-cms/content/news/news') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">News</span></a></li>
                        </ul>
                    </div>
                </li>

                <li class="menu-section ">
                    <h4 class="menu-text">Product</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>

                <li class="menu-item {{ (request()->is('admin-cms/products/technologies/*') || request()->is('admin-cms/products/technologies')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
                    <a href="{{ url('admin-cms/products/technologies') }}" class="menu-link ">
                        <span class="menu-icon la la-list icon-xl"></span>
                        <span class="menu-text">Technologies</span>
                    </a>
                </li>

                <li class="menu-item {{ (request()->is('admin-cms/products/european-standard/*') || request()->is('admin-cms/products/european-standard')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
                    <a href="{{ url('admin-cms/products/european-standard') }}" class="menu-link ">
                        <span class="menu-icon la la-globe-europe icon-xl"></span>
                        <span class="menu-text">European Standard</span>
                    </a>
                </li>

                <li class="menu-item {{ (request()->is('admin-cms/products/products/*') || request()->is('admin-cms/products/products')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
                    <a href="{{ url('admin-cms/products/products') }}" class="menu-link ">
                        <span class="menu-icon la la-boxes icon-xl"></span>
                        <span class="menu-text">Products</span>
                    </a>
                </li>

                <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="menu-icon la la-code-branch icon-xl"></span>
                        <span class="menu-text">Installations</span>

                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu " kt-hidden-height="200" style="">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li class="menu-item  menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">Installations</span>
                                </span>
                            </li>

                            <li class="menu-item " aria-haspopup="true"><a href="{{ url('admin-cms/products/installations/master') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Master Data</span></a></li>

                            <li class="menu-item " aria-haspopup="true"><a href="{{ url('admin-cms/products/installations/installations') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Installations</span></a></li>
                        </ul>
                    </div>
                </li>

                <li class="menu-section ">
                    <h4 class="menu-text">Settings</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>

                <li class="menu-item {{ (request()->is('admin-cms/settings/roles/*') || request()->is('admin-cms/settings/roles')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
                    <a href="{{ url('admin-cms/settings/roles') }}" class="menu-link ">
                        <span class="menu-icon la la-user-tag icon-xl"></span>
                        <span class="menu-text">Roles</span>
                    </a>
                </li>

                <li class="menu-item {{ (request()->is('admin-cms/settings/users/*') || request()->is('admin-cms/settings/users')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
                    <a href="{{ url('admin-cms/settings/users') }}" class="menu-link ">
                        <span class="menu-icon la la-user icon-xl"></span>
                        <span class="menu-text">Users</span>
                    </a>
                </li>

                <li class="menu-item {{ (request()->is('admin-cms/settings/pages/*') || request()->is('admin-cms/settings/pages')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
                    <a href="{{ url('admin-cms/settings/pages') }}" class="menu-link ">
                        <span class="menu-icon la la-file icon-xl"></span>
                        <span class="menu-text">Pages</span>
                    </a>
                </li>

                <li class="menu-item {{ (request()->is('admin-cms/settings/navbar/*') || request()->is('admin-cms/settings/navbar')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
                    <a href="{{ url('admin-cms/settings/navbar') }}" class="menu-link ">
                        <span class="menu-icon la la-list-ul icon-xl"></span>
                        <span class="menu-text">Navbar</span>
                    </a>
                </li>

                <li class="menu-item {{ (request()->is('admin-cms/settings/translations/*') || request()->is('admin-cms/settings/translations')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
                    <a href="{{ url('admin-cms/settings/translations') }}" class="menu-link ">
                        <span class="menu-icon la la-exchange-alt icon-xl"></span>
                        <span class="menu-text">Translations</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
