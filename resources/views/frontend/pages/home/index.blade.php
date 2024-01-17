@extends('frontend.layouts.app')

@section('content')

@if (!empty($headerBanner))
    <div class="banner" style="background-image: url('{{ $headerBanner->headerBannerId->image->path ?? '#' }}');">
        <div class="container h-100">
            <div class="row h-100 justify-content-center">
                <div class="col-12 col-md-8">
                    <div class="flex-center">
                        <span class="banner-contain">
                            <h1 class="mb-4">{{ $headerBanner->title }}</h1>
                            <p>{{ $headerBanner->description }}</p>
                            <a href="{{ $headerBanner->link }}" class="button-primary mt-5">{{ $headerBanner->cta }}</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@if (!empty($video))
    <div class="section pt-0">
        <div style="height: 1000vh;">
            <div id="scrolly-video"></div>
        </div>
    </div>
@endif

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h3 class="title-50-bold">Tentukan Lift Rumah Pilihan Anda</h3>
            </div>
        </div>
        <div class="row">
            @foreach ($products as $key => $val)
                @if ($key < 2)
                    <div class="col-12 col-md-6 mb-3">
                        <div class="card-background" style="background-image: url('{{ $val->productId->thumbnail->path ?? '#' }}')">
                            <div class="card-background-content">
                                <h3 class="c-white title-30-bold">{{ $val->name }}</h3>
                                <p class="c-white">{{ $val->short_description }}</p>
                                <hr>
                                <a href="{{ urlLocale('product/'.$val->slug) }}" class="c-white title-20-bold">Lebih lengkap</a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-12 col-md-4 mb-3">
                        <div class="card-background" style="background-image: url('{{ $val->productId->thumbnail->path ?? '#' }}')">
                            <div class="card-background-content">
                                <h3 class="c-white title-30-bold">{{ $val->name }}</h3>
                                <p class="c-white">{{ $val->short_description }}</p>
                                <hr>
                                <a href="{{ urlLocale('product/'.$val->slug) }}" class="c-white title-20-bold">Lebih lengkap</a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>

@foreach ($menuSection as $key => $val)
    @if ($key % 2 == 0)
        <div class="section background-img" style="background-image: url('{{ $val->homeMenuSectionId->image->path }}');">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h5 class="title-50-bold c-white">{{ $val->title }}</h5>
                        <p class="c-white mb-4">{{ $val->description }}</p>
                        <a href="{{ $val->homeMenuSectionId->url }}" class="button-orange">{{ $val->cta }}</a>
                    </div>
                    <div class="col-12 col-md-6">
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="section background-img" style="background-image: url('{{ $val->homeMenuSectionId->image->path }}');">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-6">
                    </div>
                    <div class="col-12 col-md-6">
                        <h5 class="title-50-bold c-white">{{ $val->title }}</h5>
                        <p class="c-white mb-4">{{ $val->description }}</p>
                        <a href="{{ $val->homeMenuSectionId->url }}" class="button-orange">{{ $val->cta }}</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

