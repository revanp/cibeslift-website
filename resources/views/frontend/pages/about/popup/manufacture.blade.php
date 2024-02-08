<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-7 text-center mb-5">
            <h5 class="title-50-bold">{{ $manufacture['manufacture'][0]['name'] }}</h5>
            <p>{{ $manufacture['manufacture'][0]['description'] }}</p>
        </div>
    </div>
    <div class="row justify-content-center">
        @foreach ($manufacture['manufacture_id_has_product_id'] as $key => $val)
            <div class="col-12 col-md-4">
                <div class="card-standard bg-gray background-default text-center" style="background-image: url('{{ $val['product_id']['thumbnail']['path'] }}');">
                    <div class="card-standard_img"></div>
                    <div class="card-standard_content">
                        <h5 class="title-30-bold c-white">{{ $val['product_id']['product'][0]['name'] }}</h5>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
