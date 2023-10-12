@extends('backend.layouts.app')

@section('content')
    <div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <h5 class="text-dark font-weight-bold my-1 mr-5">
                        Edit Property
                    </h5>

                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-muted">Products</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin-cms/products/properties') }}" class="text-muted">Properties</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ url('admin-cms/products/properties/edit/'.$data['id']) }}" class="text-muted">Edit Property</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
		<div class=" container ">
            <form action="{{ url('admin-cms/products/properties/edit/'.$data['id']) }}" method="POST" enctype="multipart/form-data">
                <div class="row">
                    @csrf
                    <div class="col-md-6">
                        <div class="card card-custom">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">Edit Property</h3>
                                </div>
                                <div class="card-toolbar">
                                    <a href="{{ url('admin-cms/products/properties') }}" class="btn btn-danger font-weight-bolder">
                                        <span class="svg-icon svg-icon-md"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-12.000003, -11.999999) "/>
                                            </g>
                                        </svg></span> Back
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>Image</label>
                                        <div class="form-group__file">
                                            <div class="file-wrapper">
                                                <input type="file" name="image" class="file-input"/>
                                                <div class="file-preview-background">+</div>
                                                <img src="{{ $data['image']['path'] ?? '' }}" style="opacity: 1" width="240px" class="file-preview"/>
                                            </div>
                                        </div>
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>Sort</label>
                                        <select name="sort" id="" class="form-control @if($errors->has('sort')) is-invalid @endif">
                                            <option value="">-- LAST ORDER --</option>
                                            @php
                                                $sortData = !empty(old('sort')) ? old('sort') : $data['sort'];
                                            @endphp
                                            @for($i = 1; $i <= $sort; $i++)
                                                <option value="{{ $i }}" {{ $sortData == $i ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                        @error('sort')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-12 col-form-label">
                                            <div class="checkbox-inline">
                                                <label class="checkbox checkbox-success">
                                                    <input type="checkbox" name="is_active" {{ (!empty(old('is_active')) ? old('is_active') : $data['is_active']) == '1' ? 'checked' : '' }}/>
                                                    <span></span>
                                                    Active
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="separator separator-solid separator-border-3 mb-5"></div>

                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" role="tab" href="#idTab">Indonesia</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" role="tab" href="#enTab">English</a>
                                    </li>
                                </ul>

                                <div class="tab-content mb-4" style="display: block !important;">
                                    <div class="tab-pane active" id="idTab" role="tabpanel">
                                        <div class="row mt-5">
                                            <div class="form-group col-md-12">
                                                <label>Name</label>
                                                <input type="text" class="form-control @if($errors->has('input.id.name')) is-invalid @endif" placeholder="Enter name" name="input[id][name]" value="{{ !empty(old('input.id.name')) ? old('input.id.name') : $data['product_property']['id']['name'] }}"/>
                                                @error('input.id.name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="enTab" role="tabpanel">
                                        <div class="row mt-5">
                                            <div class="form-group col-md-12">
                                                <label>Name</label>
                                                <input type="text" class="form-control @if($errors->has('input.en.name')) is-invalid @endif" placeholder="Enter name" name="input[en][name]" value="{{ !empty(old('input.en.name')) ? old('input.en.name') : $data['product_property']['en']['name'] }}"/>
                                                @error('input.en.name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                <button type="reset" class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-custom">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">Property Value</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="property-box">
                                    @foreach ($data['product_property_value_id'] as $key => $val)
                                        <div class="property-item p-5" style="border: 1px dashed #d1d6dd">
                                            <input type="hidden" name="value[{{ $key }}][id]" value="{{ $val['id'] }}">
                                            <a href="#" class="btn btn-icon delete-item-value btn-danger btn-xs" style="position: absolute; margin-top:-4vh; margin-left: -30px"><i class="flaticon2-delete"></i></a>

                                            <div class="form-group col-md-12">
                                                <label>Image Value</label>
                                                <div class="form-group__file">
                                                    <div class="file-wrapper">
                                                        <input type="file" name="value[{{ $key }}][image]" class="file-input"/>
                                                        <div class="file-preview-background">+</div>
                                                        <img src="{{ $data['product_property_value_id'][$key]['image']['path'] ?? '' }}" style="opacity: 1" width="240px" class="file-preview"/>
                                                    </div>
                                                </div>
                                                @error('value.*.image')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" role="tab" href="#idValue0Tab">Indonesia</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" role="tab" href="#enValue0Tab">English</a>
                                                </li>
                                            </ul>

                                            <div class="tab-content mb-4" style="display: block !important;">
                                                <div class="tab-pane active" id="idValue0Tab" role="tabpanel">
                                                    <div class="row mt-5">
                                                        <div class="form-group col-md-12">
                                                            <label>Name Value</label>
                                                            <input type="text" class="form-control @if($errors->has('value.*.id.name')) is-invalid @endif" placeholder="Enter name" name="value[{{ $key }}][input][id][name]" value="{{ $data['product_property_value_id'][$key]['product_property_value']['id']['name'] ?? '' }}"/>
                                                            @error('value.*.id.name')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="enValue0Tab" role="tabpanel">
                                                    <div class="row mt-5">
                                                        <div class="form-group col-md-12">
                                                            <label>Name Value</label>
                                                            <input type="text" class="form-control @if($errors->has('value.*.en.name')) is-invalid @endif" placeholder="Enter name" name="value[{{ $key }}][input][en][name]" value="{{ $data['product_property_value_id'][$key]['product_property_value']['en']['name'] ?? '' }}"/>
                                                            @error('value.*.en.name')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <a href="#" class="btn btn-primary w-100 mt-5 add-item-value" data-count="{{ count($data['product_property_value_id']) }}"><i class="flaticon2-plus"></i> Add Item</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('public/backend/plugins/custom/ckeditor/ckeditor-classic.bundle.js?v=7.0.6') }}"></script>
    <script>
        $('.add-item-value').click(function(e){
            e.preventDefault();

            var dataCount = $(this).data('count');
            console.log(dataCount + 1);
            var propertyBox = $('.property-box');

            var html = `<div class="property-item p-5 mt-5" style="border: 1px dashed #d1d6dd">
                <a href="#" class="btn btn-icon delete-item-value btn-danger btn-xs" style="position: absolute; margin-top:-4vh; margin-left: -30px"><i class="flaticon2-delete"></i></a>

                <div class="form-group col-md-12">
                    <label>Image Value</label>
                    <div class="form-group__file">
                        <div class="file-wrapper">
                            <input type="file" name="value[`+dataCount+`][image]" class="file-input"/>
                            <div class="file-preview-background">+</div>
                            <img src="" width="240px" class="file-preview"/>
                        </div>
                    </div>
                    @error('value.*.image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" role="tab" href="#idValue`+dataCount+`Tab">Indonesia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" role="tab" href="#enValue`+dataCount+`Tab">English</a>
                    </li>
                </ul>

                <div class="tab-content mb-4" style="display: block !important;">
                    <div class="tab-pane active" id="idValue`+dataCount+`Tab" role="tabpanel">
                        <div class="row mt-5">
                            <div class="form-group col-md-12">
                                <label>Name Value</label>
                                <input type="text" class="form-control @if($errors->has('value.*.id.name')) is-invalid @endif" placeholder="Enter name" name="value[`+dataCount+`][input][id][name]" value="{{ old('value.*.id.name') }}"/>
                                @error('value.*.id.name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="enValue`+dataCount+`Tab" role="tabpanel">
                        <div class="row mt-5">
                            <div class="form-group col-md-12">
                                <label>Name Value</label>
                                <input type="text" class="form-control @if($errors->has('value.*.en.name')) is-invalid @endif" placeholder="Enter name" name="value[`+dataCount+`][input][en][name]" value="{{ old('value.*.en.name') }}"/>
                                @error('value.*.en.name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;

            propertyBox.append(html);

            $(this).data('count', dataCount + 1)
        })

        $(document).on('click', '.delete-item-value', function(){
            $(this).parent().remove();
        })
    </script>

    <style>
        .form-group__file {
            display: flex;
            flex-direction: column;
            position: relative;
            width: 100%;
            min-width: 130px;
            height: 240px;
        }

        .file-wrapper {
            position: relative;
        }

        .file-label {
            margin: 10px 0;
        }

        .file-input {
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 240px;
            cursor: pointer;
            z-index: 100;
        }

        .file-preview-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 240px;
            border: 1px solid #E4E6EF;
            border-radius: 14px;
            text-transform: uppercase;
            font-size: 70px;
            letter-spacing: 3px;
            text-align: center;
            color: #bbb;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1;
        }

        .file-preview {
            width: 100%;
            height: 240px;
            position: absolute;
            top: 0;
            left: 0;
            border-radius: 10px;
            z-index: 10;
            object-fit: cover;
            opacity: 0;
            transition: opacity 0.4s ease-in;
        }
    </style>
@endsection
