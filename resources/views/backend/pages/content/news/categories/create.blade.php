@extends('backend.layouts.app')

@section('content')
    <div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <h5 class="text-dark font-weight-bold my-1 mr-5">
                        Create Category
                    </h5>

                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-muted">Content</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#" class="text-muted">News</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin-cms/content/news/categories') }}" class="text-muted">Category</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ url('admin-cms/content/news/categories/create') }}" class="text-muted">Create Category</a>
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
                            <h3 class="card-label">Create Category</h3>
                        </div>
                        <div class="card-toolbar">
                            <a href="{{ url('admin-cms/content/news/categories') }}" class="btn btn-danger font-weight-bolder">
                                <span class="svg-icon svg-icon-md"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                        <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-12.000003, -11.999999) "/>
                                    </g>
                                </svg></span> Back
                            </a>
                        </div>
                    </div>
                    <form action="{{ url('admin-cms/content/news/categories/create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
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
                                            <input type="text" class="form-control @if($errors->has('input.id.name')) is-invalid @endif" placeholder="Enter name" name="input[id][name]" value="{{ old('input.id.name') }}"/>
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
                                            <input type="text" class="form-control @if($errors->has('input.en.name')) is-invalid @endif" placeholder="Enter name" name="input[en][name]" value="{{ old('input.en.name') }}"/>
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
                        <div class="form-group col-md-12">
                            <label>Description</label>
                            <textarea name="input[id][description]" class="ckeditor-id-description @if($errors->has('input.id.description')) is-invalid @endif">{{ old('input.id.description') }}</textarea>
                            @error('input.id.description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
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
        $(document).ready(function(){

        });
    </script>
@endsection
