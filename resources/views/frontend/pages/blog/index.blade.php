@extends('frontend.layouts.app')

@section('content')
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-7">
                <div class="row mb-5">
                    @if(!empty($item))
                        @foreach ($item as $key => $items)
                            @if ($key == 0)
                                @php
                                    $image = $items->newsId->thumbnail ? $items->newsId->thumbnail->path : '';
                                @endphp
                                <div class="col-12">
                                    <div class="card-hero">
                                        <div class="card-hero-thumbnail" style="background-image: url('{{ $image }}');"></div>
                                        <div class="card-hero-content">
                                            <label class="date">{{ date('d M Y H:i', strtotime($items->newsId->publish_date)) }}</label>
                                            <h3 class="title-50-bold">{{ $items->title }}</h3>
                                            <p class="title-20-regular">{{ Str::substr($items->description, 0, 100) }}</p>
                                            <a href="{{ urlLocale('blog/'.$items->slug) }}" class="link">Read More <i class="fi fi-rr-arrow-small-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="col-12 col-md-5">
                @if(!empty($item))
                    @foreach ($item as $key => $items)
                        @if ($key > 0 && $key < 2)
                            @php
                                $image = $items->newsId->thumbnail ? $items->newsId->thumbnail->path : '';
                            @endphp
                            <div class="row">
                                <div class="col-12">
                                    <div class="card-hero-thumbnail small-thumbnail" style="background-image: url('{{ $image }}');"></div>
                                    <div class="card-hero-content">
                                        <label class="date">{{ date('d M Y H:i', strtotime($items->newsId->publish_date)) }}</label>
                                        <h3 class="title-20-bold">{{ $items->title }}</h3>
                                        <p class="title-20-regular">{{ Str::substr($items->description, 0, 100) }}</p>
                                        <a href="{{ urlLocale('blog/'.$items->slug) }}" class="link">Read More <i class="fi fi-rr-arrow-small-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
@endpush
