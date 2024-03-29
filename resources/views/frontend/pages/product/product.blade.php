@extends('frontend.layouts.app')

@section('content')
    <div class="banner" style="background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ $product['product_id']['banner']['path'] ?? '#' }}');">
        <div class="container h-100">
            <div class="row h-100 justify-content-center">
                <div class="col-12 col-md-8">
                    <div class="flex-center">
                        <span class="banner-contain text-center">
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
                    @php
                        $col = 'col-md-12';
                        if(count($product['product_id']['child']) % 4 == 0){
                            $col = 'col-md-3';
                        }elseif(count($product['product_id']['child']) % 3 == 0){
                            $col = 'col-md-4';
                        }elseif(count($product['product_id']['child']) % 2 == 0){
                            $col = 'col-md-6';
                        }
                    @endphp
                    @foreach ($product['product_id']['child'] as $key => $val)
                        <div class="col-12 {{ $col }} text-center">
                            <a href="{{ urlLocale('product/'.$product['slug'].'/'.$val['product'][0]['slug']) }}" class="button-orange">{{ $val['product'][0]['name'] }}</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @if (!empty($product['product_id']['product_usp_id']))
        <div class="section">
            <div class="container">
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
            </div>
        </div>
    @endif

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

    @foreach ($product['product_id']['child'] as $key => $val)
        @if ($key % 2 == 0)
            <div class="section">
                <div class="container">
                    @if ($key == 0)
                        <hr class="mb-5">
                    @endif
                    <div class="row">
                        <div class="col-12 col-md-6 text-center">
                            <img src="{{ $val['thumbnail']['path'] ?? '#' }}" alt="" class="w-100">
                            {{-- <p class="title-20-bold mt-3">{{ $val['product'][0]['name'] }}</p> --}}
                        </div>
                        <div class="col-12 col-md-6">
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
                        <div class="col-12 col-md-6">
                            <div class="flex-center">
                                <span>
                                    <h4 class="title-50-bold">{{ $val['product'][0]['page_title'] ?? '' }}</h4>
                                    <p>{{ $val['product'][0]['description'] }}</p>
                                    <a href="#" class="button-orange">{{ $val['product'][0]['name'] }}</a>
                                </span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 text-center">
                            <img src="{{ $val['thumbnail']['path'] ?? '#' }}" alt="" class="w-100">
                            {{-- <p class="title-20-bold mt-3">{{ $val['product'][0]['name'] }}</p> --}}
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
                                {{-- <div class="position-relative">
                                    <img src="{{ $val['image']['path'] }}" alt="" class="w-100">
                                    <div class="position-middle title-30-bold">{{ $val['product_customization'][0]['name'] }}</div>
                                    <div class="card-standard_content">
                                        <h5 class="title-20-bold c-white">{{ $val['product_customization'][0]['name'] }}</h5>
                                    </div>
                                </div> --}}
                                <div class="card-standard background-default bg-gray mb-4" style="background-image:linear-gradient(0deg, rgba(0, 0, 0, 1), rgba(0, 0, 0, 0)), url('{{ $val['image']['path'] }}')">
                                    <div class="card-standard_img"></div>
                                    <div class="card-standard_content">
                                        <h5 class="title-20-bold c-white">{{ $val['product_customization'][0]['name'] }}</h5>
                                    </div>
                                </div>
                                <span class="d-block mt-5">
                                    <a href="javascript:;" class="button-orange btn-customization" data-id="{{ Crypt::encrypt($val['id']) }}">Learn More</a>
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
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h5 class="title-50-bold">Sistem Keamanan Terkini</h5>
                </div>
            </div>
            <div class="row">
                @foreach ($product['product_id']['product_id_has_product_technology_id'] as $key => $val)
                    <div class="col-6 col-md-4">
                        <div class="card-standard background-default bg-gray mb-4" style="background-image:linear-gradient(0deg, rgba(0, 0, 0, 1), rgba(0, 0, 0, 0)), url('{{ $val['product_technology_id']['image']['path'] ?? '#' }}')">
                            <div class="card-standard_img"></div>
                            <div class="card-standard_content">
                                <h5 class="title-20-bold c-white">{{ $val['product_technology_id']['product_technology'][0]['name'] }}</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @foreach ($product['product_id']['product_feature_id'] as $key => $val)
        @if ($key % 2 == 0)
            <div class="section background-default" style="background-image: linear-gradient(to right, rgba(0, 0, 0, 1), rgba(0, 0, 0, 0)), url('{{ $val['image']['path'] ?? '#' }}'); padding: 200px 0 200px 0;">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <h5 class="title-50-bold c-white">{{ $val['product_feature'][0]['name'] }}</h5>
                            <p class="c-white">{{ $val['product_feature'][0]['description'] }}</p>
                        </div>
                        <div class="col-12 col-md-6">

                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="section background-default" style="background-image: linear-gradient(to left, rgba(0, 0, 0, 1), rgba(0, 0, 0, 0)), url('{{ $val['image']['path'] ?? '#' }}');">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-6">
                        </div>
                        <div class="col-12 col-md-6">
                            <h5 class="title-50-bold c-white">{{ $val['product_feature'][0]['name'] }}</h5>
                            <p class="c-white">{{ $val['product_feature'][0]['description'] }}</p>
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

    </div>

@endsection

@push('script')
<script>
    $(document).ready(function(){
        $('.btn-customization').click(function(e){
            e.preventDefault();

            var id = $(this).data('id');

            $.ajax({
                url: "{{ urlLocale('product/get-customization') }}",
                data: {
                    id: id
                },
                success: function(data){
                    $("#customization").html(data);
                    $("#customization").fancybox().trigger('click');
                }
            })
        });
    });
</script>
@endpush
