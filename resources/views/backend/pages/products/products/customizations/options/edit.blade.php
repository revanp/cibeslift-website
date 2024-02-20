@extends('backend.layouts.app')

@section('content')
    <div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <h5 class="text-dark font-weight-bold my-1 mr-5">
                        Update Option
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
                            <a href="{{ url('admin-cms/products/products/customizations/'.$id.'/options/'.$idCustomization.'/edit/'.$idOption) }}" class="text-muted">Update Option</a>
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
                        <h3 class="card-label">Update Option</h3>
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
                <form action="{{ url('admin-cms/products/products/customizations/'.$id.'/options/'.$idCustomization.'/edit/'.$idOption) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
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
                                            <input type="text" class="form-control @if($errors->has('input.'.$key.'.name')) is-invalid @endif" placeholder="Enter name" name="input[{{ $key }}][name]" value="{{ $data['product_customization_option'][$key]['name'] }}"/>
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

                        <div class="variation-box mt-5 hide-have-a-child {{ $data['have_a_child'] != 0 ? 'd-none' : '' }}">
                            @if (!empty($data['product_customization_option_variation_id']))
                                @foreach ($data['product_customization_option_variation_id'] as $k => $v)
                                    <input type="hidden" name="variation[{{$k}}][id]" value="{{ $v['id'] }}">
                                    <div class="variation-item">
                                        <div class="row">
                                            <div class="form-group picture_upload col-md-6">
                                                <label>Variation Image</label>
                                                <div class="form-group__file">
                                                    <div class="file-wrapper">
                                                        <input type="file" name="variation[{{ $k }}][image]" class="file-input"/>
                                                        <div class="file-preview-background">+</div>
                                                        <img src="{{ $v['image']['path'] ?? '' }}" style="opacity: 1" width="240px" class="file-preview"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <ul class="nav nav-tabs" id="variationTab" role="tablist">
                                                    @foreach ($lang as $key => $val)
                                                        <li class="nav-item">
                                                            <a class="nav-link {{ $key == 'id' ? 'active' : '' }}" data-toggle="tab" role="tab" href="#{{ $key }}{{$k}}VariationTab">{{ $val }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>

                                                <div class="tab-content" style="display: block !important;">
                                                    @foreach ($lang as $key => $val)
                                                        <div class="tab-pane {{ $key == 'id' ? 'active' : '' }}" id="{{ $key }}{{$k}}VariationTab" role="tabpanel">
                                                            <div class="row mt-5">
                                                                <div class="form-group col-md-12">
                                                                    <label>Name</label>
                                                                    <input type="text" class="form-control" placeholder="Enter name" name="variation[{{ $k }}][input][{{ $key }}][name]" value="{{ $v['product_customization_option_variation'][$key]['name'] }}"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                @if (count($data['product_customization_option_variation_id']) > 1)
                                                    <a href="{{ url('admin-cms/products/products/customizations/'.$id.'/options/'.$idCustomization.'/edit/'.$idOption.'/delete-variation/'.$v['id']) }}" class="btn btn-danger btn-delete-variation"><i class="flaticon2-delete"></i> Delete</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
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
                            @endif
                        </div>
                        <div class="row justify-content-center hide-have-a-child {{ $data['have_a_child'] != 0 ? 'd-none' : '' }}">
                            <a href="{{ count($data['product_customization_option_variation_id']) == 0 ? 1 : count($data['product_customization_option_variation_id']) }}" class="btn btn-primary w-20 mt-5 add-item-variation" data-count="1"><i class="flaticon2-plus"></i> Add Another Variation</a>
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
    $('form').submit(function(e){
        e.preventDefault();

        var action = $(this).attr('action');

        var formData = new FormData(this);

        // $.ajax({
        //     url: "{{ url('admin-cms/products/products/validation') }}",
        //     type: 'POST',
        //     data: formData,
        //     processData: false,
        //     contentType: false,
        //     cache: false,
        //     success: function(data){

        //     },
        //     error: function(data){
        //         var result = data.responseJSON;

        //         $.each(result.data, function(key, value){
        //             toastr.error(value[0]);
        //         })
        //     }
        // })

        $.ajax({
            url: action,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data){
                if(data.redirect != null){
                    window.location.replace(data.redirect);
                }
            },
            error: function(data){
                var result = data.responseJSON;

                $.each(result.data, function(key, value){
                    toastr.error(value[0]);
                })
            }
        })
    });

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

    $('.btn-delete-variation').click(function(e){
        e.preventDefault();

        var href = $(this).attr('href');

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = href;
            }
        });

    });
</script>
@endsection
