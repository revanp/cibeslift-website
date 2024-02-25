<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-3 text-center" >
            <img src="{{ $customization['image']['path'] ?? '' }}" class="w-100" alt="">
        </div>
        <div class="col-12 col-md-9">
            <div class="row">
                <div class="col-12">
                    <h5 class="title-30-bold">{{ $customization['product_customization'][0]['name'] }}</h5>
                    <p>{{ $customization['product_customization'][0]['description'] }}</p>
                </div>
            </div>
            <div class="row">
                @foreach ($customization['product_customization_feature_id'] as $key => $val)
                    <div class="col-12 col-md-4">
                        <div class="card-standard position-relative card-standard-smalls background-default bg-gray mb-4" style="background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ $val['image']['path'] ?? '' }}')">
                            <div class="card-standard_content card-standard_content_bottom text-center">
                                <h5 class="title-20-bold c-white">{{ $val['product_customization_feature'][0]['name'] }}</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @foreach ($customization['product_customization_option_id'] as $key => $val)
                <div class="row mt-5 mb-3">
                    <div class="col-12 mb-4">
                        <h5 class="title-30-bold">{{ $val['product_customization_option'][0]['name'] }}</h5>
                    </div>
                    <div class="col-12">
                        <ul class="{{ (str_contains($val['product_customization_option'][0]['name'], 'Color') || str_contains($val['product_customization_option'][0]['name'], 'Warna')) ? 'color-show' : 'pattern-show' }}">
                            @foreach ($val['product_customization_option_variation_id'] as $key2 => $val2)
                                <li>
                                    <div class="{{ (str_contains($val['product_customization_option'][0]['name'], 'Color') || str_contains($val['product_customization_option'][0]['name'], 'Warna')) ? 'color-item' : 'pattern-item' }}">
                                        {{-- <img src="{{ $val2['image']['path'] ?? '' }}" class="w-100" alt=""> --}}
                                        <span style="background-image: url('{{ $val2['image']['path'] ?? '' }}');"></span>
                                        <label>{{ $val2['product_customization_option_variation'][0]['name'] }}</label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
