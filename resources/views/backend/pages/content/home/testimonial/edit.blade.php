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
                        Edit Testimonial
                    </h5>

                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-muted">Content</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin-cms/content/home/testimonial') }}" class="text-muted">Testimonial</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ url('admin-cms/content/home/testimonial/edit/'.$data['id']) }}" class="text-muted">Edit Testimonial</a>
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
                        <h3 class="card-label">Edit Testimonial</h3>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ url('admin-cms/content/home/testimonial') }}" class="btn btn-danger font-weight-bolder">
                            <span class="svg-icon svg-icon-md"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                    <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-12.000003, -11.999999) "/>
                                </g>
                            </svg></span> Back
                        </a>
                    </div>
                </div>
                <form action="{{ url('admin-cms/content/home/testimonial/edit/'.$data['id']) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group picture_upload col-md-6">
                                <label>Image</label>
                                <div class="form-group__file">
                                    <div class="file-wrapper">
                                        <input type="file" name="image" class="file-input"/>
                                        <div class="file-preview-background">+</div>
                                        @if (!empty($data['image']['path']))
                                            <img src="{{ $data['image']['path'] ?? '' }}" style="opacity: 1" width="240px" class="file-preview"/>
                                        @else
                                            <img src="" width="240px" class="file-preview"/>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Product</label>
                                    <select name="id_product_id" id="" class="form-control">
                                        <option value="">-- CHOOSE PRODUCT --</option>
                                        @foreach ($products as $key => $val)
                                            <option value="{{ $val->id_product_id }}" {{ (!empty($data) && $data['id_product_id'] == $val->id_product_id) ? 'selected' : '' }}>{{ $val->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Sort</label>
                                    <select name="sort" id="" class="form-control">
                                        <option value="">-- LAST ORDER --</option>
                                        @for($i = 1; $i <= $sort; $i++)
                                            <option value="{{ $i }}" {{ (!empty($data) && $data['sort'] == $i) ? 'selected' : '' }} >{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="col-12 col-form-label">
                                        <div class="checkbox-inline">
                                            <label class="checkbox checkbox-success">
                                                <input type="checkbox" name="is_active" {{ (!empty($data) && $data['is_active']) ? 'checked' : '' }}/>
                                                <span></span>
                                                Active
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

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
                                            <label>Customer</label>
                                            <input type="text" class="form-control" placeholder="Enter customer" name="input[{{ $key }}][customer]" value="{{ $data['testimonial'][$key]['customer'] ?? '' }}"/>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Testimony</label>
                                            <textarea name="input[{{ $key }}][testimony]" placeholder="Enter testimony" id="" rows="5" class="form-control">{{ $data['testimonial'][$key]['testimony'] ?? '' }}</textarea>
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


