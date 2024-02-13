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

    <div class="section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 col-md-6">
                    <div class="flex-middle">
                        <span>
                            <h4 class="title-50-bold">{{ $product['page_title'] }}</h4>
                        </span>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <p>{{ $product['description'] }}</p>
                </div>
            </div>

            @if (!empty($product['product_id']['product_usp_id']))
                <div class="row">
                    @foreach ($product['product_id']['product_usp_id'] as $key => $val)
                        <div class="col-12 col-md-3">
                            <div class="card card-usp">
                                <img src="{{ $val['image']['path'] ?? '#' }}" width="50px" class="mb-3" alt="">
                                <div class="d-block">
                                    <h5 class="title-30-bold">{{ $val['product_usp'][0]['name'] }}</h5>
                                    <p>{{ $val['product_usp'][0]['description'] ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    @foreach ($product['product_id']['child'] as $key => $val)
        @if ($key % 2 == 0)
            <div class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-4 text-center">
                            <img src="{{ $val['specification_image']['path'] ?? '#' }}" alt="">
                            <p class="title-20-bold mt-3">{{ $val['product'][0]['name'] }}</p>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="flex-center">
                                <span>
                                    <h4 class="title-50-bold">{{ $val['product'][0]['page_title'] ?? '' }}</h4>
                                    <p>{{ $val['product'][0]['description'] }}</p>
                                    <a href="#" class="button-orange">{{ $val['product'][0]['name'] }}</a>
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
                                    <h4 class="title-50-bold">{{ $val['product'][0]['page_title'] ?? '' }}</h4>
                                    <p>{{ $val['product'][0]['description'] }}</p>
                                    <a href="#" class="button-orange">{{ $val['product'][0]['name'] }}</a>
                                </span>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 text-center">
                            <img src="{{ $val['specification_image']['path'] ?? '#' }}" alt="">
                            <p class="title-20-bold mt-3">{{ $val['product'][0]['name'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h3 class="title-50-bold">3 Tier Customization</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    <a href="javascript:;" data-fancybox data-src="#customization">
                        <img src="{{ asset('public/frontend/images/Group 124.png') }}" alt="">
                    </a>
                </div>
                <div class="col-12 col-md-4">
                    <a href="javascript:;" data-fancybox data-src="#customization">
                        <img src="{{ asset('public/frontend/images/Group 125.png') }}" alt="">
                    </a>
                </div>
                <div class="col-12 col-md-4">
                    <a href="javascript:;" data-fancybox data-src="#customization">
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
                @foreach ($product['product_id']['product_id_has_product_technology_id'] as $key => $val)
                    <div class="col-6 col-md-4">
                        <a href="">
                            <div class="card-standard bg-gray mb-4">
                                <div class="card-standard_img" style="background-image: url('{{ $val['product_technology_id']['image']['path'] ?? '#' }}');"></div>
                                <div class="card-standard_content">
                                    <h5 class="title-20-bold">{{ $val['product_technology_id']['product_technology'][0]['name'] }}</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @foreach ($product['product_id']['product_feature_id'] as $key => $val)
        @if ($key % 2 == 0)
            <div class="section background-default" style="background-image: url('{{ $val['image']['path'] ?? '#' }}');">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <h5 class="title-50-bold">{{ $val['product_feature'][0]['name'] }}</h5>
                            <p>{{ $val['product_feature'][0]['description'] }}</p>
                        </div>
                        <div class="col-12 col-md-6">
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="section background-default" style="background-image: url('{{ $val['image']['path'] ?? '#' }}');">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-6">
                        </div>
                        <div class="col-12 col-md-6">
                            <h5 class="title-50-bold">{{ $val['product_feature'][0]['name'] }}</h5>
                            <p>{{ $val['product_feature'][0]['description'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    @if (!empty($product['product_id']['product_id_has_faq_id']))
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
                            @foreach ($product['product_id']['product_id_has_faq_id'] as $key => $val)
                                <div class="accordion-item">
                                    <button id="accordion-button-{{ $key }}" aria-expanded="false"><span class="accordion-title">{{ $val['faq_id']['faq'][0]['title'] }}</span><span class="icon" aria-hidden="true"></span></button>
                                    <div class="accordion-content">
                                        <p>{{ $val['faq_id']['faq'][0]['description'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

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

    <div id="customization" style="display: none; min-width: 1200px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-7 text-center mb-5">
                    <h5 class="title-50-bold">3 Tier Customization</h5>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-md-6">
                    <div class="card-standard bg-gray background-default text-center" style="background-image: url('{{ asset('public/frontend/images/dawdwafa.jpg') }}');">
                        <div class="card-standard_img"></div>
                        <div class="card-standard_content">
                            <h5 class="title-30-bold c-white">Cibes Air</h5>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <h5 class="title-30-bold">Screwdrive</h5>
                    <p>Screwdrive bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla</p>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
@endpush
