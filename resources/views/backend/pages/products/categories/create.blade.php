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
                            <a href="#" class="text-muted">Products</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin-cms/products/categories') }}" class="text-muted">Categories</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ url('admin-cms/products/categories/create') }}" class="text-muted">Create Category</a>
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
                    <form action="{{ url('admin-cms/products/categories/create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Thumbnail</label>
                                    <div class="form-group__file">
                                        <div class="file-wrapper">
                                            <input type="file" name="id_card" class="file-input imageUpload" accept="image/png, image/gif, image/jpeg"/>
                                            <div class="file-preview-background">+</div>
                                            <img src="" id="imagePreview" width="240px" class="file-preview"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group picture_upload col-md-6">
                                    <label>Banner</label>
                                    <div class="form-group__file">
                                        <div class="file-wrapper">
                                            <input type="file" name="id_card" class="file-input imageUpload" accept="image/png, image/gif, image/jpeg"/>
                                            <div class="file-preview-background">+</div>
                                            <img src="" id="imagePreview" width="240px" class="file-preview"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Name</label>
                                    <input type="text" class="form-control @if($errors->has('input.id.name')) is-invalid @endif" placeholder="Enter name" name="input[id][name]" value="{{ old('input.id.name') }}"/>
                                    @error('input.id.name')
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
                                            <label>Name</label>
                                            <input type="text" class="form-control @if($errors->has('input.id.name')) is-invalid @endif" placeholder="Enter name" name="input[id][name]" value="{{ old('input.id.name') }}"/>
                                            @error('input.id.name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
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
                                    </div>
                                </div>
                                <div class="tab-pane" id="enTab" role="tabpanel">
                                    <div class="row mt-5">
                                        <div class="form-group col-md-6">
                                            <label>Name</label>
                                            <input type="text" class="form-control @if($errors->has('input.en.name')) is-invalid @endif" placeholder="Enter name" name="input[en][name]" value="{{ old('input.en.name') }}"/>
                                            @error('input.en.name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Description</label>
                                            <textarea name="input[en][description]" class="ckeditor-en-description @if($errors->has('input.en.description')) is-invalid @endif">{{ old('input.en.description') }}</textarea>
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
    <script src="{{ asset('public/backend/plugins/custom/ckeditor/ckeditor-classic.bundle.js?v=7.0.6') }}"></script>
    <script>
        $(document).ready(function(){
            ClassicEditor.create(document.querySelector('.ckeditor-id-description'));

            ClassicEditor.create(document.querySelector('.ckeditor-en-description'));

            $('.imageUpload').change(function(){
                readImgUrlAndPreview(this);
                function readImgUrlAndPreview(input){
                    if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#imagePreview').attr('src', e.target.result);
                        $('#imagePreview').css('opacity', 1);
                    }
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            });
        });

        const inputFile = document.querySelector(".picture__input");
        const pictureImage = document.querySelector(".picture__image");
        const pictureImageTxt = '<i class="flaticon-upload icon-xxl text-dark-50"></i> <span class="ml-3">Upload File</span>';
        pictureImage.innerHTML = pictureImageTxt;

        inputFile.addEventListener("change", function (e) {
        const inputTarget = e.target;
        const file = inputTarget.files[0];

        if (file) {
            const reader = new FileReader();

            reader.addEventListener("load", function (e) {
            const readerTarget = e.target;

            const img = document.createElement("img");
            img.src = readerTarget.result;
            img.classList.add("picture__img");

            pictureImage.innerHTML = "";
            pictureImage.appendChild(img);
            });

            reader.readAsDataURL(file);
        } else {
            pictureImage.innerHTML = pictureImageTxt;
        }
        });

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
