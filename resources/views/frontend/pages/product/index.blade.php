@extends('frontend.layouts.app')

@section('content')

    @foreach ($products as $key => $val)
        @if ($val['product_id']['product_summary_type'] == 0)
            <div class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center mb-5">
                            <h3 class="title-50-bold">{{ $val['name'] }}</h3>
                            <p class="title-22-bold">{{ $val['short_description'] }}</p>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($val['product_id']['child'] as $key2 => $val2)
                            <div class="col-12 col-md-4">
                                <div class="card-standard bg-gray mb-4">
                                    <div class="card-standard_img card-standard_img_float text-center" style="background: url('{{ $val2['thumbnail']['path'] }}'); background-repeat: no-repeat; background-size: cover;">
                                        <span>
                                            <h4>{{ $val2['product'][0]['name'] }}</h4>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <a href="{{ urlLocale('product/'.$val['slug']) }}" class="button-orange">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        @elseif ($val['product_id']['product_summary_type'] == 1)
            <div class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="flex-middle">
                                <span>
                                    <h4 class="title-50-bold">{{ $val['name'] }}</h4>
                                    <p class="mb-5">{{ $val['short_description'] }}</p>
                                    <a href="#" class="button-orange">Learn More</a>
                                </span>
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="text-center d-inline-block">
                                <img src="{{ $val['product_id']['product_summary_image']['path'] }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card-bg-img has-overlay" style="background-image: url('{{ asset('public/frontend/images/Banner---Homepage-Website.jpg') }}');">
                        <div class="card-bg-img-content">
                            <span>
                                <h4 class="title-50-bold c-white">Cibes Classics</h4>
                                <p class="c-white d-block mb-5">Old But Gold</p>
                                <a href="#" class="button-orange">Learn More</a>
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
                <div class="col-12">
                    <div class="card-bg-img" style="background-image: url('{{ asset('public/frontend/images/Cibes Voyager.png') }}');">
                        <div class="card-bg-img-content">
                            <span>
                                <h4 class="title-100-bold c-black">CIBES VOYAGER</h4>
                                <p class="c-black d-block mb-5">LINTASI GALAXY</p>
                                <a href="#" class="button-orange">Learn More</a>
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
                <div class="col-12 text-center mb-5">
                    <h3 class="title-50-bold">Cibes S-Series</h3>
                    <p class="title-22-bold">Lift Valing Oke</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card-standard bg-gray mb-4">
                        <div class="card-standard_img card-standard_img_float text-center">
                            <span>
                                <h4>Cibes Air Series</h4>
                                <p>Valing Simpel</p>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card-standard bg-gray mb-4">
                        <div class="card-standard_img card-standard_img_float text-center">
                            <span>
                                <h4>Cibes Air Series</h4>
                                <p>Valing Simpel</p>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <a href="#" class="button-orange">Learn More</a>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h3 class="title-50-bold">Teknologi Lift Rumah Cibes</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 col-md-4 text-center mb-5">
                            <div class="icon-rounded" style="background-image: url('{{ asset('public/frontend/images/Cibes Voyager.png') }}');"></div>
                            <span>
                                <h5 class="title-30-bold">Screwdrive</h5>
                            </span>
                        </div>
                        <div class="col-12 col-md-4 text-center mb-5">
                            <div class="icon-rounded" style="background-image: url('{{ asset('public/frontend/images/Cibes Voyager.png') }}');"></div>
                            <span>
                                <h5 class="title-30-bold">Garansi 5, 5, 15 Tahun</h5>
                            </span>
                        </div>
                        <div class="col-12 col-md-4 text-center mb-5">
                            <div class="icon-rounded" style="background-image: url('{{ asset('public/frontend/images/Cibes Voyager.png') }}');"></div>
                            <span>
                                <h5 class="title-30-bold">Garansi 5, 5, 15 Tahun</h5>
                            </span>
                        </div>
                        <div class="col-12 col-md-4 text-center mb-5">
                            <div class="icon-rounded" style="background-image: url('{{ asset('public/frontend/images/Cibes Voyager.png') }}');"></div>
                            <span>
                                <h5 class="title-30-bold">Garansi 5, 5, 15 Tahun</h5>
                            </span>
                        </div>
                        <div class="col-12 col-md-4 text-center mb-5">
                            <div class="icon-rounded" style="background-image: url('{{ asset('public/frontend/images/Cibes Voyager.png') }}');"></div>
                            <span>
                                <h5 class="title-30-bold">Garansi 5, 5, 15 Tahun</h5>
                            </span>
                        </div>
                        <div class="col-12 col-md-4 text-center mb-5">
                            <div class="icon-rounded" style="background-image: url('{{ asset('public/frontend/images/Cibes Voyager.png') }}');"></div>
                            <span>
                                <h5 class="title-30-bold">Garansi 5, 5, 15 Tahun</h5>
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
                <div class="col-12 text-center mb-5">
                    <h5 class="title-50-bold">European Standard</h5>
                    <p>Keamanan Lift Cibes Sudah Sesuai dengan Standar Keamanan Eropa</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="card-standard bg-gray mb-4 bg-image" style="background-image: url('{{ asset('public/frontend/images/Cibes_ProductPage_V80LXPlus_02_110_010_0001 1.png') }}');">
                        <div class="card-standard_img card-standard_img_float_bottom_left position-relative">
                            <span>
                                <h4 class="c-white">Cibes V-Series</h4>
                                <p class="c-white title-18-reguler">Bersertifikat LEvel Integrity 3 jadi lebih aman bla bla bla bla</p>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card-standard bg-gray mb-4 bg-image" style="background-image: url('{{ asset('public/frontend/images/Cibes_ProductPage_V80LXPlus_02_110_010_0001 1.png') }}');">
                        <div class="card-standard_img card-standard_img_float_bottom_left position-relative">
                            <span>
                                <h4 class="c-white">Cibes V-Series</h4>
                                <p class="c-white title-18-reguler">Bersertifikat LEvel Integrity 3 jadi lebih aman bla bla bla bla</p>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card-standard bg-gray mb-4 bg-image" style="background-image: url('{{ asset('public/frontend/images/Cibes_ProductPage_V80LXPlus_02_110_010_0001 1.png') }}');">
                        <div class="card-standard_img card-standard_img_float_bottom_left position-relative">
                            <span>
                                <h4 class="c-white">Cibes V-Series</h4>
                                <p class="c-white title-18-reguler">Bersertifikat LEvel Integrity 3 jadi lebih aman bla bla bla bla</p>
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
                    <h5 class="title-50-bold">Compare Lift Model</h5>
                    <p>Lift Rumah Cibes dapat dikustomisasi sesuai dengan selera Anda. Kami memiliki banyak pilihan warna, material, maupun fitur. </p>
                    <a href="#" class="button-orange">Compare Model</a>
                </div>
                <div class="col-12 col-md-6">
                    <img src="{{ asset('public/frontend/images/Cibes_Bringing-people-together_Outside_Night.jpg') }}" alt="" class="w-100">
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <img src="{{ asset('public/frontend/images/Cibes_Bringing-people-together_Outside_Night.jpg') }}" alt="" class="w-100">
                </div>
                <div class="col-12 col-md-6">
                    <h5 class="title-50-bold">Customize Your Lift</h5>
                    <p>Lift Rumah Cibes dapat dipasang dengan mudah. Karena tidak memerlukan pit dan ruang mesin, dan juga sudah dilengkapi dengan shaft bawaan.</p>
                    <a href="#" class="button-orange">Desain Lift Saya</a>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h5 class="title-50-bold">More Detailed About Cibes Lift</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="card-standard bg-gray mb-4 bg-image" style="background-image: url('{{ asset('public/frontend/images/Cibes_ProductPage_V80LXPlus_02_110_010_0001 1.png') }}');">
                        <div class="card-standard_img card-standard_img_float_bottom_left position-relative">
                            <span>
                                <h4 class="c-white">Full Size Options</h4>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card-standard bg-gray mb-4 bg-image" style="background-image: url('{{ asset('public/frontend/images/Cibes_ProductPage_V80LXPlus_02_110_010_0001 1.png') }}');">
                        <div class="card-standard_img card-standard_img_float_bottom_left position-relative">
                            <span>
                                <h4 class="c-white">Complete Specifications</h4>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card-standard bg-gray mb-4 bg-image" style="background-image: url('{{ asset('public/frontend/images/Cibes_ProductPage_V80LXPlus_02_110_010_0001 1.png') }}');">
                        <div class="card-standard_img card-standard_img_float_bottom_left position-relative">
                            <span>
                                <h4 class="c-white">Repair & Maintenance</h4>
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
                <div class="col-12 col-md-4">
                    <h5 class="title-50-bold">F.A.Q</h5>
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
                <div class="col-12 col-md-8">
                    <h5 class="title-50-bold">Punya Pertanyaan Lain?</h5>
                    <p class="mb-4">Isi form berikut ini dan Lift Consultant Kami Siap Membantu!</p>
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
@endsection

@push('script')
@endpush
