@extends('frontend.layouts.app')

@section('content')

    <div class="banner" style="background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ $product['product_id']['banner']['path'] ?? '#' }}');">
        <div class="container h-100">
            <div class="row h-100 justify-content-center text-center">
                <div class="col-12 col-md-8">
                    <div class="flex-middle" style="justify-content: center;">
                        <span class="banner-contain">
                            <h1 class="mb-4">{{ $product['name'] }}</h1>
                            <p>{{ $product['short_description'] }}</p>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="absolute-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-4 text-center"><a href="#" class="button-orange">Features</a></div>
                    <div class="col-12 col-md-4 text-center"><a href="#" class="button-orange">Specifications</a></div>
                    <div class="col-12 col-md-4 text-center"><a href="#" class="button-orange">Installation</a></div>
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
            <div class="row">
                @foreach ($product['product_id']['product_usp_id'] as $key => $val)
                    <div class="col-12 col-md-3 d-flex">
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
        </div>
    </div>

    @if (!empty($product['product_id']['product_highlight_id']))
        @foreach ($product['product_id']['product_highlight_id'] as $key => $val)
            @if ($key % 2 == 0)
                <div class="section" style="padding: 75px 0 0 0 !important">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <img src="{{ $val['image']['path'] ?? '#' }}" class="w-100" alt="">
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="h-100 flex-middle">
                                    <span>
                                        <h5 class="title-50-bold">{{ $val['product_highlight'][0]['name'] }}</h5>
                                        <p>{{ $val['product_highlight'][0]['description'] }}</p>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="section" style="padding: 75px 0 0 0 !important">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="h-100 flex-middle">
                                    <span>
                                        <h5 class="title-50-bold">{{ $val['product_highlight'][0]['name'] }}</h5>
                                        <p>{{ $val['product_highlight'][0]['description'] }}</p>
                                    </span>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <img src="{{ $val['image']['path'] ?? '#' }}" class="w-100" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endif

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h3 class="title-50-bold">{{ count($product['product_id']['product_customization_id']) }} Tier Customization</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        @php
                            $col = 'col-md-12';
                            if (count($product['product_id']['product_customization_id']) % 4 == 0) {
                                $col = 'col-md-3';
                            }else if (count($product['product_id']['product_customization_id']) % 3 == 0) {
                                $col = 'col-md-4';
                            }else if (count($product['product_id']['product_customization_id']) % 2 == 0) {
                                $col = 'col-md-6';
                            }
                        @endphp
                        @foreach ($product['product_id']['product_customization_id'] as $key => $val)
                            <div class="col-12 {{ $col }} text-center mb-4">
                                <div class="position-relative">
                                    <img src="{{ $val['image']['path'] }}" alt="" class="w-100">
                                    <div class="position-middle title-30-bold">{{ $val['product_customization'][0]['name'] }}</div>
                                </div>
                                <span class="d-block mt-5">
                                    <a href="javascript:;" data-fancybox data-src="#customization" class="button-orange">Learn More</a>
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-5 pe-5">
                    <h3 class="title-50-bold mb-5">Specification</h3>

                    <p class="title-25"><strong>Installation</strong> Indoor/Outdoor</p>

                    <p class="title-25"><b>Power supply 1</b> × 230 VAC/3 × 230 VAC/3 × 400 VAC, 50 Hz, 16 A, 3 × 2,5 mm²</p>

                    <p class="title-25"><b>Min Headroom</b> 2300 mm (full-height door)</p>

                    <p class="title-25"><b>Drive system</b> Screw and nut</p>

                    <p class="title-25"><b>Max number of stops</b> 6 Stops</p>

                    <p class="title-25"><b>Door configuration</b> Single access, open-through, adjacent</p>

                    <p class="title-25"><b>Rated Load</b> 500kg</p>

                    <p class="title-25"><b>Speed Max</b> 0.25 m/s</p>

                    <p class="title-25"><b>Lift Pit</b> 1200mm or 0mm with ramp</p>

                    <p class="title-25"><b>Max. Travel</b> 20m</p>

                    <p class="title-25"><b>Motor Power</b> 2.2kw</p>
                </div>

                <div class="col-md-2">
                    <img src="{{ $product['product_id']['specification_image']['path'] ?? '' }}" class="w-100" alt="">
                </div>

                <div class="col-12 col-md-5 ps-5">
                    <div class="flex-center h-100">
                        <span>
                            <h4 class="title-30-bold">{{ $product['name'] }} Sizes</h4>
                            <p class="title-20-regular">{!! $product['product_id']['product_specification']['size'] !!}</p>
                            <a href="#" class="button-orange">Get Full Size Here</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h3 class="title-50-bold">{{ $product['name'] }} Installation</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 col-md-3 text-center mb-4">
                            <div class="card-slider">
                                <span class="tag">Voyager</span>
                            </div>
                            <span>
                                <h5 class="title-30-bold">Garansi 5, 5, 15 Tahun</h5>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                            </span>
                        </div>
                        <div class="col-12 col-md-3 text-center mb-4">
                            <div class="card-slider">
                                <span class="tag">Voyager</span>
                            </div>
                            <span>
                                <h5 class="title-30-bold">Garansi 5, 5, 15 Tahun</h5>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                            </span>
                        </div>
                        <div class="col-12 col-md-3 text-center mb-4">
                            <div class="card-slider">
                                <span class="tag">Voyager</span>
                            </div>
                            <span>
                                <h5 class="title-30-bold">Garansi 5, 5, 15 Tahun</h5>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                            </span>
                        </div>
                        <div class="col-12 col-md-3 text-center mb-4">
                            <div class="card-slider">
                                <span class="tag">Voyager</span>
                            </div>
                            <span>
                                <h5 class="title-30-bold">Garansi 5, 5, 15 Tahun</h5>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card-standard bg-gray mb-4 bg-image" style="background-image: url('{{ asset('public/frontend/images/Cibes_ProductPage_V80LXPlus_02_110_010_0001 1.png') }}');">
                        <div class="card-standard_img card-standard_img_float_bottom_left position-relative">
                            <span>
                                <h4 class="c-white title-30-bold mb-4">Desain {{ $product['name'] }} Anda</h4>
                                <a href="#" class="button-orange">Design Here</a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card-standard bg-gray mb-4 bg-image" style="background-image: url('{{ asset('public/frontend/images/Cibes_ProductPage_V80LXPlus_02_110_010_0001 1.png') }}');">
                        <div class="card-standard_img card-standard_img_float_bottom_left position-relative">
                            <span>
                                <h4 class="c-white title-30-bold mb-4">Compare with Other Product</h4>
                                <a href="#" class="button-orange">Compare Here</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h5 class="title-50-bold">Ketahui Produk Lainnya</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-3">
                    <div class="card-standard card-standard-small bg-gray mb-4">
                        <div class="card-standard_img card-standard_img_float text-center">
                            <span>
                                <h4>Full Size Options</h4>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="card-standard card-standard-small bg-gray mb-4">
                        <div class="card-standard_img card-standard_img_float text-center">
                            <span>
                                <h4>Complete Specifications</h4>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="card-standard card-standard-small bg-gray mb-4">
                        <div class="card-standard_img card-standard_img_float text-center">
                            <span>
                                <h4>Complete Specifications</h4>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="card-standard card-standard-small bg-gray mb-4">
                        <div class="card-standard_img card-standard_img_float text-center">
                            <span>
                                <h4>Complete Specifications</h4>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8">
                    <span class="text-center">
                        <h5 class="title-50-bold">Punya Pertanyaan Seputar {{ $product['name'] }}?</h5>
                        <p class="mb-4">Isi form berikut ini dan Lift Consultant Kami Siap Membantu!</p>
                    </span>
                    <div class="card-form">
                        <form action="">
                            <div class="row mb-4">
                                <div class="col-12 col-md-6">
                                    <input class="form-control" type="text" placeholder="Name">
                                </div>
                                <div class="col-12 col-md-6">
                                    <input class="form-control" type="text" placeholder="Telepon">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-6">
                                    <input class="form-control" type="text" placeholder="Email">
                                </div>
                                <div class="col-12 col-md-3">
                                    <input class="form-control" type="text" placeholder="Kota">
                                </div>
                                <div class="col-12 col-md-3">
                                    <select class="form-select">
                                        <option selected>Jumlah Lantai</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-12">
                                    <textarea class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col text-center">
                                    <a href="" class="button-orange">Hubungi Saya</a>
                                </div>
                            </div>
                        </form>
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
                <div class="col-12 col-md-3 text-center" >
                    <img src="{{ asset('public/frontend/images/Cibes_ProductPage_V80LXPlus_02_110_010_0001 1.png') }}" class="w-100" alt="">
                </div>
                <div class="col-12 col-md-9">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="title-30-bold">Screwdrive</h5>
                            <p>Screwdrive bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="card-standard position-relative card-standard-smalls background-default bg-gray mb-4" style="background-image: url('{{ asset('public/frontend/images/Rectangle 10 (4).jpg') }}')">
                                <div class="card-standard_content card-standard_content_bottom text-center">
                                    <h5 class="title-20-bold c-white">Cibes Lift Indonesia HQ</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="card-standard position-relative card-standard-smalls background-default bg-gray mb-4" style="background-image: url('{{ asset('public/frontend/images/Rectangle 10 (4).jpg') }}')">
                                <div class="card-standard_content card-standard_content_bottom text-center">
                                    <h5 class="title-20-bold c-white">Cibes Lift Indonesia HQ</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="card-standard position-relative card-standard-smalls background-default bg-gray mb-4" style="background-image: url('{{ asset('public/frontend/images/Rectangle 10 (4).jpg') }}')">
                                <div class="card-standard_content card-standard_content_bottom text-center">
                                    <h5 class="title-20-bold c-white">Cibes Lift Indonesia HQ</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5 mb-3">
                        <div class="col-12 mb-4">
                            <h5 class="title-30-bold">Color Options</h5>
                        </div>
                        <div class="col-12">
                            <ul class="color-show">
                                <li>
                                    <div class="color-item">
                                        <span style="background-color: red;"></span>
                                        <label>January 4</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row mt-5 mb-3">
                        <div class="col-12 mb-4">
                            <h5 class="title-30-bold">Mood Wall Pattern Options</h5>
                        </div>
                        <div class="col-12">
                            <ul class="pattern-show">
                                <li>
                                    <div class="pattern-item">
                                        <span style="background-color: red;"></span>
                                        <label>Forest Pines</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
@endpush
