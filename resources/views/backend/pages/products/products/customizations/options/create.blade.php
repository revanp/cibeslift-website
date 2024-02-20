@extends('backend.layouts.app')

@section('content')
    <div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <h5 class="text-dark font-weight-bold my-1 mr-5">
                        Create Option
                    </h5>

                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-muted">Products</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin-cms/products/products') }}" class="text-muted">Products</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin-cms/products/products/customizations/'.$id) }}" class="text-muted">Customization</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin-cms/products/products/customizations/'.$id.'/options/'.$idCustomization) }}" class="text-muted">Options</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ url('admin-cms/products/products/customizations/'.$id.'/create') }}" class="text-muted">Create Option</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
		<div class=" container ">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Create Option</h3>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ url('admin-cms/products/products/customizations/'.$id.'/options/'.$idCustomization) }}" class="btn btn-danger font-weight-bolder">
                            <span class="svg-icon svg-icon-md"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                    <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-12.000003, -11.999999) "/>
                                </g>
                            </svg></span> Back
                        </a>
                    </div>
                </div>
                <form action="{{ url('admin-cms/products/products/customizations/'.$id.'/options/'.$idCustomization.'/create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group col-md-12">
                            <label>Duplicate From</label>
                            <select name="duplicate_from" class="form-control duplicate-form">
                                <option value="" selected disabled>-- SELECT OPTION TO DUPLICATE --</option>
                            </select>
                            <span class="form-text text-muted">Only option with variation.</span>
                        </div>

                        <hr>

                        <div class="form-group col-md-3">
                            <div class="col-12 col-form-label">
                                <div class="checkbox-inline">
                                    <label class="checkbox checkbox-success">
                                        <input type="checkbox" name="have_a_child"/>
                                        <span></span>
                                        Have a child product?
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6 hide-have-a-child">
                            <label>Parent Option</label>
                            <select name="parent_id" class="form-control @if($errors->has('parent_id')) is-invalid @endif">
                                @php
                                    $parentIdData = !empty(old('parent_id')) ? old('parent_id') : '';
                                @endphp
                                <option value="">-- SELECT PARENT OPTION --</option>
                                @foreach ($parents as $key => $val)
                                    <option value="{{ $val->productCustomizationOptionId->id }}" {{ $parentIdData == '0' ? 'selected' : '' }}>{{ $val->name }}</option>
                                @endforeach
                            </select>
                            <span class="form-text text-muted">Empty this field if option is standalone.</span>
                            @error('parent_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        @php
                            $lang = ['id' => 'Indonesia', 'en' => 'English'];
                        @endphp
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @foreach ($lang as $key => $val)
                                <li class="nav-item">
                                    <a class="nav-link {{ $key == 'id' ? 'active' : '' }}" data-toggle="tab" role="tab" href="#{{ $key }}Tab">{{ $val }}</a>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-content mb-4" style="display: block !important;">
                            @foreach ($lang as $key => $val)
                                <div class="tab-pane {{ $key == 'id' ? 'active' : '' }}" id="{{ $key }}Tab" role="tabpanel">
                                    <div class="row mt-5">
                                        <div class="form-group col-md-12">
                                            <label>Name</label>
                                            <input type="text" class="form-control @if($errors->has('input.'.$key.'.name')) is-invalid @endif" placeholder="Enter name" name="input[{{ $key }}][name]" value="{{ old('input.'.$key.'.name') }}"/>
                                            @error('input.'.$key.'.name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <hr>

                        <div class="variation-box mt-5 hide-have-a-child">
                            <div class="variation-item">
                                <div class="row">
                                    <div class="form-group picture_upload col-md-6">
                                        <label>Variation Image</label>
                                        <div class="form-group__file">
                                            <div class="file-wrapper">
                                                <input type="file" name="variation[0][image]" class="file-input"/>
                                                <div class="file-preview-background">+</div>
                                                <img src="" width="240px" class="file-preview"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="nav nav-tabs" id="variationTab" role="tablist">
                                            @foreach ($lang as $key => $val)
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $key == 'id' ? 'active' : '' }}" data-toggle="tab" role="tab" href="#{{ $key }}0VariationTab">{{ $val }}</a>
                                                </li>
                                            @endforeach
                                        </ul>

                                        <div class="tab-content mb-4" style="display: block !important;">
                                            @foreach ($lang as $key => $val)
                                                <div class="tab-pane {{ $key == 'id' ? 'active' : '' }}" id="{{ $key }}0VariationTab" role="tabpanel">
                                                    <div class="row mt-5">
                                                        <div class="form-group col-md-12">
                                                            <label>Name</label>
                                                            <input type="text" class="form-control" placeholder="Enter name" name="variation[0][input][{{ $key }}][name]" value=""/>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center hide-have-a-child">
                            <a href="#" class="btn btn-primary w-20 mt-5 add-item-variation" data-count="1"><i class="flaticon2-plus"></i> Add Another Variation</a>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <button type="reset" class="btn btn-secondary">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $('input[name="have_a_child"]').on('change', function(){
        var checked = $('input[name="have_a_child"]:checked').length;

        if (checked == 0) {
            $('.hide-have-a-child').removeClass('d-none');
        } else {
            $('.hide-have-a-child').addClass('d-none');
        }
    });

    $('.add-item-variation').click(function(e){
        e.preventDefault();

        var dataCount = $(this).data('count');
        var listBox = $('.variation-box');

        var html = `<div class="variation-item mt-5">
            <div class="row">
                <div class="form-group picture_upload col-md-6">
                    <label>Variation Image</label>
                    <div class="form-group__file">
                        <div class="file-wrapper">
                            <input type="file" name="variation[`+dataCount+`][image]" class="file-input">
                            <div class="file-preview-background">+</div>
                            <img src="" width="240px" class="file-preview">
                        </div>
                    </div>
                                        </div>
                <div class="col-md-6">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                        <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" role="tab" href="#id`+dataCount+`VariationTab">Indonesia</a>
                            </li>
                                                        <li class="nav-item">
                                <a class="nav-link " data-toggle="tab" role="tab" href="#en`+dataCount+`VariationTab">English</a>
                            </li>
                                                </ul>

                    <div class="tab-content mb-4" style="display: block !important;">
                                                        <div class="tab-pane active" id="id`+dataCount+`VariationTab" role="tabpanel">
                                <div class="row mt-5">
                                    <div class="form-group col-md-12">
                                        <label>Name</label>
                                        <input type="text" class="form-control" placeholder="Enter name" name="variation[`+dataCount+`][input][id][name]" value="">
                                    </div>
                                </div>
                            </div>
                                                        <div class="tab-pane " id="en`+dataCount+`VariationTab" role="tabpanel">
                                <div class="row mt-5">
                                    <div class="form-group col-md-12">
                                        <label>Name</label>
                                        <input type="text" class="form-control" placeholder="Enter name" name="variation[`+dataCount+`][input][en][name]" value="">
                                    </div>
                                </div>
                            </div>
                                                </div>
                </div>
            </div>
        </div>`;

        listBox.append(html);

        $(this).data('count', dataCount + 1)
    })

    $(document).ready(function() {
        // var haveAChild = $('input[name="have_a_child"]').val();

        $('.duplicate-form').select2({
            minimumInputLength: 0,
            tags: true,
            minimumResultsForSearch: 10,
            ajax: {
                url: "{{ url('admin-cms/products/products/customizations/'.$id.'/options/'.$idCustomization.'/get-option-to-duplicate') }}",
                dataType: "json",
                type: "GET",
                data: function (params) {
                    var queryParameters = {
                        term: params.term,

                    }
                    return queryParameters;
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id_product_customization_option_id
                            }
                        })
                    };
                }
            }
        })
    })

    $('.duplicate-form').on('change', function(){
        var id = $(this).find('option:selected').val();
        $.ajax({
            url: "{{ url('admin-cms/products/products/customizations/'.$id.'/options/'.$idCustomization.'/option-to-duplicate') }}",
            dataType: "json",
            type: "GET",
            data: {
                id: id
            },
            success: function (data) {
                $('input[name="have_a_child"]').attr('disabled', true)

                @foreach ($lang as $key => $val)
                    $('input[name="input[{{ $key }}][name]"]').val(data.product_customization_option.{{ $key }}.name)
                @endforeach

                var dataCount = 0;
                $.each(data.product_customization_option_variation_id, function (k, v){
                    dataCount = k;
                    var html = `<div class="variation-item mt-5">
                        <div class="row">
                            <div class="form-group picture_upload col-md-6">
                                <label>Variation Image</label>
                                <div class="form-group__file">
                                    <div class="file-wrapper">
                                        <input type="file" name="variation[`+k+`][image]" class="file-input">
                                        <div class="file-preview-background">+</div>
                                        <img src="`+v.image.path+`" width="240px" class="file-preview" style="opacity: 1">
                                    </div>
                                </div>
                                <input type="hidden" name="variation[`+k+`][image_id]" value="`+v.image.id+`">
                            </div>
                            <div class="col-md-6">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    @foreach ($lang as $key => $val)
                                        <li class="nav-item">
                                            <a class="nav-link {{ $key == 'id' ? 'active' : '' }}" data-toggle="tab" role="tab" href="#{{ $key }}`+k+`VariationTab">{{ $val }}</a>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="tab-content mb-4" style="display: block !important;">
                                    @foreach ($lang as $key => $val)
                                        <div class="tab-pane {{ $key == 'id' ? 'active' : '' }}" id="{{ $key }}`+k+`VariationTab" role="tabpanel">
                                            <div class="row mt-5">
                                                <div class="form-group col-md-12">
                                                    <label>Name</label>
                                                    <input type="text" class="form-control" placeholder="Enter name" name="variation[`+k+`][input][{{ $key }}][name]" value="`+ v.product_customization_option_variation.{{ $key }}.name +`">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>`;

                    if(k == 0){
                        $('.variation-box').html(html);
                    }else{
                        $('.variation-box').append(html);
                    }
                })

                $('.add-item-variation').data('count', dataCount + 1)
            }
        })
    })
</script>
@endsection
