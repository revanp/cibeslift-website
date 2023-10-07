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
                                <div class="form-group col-md-6">
                                    <label>Thumbnail</label>
                                    <div class="form-group__file">
                                        <div class="file-wrapper">
                                            <input type="file" name="thumbnail" class="file-input thumbnailUpload"/>
                                            <div class="file-preview-background">+</div>
                                            <img src="{{ $data['thumbnail']['path'] ?? '' }}" style="opacity: 1" width="240px" class="file-preview"/>
                                        </div>
                                    </div>
                                    @error('thumbnail')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
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
                                    <label>File Icon</label>
                                    <div class="form-group__file">
                                        <div class="file-wrapper">
                                            <input type="file" name="file_icon" class="file-input"/>
                                            <div class="file-preview-background">+</div>
                                            <img src="{{ $data['file_icon']['path'] ?? '' }}" style="opacity: 1" width="240px" class="file-preview"/>
                                        </div>
                                    </div>
                                    @error('file_icon')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group picture_upload col-md-6">
                                    <label>Video Thumbnail</label>
                                    <div class="form-group__file">
                                        <div class="file-wrapper">
                                            <input type="file" name="video_thumbnail" class="file-input"/>
                                            <div class="file-preview-background">+</div>
                                            <img src="{{ $data['video_thumbnail']['path'] ?? '' }}" style="opacity: 1" width="240px" class="file-preview"/>
                                        </div>
                                    </div>
                                    @error('video_thumbnail')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group picture_upload col-md-4">
                                    @if (!empty($data['image'][0]))
                                        @if (count($data['image']) > 1)
                                            <label>Image 1 <strong><a href="{{ url('admin-cms/delete-media/'.$data['image'][0]['id']) }}" class="text-danger btn-delete-media">Delete</a></strong></label>
                                        @else
                                            <label>Image 1</label>
                                        @endif
                                    @else
                                        <label>Image 1</label>
                                    @endif

                                    <div class="form-group__file">
                                        <div class="file-wrapper">
                                            <input type="file" name="image[0]" class="file-input"/>
                                            <div class="file-preview-background">+</div>
                                            <img src="{{ $data['image'][0]['path'] ?? '' }}" {!! !empty($data['image'][0]) ? 'style="opacity: 1"' : '' !!} width="240px" class="file-preview"/>
                                            @if (!empty($data['image'][0]))
                                                <input type="hidden" name="image_id[0]" value="{{ $data['image'][0]['id'] }}">
                                            @endif
                                        </div>
                                    </div>
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group picture_upload col-md-4">
                                    @if (!empty($data['image'][1]))
                                        <label>Image 2 <strong><a href="{{ url('admin-cms/delete-media/'.$data['image'][1]['id']) }}" class="text-danger">Delete</a></strong></label>
                                    @else
                                        <label>Image 2</label>
                                    @endif
                                    <div class="form-group__file">
                                        <div class="file-wrapper">
                                            <input type="file" name="image[1]" class="file-input"/>
                                            <div class="file-preview-background">+</div>
                                            <img src="{{ $data['image'][1]['path'] ?? '' }}" {!! !empty($data['image'][1]) ? 'style="opacity: 1"' : '' !!} width="240px" class="file-preview"/>
                                            @if (!empty($data['image'][1]))
                                                <input type="hidden" name="image_id[1]" value="{{ $data['image'][1]['id'] }}">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group picture_upload col-md-4">
                                    @if (!empty($data['image'][2]))
                                        <label>Image 3 <strong><a href="{{ url('admin-cms/delete-media/'.$data['image'][2]['id']) }}" class="text-danger">Delete</a></strong></label>
                                    @else
                                        <label>Image 3</label>
                                    @endif
                                    <div class="form-group__file">
                                        <div class="file-wrapper">
                                            <input type="file" name="image[2]" class="file-input"/>
                                            <div class="file-preview-background">+</div>
                                            <img src="{{ $data['image'][2]['path'] ?? '' }}" {!! !empty($data['image'][2]) ? 'style="opacity: 1"' : '' !!} width="240px" class="file-preview"/>
                                            @if (!empty($data['image'][2]))
                                                <input type="hidden" name="image_id[2]" value="{{ $data['image'][2]['id'] }}">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Video URL</label>
                                    <input type="text" class="form-control @if($errors->has('video_url')) is-invalid @endif" placeholder="Enter video URL" name="video_url" value="{{ !empty(old('video_url')) ? old('video_url') : $data['video_url'] }}"/>
                                    @error('video_url')
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
                                <div class="form-group col-md-3">
                                    <div class="col-12 col-form-label">
                                        <div class="checkbox-inline">
                                            <label class="checkbox checkbox-success">
                                                <input type="checkbox" name="is_self_design" {{ (!empty(old('is_self_design')) ? old('is_self_design') : $data['is_self_design']) == '1' ? 'checked' : '' }}/>
                                                <span></span>
                                                Self Design
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
                                        <div class="form-group col-md-6">
                                            <label>Name</label>
                                            <input type="text" class="form-control @if($errors->has('input.id.name')) is-invalid @endif" placeholder="Enter name" name="input[id][name]" value="{{ !empty(old('input.id.name')) ? old('input.id.name') : $data['product_category']['id']['name'] }}"/>
                                            @error('input.id.name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Description</label>
                                            <textarea name="input[id][description]" class="ckeditor-id-description @if($errors->has('input.id.description')) is-invalid @endif">{{ !empty(old('input.id.description')) ? old('input.id.description') : $data['product_category']['id']['description'] }}</textarea>
                                            @error('input.id.description')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Post Title</label>
                                            <input type="text" class="form-control @if($errors->has('input.id.post_title')) is-invalid @endif" placeholder="Enter post title" name="input[id][post_title]"  value="{{ !empty(old('input.id.post_title')) ? old('input.id.post_title') : $data['product_category']['id']['post_title'] }}"/>
                                            @error('input.id.post_title')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Post Description</label>
                                            <textarea name="input[id][post_description]" class="ckeditor-id-post-description @if($errors->has('input.id.post_description')) is-invalid @endif">{{ !empty(old('input.id.post_description')) ? old('input.id.post_description') : $data['product_category']['id']['post_description'] }}</textarea>
                                            @error('input.id.post_description')
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
                                            <input type="text" class="form-control @if($errors->has('input.id.seo_title')) is-invalid @endif" placeholder="Enter SEO title" name="input[id][seo_title]" value="{{ !empty(old('input.id.seo_title')) ? old('input.id.seo_title') : $data['product_category']['id']['seo_title'] }}"/>
                                            @error('input.id.seo_title')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>SEO Description</label>
                                            <textarea name="input[id][seo_description]" rows="3" class="form-control @if($errors->has('input.id.seo_description')) is-invalid @endif">{{ !empty(old('input.id.seo_description')) ? old('input.id.seo_description') : $data['product_category']['id']['seo_description'] }}</textarea>
                                            @error('input.id.seo_title')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>SEO Keyword</label>
                                            <input type="text" class="form-control @if($errors->has('input.id.seo_keyword')) is-invalid @endif" placeholder="Enter SEO keyword" name="input[id][seo_keyword]" value="{{ !empty(old('input.id.seo_keyword')) ? old('input.id.seo_keyword') : $data['product_category']['id']['seo_keyword'] }}"/>
                                            @error('input.id.seo_keyword')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>SEO Canonical URL</label>
                                            <input type="text" class="form-control @if($errors->has('input.id.seo_canonical_url')) is-invalid @endif" placeholder="Enter SEO canonical URL" name="input[id][seo_canonical_url]" value="{{ !empty(old('input.id.seo_canonical_url')) ? old('input.id.seo_canonical_url') : $data['product_category']['id']['seo_canonical_url'] }}"/>
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
                                        <div class="form-group col-md-6">
                                            <label>Name</label>
                                            <input type="text" class="form-control @if($errors->has('input.en.name')) is-invalid @endif" placeholder="Enter name" name="input[en][name]" value="{{ !empty(old('input.en.name')) ? old('input.en.name') : $data['product_category']['en']['name'] }}"/>
                                            @error('input.en.name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Description</label>
                                            <textarea name="input[en][description]" class="ckeditor-en-description @if($errors->has('input.en.description')) is-invalid @endif">{{ !empty(old('input.en.description')) ? old('input.en.description') : $data['product_category']['en']['description'] }}</textarea>
                                            @error('input.en.description')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Post Title</label>
                                            <input type="text" class="form-control @if($errors->has('input.en.post_title')) is-invalid @endif" placeholder="Enter post title" name="input[en][post_title]"  value="{{ !empty(old('input.en.post_title')) ? old('input.en.post_title') : $data['product_category']['en']['post_title'] }}"/>
                                            @error('input.en.post_title')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Post Description</label>
                                            <textarea name="input[en][post_description]" class="ckeditor-en-post-description @if($errors->has('input.en.post_description')) is-invalid @endif">{{ !empty(old('input.en.post_description')) ? old('input.en.post_description') : $data['product_category']['en']['post_description'] }}</textarea>
                                            @error('input.en.post_description')
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
                                            <input type="text" class="form-control @if($errors->has('input.en.seo_title')) is-invalid @endif" placeholder="Enter SEO title" name="input[en][seo_title]" value="{{ !empty(old('input.en.seo_title')) ? old('input.en.seo_title') : $data['product_category']['en']['seo_title'] }}"/>
                                            @error('input.en.seo_title')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>SEO Description</label>
                                            <textarea name="input[en][seo_description]" rows="3" class="form-control @if($errors->has('input.en.seo_description')) is-invalid @endif">{{ !empty(old('input.en.seo_description')) ? old('input.en.seo_description') : $data['product_category']['en']['seo_description'] }}</textarea>
                                            @error('input.en.seo_title')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>SEO Keyword</label>
                                            <input type="text" class="form-control @if($errors->has('input.en.seo_keyword')) is-invalid @endif" placeholder="Enter SEO keyword" name="input[en][seo_keyword]" value="{{ !empty(old('input.en.seo_keyword')) ? old('input.en.seo_keyword') : $data['product_category']['en']['seo_keyword'] }}"/>
                                            @error('input.en.seo_keyword')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>SEO Canonical URL</label>
                                            <input type="text" class="form-control @if($errors->has('input.en.seo_canonical_url')) is-invalid @endif" placeholder="Enter SEO canonical URL" name="input[en][seo_canonical_url]" value="{{ !empty(old('input.en.seo_canonical_url')) ? old('input.en.seo_canonical_url') : $data['product_category']['en']['seo_canonical_url'] }}"/>
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
    </div>
@endsection

@section('script')
    <script src="{{ asset('public/backend/plugins/custom/ckeditor/ckeditor-classic.bundle.js?v=7.0.6') }}"></script>
    <script>
        $(document).ready(function(){
            ClassicEditor.create(document.querySelector('.ckeditor-id-description'));
            ClassicEditor.create(document.querySelector('.ckeditor-id-post-description'));

            ClassicEditor.create(document.querySelector('.ckeditor-en-description'));
            ClassicEditor.create(document.querySelector('.ckeditor-en-post-description'));
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
