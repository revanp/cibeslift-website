@extends('frontend.layouts.app')

@section('content')

    <div class="banner" style="background-image: url('{{ $product['product_id']['banner']['path'] ?? '#' }}');">
        <div class="container h-100">
            <div class="row h-100 justify-content-center">
                <div class="col-12 col-md-8">
                    <div class="flex-center">
                        <span class="banner-contain">
                            <h1 class="mb-4">{{ $product['name'] }}</h1>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @foreach ($category->productCategoryId->productCategoryUspId as $key => $val)
        @if ($key % 2 == 0)
            <div class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <h5 class="title-50-bold">{{ $val->productCategoryUsp[0]->name }}</h5>
                            <p>{{ $val->productCategoryUsp[0]->description }}</p>
                        </div>
                        <div class="col-12 col-md-6">
                            <img src="{{ $val->image->path ?? '#' }}" class="w-100" alt="">
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <img src="{{ $val->image->path ?? '#' }}" class="w-100" alt="">
                        </div>
                        <div class="col-12 col-md-6">
                            <h5 class="title-50-bold">{{ $val->productCategoryUsp[0]->name }}</h5>
                            <p>{{ $val->productCategoryUsp[0]->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach --}}

    {{-- @foreach ($category->productCategoryId->productId as $key => $val)
        @if ($key % 2 == 0)
            <div class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-4 text-center">
                            <img src="{{ $val->spesificationImage->path ?? '#' }}" alt="">
                            <p class="title-20-bold mt-3">{{ $val->product[0]->name }}</p>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="flex-center">
                                <span>
                                    <h4 class="title-50-bold">{{ $val->product[0]->page_title }}</h4>
                                    <p>{{ $val->product[0]->description }}</p>
                                    <a href="#" class="button-orange">{{ $val->product[0]->name }}</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-8">
                            <div class="flex-center">
                                <span>
                                    <h4 class="title-50-bold">{{ $val->product[0]->page_title }}</h4>
                                    <p>{{ $val->product[0]->description }}</p>
                                    <a href="#" class="button-orange">{{ $val->product[0]->name }}</a>
                                </span>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 text-center">
                            <img src="{{ $val->spesificationImage->path ?? '#' }}" alt="">
                            <p class="title-20-bold mt-3">{{ $val->product[0]->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach --}}

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h3 class="title-50-bold">3 Tier Customization</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    <a href="#">
                        <img src="{{ asset('public/frontend/images/Group 124.png') }}" alt="">
                    </a>
                </div>
                <div class="col-12 col-md-4">
                    <a href="#">
                        <img src="{{ asset('public/frontend/images/Group 125.png') }}" alt="">
                    </a>
                </div>
                <div class="col-12 col-md-4">
                    <a href="#">
                        <img src="{{ asset('public/frontend/images/Group 126.png') }}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h5 class="title-50-bold">Sistem Keamanan Terkini</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-md-4">
                    <a href="">
                        <div class="card-standard bg-gray mb-4">
                            <div class="card-standard_img"></div>
                            <div class="card-standard_content">
                                <h5 class="title-20-bold">Screw Drive Technology</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4">
                    <a href="">
                        <div class="card-standard bg-gray mb-4">
                            <div class="card-standard_img"></div>
                            <div class="card-standard_content">
                                <h5 class="title-20-bold">European Standard Certified</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4">
                    <a href="">
                        <div class="card-standard bg-gray mb-4">
                            <div class="card-standard_img"></div>
                            <div class="card-standard_content">
                                <h5 class="title-20-bold">European Standard Certified</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4">
                    <a href="">
                        <div class="card-standard bg-gray mb-4">
                            <div class="card-standard_img"></div>
                            <div class="card-standard_content">
                                <h5 class="title-20-bold">European Standard Certified</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4">
                    <a href="">
                        <div class="card-standard bg-gray mb-4">
                            <div class="card-standard_img"></div>
                            <div class="card-standard_content">
                                <h5 class="title-20-bold">European Standard Certified</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4">
                    <a href="">
                        <div class="card-standard bg-gray mb-4">
                            <div class="card-standard_img"></div>
                            <div class="card-standard_content">
                                <h5 class="title-20-bold">European Standard Certified</h5>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="section background-default" style="background-image: url('{{ asset('public/frontend/images/Banner---Homepage-Website.jpg') }}');"> 
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h5 class="title-50-bold">Smart Control Panel</h5>
                    <p>Lift Rumah Cibes dapat dikustomisasi sesuai dengan selera Anda. Kami memiliki banyak pilihan warna, material, maupun fitur. </p>
                </div>
                <div class="col-12 col-md-6">
                </div>
            </div>
        </div>
    </div>

    <div class="section background-default" style="background-image: url('{{ asset('public/frontend/images/Banner---Homepage-Website.jpg') }}');"> 
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                </div>
                <div class="col-12 col-md-6">
                    <h5 class="title-50-bold">Smart Control Panel+</h5>
                    <p>Lift Rumah Cibes dapat dipasang dengan mudah. Karena tidak memerlukan pit dan ruang mesin, dan juga sudah dilengkapi dengan shaft bawaan.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h5 class="title-50-bold">F.A.Q</h5>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-md-8">
                    <div class="accordion">
                        <div class="accordion-item">
                          <button id="accordion-button-1" aria-expanded="false"><span class="accordion-title">Why is the moon sometimes out during the day?</span><span class="icon" aria-hidden="true"></span></button>
                          <div class="accordion-content">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Elementum sagittis vitae et leo duis ut. Ut tortor pretium viverra suspendisse potenti.</p>
                          </div>
                        </div>
                        <div class="accordion-item">
                          <button id="accordion-button-2" aria-expanded="false"><span class="accordion-title">Why is the sky blue?</span><span class="icon" aria-hidden="true"></span></button>
                          <div class="accordion-content">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Elementum sagittis vitae et leo duis ut. Ut tortor pretium viverra suspendisse potenti.</p>
                          </div>
                        </div>
                        <div class="accordion-item">
                          <button id="accordion-button-3" aria-expanded="false"><span class="accordion-title">Will we ever discover aliens?</span><span class="icon" aria-hidden="true"></span></button>
                          <div class="accordion-content">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Elementum sagittis vitae et leo duis ut. Ut tortor pretium viverra suspendisse potenti.</p>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <hr>
    </div>

    <div class="section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h5 class="title-50-bold">Ketahui Produk Lainnya</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card-standard bg-gray mb-4">
                        <div class="card-standard_img card-standard_img_float">
                            <span>
                                <h4>Cibes Air Series</h4>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card-standard bg-gray mb-4">
                        <div class="card-standard_img card-standard_img_float">
                            <span>
                                <h4>Cibes Classics</h4>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
@endpush
