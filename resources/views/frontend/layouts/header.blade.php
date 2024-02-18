<div class="@if(Request::path() == 'id' || Request::url() == 'en') header-home @else header @endif">
    <div class="container">
        <div class="row">
            <div class="col-4 col-md-6">
                <a href="{{ urlLocale('/') }}">
                    <img src="{{ asset('public/frontend/images/cibes_logo.svg') }}" alt="">
                </a>
            </div>
            <div class="col-8 col-md-6">
                <div class="text-end">
                    <ul class="menu main-menu">
                        <li>
                            <a href="{{ urlLocale('product') }}">{{ __('title.product') }}</a>
                            {{-- <div class="header-dropdown">

                            </div> --}}
                        </li>
                        <li><a href="#">{{ __('title.installation') }}</a></li>
                    </ul>
                    <a href="{{ urlLocale('') }}#contact_us" class="button-primary">{{ __('buttons.install_a_home_elevator') }}</a>
                    <a href="javascript:;" id="sidebarToggle" class="ms-3">
                        <img src="{{ asset('public/frontend/images/menu-burger.png') }}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="sidebar">

    <div class="sidebar-search">
        <div class="row">
            <div class="col-9">
                <div class="mb-3">
                    <input type="text" class="form-control" id="search" placeholder="Search">
                </div>
            </div>
            <div class="col-3 text-end">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="lang" data-bs-toggle="dropdown" aria-expanded="false">
                        EN
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="lang">
                        <li><a class="dropdown-item" href="#">ID</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="sidebar-menu">
        <div class="row">
            <div class="col">
                <ul class="menu">
                    <li><a href="#">About Us <img src="{{ asset('public/frontend/images/Arrow.png') }}" alt=""></a></li>
                    <li><a href="#">Product <img src="{{ asset('public/frontend/images/Arrow.png') }}" alt=""></a></a></li>
                    <li><a href="#">Installation <img src="{{ asset('public/frontend/images/Arrow.png') }}" alt=""></a></a></li>
                    <li><a href="#">Information Kit <img src="{{ asset('public/frontend/images/Arrow.png') }}" alt=""></a></a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="sidebar-info">
        <div class="row">
            <div class="col">
                <p>Get assistance from Our Lift Consultant!</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="alert alert-light" role="alert">
                    0812 2196 9005
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="alert alert-light" role="alert">
                    indo@cibeslift.com
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button class="button-orange w-100">Pasang lift rumah</button>
            </div>
        </div>
    </div>
</div>
