@extends('backend.layouts.app')

@section('content')
    <div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <h5 class="text-dark font-weight-bold my-1 mr-5">
                        Edit Header Banner
                    </h5>

                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-muted">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin-cms/home/header-banner') }}" class="text-muted">Header Banner</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ url('admin-cms/home/header-banner/edit/'.$headerBannerId->id) }}" class="text-muted">Edit Header Banner</a>
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
                            <span class="card-icon"><i class="flaticon2-analytics-2"></i></span>
                            <h3 class="card-label">Edit Header Banner</h3>
                        </div>
                        <div class="card-toolbar">
                            <a href="{{ url('admin-cms/home/header-banner') }}" class="btn btn-danger font-weight-bolder">
                                <span class="svg-icon svg-icon-md"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                        <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-12.000003, -11.999999) "/>
                                    </g>
                                </svg></span> Back
                            </a>
                        </div>
                    </div>
                    <form action="{{ url('admin-cms/home/header-banner/edit/'.$headerBannerId->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Image</label>
                                    <div class="custom-file">
                                        <input type="file" name="image" class="custom-file-input  @if($errors->has('image')) is-invalid @endif" id="customFile"/>
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                    @error('image')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <hr>

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
                                        <div class="form-group col-md-6">
                                            <label>Title</label>
                                            <input type="text" class="form-control @if($errors->has('input.id.title')) is-invalid @endif" placeholder="Enter title" name="input[id][title]" value="{{ !empty(old('input.id.title')) ? old('input.id.title') : $headerBanner['id']['title'] }}"/>
                                            @error('input.id.title')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Call to Action</label>
                                            <input type="text" class="form-control @if($errors->has('input.id.cta')) is-invalid @endif" placeholder="Enter call to action" name="input[id][cta]" value="{{ !empty(old('input.id.cta')) ? old('input.id.cta') : $headerBanner['id']['cta'] }}"/>
                                            @error('input.id.cta')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Link</label>
                                            <input type="text" class="form-control @if($errors->has('input.id.link')) is-invalid @endif" placeholder="Enter link" name="input[id][link]" value="{{ !empty(old('input.id.link')) ? old('input.id.link') : $headerBanner['id']['link'] }}"/>
                                            @error('input.id.link')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Description</label>
                                            <textarea name="input[id][description]" id="" rows="5" class="form-control @if($errors->has('input.id.description')) is-invalid @endif">{{ !empty(old('input.id.description')) ? old('input.id.description') : $headerBanner['id']['description'] }}</textarea>
                                            @error('input.id.description')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="enTab" role="tabpanel">
                                    <div class="row mt-5">
                                        <div class="form-group col-md-6">
                                            <label>Title</label>
                                            <input type="text" class="form-control @if($errors->has('input.en.title')) is-invalid @endif" placeholder="Enter title" name="input[en][title]" value="{{ !empty(old('input.en.title')) ? old('input.en.title') : $headerBanner['en']['title'] }}"/>
                                            @error('input.en.title')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Call to Action</label>
                                            <input type="text" class="form-control @if($errors->has('input.en.cta')) is-invalid @endif" placeholder="Enter call to action" name="input[en][cta]" value="{{ !empty(old('input.en.cta')) ? old('input.en.cta') : $headerBanner['en']['cta'] }}"/>
                                            @error('input.en.cta')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Link</label>
                                            <input type="text" class="form-control @if($errors->has('input.en.link')) is-invalid @endif" placeholder="Enter link" name="input[en][link]" value="{{ !empty(old('input.en.link')) ? old('input.en.link') : $headerBanner['en']['link'] }}"/>
                                            @error('input.en.link')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Description</label>
                                            <textarea name="input[en][description]" id="" rows="5" class="form-control @if($errors->has('input.en.description')) is-invalid @endif">{{ !empty(old('input.en.description')) ? old('input.en.description') : $headerBanner['en']['description'] }}</textarea>
                                            @error('input.en.description')
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
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){

        });
    </script>
@endsection
