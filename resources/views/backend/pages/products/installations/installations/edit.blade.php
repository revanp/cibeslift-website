@extends('backend.layouts.app')

@php
    $lang = ['id' => 'Indonesia', 'en' => 'English'];
@endphp

@section('content')
    <div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <h5 class="text-dark font-weight-bold my-1 mr-5">
                        Edit Installation
                    </h5>

                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-muted">Products</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#" class="text-muted">Installations</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin-cms/products/installations/installations') }}" class="text-muted">Installations</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ url('admin-cms/products/installations/installations/edit/'.$data['id']) }}" class="text-muted">Edit Installation</a>
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
                        <h3 class="card-label">Edit Installation</h3>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ url('admin-cms/products/installations/installations') }}" class="btn btn-danger font-weight-bolder">
                            <span class="svg-icon svg-icon-md"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                    <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-12.000003, -11.999999) "/>
                                </g>
                            </svg></span> Back
                        </a>
                    </div>
                </div>

                <form action="{{ url('admin-cms/products/installations/installations/edit/'.$data['id']) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group picture_upload col-md-12">
                                <label>Thumbnail</label>
                                <div class="form-group__file">
                                    <div class="file-wrapper">
                                        <input type="file" name="thumbnail" class="file-input"/>
                                        <div class="file-preview-background">+</div>
                                        @if (!empty($data['thumbnail']))
                                            <img src="{{ $data['thumbnail']['path'] ?? '' }}" style="opacity: 1" width="240px" class="file-preview"/>
                                        @else
                                            <img src="" width="240px" class="file-preview"/>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Images (<a href="javascript:;" data-count="{{ count($data['image']) <= 3 ? 3 : count($data['image']) }}" class="add-item-image">Add More</a>)</label>
                                <div class="image-box row">
                                    <div class="image-item col-md-4">
                                        <div class="form-group picture_upload">
                                            <div class="form-group__file">
                                                <div class="file-wrapper">
                                                    <input type="file" name="image[0]" class="file-input"/>
                                                    <div class="file-preview-background">+</div>
                                                    @if (!empty($data['image'][0]))
                                                        <img src="{{ $data['image'][0]['path'] ?? '' }}" style="opacity: 1" width="240px" class="file-preview"/>
                                                        <input type="text" name="image_id[0]" value="{{ $data['image'][0]['id'] }}">
                                                    @else
                                                        <img src="" width="240px" class="file-preview"/>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="image-item col-md-4">
                                        <div class="form-group picture_upload">
                                            <div class="form-group__file">
                                                <div class="file-wrapper">
                                                    <input type="file" name="image[1]" class="file-input"/>
                                                    <div class="file-preview-background">+</div>
                                                    @if (!empty($data['image'][1]))
                                                        <img src="{{ $data['image'][1]['path'] ?? '' }}" style="opacity: 1" width="240px" class="file-preview"/>
                                                        <input type="text" name="image_id[1]" value="{{ $data['image'][1]['id'] }}">
                                                    @else
                                                        <img src="" width="240px" class="file-preview"/>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="image-item col-md-4">
                                        <div class="form-group picture_upload">
                                            <div class="form-group__file">
                                                <div class="file-wrapper">
                                                    <input type="file" name="image[2]" class="file-input"/>
                                                    <div class="file-preview-background">+</div>
                                                    @if (!empty($data['image'][2]))
                                                        <img src="{{ $data['image'][2]['path'] ?? '' }}" style="opacity: 1" width="240px" class="file-preview"/>
                                                        <input type="text" name="image_id[2]" value="{{ $data['image'][2]['id'] }}">
                                                    @else
                                                        <img src="" width="240px" class="file-preview"/>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach ($data['image'] as $key => $val)
                                        @if ($key >= 4)
                                            <div class="image-item col-md-4">
                                                <div class="form-group picture_upload">
                                                    <div class="form-group__file">
                                                        <div class="file-wrapper">
                                                            <input type="file" name="image[{{ $key }}]" class="file-input"/>
                                                            <div class="file-preview-background">+</div>
                                                            @if (!empty($data['image'][$key]))
                                                                <img src="{{ $data['image'][$key]['path'] ?? '' }}" style="opacity: 1" width="240px" class="file-preview"/>
                                                                <input type="text" name="image_id[{{ $key }}]" value="{{ $data['image'][$key]['id'] }}">
                                                            @else
                                                                <img src="" width="240px" class="file-preview"/>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Product</label>
                                <select name="id_product_id" class="form-control">
                                    <option value="" selected disabled>-- SELECT PRODUCT --</option>
                                    @foreach ($products as $key => $val)
                                        <option value="{{ $val->id_product_id }}" {{ $data['id_product_id'] == $val->id_product_id ? 'selected' : '' }}>{{ $val->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Size</label>
                                <select name="id_product_installation_size_id" class="form-control">
                                    <option value="" selected disabled>-- SELECT SIZE --</option>
                                    @foreach ($size as $key => $val)
                                        <option value="{{ $val->id_product_installation_size_id }}"{{ $data['id_product_installation_size_id'] == $val->id_product_installation_size_id ? 'selected' : '' }}>{{ $val->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Floor Size</label>
                                <select name="id_product_installation_floor_size_id" class="form-control">
                                    <option value="" selected disabled>-- SELECT FLOOR SIZE --</option>
                                    @foreach ($floorSize as $key => $val)
                                        <option value="{{ $val->id_product_installation_floor_size_id }}" {{ $data['id_product_installation_floor_size_id'] == $val->id_product_installation_floor_size_id ? 'selected' : '' }}>{{ $val->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Area</label>
                                <select name="id_product_installation_area_id" class="form-control">
                                    <option value="" selected disabled>-- SELECT AREA --</option>
                                    @foreach ($area as $key => $val)
                                        <option value="{{ $val->id_product_installation_area_id }}" {{ $data['id_product_installation_area_id'] == $val->id_product_installation_area_id ? 'selected' : '' }}>{{ $val->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Location</label>
                                <select name="id_product_installation_location_id" class="form-control">
                                    <option value="" selected disabled>-- SELECT LOCATION --</option>
                                    @foreach ($location as $key => $val)
                                        <option value="{{ $val->id_product_installation_location_id }}" {{ $data['id_product_installation_location_id'] == $val->id_product_installation_location_id ? 'selected' : '' }}>{{ $val->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Color</label>
                                <select name="id_product_installation_color_id" class="form-control">
                                    <option value="" selected disabled>-- SELECT COLOR --</option>
                                    @foreach ($color as $key => $val)
                                        <option value="{{ $val->id_product_installation_color_id }}" {{ $data['id_product_installation_color_id'] == $val->id_product_installation_color_id ? 'selected' : '' }}>{{ $val->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Location (City)</label>
                                <input type="text" class="form-control" name="location" placeholder="Enter location" value="{{ $data['location'] ?? '' }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Number of Stops</label>
                                <input type="text" class="form-control" name="number_of_stops" placeholder="Enter number of stops" value="{{ $data['number_of_stops'] ?? '' }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Installation Date</label>
                                <input type="text" class="form-control datepicker w-100" name="installation_date" placeholder="Enter installation date" readonly value="{{ $data['installation_date'] ?? '' }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <div class="col-12 col-form-label">
                                    <div class="checkbox-inline">
                                        <label class="checkbox checkbox-success">
                                            <input type="checkbox" name="is_active" {{ $data['is_active'] ? 'checked' : '' }}/>
                                            <span></span>
                                            Active
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="separator separator-solid separator-border-3 mb-5"></div>

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
                                        <div class="form-group col-md-6">
                                            <label>Name</label>
                                            <input type="text" class="form-control" placeholder="Enter name" name="input[{{ $key }}][name]" value="{{ $data['product_installation'][$key]['name'] ?? '' }}"/>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Description</label>
                                            <textarea name="input[{{ $key }}][description]" class="form-control" placeholder="Enter description">{{ $data['product_installation'][$key]['description'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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

        $('.add-item-image').click(function(e){
            e.preventDefault();

            var dataCount = $(this).data('count');
            var imageBox = $('.image-box');

            var html = `<div class="image-item col-md-4">
                <div class="form-group picture_upload">
                    <div class="form-group__file">
                        <div class="file-wrapper">
                            <input type="file" name="image[`+dataCount+`]" class="file-input"/>
                            <div class="file-preview-background">+</div>
                            <img src="" width="240px" class="file-preview"/>
                        </div>
                    </div>
                </div>
            </div>`;

            imageBox.append(html);

            $(this).data('count', dataCount + 1)
        })
    </script>
@endsection