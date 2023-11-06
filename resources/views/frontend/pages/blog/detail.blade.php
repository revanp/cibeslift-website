@extends('frontend.layouts.app')

@section('content')

    <div class="section">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-12 text-center mb-4">
                    @php
                        $image = $data->newsId->thumbnail 
                                ? $data->newsId->thumbnail->path : '';
                    @endphp
                    <div class="article-image mb-5" stle="background-image: url('{{ $image }}');"></div>
                    <h2 class="title-50-bold">{{ $data->title }}</h2>
                </div>
                <div class="col-12 col-md-8">
                    {!! $data->content !!}
                </div>
            </div>
            <div class="row d-none">
                <div class="col-12">

                    <div class="row">
                        <div class="col-12 mb-5">
                            <h4 class="title-30-bold">Baca Artikel Lainnya</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="card-hero mb-5">
                                <div class="card-hero-thumbnail small-thumbnail"></div>
                                <div class="card-hero-content">
                                    <label class="date">12/09/2023</label>
                                    <h3 class="title-20-bold">Beli Lift Cibes, Jangan Kreativ!</h3>
                                    <p class="title-20-regular">Lihat instalasi Lift Rumah Cibes bla bla bla bla bla bla bla bla bla bla</p>
                                    <a href="#" class="link">Read More <i class="fi fi-rr-arrow-small-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card-hero mb-5">
                                <div class="card-hero-thumbnail small-thumbnail"></div>
                                <div class="card-hero-content">
                                    <label class="date">12/09/2023</label>
                                    <h3 class="title-20-bold">Beli Lift Cibes, Jangan Kreativ!</h3>
                                    <p class="title-20-regular">Lihat instalasi Lift Rumah Cibes bla bla bla bla bla bla bla bla bla bla</p>
                                    <a href="#" class="link">Read More <i class="fi fi-rr-arrow-small-right"></i></a>
                                </div>
                            </div>
                        </div> 
                        <div class="col-4">
                            <div class="card-hero mb-5">
                                <div class="card-hero-thumbnail small-thumbnail"></div>
                                <div class="card-hero-content">
                                    <label class="date">12/09/2023</label>
                                    <h3 class="title-20-bold">Beli Lift Cibes, Jangan Kreativ!</h3>
                                    <p class="title-20-regular">Lihat instalasi Lift Rumah Cibes bla bla bla bla bla bla bla bla bla bla</p>
                                    <a href="#" class="link">Read More <i class="fi fi-rr-arrow-small-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
@endpush
