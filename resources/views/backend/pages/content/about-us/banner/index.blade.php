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
                        Banner
                    </h5>

                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-muted">Content</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#" class="text-muted">About Us</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ url('admin-cms/content/about-us/banner') }}" class="text-muted">Banner</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
		<div class=" container ">
            <div class="card card-custom mb-5">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Banner</h3>
                    </div>
                </div>
                <form action="{{ url('admin-cms/content/about-us/banner/create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group picture_upload">
                            <label>Image</label>
                            <div class="form-group__file">
                                <div class="file-wrapper">
                                    <input type="file" name="image" class="file-input"/>
                                    <div class="file-preview-background">+</div>
                                    @if (!empty($data))
                                        <img src="{{ $data['image']['path'] ?? '' }}" style="opacity: 1" width="240px" class="file-preview"/>
                                    @else
                                        <img src="" width="240px" class="file-preview"/>
                                    @endif
                                </div>
                            </div>
                        </div>

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
                                            <label>Title</label>
                                            <input type="text" class="form-control" name="input[{{ $key }}][title]" placeholder="Enter title" value="{{ $data['about_us_banner'][$key]['title'] ?? '' }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Description</label>
                                            <textarea name="input[{{ $key }}][description]" class="form-control" placeholder="Enter description">{{ $data['about_us_banner'][$key]['description'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>

    </script>
@endsection
