@extends('backend.layouts.app')

@section('content')
    <div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <h5 class="text-dark font-weight-bold my-1 mr-5">
                        Edit Category
                    </h5>

                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-muted">Products</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin-cms/products/categories') }}" class="text-muted">Categories</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ url('admin-cms/products/categories/edit/'.$data['id']) }}" class="text-muted">Edit Category</a>
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
                            <h3 class="card-label">Edit Category</h3>
                        </div>
                        <div class="card-toolbar">
                            <a href="{{ url('admin-cms/products/categories') }}" class="btn btn-danger font-weight-bolder">
                                <span class="svg-icon svg-icon-md"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                        <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-12.000003, -11.999999) "/>
                                    </g>
                                </svg></span> Back
                            </a>
                        </div>
                    </div>
                    <form action="{{ url('admin-cms/products/categories/edit/'.$data['id']) }}" method="POST" enctype="multipart/form-data">
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
                                    <label>Menu Icon</label>
                                    <div class="form-group__file">
                                        <div class="file-wrapper">
                                            <input type="file" name="menu_icon" class="file-input"/>
                                            <div class="file-preview-background">+</div>
                                            <img src="{{ $data['menu_icon']['path'] ?? '' }}" style="opacity: 1" width="240px" class="file-preview"/>
                                        </div>
                                    </div>
                                    @error('menu_icon')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group picture_upload col-md-12">
                                    <label>Product Summary Image</label>
                                    <div class="form-group__file">
                                        <div class="file-wrapper">
                                            <input type="file" name="product_summary_image" class="file-input"/>
                                            <div class="file-preview-background">+</div>
                                            @if (!empty($data['product_summary_image']))
                                                <img src="{{ $data['product_summary_image']['path'] ?? '' }}" style="opacity: 1" width="240px" class="file-preview"/>
                                            @else
                                                <img src="" width="240px" class="file-preview"/>
                                            @endif
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
                                            <option value="{{ $val->id_product_technology_id }}" {{ in_array($val->id_product_technology_id, $data['product_category_id_has_product_technology_id']) ? 'selected' : '' }}>{{ $val->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Product Summary Type</label>
                                    <select name="product_summary_type" class="form-control @if($errors->has('product_summary_type')) is-invalid @endif">
                                        @php
                                            $productSummaryTypeData = !empty(old('product_summary_type')) ? old('product_summary_type') : $data['product_summary_type'];
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
                                                <input type="text" class="form-control @if($errors->has('input.'.$key.'.name')) is-invalid @endif" placeholder="Enter name" name="input[{{ $key }}][name]" value="{{ !empty(old('input.'.$key.'.name')) ? old('input.'.$key.'.name') : $data['product_category'][$key]['name'] }}"/>
                                                @error('input.'.$key.'.name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Page Title</label>
                                                <input type="text" class="form-control @if($errors->has('input.'.$key.'.page_title')) is-invalid @endif" placeholder="Enter post title" name="input[{{ $key }}][page_title]" value="{{ !empty(old('input.'.$key.'.page_title')) ? old('input.'.$key.'.page_title') : $data['product_category'][$key]['page_title'] }}"/>
                                                @error('input.'.$key.'.page_title')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Short Description</label>
                                                <textarea name="input[{{ $key }}][short_description]" class="form-control @if($errors->has('input.'.$key.'.short_description')) is-invalid @endif">{{ !empty(old('input.'.$key.'.short_description')) ? old('input.'.$key.'.short_description') : $data['product_category'][$key]['short_description'] }}</textarea>
                                                @error('input.'.$key.'.short_description')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Description</label>
                                                <textarea name="input[{{ $key }}][description]" rows="5" class="form-control @if($errors->has('input.'.$key.'.description')) is-invalid @endif">{{ !empty(old('input.'.$key.'.description')) ? old('input.'.$key.'.description') : $data['product_category'][$key]['description'] }}</textarea>
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
                                                <input type="text" class="form-control @if($errors->has('input.'.$key.'.seo_title')) is-invalid @endif" placeholder="Enter SEO title" name="input[{{ $key }}][seo_title]" value="{{ !empty(old('input.'.$key.'.seo_title')) ? old('input.'.$key.'.seo_title') : $data['product_category'][$key]['seo_title'] }}"/>
                                                @error('input.'.$key.'.seo_title')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>SEO Description</label>
                                                <textarea name="input[{{ $key }}][seo_description]" rows="3" class="form-control @if($errors->has('input.'.$key.'.seo_description')) is-invalid @endif">{{ !empty(old('input.'.$key.'.seo_description')) ? old('input.'.$key.'.seo_description') : $data['product_category'][$key]['seo_description'] }}</textarea>
                                                @error('input.'.$key.'.seo_title')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>SEO Keyword</label>
                                                <input type="text" class="form-control @if($errors->has('input.'.$key.'.seo_keyword')) is-invalid @endif" placeholder="Enter SEO keyword" name="input[{{ $key }}][seo_keyword]" value="{{ !empty(old('input.'.$key.'.seo_keyword')) ? old('input.'.$key.'.seo_keyword') : $data['product_category'][$key]['seo_keyword'] }}"/>
                                                @error('input.'.$key.'.seo_keyword')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>SEO Canonical URL</label>
                                                <input type="text" class="form-control @if($errors->has('input.'.$key.'.seo_canonical_url')) is-invalid @endif" placeholder="Enter SEO canonical URL" name="input[{{ $key }}][seo_canonical_url]" value="{{ !empty(old('input.'.$key.'.seo_canonical_url')) ? old('input.'.$key.'.seo_canonical_url') : $data['product_category'][$key]['seo_canonical_url'] }}"/>
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

@endsection
