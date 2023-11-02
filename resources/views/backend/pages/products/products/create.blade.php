@extends('backend.layouts.app')

@section('content')
    <div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <h5 class="text-dark font-weight-bold my-1 mr-5">
                        Create Product
                    </h5>

                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-muted">Products</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin-cms/products/products') }}" class="text-muted">Products</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ url('admin-cms/products/products/create') }}" class="text-muted">Create Product</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<form action="{{ url('admin-cms/products/products/create') }}" method="POST" enctype="multipart/form-data">
    <div class="d-flex flex-column-fluid">
		<div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Create Product</h3>
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
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 hide-have-a-child">
                            <label>Parent Product</label>
                            <select name="parent_id" class="form-control @if($errors->has('parent_id')) is-invalid @endif">
                                @php
                                    $parentIdData = !empty(old('parent_id')) ? old('parent_id') : '';
                                @endphp
                                <option value="">-- SELECT PARENT PRODUCT --</option>
                                @foreach ($parents as $key => $val)
                                    <option value="{{ $val->productId->id }}" {{ $parentIdData == '0' ? 'selected' : '' }}>{{ $val->name }}</option>
                                @endforeach
                                <option value="1">iseng</option>
                            </select>
                            <span class="form-text text-muted">Empty this field if product is standalone.</span>
                            @error('parent_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group picture_upload col-md-6">
                            <label>*Banner</label>
                            <div class="form-group__file">
                                <div class="file-wrapper">
                                    <input type="file" name="banner" class="file-input"/>
                                    <div class="file-preview-background">+</div>
                                    <img src="" width="240px" class="file-preview"/>
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
                                    <img src="" width="240px" class="file-preview"/>
                                </div>
                            </div>
                            @error('thumbnail')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group picture_upload col-md-6">
                            <label>Menu Icon</label>
                            <div class="form-group__file">
                                <div class="file-wrapper">
                                    <input type="file" name="menu_icon" class="file-input"/>
                                    <div class="file-preview-background">+</div>
                                    <img src="" width="240px" class="file-preview"/>
                                </div>
                            </div>
                            @error('menu_icon')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group picture_upload col-md-6 hide-parent-not-null">
                            <label>Product Summary Image</label>
                            <div class="form-group__file">
                                <div class="file-wrapper">
                                    <input type="file" name="product_summary_image" class="file-input"/>
                                    <div class="file-preview-background">+</div>
                                    <img src="" width="240px" class="file-preview"/>
                                </div>
                            </div>
                            @error('product_summary_image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Technologies</label>
                            <select name="technologies[]" multiple class="select2 form-control @if($errors->has('technologies')) is-invalid @endif">
                                @foreach ($technologies as $key => $val)
                                    <option value="{{ $val->id_product_technology_id }}">{{ $val->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6 hide-parent-not-null">
                            <label>*Product Summary Type</label>
                            <select name="product_summary_type" class="form-control @if($errors->has('product_summary_type')) is-invalid @endif">
                                @php
                                    $productSummaryTypeData = !empty(old('product_summary_type')) ? old('product_summary_type') : '';
                                @endphp
                                <option value="">-- SELECT PRODUCT SUMMARY TYPE --</option>
                                <option value="0" {{ $productSummaryTypeData == '0' ? 'selected' : '' }}>List Product</option>
                                <option value="1" {{ $productSummaryTypeData == '1' ? 'selected' : '' }}>Big Banner With Text on The Left</option>
                                <option value="2" {{ $productSummaryTypeData == '2' ? 'selected' : '' }}>Big Banner With Overlay and Center Text</option>
                                <option value="3" {{ $productSummaryTypeData == '3' ? 'selected' : '' }}>Big Banner Without Overlay and Black Text</option>
                            </select>
                            @error('product_summary_type')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Sort</label>
                            <select name="sort" id="" class="form-control @if($errors->has('sort')) is-invalid @endif">
                                <option value="">-- LAST ORDER --</option>
                                @for($i = 1; $i <= $sort; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @error('sort')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <div class="col-12 col-form-label">
                                <div class="checkbox-inline">
                                    <label class="checkbox checkbox-success">
                                        <input type="checkbox" name="is_active"/>
                                        <span></span>
                                        Active
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="separator separator-solid separator-border-3 mb-5"></div>

                    @include('backend.pages.products.products.create.product')
                </div>
            </div>

            <div class="specification-section">
                @include('backend.pages.products.products.create.specification')
            </div>

            <div class="card card-custom mt-5">
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

        $('input[name="have_a_child"]').on('change', function(){
            var checked = $('input[name="have_a_child"]:checked').length;

            if (checked == 0) {
                $('.hide-have-a-child').removeClass('d-none');
                $('.specification-section').removeClass('d-none');
            } else {
                $('select[name="parent_id"]').val('');
                $('.hide-parent-not-null').removeClass('d-none');
                $('.hide-have-a-child').addClass('d-none');
                $('.specification-section').addClass('d-none');
            }
        });

        $('select[name="parent_id"]').on('change', function(){
            var parentId = $(this).val();

            if (parentId == '') {
                $('.hide-parent-not-null').removeClass('d-none');
            }else{
                $('.hide-parent-not-null').addClass('d-none');
            }
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
                            <div class="form-group col-md-6">
                                <label>Name</label>
                                <input type="text" class="form-control @if($errors->has('image.*.id.name')) is-invalid @endif" placeholder="Enter name" name="image[`+dataCount+`][input][id][name]" value="{{ old('image.*.id.name') }}"/>
                                @error('image.*.id.name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Description</label>
                                <input type="text" class="form-control @if($errors->has('image.*.id.description')) is-invalid @endif" placeholder="Enter description" name="image[`+dataCount+`][input][id][description]" value="{{ old('image.*.id.description') }}"/>
                                @error('image.*.id.description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="enImage`+dataCount+`Tab" role="tabpanel">
                        <div class="row mt-5">
                            <div class="form-group col-md-6">
                                <label>Name</label>
                                <input type="text" class="form-control @if($errors->has('image.*.en.name')) is-invalid @endif" placeholder="Enter name" name="image[`+dataCount+`][input][en][name]" value="{{ old('image.*.en.name') }}"/>
                                @error('image.*.en.name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Description</label>
                                <input type="text" class="form-control @if($errors->has('image.*.en.description')) is-invalid @endif" placeholder="Enter description" name="image[`+dataCount+`][input][en][description]" value="{{ old('image.*.en.description') }}"/>
                                @error('image.*.en.description')
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
