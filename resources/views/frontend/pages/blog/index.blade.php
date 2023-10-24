@extends('frontend.layouts.app')

@section('content')

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-7">
                    <div class="row mb-5">
                        @if(!empty($item))
                            @foreach ($item as $items)
                                @php
                                    $image = $items->newsId->thumbnail 
                                           ? $items->newsId->thumbnail->path : '';
                                @endphp
                                <div class="col-12">
                                    <div class="card-hero">
                                        <div class="card-hero-thumbnail" style="background-image: url('{{ $image }}');"></div>
                                        <div class="card-hero-content">
                                            <label class="date">{{ $items->newsId->publish_date }}</label>
                                            <h3 class="title-50-bold">{{ $items->title }} </h3>
                                            <p class="title-20-regular">{{ Str::substr($items->description, 0, 100) }}</p>
                                            <a href="{{ urlLocale('blog/'.$items->slug) }}" class="link">Read More <i class="fi fi-rr-arrow-small-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="row d-none">
                        @if(!empty($item))
                            @foreach ($item as $items)
                                @php
                                    $image = $items->newsId->thumbnail 
                                           ? $items->newsId->thumbnail->path : '';
                                @endphp
                                <div class="col-4">
                                    <div class="card-hero mb-5">
                                        <div class="card-hero-thumbnail small-thumbnail" style="background-image: url('{{ $image }}');"></div>
                                        <div class="card-hero-content">
                                            <label class="date">{{ $items->newsId->publish_date }}</label>
                                            <h3 class="title-20-bold">{{ $items->title }} </h3>
                                            <p class="title-20-regular">{{ Str::substr($items->description, 0, 100) }}</p>
                                            <a href="{{ urlLocale('blog/'.$items->slug) }}" class="link">Read More <i class="fi fi-rr-arrow-small-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <div class="col-12 text-center my-5 d-none">
                            <a href="#" class="button-orange">Read more</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-5 d-none">
                    <div class="row">
                        <div class="col-6">
                            <div class="card-hero-thumbnail small-thumbnail"></div>
                        </div>
                        <div class="col-6">
                            <div class="card-hero-content">
                                <label class="date">12/09/2023</label>
                                <h3 class="title-20-bold">Beli Lift Cibes, Jangan Kreativ!</h3>
                                <p class="title-20-regular">Lihat instalasi Lift Rumah Cibes bla bla bla bla bla bla bla bla bla bla</p>
                                <a href="#" class="link">Read More <i class="fi fi-rr-arrow-small-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="card-hero-thumbnail small-thumbnail"></div>
                        </div>
                        <div class="col-6">
                            <div class="card-hero-content">
                                <label class="date">12/09/2023</label>
                                <h3 class="title-20-bold">Beli Lift Cibes, Jangan Kreativ!</h3>
                                <p class="title-20-regular">Lihat instalasi Lift Rumah Cibes bla bla bla bla bla bla bla bla bla bla</p>
                                <a href="#" class="link">Read More <i class="fi fi-rr-arrow-small-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="card-hero-thumbnail small-thumbnail"></div>
                        </div>
                        <div class="col-6">
                            <div class="card-hero-content">
                                <label class="date">12/09/2023</label>
                                <h3 class="title-20-bold">Beli Lift Cibes, Jangan Kreativ!</h3>
                                <p class="title-20-regular">Lihat instalasi Lift Rumah Cibes bla bla bla bla bla bla bla bla bla bla</p>
                                <a href="#" class="link">Read More <i class="fi fi-rr-arrow-small-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="card-hero-thumbnail small-thumbnail"></div>
                        </div>
                        <div class="col-6">
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

@endsection

@push('script')
@endpush