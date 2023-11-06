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
        @csrf
        <input type="hidden" name="form_type" value="create">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom mb-3">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" role="tab" href="#productTab">Product</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" role="tab" href="#productDetailTab">Product Detail</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="tab-content mb-4" style="display: block !important;">
                    <div class="tab-pane active" id="productTab" role="tabpanel">
                        @include('backend.pages.products.products.create.product-tab')
                    </div>

                    <div class="tab-pane" id="productDetailTab" role="tabpanel">
                        @include('backend.pages.products.products.create.product-detail-tab')
                    </div>
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

        $('form').submit(function(e){
            e.preventDefault();

            var action = $(this).attr('action');

            var formData = new FormData(this);

            $.ajax({
                url: "{{ url('admin-cms/products/products/validation') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data){
                    $.ajax({
                        url: action,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        cache: false,
                        success: function(data){
                            if(data.redirect != null){
                                window.location.replace(data.redirect);
                            }
                        },
                        error: function(data){
                            var result = data.responseJSON;
                        }
                    })
                },
                error: function(data){
                    var result = data.responseJSON;

                    $.each(result.data, function(key, value){
                        toastr.error(value[0]);
                    })
                }
            })
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

        $('.add-item-usp').click(function(e){
            e.preventDefault();

            var dataCount = $(this).data('count');
            var listBox = $('.usp-box');

            var html = `<div class="usp-item mt-5">
                <div class="row">
                    <div class="form-group picture_upload col-md-6">
                        <label>USP Image</label>
                        <div class="form-group__file">
                            <div class="file-wrapper">
                                <input type="file" name="usp[`+dataCount+`][image]" class="file-input">
                                <div class="file-preview-background">+</div>
                                <img src="" width="240px" class="file-preview">
                            </div>
                        </div>
                                            </div>
                    <div class="col-md-6">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                            <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" role="tab" href="#idTab">Indonesia</a>
                                </li>
                                                            <li class="nav-item">
                                    <a class="nav-link " data-toggle="tab" role="tab" href="#enTab">English</a>
                                </li>
                                                    </ul>

                        <div class="tab-content mb-4" style="display: block !important;">
                                                            <div class="tab-pane active" id="idUspTab" role="tabpanel">
                                    <div class="row mt-5">
                                        <div class="form-group col-md-12">
                                            <label>Name</label>
                                            <input type="text" class="form-control" placeholder="Enter name" name="usp[`+dataCount+`][input][id][name]" value="">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Description</label>
                                            <textarea name="usp[`+dataCount+`][input][id][description]" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                                            <div class="tab-pane " id="enUspTab" role="tabpanel">
                                    <div class="row mt-5">
                                        <div class="form-group col-md-12">
                                            <label>Name</label>
                                            <input type="text" class="form-control" placeholder="Enter name" name="usp[`+dataCount+`][input][en][name]" value="">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Description</label>
                                            <textarea name="usp[`+dataCount+`][input][en][description]" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                                    </div>
                    </div>
                </div>
            </div>`;

            listBox.append(html);

            $(this).data('count', dataCount + 1)
        })

        $('.add-item-feature').click(function(e){
            e.preventDefault();

            var dataCount = $(this).data('count');
            var listBox = $('.feature-box');

            var html = `<div class="feature-item mt-5">
                <div class="row">
                    <div class="form-group picture_upload col-md-6">
                        <label>Feature Image</label>
                        <div class="form-group__file">
                            <div class="file-wrapper">
                                <input type="file" name="feature[`+dataCount+`][image]" class="file-input">
                                <div class="file-preview-background">+</div>
                                <img src="" width="240px" class="file-preview">
                            </div>
                        </div>
                                            </div>
                    <div class="col-md-6">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                            <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" role="tab" href="#idTab">Indonesia</a>
                                </li>
                                                            <li class="nav-item">
                                    <a class="nav-link " data-toggle="tab" role="tab" href="#enTab">English</a>
                                </li>
                                                    </ul>

                        <div class="tab-content mb-4" style="display: block !important;">
                                                            <div class="tab-pane active" id="idTab" role="tabpanel">
                                    <div class="row mt-5">
                                        <div class="form-group col-md-12">
                                            <label>Name</label>
                                            <input type="text" class="form-control" placeholder="Enter name" name="feature[`+dataCount+`][input][id][name]" value="">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Description</label>
                                            <textarea name="feature[`+dataCount+`][input][id][description]" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                                            <div class="tab-pane " id="enTab" role="tabpanel">
                                    <div class="row mt-5">
                                        <div class="form-group col-md-12">
                                            <label>Name</label>
                                            <input type="text" class="form-control" placeholder="Enter name" name="feature[`+dataCount+`][input][en][name]" value="">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Description</label>
                                            <textarea name="feature[`+dataCount+`][input][en][description]" class="form-control"></textarea>
                                        </div>
                                    </div>
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
