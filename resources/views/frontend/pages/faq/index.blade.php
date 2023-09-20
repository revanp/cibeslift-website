@extends('frontend.layouts.app')

@section('content')

    <div class="section">
        <div class="container">
            @foreach ($faqs as $key => $val)
                <div class="row mb-5">
                    <div class="col-12 col-md-5">
                        <h3 class="title-50-bold">{{ $val['name'] }}</h3>
                    </div>
                    <div class="col-12 col-md-7">
                        <div class="accordion">
                            @foreach ($val['questions'] as $key2 => $val2)
                                <div class="accordion-item">
                                    <button id="accordion-button-1" aria-expanded="false">
                                        <span class="accordion-title">{{ $val2['title'] }}</span><span class="icon" aria-hidden="true"></span>
                                    </button>
                                    <div class="accordion-content">
                                        <p>{{ $val2['description'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@push('script')
@endpush
