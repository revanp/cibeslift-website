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
                        Why Cibes
                    </h5>

                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-muted">Content</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ url('admin-cms/content/home/why-cibes') }}" class="text-muted">Why Cibes</a>
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
                        <h3 class="card-label">Why Cibes Title</h3>
                    </div>
                </div>
                <form action="{{ url('admin-cms/content/home/why-cibes/create-title') }}" method="POST" enctype="multipart/form-data" class="form-title">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group picture_upload col-md-6">
                                <label>Image</label>
                                <div class="form-group__file">
                                    <div class="file-wrapper">
                                        <input type="file" name="image" class="file-input"/>
                                        <div class="file-preview-background">+</div>
                                        @if (!empty($title['id']['image']['path']))
                                            <img src="{{ $title['id']['image']['path'] ?? '' }}" style="opacity: 1" width="240px" class="file-preview"/>
                                        @else
                                            <img src="" width="240px" class="file-preview"/>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
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
                                                <div class="form-group col-md-12">
                                                    <label>Title</label>
                                                    <input type="text" class="form-control" placeholder="Enter title" name="input[{{ $key }}][title]" value="{{ $title[$key]['title'] ?? '' }}"/>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Description</label>
                                                    <textarea name="input[{{ $key }}][description]" id="" rows="5" class="form-control" placeholder="Enter description">{{ $title[$key]['description'] ?? '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
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

            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">List Why Cibes USP</h3>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ url('admin-cms/content/home/why-cibes/create') }}" class="btn btn-primary font-weight-bolder">
                            <i class="flaticon2-add icon-md"></i> New Record
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-separate table-head-custom table-checkable" id="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Subtitle</th>
                                    <th>Status</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('.form-title').submit(function(e){
                e.preventDefault();

                var action = $(this).attr('action');

                var formData = new FormData(this);

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

                        $.each(result.data, function(key, value){
                            toastr.error(value[0]);
                        })
                    }
                })
            });
        });

        $(document).ready(function(){
            $('#table').DataTable({
                responsive: true,
                searchDelay: 500,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('admin-cms/content/home/why-cibes/datatable') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    }
                },
                columns: [
                    {data: 'rownum'},
                    {data: 'image', searchable: false, orderable: false},
                    {data: 'title'},
                    {data: 'subtitle'},
                    {data: 'is_active', searchable: false, orderable: false},
                    {data: 'action', searchable: false, orderable: false},
                ]
            });
        });

        $(document).on('change', '.btn-activate', function(e){
            event.preventDefault();

            var t      = $(this);
            var id     = t.attr("data-id");
            var status = t.prop('checked') ? 1 : 0;

            $.ajax({
                url: "{{ url('admin-cms/content/home/why-cibes/change-status') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    _method: 'put',
                    status: status,
                    id: id,
                    "_token": "{{ csrf_token() }}"
                },
            })
            .done(function(res) {
                if(res.success == true){
                    toastr.success(res.message);
                }else{
                    toastr.error(res.message);
                }
            })
            .fail(function(err) {
                toastr.error(res.message);
            });
        });
    </script>
@endsection
