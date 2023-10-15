@extends('backend.layouts.app')

@section('content')
    <div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <h5 class="text-dark font-weight-bold my-1 mr-5">
                        Create News
                    </h5>

                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-muted">Content</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#" class="text-muted">News</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin-cms/content/news/news') }}" class="text-muted">News</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ url('admin-cms/content/news/news/create') }}" class="text-muted">Create News</a>
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
                            <h3 class="card-label">Create News</h3>
                        </div>
                        <div class="card-toolbar">
                            <a href="{{ url('admin-cms/content/news/news') }}" class="btn btn-danger font-weight-bolder">
                                <span class="svg-icon svg-icon-md"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                        <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-12.000003, -11.999999) "/>
                                    </g>
                                </svg></span> Back
                            </a>
                        </div>
                    </div>
                    <form action="{{ url('admin-cms/content/news/news/create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Thumbnail</label>
                                    <div class="form-group__file">
                                        <div class="file-wrapper">
                                            <input type="file" name="thumbnail" class="file-input thumbnailUpload"/>
                                            <div class="file-preview-background">+</div>
                                            <img src="" width="240px" class="file-preview"/>
                                        </div>
                                    </div>
                                    @error('thumbnail')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Category</label>
                                    <select name="id_news_category_id" class="form-control @if($errors->has('id_news_category_id')) is-invalid @endif">
                                        <option value="">-- SELECT CATEGORY --</option>
                                        @php
                                            $idNewsCategoryId = old('id_news_category_id');
                                        @endphp
                                        @foreach ($categories as $key => $val)
                                            <option value="{{ $val->id_news_category_id }}" {{ $idNewsCategoryId == $val->id_news_category_id ? 'selected' : '' }}>{{ $val->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_news_category_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Publish Date</label>
                                    <div class="input-group date" >
                                        <input type="text" class="form-control datepicker @if($errors->has('publish_date')) is-invalid @endif" readonly name="publish_date" value="{{ old('publish_date') }}"/>
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                    @error('publish_date')
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
                                <div class="form-group col-md-3">
                                    <div class="col-12 col-form-label">
                                        <div class="checkbox-inline">
                                            <label class="checkbox checkbox-success">
                                                <input type="checkbox" name="is_top"/>
                                                <span></span>
                                                Always Top?
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="col-12 col-form-label">
                                        <div class="checkbox-inline">
                                            <label class="checkbox checkbox-success">
                                                <input type="checkbox" name="is_home"/>
                                                <span></span>
                                                Show at Home Page?
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                            <label>Title</label>
                                            <input type="text" class="form-control @if($errors->has('input.id.title')) is-invalid @endif" placeholder="Enter title" name="input[id][title]" value="{{ old('input.id.title') }}"/>
                                            @error('input.id.title')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Description</label>
                                            <textarea name="input[id][description]" class="form-control @if($errors->has('input.id.description')) is-invalid @endif" placeholder="Enter description">{{ old('input.id.description') }}</textarea>
                                            @error('input.id.description')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Content</label>
                                            <textarea name="input[id][content]" class="ckeditor-id-content @if($errors->has('input.id.content')) is-invalid @endif">{{ old('input.id.content') }}</textarea>
                                            @error('input.id.content')
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
                                            <input type="text" class="form-control @if($errors->has('input.id.seo_title')) is-invalid @endif" placeholder="Enter SEO title" name="input[id][seo_title]" value="{{ old('input.id.seo_title') }}"/>
                                            @error('input.id.seo_title')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>SEO Description</label>
                                            <textarea name="input[id][seo_description]" rows="3" class="form-control @if($errors->has('input.id.seo_description')) is-invalid @endif">{{ old('input.id.seo_description') }}</textarea>
                                            @error('input.id.seo_title')
                                            <div class="form-control">
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>SEO Keyword</label>
                                            <input type="text" class="form-control @if($errors->has('input.id.seo_keyword')) is-invalid @endif" placeholder="Enter SEO keyword" name="input[id][seo_keyword]" value="{{ old('input.id.seo_keyword') }}"/>
                                            @error('input.id.seo_keyword')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>SEO Canonical URL</label>
                                            <input type="text" class="form-control @if($errors->has('input.id.seo_canonical_url')) is-invalid @endif" placeholder="Enter SEO canonical URL" name="input[id][seo_canonical_url]" value="{{ old('input.id.seo_canonical_url') }}"/>
                                            @error('input.id.seo_canonical_url')
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
                                            <label>Title</label>
                                            <input type="text" class="form-control @if($errors->has('input.en.title')) is-invalid @endif" placeholder="Enter title" name="input[en][title]" value="{{ old('input.en.title') }}"/>
                                            @error('input.en.title')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Description</label>
                                            <textarea name="input[en][description]" class="form-control @if($errors->has('input.en.description')) is-invalid @endif" placeholder="Enter description">{{ old('input.en.description') }}</textarea>
                                            @error('input.en.description')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Content</label>
                                            <textarea name="input[en][content]" class="ckeditor-en-content @if($errors->has('input.en.content')) is-invalid @endif">{{ old('input.en.content') }}</textarea>
                                            @error('input.en.content')
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
                                            <input type="text" class="form-control @if($errors->has('input.en.seo_title')) is-invalid @endif" placeholder="Enter SEO title" name="input[en][seo_title]" value="{{ old('input.en.seo_title') }}"/>
                                            @error('input.en.seo_title')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>SEO Description</label>
                                            <textarea name="input[en][seo_description]" rows="3" class="form-control @if($errors->has('input.en.seo_description')) is-invalid @endif">{{ old('input.en.seo_description') }}</textarea>
                                            @error('input.en.seo_title')
                                            <div class="form-control">
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>SEO Keyword</label>
                                            <input type="text" class="form-control @if($errors->has('input.en.seo_keyword')) is-invalid @endif" placeholder="Enter SEO keyword" name="input[en][seo_keyword]" value="{{ old('input.en.seo_keyword') }}"/>
                                            @error('input.en.seo_keyword')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>SEO Canonical URL</label>
                                            <input type="text" class="form-control @if($errors->has('input.en.seo_canonical_url')) is-invalid @endif" placeholder="Enter SEO canonical URL" name="input[en][seo_canonical_url]" value="{{ old('input.en.seo_canonical_url') }}"/>
                                            @error('input.en.seo_canonical_url')
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
                    </form>
                </div>
        </div>

@endsection

@section('script')
    <script src="{{ asset('public/backend/plugins/custom/ckeditor/ckeditor-classic.bundle.js?v=7.0.6') }}"></script>
    <script>
        $(document).ready(function(){
            ClassicEditor.create(document.querySelector('.ckeditor-id-content'));
            ClassicEditor.create(document.querySelector('.ckeditor-en-content'));
        });
    </script>
@endsection
