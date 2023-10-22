@extends('backend.layouts.app')

@section('content')
    <div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <h5 class="text-dark font-weight-bold my-1 mr-5">
                        Edit Product
                    </h5>

                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-muted">Products</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin-cms/products/products') }}" class="text-muted">Products</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ url('admin-cms/products/products/edit/'.$data['id']) }}" class="text-muted">Edit Product</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<form action="{{ url('admin-cms/products/products/edit/'.$data['id']) }}" method="POST" enctype="multipart/form-data">
    <div class="d-flex flex-column-fluid">
		<div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Edit Product</h3>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ url('admin-cms/products/products') }}" class="btn btn-danger font-weight-bolder">
                            <span class="svg-icon svg-icon-md"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                    <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-12.000003, -11.999999) "/>
                                </g>
                            </svg></span> Back
                        </a>
                    </div>
                </div>
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="form-group picture_upload col-md-6">
                            <label>Banner</label>
                            <div class="form-group__file">
                                <div class="file-wrapper">
                                    <input type="file" name="banner" class="file-input"/>
                                    <div class="file-preview-background">+</div>
                                    <img src="{{ $data['banner']['path'] ?? '' }}" style="opacity: 1" width="240px" class="file-preview"/>
                                </div>
                            </div>
                            @error('banner')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group picture_upload col-md-6">
                            <label>Thumbnail</label>
                            <div class="form-group__file">
                                <div class="file-wrapper">
                                    <input type="file" name="thumbnail" class="file-input"/>
                                    <div class="file-preview-background">+</div>
                                    <img src="{{ $data['thumbnail']['path'] ?? '' }}" style="opacity: 1" width="240px" class="file-preview"/>
                                </div>
                            </div>
                            @error('thumbnail')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Product Category</label>
                            <select name="id_product_category_id" class="form-control @if($errors->has('id_product_category_id')) is-invalid @endif">
                                @php
                                    $idProductCategoryId = !empty(old('id_product_category_id')) ? old('id_product_category_id') : $data['id_product_category_id'];
                                @endphp
                                <option value="">-- SELECT PRODUCT CATEGORY --</option>
                                @foreach ($categories as $key => $val)
                                    <option value="{{ $val->id_product_category_id }}" {{ $idProductCategoryId == $val->id_product_category_id ? 'selected' : '' }}>{{ $val->name }}</option>
                                @endforeach]
                            </select>
                            @error('id_product_category_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
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
                        <div class="form-group col-md-3">
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
                                    <div class="form-group col-md-6">
                                        <label>Name</label>
                                        <input type="text" class="form-control @if($errors->has('input.'.$key.'.name')) is-invalid @endif" placeholder="Enter name" name="input[{{ $key }}][name]" value="{{ !empty(old('input.'.$key.'.name')) ? old('input.'.$key.'.name') : $data['product'][$key]['name'] }}"/>
                                        @error('input.'.$key.'.name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Page Title</label>
                                        <input type="text" class="form-control @if($errors->has('input.'.$key.'.page_title')) is-invalid @endif" placeholder="Enter post title" name="input[{{ $key }}][page_title]" value="{{ !empty(old('input.'.$key.'.page_title')) ? old('input.'.$key.'.page_title') : $data['product'][$key]['page_title'] }}"/>
                                        @error('input.'.$key.'.page_title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Short Description</label>
                                        <textarea name="input[{{ $key }}][short_description]" class="form-control @if($errors->has('input.'.$key.'.short_description')) is-invalid @endif">{{ !empty(old('input.'.$key.'.short_description')) ? old('input.'.$key.'.short_description') : $data['product'][$key]['short_description'] }}</textarea>
                                        @error('input.'.$key.'.short_description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Description</label>
                                        <textarea name="input[{{ $key }}][description]" rows="5" class="form-control @if($errors->has('input.'.$key.'.description')) is-invalid @endif">{{ !empty(old('input.'.$key.'.description')) ? old('input.'.$key.'.description') : $data['product'][$key]['description'] }}</textarea>
                                        @error('input.'.$key.'.description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="separator separator-dashed separator-border-2"></div>

                                <h3 class="display-5 mt-5">SEO</h3>
                                <div class="row mt-3">
                                    <div class="form-group col-md-6">
                                        <label>SEO Title</label>
                                        <input type="text" class="form-control @if($errors->has('input.'.$key.'.seo_title')) is-invalid @endif" placeholder="Enter SEO title" name="input[{{ $key }}][seo_title]" value="{{ !empty(old('input.'.$key.'.seo_title')) ? old('input.'.$key.'.seo_title') : $data['product'][$key]['seo_title'] }}"/>
                                        @error('input.'.$key.'.seo_title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>SEO Description</label>
                                        <textarea name="input[{{ $key }}][seo_description]" rows="3" class="form-control @if($errors->has('input.'.$key.'.seo_description')) is-invalid @endif">{{ !empty(old('input.'.$key.'.seo_description')) ? old('input.'.$key.'.seo_description') : $data['product'][$key]['seo_description'] }}</textarea>
                                        @error('input.'.$key.'.seo_title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>SEO Keyword</label>
                                        <input type="text" class="form-control @if($errors->has('input.'.$key.'.seo_keyword')) is-invalid @endif" placeholder="Enter SEO keyword" name="input[{{ $key }}][seo_keyword]" value="{{ !empty(old('input.'.$key.'.seo_keyword')) ? old('input.'.$key.'.seo_keyword') : $data['product'][$key]['seo_keyword'] }}"/>
                                        @error('input.'.$key.'.seo_keyword')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>SEO Canonical URL</label>
                                        <input type="text" class="form-control @if($errors->has('input.'.$key.'.seo_canonical_url')) is-invalid @endif" placeholder="Enter SEO canonical URL" name="input[{{ $key }}][seo_canonical_url]" value="{{ !empty(old('input.'.$key.'.seo_canonical_url')) ? old('input.'.$key.'.seo_canonical_url') : $data['product'][$key]['seo_canonical_url'] }}"/>
                                        @error('input.'.$key.'.seo_canonical_url')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card card-custom mt-5">
                <div class="card-header">
                    <div class="card-title">Product Specification</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group picture_upload col-md-6">
                            <label>Spesification Image</label>
                            <div class="form-group__file">
                                <div class="file-wrapper">
                                    <input type="file" name="spesification_image" class="file-input"/>
                                    <div class="file-preview-background">+</div>
                                    <img src="{{ $data['spesification_image']['path'] ?? '' }}" style="opacity: 1" width="240px" class="file-preview"/>
                                </div>
                            </div>
                            @error('spesification_image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Size</label>
                            <textarea name="specification[size]" class="ckeditor-size @if($errors->has('specification.size')) is-invalid @endif">{{ !empty(old('specification.size')) ? old('specification.size') : $data['product_specification']['size'] }}</textarea>
                            @error('specification.size')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Installation</label>
                            <input type="text" class="form-control @if($errors->has('specification.installation')) is-invalid @endif" placeholder="Enter installation" name="specification[installation]" value="{{ !empty(old('specification.installation')) ? old('specification.installation') : $data['product_specification']['installation'] }}"/>
                            @error('specification.installation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Power Supply</label>
                            <input type="text" class="form-control @if($errors->has('specification.power_supply')) is-invalid @endif" placeholder="Enter power supply" name="specification[power_supply]" value="{{ !empty(old('specification.power_supply')) ? old('specification.power_supply') : $data['product_specification']['power_supply'] }}"/>
                            @error('specification.power_supply')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Min. Headroom</label>
                            <input type="text" class="form-control @if($errors->has('specification.min_headroom')) is-invalid @endif" placeholder="Enter min. headroom" name="specification[min_headroom]" value="{{ !empty(old('specification.min_headroom')) ? old('specification.min_headroom') : $data['product_specification']['min_headroom'] }}"/>
                            @error('specification.min_headroom')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Drive System</label>
                            <input type="text" class="form-control @if($errors->has('specification.drive_system')) is-invalid @endif" placeholder="Enter drive system" name="specification[drive_system]" value="{{ !empty(old('specification.drive_system')) ? old('specification.drive_system') : $data['product_specification']['drive_system'] }}"/>
                            @error('specification.drive_system')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Max. Number of Stops</label>
                            <input type="text" class="form-control @if($errors->has('specification.max_number_of_stops')) is-invalid @endif" placeholder="Enter max. number of stops" name="specification[max_number_of_stops]" value="{{ !empty(old('specification.max_number_of_stops')) ? old('specification.max_number_of_stops') : $data['product_specification']['max_number_of_stops'] }}"/>
                            @error('specification.max_number_of_stops')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Door Configuration</label>
                            <input type="text" class="form-control @if($errors->has('specification.door_configuration')) is-invalid @endif" placeholder="Enter door configuration" name="specification[door_configuration]" value="{{ !empty(old('specification.door_configuration')) ? old('specification.door_configuration') : $data['product_specification']['door_configuration'] }}"/>
                            @error('specification.door_configuration')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Rated Load</label>
                            <input type="text" class="form-control @if($errors->has('specification.rated_load')) is-invalid @endif" placeholder="Enter rated load" name="specification[rated_load]" value="{{ !empty(old('specification.rated_load')) ? old('specification.rated_load') : $data['product_specification']['rated_load'] }}"/>
                            @error('specification.rated_load')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Speed Max.</label>
                            <input type="text" class="form-control @if($errors->has('specification.speed_max')) is-invalid @endif" placeholder="Enter speed max." name="specification[speed_max]" value="{{ !empty(old('specification.speed_max')) ? old('specification.speed_max') : $data['product_specification']['speed_max'] }}"/>
                            @error('specification.speed_max')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Lift Pit</label>
                            <input type="text" class="form-control @if($errors->has('specification.lift_pit')) is-invalid @endif" placeholder="Enter lift pit" name="specification[lift_pit]" value="{{ !empty(old('specification.lift_pit')) ? old('specification.lift_pit') : $data['product_specification']['lift_pit'] }}"/>
                            @error('specification.lift_pit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Max. Travel</label>
                            <input type="text" class="form-control @if($errors->has('specification.max_travel')) is-invalid @endif" placeholder="Enter max. travel" name="specification[max_travel]" value="{{ !empty(old('specification.max_travel')) ? old('specification.max_travel') : $data['product_specification']['max_travel'] }}"/>
                            @error('specification.max_travel')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Motor Power</label>
                            <input type="text" class="form-control @if($errors->has('specification.motor_power')) is-invalid @endif" placeholder="Enter motor power" name="specification[motor_power]" value="{{ !empty(old('specification.motor_power')) ? old('specification.motor_power') : $data['product_specification']['motor_power'] }}"/>
                            @error('specification.motor_power')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-custom mt-5">
                <div class="card-header">
                    <div class="card-title">Product Image</div>
                </div>
                <div class="card-body">
                    <div class="list-box">
                        @foreach ($data['product_image_id'] as $key => $val)
                            <div class="list-item p-5 {{ $key != 0 ? 'mt-5' : '' }}" style="border: 1px dashed #d1d6dd">
                                @if ($key != 0)
                                    <a href="#" class="btn btn-icon delete-item-value btn-danger btn-xs" style="position: absolute; margin-top:-4vh; margin-left: -30px"><i class="flaticon2-delete"></i></a>
                                @endif
                                <input type="hidden" name="image[{{ $key }}][id]" value="{{ $val['id'] }}">
                                <div class="form-group col-md-12">
                                    <label>Image</label>
                                    <div class="form-group__file">
                                        <div class="file-wrapper">
                                            <input type="file" name="image[{{ $key }}][image]" class="file-input"/>
                                            <div class="file-preview-background">+</div>
                                            <img src="{{ $data['product_image_id'][$key]['image']['path'] ?? '' }}" style="opacity: 1" width="240px" class="file-preview"/>
                                        </div>
                                    </div>
                                    @error('image.*.image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" role="tab" href="#idImage{{ $key }}Tab">Indonesia</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" role="tab" href="#enImage{{ $key }}Tab">English</a>
                                    </li>
                                </ul>

                                <div class="tab-content mb-4" style="display: block !important;">
                                    <div class="tab-pane active" id="idImage{{ $key }}Tab" role="tabpanel">
                                        <div class="row mt-5">
                                            <div class="form-group col-md-12">
                                                <label>Name</label>
                                                <input type="text" class="form-control @if($errors->has('image.*.id.name')) is-invalid @endif" placeholder="Enter name" name="image[{{ $key }}][input][id][name]" value="{{ $data['product_image_id'][$key]['product_image']['id']['name'] ?? '' }}"/>
                                                @error('image.*.id.name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="enImage{{ $key }}Tab" role="tabpanel">
                                        <div class="row mt-5">
                                            <div class="form-group col-md-12">
                                                <label>Name</label>
                                                <input type="text" class="form-control @if($errors->has('image.*.en.name')) is-invalid @endif" placeholder="Enter name" name="image[{{ $key }}][input][en][name]" value="{{ $data['product_image_id'][$key]['product_image']['en']['name'] ?? '' }}"/>
                                                @error('image.*.en.name')
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
                    <a href="#" class="btn btn-primary w-100 mt-5 add-item-value" data-count="{{ count($data['product_image_id']) }}"><i class="flaticon2-plus"></i> Add Item</a>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button type="reset" class="btn btn-secondary">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('script')
    <script src="{{ asset('public/backend/plugins/custom/ckeditor/ckeditor-classic.bundle.js?v=7.0.6') }}"></script>
    <script>
        $(document).ready(function(){
            ClassicEditor.create(document.querySelector('.ckeditor-size'));
        });

        $('.add-item-value').click(function(e){
            e.preventDefault();

            var dataCount = $(this).data('count');
            var listBox = $('.list-box');

            var html = `<div class="property-item p-5 mt-5" style="border: 1px dashed #d1d6dd">
                <a href="#" class="btn btn-icon delete-item-value btn-danger btn-xs" style="position: absolute; margin-top:-4vh; margin-left: -30px"><i class="flaticon2-delete"></i></a>

                <div class="form-group col-md-12">
                    <label>Image</label>
                    <div class="form-group__file">
                        <div class="file-wrapper">
                            <input type="file" name="image[`+dataCount+`][image]" class="file-input"/>
                            <div class="file-preview-background">+</div>
                            <img src="" width="240px" class="file-preview"/>
                        </div>
                    </div>
                </div>

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" role="tab" href="#idImage`+dataCount+`Tab">Indonesia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" role="tab" href="#enImage`+dataCount+`Tab">English</a>
                    </li>
                </ul>

                <div class="tab-content mb-4" style="display: block !important;">
                    <div class="tab-pane active" id="idImage`+dataCount+`Tab" role="tabpanel">
                        <div class="row mt-5">
                            <div class="form-group col-md-12">
                                <label>Name</label>
                                <input type="text" class="form-control @if($errors->has('image.*.id.name')) is-invalid @endif" placeholder="Enter name" name="image[`+dataCount+`][input][id][name]" value="{{ old('image.*.id.name') }}"/>
                                @error('image.*.id.name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="enImage`+dataCount+`Tab" role="tabpanel">
                        <div class="row mt-5">
                            <div class="form-group col-md-12">
                                <label>Name</label>
                                <input type="text" class="form-control @if($errors->has('image.*.en.name')) is-invalid @endif" placeholder="Enter name" name="image[`+dataCount+`][input][en][name]" value="{{ old('image.*.en.name') }}"/>
                                @error('image.*.en.name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;

            listBox.append(html);

            $(this).data('count', dataCount + 1)
        })

        $(document).on('click', '.delete-item-value', function(){
            $(this).parent().remove();
        })
    </script>
@endsection
