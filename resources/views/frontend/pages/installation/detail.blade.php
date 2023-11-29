@extends('frontend.layouts.app')

@section('content')

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <h2 class="title-50-bold mb-5">Enjoy Golden Sunset with Cibes Voyager</h2>
                    <img src="{{ asset('public/frontend/images/Banner---Homepage-Website.jpg') }}" class="w-100" alt="">
                </div>
                <div class="col-6 col-md-3">
                    <img src="{{ asset('public/frontend/images/Rectangle 10 (2).jpg') }}" class="w-100" alt="">
                </div>
                <div class="col-6 col-md-3">
                    <img src="{{ asset('public/frontend/images/Rectangle 10 (3).jpg') }}" class="w-100" alt="">
                </div>
                <div class="col-6 col-md-3">
                    <img src="{{ asset('public/frontend/images/Rectangle 10 (4).jpg') }}" class="w-100" alt="">
                </div>
                <div class="col-6 col-md-3">
                    <img src="{{ asset('public/frontend/images/Rectangle 10 (2).jpg') }}" class="w-100" alt="">
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card-custom">
                        <div class="row">
                            <div class="col">
                                <p>
                                <b>Lift Model</b> <br>
                                Cibes Voyager Elegance
                                </p>
                                <p>
                                <b>Number of Stops</b> <br>
                                4 Stops
                                </p>
                                <p>
                                <b>Travel Height</b> <br>
                                11000mm
                                </p>
                                <p>
                                <b>Shaft</b> <br>
                                All Glass
                                </p>
                            </div>
                            <div class="col">
                                <p>
                                <b>Finished Size</b> <br>
                                1040mm x 1050mm
                                </p>
                                <p>
                                <b>Platform Size</b> <br>
                                1040mm x 1050mm
                                </p>
                                <p>
                                <b>Lift Position</b> <br>
                                Outdoor
                                </p>
                                <p>
                                <b>Lift Installation</b> <br>
                                Residential
                                </p>
                            </div>
                            <div class="col">
                                <p>
                                <b>Shaft</b> <br>
                                All Glass
                                </p>
                                <p>
                                <b>Color</b> <br>
                                Gothic Graphite Black
                                </p>
                                <p>
                                <b>Pattern</b> <br>
                                Pavona Feathers
                                </p>
                                <p>
                                <b>Flooring</b> <br>
                                Oak Wood
                                </p>
                            </div>
                            <div class="col">
                                <p>
                                <b>Feature Upgrade</b> <br>
                                Music Player
                                </p>
                                <p>
                                <b>Finished Installation</b> <br>
                                10 November 2023
                                </p>
                                <p>
                                <b>Location</b> <br>
                                Bandung, Indonesia
                                </p>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12 text-center mb-4">
                    <h3 class="title-50-bold">
                        Instalasi Terkait
                    </h3>
                </div>
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

@endsection
@push('script')
@endpush