@if (!empty($whyCibesTitle))
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 pe-0 pe-md-5">
                <div class="row">
                    <div class="col-12 mb-5">
                        <h3 class="title-50-bold mb-2">{{ $whyCibesTitle->title ?? '' }}</h3>
                        <p>{{ $whyCibesTitle->description ?? '' }}</p>
                    </div>
                </div>
                <div class="row">
                    @foreach ($whyCibesUsp as $key => $val)
                        <div class="col-12 col-md-6 mb-4">
                            <div class="card card-usp">
                                <img src="{{ $val->image->path ?? '' }}" width="50px" class="mb-3" alt="">
                                <div class="d-block">
                                    <h5 class="title-30-bold">{{ $val->whyCibesUsp[0]->title ?? '' }}</h5>
                                    <p>{{ $val->whyCibesUsp[0]->subtitle ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="text-center">
                    <img src="{{ $whyCibesTitle->image->path ?? '' }}" class="w-100" alt="">
                </div>
            </div>
        </div>
    </div>
</div>

@endif

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 mb-4">
                <div class="flex-middle h-100">
                    <span>
                        <h5 class="title-50-bold">Bringing People Together</h5>
                        <p>We want our lifts to make a difference in your life and in the life of your loved ones. Bringing people together is our vision, and that is what we are all about.</p>
                        <a href="#" class="button-orange">Our Company Vision</a>
                    </span>
                </div>
            </div>
            <div class="col-12 col-md-6 mb-4">
                <img src="{{ asset('public/frontend/images/Rectangle 9.png') }}" class="w-100" alt="">
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 mb-4">
                <img src="{{ asset('public/frontend/images/Rectangle 11.png') }}" class="w-100" alt="">
            </div>
            <div class="col-12 col-md-6 mb-4">
                <div class="flex-middle h-100">
                    <span>
                        <h5 class="title-50-bold">Worldwide Sales Network</h5>
                        <p>We have direct sales and distribution in more than 70 countries across the world. Contact us today to get in touch with your closest Cibes dealer.</p>
                        <a href="#" class="button-orange">Contact Us</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-4 text-center">
                <img src="{{ asset('public/frontend/images/Cibes_ProductPage_V80LXPlus_02_110_010_0001 1.png') }}" class="w-100" alt="">
                <p class="title-20-bold mt-3">Cibes V90 Galaxy</p>
            </div>
            <div class="col-12 col-md-8">
                <div class="mb-4">
                    <img src="{{ asset('public/frontend/images/Cibes_Bringing-people-together_Outside_Night.jpg') }}" class="w-100" alt="">
                </div>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sequi ipsam quam possimus perferendis laboriosam repudiandae voluptates voluptas, adipisci modi eligendi natus ab tenetur dolorem exercitationem quod eos rem cupiditate deleniti.</p>
                <label class="title-20-bold">Ghani, Jakarta Timur</label>
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h3 class="title-50-bold">Instalasi Lift Cibes</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 col-md-3 text-center mb-4">
                        <div class="card-slider" style="background-image: url('{{ asset('public/frontend/images/Rectangle 10.png') }}');">
                            <span class="tag">CIBES VOYAGER ELEGANCE</span>
                        </div>
                        <span>
                            <h5 class="title-20-bold">Garansi 5, 5, 15 Tahun</h5>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        </span>
                    </div>
                    <div class="col-12 col-md-3 text-center mb-4">
                        <div class="card-slider" style="background-image: url('{{ asset('public/frontend/images/Rectangle 10 (1).png') }}');">
                            <span class="tag">CIBES AIR WOOD</span>
                        </div>
                        <span>
                            <h5 class="title-20-bold">Garansi 5, 5, 15 Tahun</h5>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        </span>
                    </div>
                    <div class="col-12 col-md-3 text-center mb-4">
                        <div class="card-slider" style="background-image: url('{{ asset('public/frontend/images/Rectangle 10 (2).png') }}');">
                            <span class="tag">CIBES V90 GALAXY</span>
                        </div>
                        <span>
                            <h5 class="title-20-bold">Garansi 5, 5, 15 Tahun</h5>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        </span>
                    </div>
                    <div class="col-12 col-md-3 text-center mb-4">
                        <div class="card-slider" style="background-image: url('{{ asset('public/frontend/images/Rectangle 10 (3).png') }}');">
                            <span class="tag">CIBES A5000</span>
                        </div>
                        <span>
                            <h5 class="title-20-bold">Garansi 5, 5, 15 Tahun</h5>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section banner-background" style="{{ asset('public/frontend/images/Cibes_ProductPage_V80LXPlus_010_030_01_0001.png') }}">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-4">
                <img src="{{ asset('public/frontend/images/Cibes_ProductPage_V90LXPlus_02_110_010_0001 1 (1).png') }}" alt="">
            </div>
            <div class="col-12 col-md-8">
                <h5 class="title-50-bold">Punya Pertanyaan Seputar Lift Rumah?</h5>
                <p class="mb-4">Isi form berikut ini dan Lift Consultant Kami Siap Membantu!</p>
                <div class="card-form">
                    <form action="">
                        <div class="row mb-4">
                            <div class="col-12 col-md-6 mb-4 mb-md-0">
                                <input class="form-control" type="text" placeholder="Name">
                            </div>
                            <div class="col-12">
                                <input class="form-control" type="text" placeholder="Telepon">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-12 col-md-6 mb-4 mb-md-0">
                                <input class="form-control" type="text" placeholder="Email">
                            </div>
                            <div class="col-12 col-md-3 mb-4 mb-md-0">
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

<script src="https://cdn.jsdelivr.net/npm/scrolly-video@latest/dist/scrolly-video.js"></script>
<script>
    @if (!empty($video))
        new ScrollyVideo({
            scrollyVideoContainer: "scrolly-video",
            src: "{{ $video->video->path ?? '#' }}",
        });
    @endif
</script>

@endpush
