@extends('frontend.layouts.app')

@section('content')

    <div class="section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12">
                    <div class="slider-installation">
                        <div class="slider-installation-item">
                            <div class="image mb-4">
                                <img src="{{ asset('public/frontend/images/Banner---Homepage-Website.jpg') }}" style="w-100" alt="">
                            </div>
                            <div class="content">
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <h3 class="title-50-bold">Enjoy Golden Sunset with Cibes Voyager</h3>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <div class="row">
                                            <div class="col">
                                                <p>Lift Model : Cibes V90</p>
                                                <p>Location : Bandung</p>
                                                <p>Number of Stops : 6 Stops</p>
                                            </div>
                                            <div class="col">
                                                <p>Door Type : Automatic Saloon Door</p>
                                                <p>Color : February 6</p>
                                                <p>Back Panel : Nebula</p>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="col-12 col-md-4">
                                        <button class="button-orange">See Other Installation</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section--large background-img" style="background-image: url('{{ asset('public/frontend/images/Rectangle 81.jpg') }}');">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h5 class="title-50-bold c-white">Kustomisasi Lift Rumah Anda</h5>
                    <p class="c-white mb-4">Lift Rumah Cibes dapat dikustomisasi sesuai dengan selera Anda. Kami memiliki banyak pilihan warna, material, maupun fitur. </p>
                    <a href="#" class="button-orange">Desain Lift Rumah Saya Sendiri</a>
                </div>
                <div class="col-12 col-md-6">
                </div>
            </div>
        </div>
    </div>
    
    <div class="section--large background-img" style="background-image: url('{{ asset('public/frontend/images/Rectangle 7.jpg') }}');">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                </div>
                <div class="col-12 col-md-6">
                    <h5 class="title-50-bold c-white">Lift Rumah dengan Teknologi Terbaru</h5>
                    <p class="c-white mb-4">Lift Rumah Cibes dapat dipasang dengan mudah. Karena tidak memerlukan pit dan ruang mesin, dan juga sudah dilengkapi dengan shaft bawaan.</p>
                    <a href="#" class="button-orange">Teknologi Cibes Lift</a>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
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
