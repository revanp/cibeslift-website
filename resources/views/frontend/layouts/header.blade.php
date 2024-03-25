@php
    $headerClass = 'header';
    if(Route::current()->getName() == 'home'){
        $headerClass = 'header-home';
    }else if(Route::current()->getName() == 'product.category'){
        $headerClass = 'header-home';
    }
@endphp
<div class="{{ $headerClass }}">
    <div class="container">
        <div class="row">
            <div class="col-4 col-md-6">
                <a href="{{ urlLocale('/') }}">
                    {{-- <img src="{{ asset('public/frontend/images/cibes_logo.svg') }}" alt=""> --}}
                </a>
            </div>
            <div class="col-8 col-md-6">
                <div class="text-end">
                    <div class="main-menu d-inline-block">
                        <a href="javascript:;" class="closeMenu d-inline-block d-lg-none">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.9998 6C17.8123 5.81253 17.558 5.70721 17.2928 5.70721C17.0277 5.70721 16.7733 5.81253 16.5858 6L11.9998 10.586L7.41382 6C7.22629 5.81253 6.97198 5.70721 6.70682 5.70721C6.44165 5.70721 6.18735 5.81253 5.99982 6C5.81235 6.18753 5.70703 6.44184 5.70703 6.707C5.70703 6.97217 5.81235 7.22647 5.99982 7.414L10.5858 12L5.99982 16.586C5.81235 16.7735 5.70703 17.0278 5.70703 17.293C5.70703 17.5582 5.81235 17.8125 5.99982 18C6.18735 18.1875 6.44165 18.2928 6.70682 18.2928C6.97198 18.2928 7.22629 18.1875 7.41382 18L11.9998 13.414L16.5858 18C16.7733 18.1875 17.0277 18.2928 17.2928 18.2928C17.558 18.2928 17.8123 18.1875 17.9998 18C18.1873 17.8125 18.2926 17.5582 18.2926 17.293C18.2926 17.0278 18.1873 16.7735 17.9998 16.586L13.4138 12L17.9998 7.414C18.1873 7.22647 18.2926 6.97217 18.2926 6.707C18.2926 6.44184 18.1873 6.18753 17.9998 6Z" fill="white"/>
                            </svg>                                
                        </a>
                        <ul class="menu">
                            <li class="has-child">
                                <a href="javascript:;">{{ __('title.product') }} <p class="d-inline-block">v</p></a>
                                <div class="header-dropdown">
                                    <a href="javascript:;" class="closeMenus">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M17.9998 6C17.8123 5.81253 17.558 5.70721 17.2928 5.70721C17.0277 5.70721 16.7733 5.81253 16.5858 6L11.9998 10.586L7.41382 6C7.22629 5.81253 6.97198 5.70721 6.70682 5.70721C6.44165 5.70721 6.18735 5.81253 5.99982 6C5.81235 6.18753 5.70703 6.44184 5.70703 6.707C5.70703 6.97217 5.81235 7.22647 5.99982 7.414L10.5858 12L5.99982 16.586C5.81235 16.7735 5.70703 17.0278 5.70703 17.293C5.70703 17.5582 5.81235 17.8125 5.99982 18C6.18735 18.1875 6.44165 18.2928 6.70682 18.2928C6.97198 18.2928 7.22629 18.1875 7.41382 18L11.9998 13.414L16.5858 18C16.7733 18.1875 17.0277 18.2928 17.2928 18.2928C17.558 18.2928 17.8123 18.1875 17.9998 18C18.1873 17.8125 18.2926 17.5582 18.2926 17.293C18.2926 17.0278 18.1873 16.7735 17.9998 16.586L13.4138 12L17.9998 7.414C18.1873 7.22647 18.2926 6.97217 18.2926 6.707C18.2926 6.44184 18.1873 6.18753 17.9998 6Z" fill="black"/>
                                        </svg>                                
                                    </a>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-12">
                                                <ul class="nav nav-tabs">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="tab1" data-bs-toggle="tab" href="#tab-content1">Cibes V-Series</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="tab2" data-bs-toggle="tab" href="#tab-content2">Cibes Air</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="tab3" data-bs-toggle="tab" href="#tab-content3">Cibes Classic</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="tab4" data-bs-toggle="tab" href="#tab-content4">Cibes S-Series</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="tab5" data-bs-toggle="tab" href="#tab-content5">Cibes Voyager</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane fade show active" id="tab-content1">
                                                        <div class="row">
                                                            <div class="col-12 col-md-4 mb-3">
                                                                <a href="#">
                                                                    <div class="card-background" style="height: 350px;text-align:left;background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://placehold.co/400')">
                                                                        <div class="card-background-content">
                                                                            <h3 class="c-white title-25-bold">Cibes V90</h3>
                                                                            <p class="c-white">Lift Rumah Full Cabin dengan Shaft</p>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                            <div class="col-12 col-md-4 mb-3">
                                                                <a href="#">
                                                                    <div class="card-background" style="height: 350px;text-align:left;background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://placehold.co/400')">
                                                                        <div class="card-background-content">
                                                                            <h3 class="c-white title-25-bold">Cibes V80</h3>
                                                                            <p class="c-white">Lift Rumah Platform</p>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                            <div class="col-12 col-md-4 mb-3">
                                                                <a href="#">
                                                                    <div class="card-background" style="height: 350px;text-align:left;background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://placehold.co/400')">
                                                                        <div class="card-background-content">
                                                                            <h3 class="c-white title-25-bold">Cibes V70</h3>
                                                                            <p class="c-white">Lift Rumah Full Cabin tanpa Shaft</p>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="tab-content2">
                                                        <div class="row">
                                                            <div class="col-12 col-md-4 mb-3">
                                                                <a href="#">
                                                                    <div class="card-background" style="height: 350px;text-align:left;background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://placehold.co/400')">
                                                                        <div class="card-background-content">
                                                                            <h3 class="c-white title-25-bold">Cibes Air Wood</h3>
                                                                            <p class="c-white">Lift Rumah Platform Panel Kayu</p>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                            <div class="col-12 col-md-4 mb-3">
                                                                <a href="#">
                                                                    <div class="card-background" style="height: 350px;text-align:left;background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://placehold.co/400')">
                                                                        <div class="card-background-content">
                                                                            <h3 class="c-white title-25-bold">Cibes Air Metal</h3>
                                                                            <p class="c-white">Lift Rumah Platform Panel Metal</p>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                            <div class="col-12 col-md-4 mb-3">
                                                                <a href="#">
                                                                    <div class="card-background" style="height: 350px;text-align:left;background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://placehold.co/400')">
                                                                        <div class="card-background-content">
                                                                            <h3 class="c-white title-25-bold">Cibes Air Linen</h3>
                                                                            <p class="c-white">Lift Rumah Platform Panel Linen</p>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="tab-content3">
                                                        <div class="row">
                                                            <div class="col-12 col-md-6 mb-3">
                                                                <a href="#">
                                                                    <div class="card-background" style="height: 350px;text-align:left;background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://placehold.co/400')">
                                                                        <div class="card-background-content">
                                                                            <h3 class="c-white title-25-bold">Cibes A5000</h3>
                                                                            <p class="c-white">Lift Rumah Platform Aksesibilitas</p>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                            <div class="col-12 col-md-6 mb-3">
                                                                <a href="#">
                                                                    <div class="card-background" style="height: 350px;text-align:left;background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://placehold.co/400')">
                                                                        <div class="card-background-content">
                                                                            <h3 class="c-white title-25-bold">Cibes A4000</h3>
                                                                            <p class="c-white">Lift Rumah Platform Hemat Ruang</p>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="tab-content4">
                                                        <div class="row">
                                                            <div class="col-12 col-md-3 mb-3">
                                                                <a href="#">
                                                                    <div class="card-background" style="height: 350px;text-align:left;background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://placehold.co/400')">
                                                                        <div class="card-background-content">
                                                                            <h3 class="c-white title-25-bold">Cibes S85</h3>
                                                                            <p class="c-white">Lift Rumah Platform High-Back</p>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                            <div class="col-12 col-md-3 mb-3">
                                                                <a href="#">
                                                                    <div class="card-background" style="height: 350px;text-align:left;background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://placehold.co/400')">
                                                                        <div class="card-background-content">
                                                                            <h3 class="c-white title-25-bold">Cibes S80</h3>
                                                                            <p class="c-white">Lift Rumah Platform Metal</p>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                            <div class="col-12 col-md-3 mb-3">
                                                                <a href="#">
                                                                    <div class="card-background" style="height: 350px;text-align:left;background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://placehold.co/400')">
                                                                        <div class="card-background-content">
                                                                            <h3 class="c-white title-25-bold">Cibes Alto</h3>
                                                                            <p class="c-white">Platform High-Back Fungsional</p>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                            <div class="col-12 col-md-3 mb-3">
                                                                <a href="#">
                                                                    <div class="card-background" style="height: 350px;text-align:left;background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://placehold.co/400')">
                                                                        <div class="card-background-content">
                                                                            <h3 class="c-white title-25-bold">Cibes Uno</h3>
                                                                            <p class="c-white">Lift Platform Fungsional</p>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="tab-content5">
                                                        <div class="row justify-content-center">
                                                            <div class="col-12 col-md-5 mb-3">
                                                                <a href="#">
                                                                    <div class="card-background" style="height: 350px;text-align:left;background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://placehold.co/400')">
                                                                        <div class="card-background-content">
                                                                            <h3 class="c-white title-25-bold">Cibes Voyager</h3>
                                                                            <p class="c-white">Lift Rumah Platform Fleksibel</p>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li><a href="#">{{ __('title.installation') }}</a></li>
                        </ul>
                        <a href="{{ urlLocale('') }}#contact_us" class="button-primary">{{ __('buttons.install_a_home_elevator') }}</a>
                    </div>
                    <a href="javascript:;" class="menuToggle d-inline-block d-lg-none">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22.9565 10.9565H1.04346C0.467168 10.9565 0 11.4237 0 12C0 12.5763 0.467168 13.0435 1.04346 13.0435H22.9565C23.5328 13.0435 24 12.5763 24 12C24 11.4237 23.5328 10.9565 22.9565 10.9565Z" fill="white"/>
                            <path d="M1.04346 5.73914H22.9565C23.5328 5.73914 24 5.27198 24 4.69568C24 4.11939 23.5328 3.65222 22.9565 3.65222H1.04346C0.467168 3.65222 0 4.11939 0 4.69568C0 5.27198 0.467168 5.73914 1.04346 5.73914Z" fill="white"/>
                            <path d="M22.9565 18.2609H1.04346C0.467168 18.2609 0 18.7281 0 19.3044C0 19.8807 0.467168 20.3478 1.04346 20.3478H22.9565C23.5328 20.3478 24 19.8807 24 19.3044C24 18.7281 23.5328 18.2609 22.9565 18.2609Z" fill="white"/>
                        </svg>                            
                    </a>
                    <a href="javascript:;" id="sidebarToggle" class="ms-3">
                        <img src="{{ asset('public/frontend/images/menu-burger.png') }}" alt="" style="width: 40px;">
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
