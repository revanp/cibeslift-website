@extends('frontend.layouts.app')

@section('content')

    <div class="section">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 text-center mb-5">
                    <h3 class="title-50-bold">The History of Cibes</h3>
                    <p class="title-20-reguler">Cibes didirikan di Swedia pada tahun 1947, ketika itu adalah jaman penjajahan negara api dan saya tidak akan pernah mengalami itu lagi.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="slider-history">
                        @foreach ($history as $key => $val)
                            <div>
                                <div class="slider-history_card" style="background-image: url('{{ $val->image->path }}');"></div>
                                <span class="slider-history_content">
                                    <h5 class="title-30-bold mb-4">{{ $val->year }}</h5>
                                    <p class="title-14-reguler">{{ $val->history[0]->description }}</p>
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
                    <h5 class="title-50-bold">Cibes Lift Around the World</h5>
                    <p>Kantor pusat dan pabrik Cibes Elevator Group berlokasi di Gävle, Swedia. Sedangkan Cibes Lift Asia berkantor pusat di Hong Kong dengan 5 cabang utama di berbagai negara di Asia Tenggara. Selain itu Cibes Lift Grup sendiri memiliki cabang utama di 11 negara lainnya di seluruh dunia.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <ul class="list-standard">
                        @foreach ($nation as $key => $val)
                            <li>
                                <a href="{{ $val->link ?? '#' }}" target="_blank">
                                    <div class="circle-flag" style="background-image: url('{{ $val->image->path }}');"></div>
                                    <label class="title-20-bold">{{ $val->nation[0]->name }}</label>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h5 class="title-50-bold">Cibes Manufactures</h5>
                    <p>Cibes Lift memiliki 3 pabrik untuk memproduksi unit lift Anda.</p>
                </div>
            </div>
            <div class="row justify-content-center">
                @foreach ($manufacture as $key => $val)
                    <div class="col-12 col-md-4">
                        <div class="card-about card-standard bg-gray background-default text-center" style="background-image: url('{{ $val->image->path }}');">
                            <div class="card-standard_img"></div>
                            <div class="card-standard_content">
                                <h5 class="title-30-bold c-white">{{ $val->manufacture[0]->name }}</h5>
                                <p class="c-white">{{ $val->manufacture[0]->description }}</p>
                                <a href="javascript:;" class="button-orange btn-manufacture" data-id="{{ Crypt::encrypt($val->id) }}">Lebih Lengkap</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div style="display: none; min-width: 1200px;" id="manufactures">

    </div>

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h5 class="title-50-bold">Cibes Lift Indonesia</h5>
                </div>
            </div>
            @if (!empty($highlightImage))
                <div class="row">
                    <div class="col-12">
                        <div class="card-image-banner" style="background-image: url('{{ $highlightImage->image->path }}');"></div>
                    </div>
                </div>
            @endif
            <div class="row mt-4 justify-content-center">
                @foreach ($highlight as $key => $val)
                    <div class="col-12 col-md-4 mb-4">
                        <div class="card card-usp">
                            <img src="{{ $val->icon->path }}" width="50px" class="mb-3" alt="">
                            <div class="d-block">
                                <h5 class="title-30-bold">{{ $val->aboutUsHighlight[0]->name }}</h5>
                                <p>{{ $val->aboutUsHighlight[0]->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @if (!empty($banner))
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <h5 class="title-50-bold">{{ $banner->title ?? '' }}</h5>
                    </div>
                    <div class="col-12 col-md-8">
                        <p class="title-20-reguler">{{ $banner->description ?? '' }}</p>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card-image-banner" style="background-image: url('{{ $banner->aboutUsBannerId->image->path ?? '#' }}');"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (!empty($aftersalesTitle))
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="flex-middle">
                            <span>
                                <h4 class="title-50-bold">{{ $aftersalesTitle->title ?? '' }}</h4>
                                <p class="mb-5">{{ $aftersalesTitle->description ?? '' }}</p>
                                <a data-fancybox data-src="#aftersales" href="javascript:;" class="button-orange">{{ $aftersalesTitle->cta ?? '' }}</a>
                            </span>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="text-center">
                            <img src="{{ $aftersalesTitle->image->path ?? '' }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div style="display: none; min-width: 1200px;" id="aftersales">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-7 text-center mb-5">
                    <h5 class="title-50-bold">Cibes Lift Indonesia After Sales Service</h5>
                </div>
            </div>
            <div class="row justify-content-center">
                @foreach ($aftersales as $key => $val)
                    <div class="col-6 col-md-4">
                        <a href="">
                            <div class="card-standard background-default bg-gray mb-4" style="background-image: url('{{ $val->aboutUsAftersalesId->image->path ?? '#' }}')">
                                <div class="card-standard_img"></div>
                                <div class="card-standard_content">
                                    <h5 class="title-20-bold c-white">{{ $val->name }}</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h5 class="title-50-bold">Cibes Lift Indonesia Showroom</h5>
                    <p class="title-20-reguler">Lokasi Showroom Cibes Lift Indonesia yang Tersebar di Seluruh Indonesia.</p>
                </div>
            </div>
            <div class="row">
                @foreach ($showroom as $key => $val)
                    <div class="col-6 col-md-4">
                        <a href="{{ $val->google_maps_link }}" target="_BLANK">
                            <div class="card-standard background-default bg-gray mb-4" style="background-image: url('{{ $val->image->path }}')">
                                <div class="card-standard_img"></div>
                                <div class="card-standard_content">
                                    <h5 class="title-20-bold c-white">{{ $val->name }}</h5>
                                    <p class="c-white">{{ $val->address }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h3 class="title-50-bold">Tentukan Lift Rumah Pilihan Anda</h3>
                </div>
            </div>
            <div class="row mb-3">
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

@endsection

@push('script')
<script>
    $(document).ready(function(){
        $('.btn-manufacture').click(function(e){
            e.preventDefault();

            var id = $(this).data('id');

            $.ajax({
                url: "{{ urlLocale('about-us/get-manufacture') }}",
                data: {
                    id: id
                },
                success: function(data){
                    $("#manufactures").html(data);
                    $("#manufactures").fancybox().trigger('click');
                }
            })
        });
    });
</script>
@endpush
