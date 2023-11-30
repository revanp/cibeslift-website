@extends('backend.layouts.app')

@section('content')
    <div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <h5 class="text-dark font-weight-bold my-1 mr-5">
                        Master Installations
                    </h5>

                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-muted">Products</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#" class="text-muted">Installations</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ url('admin-cms/products/installations/master') }}" class="text-muted">Master</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
		<div class=" container ">
            <div class="card card-custom gutter-b">
                <div class="card-header card-header-tabs-line">
                    <div class="card-title">
                        <h3 class="card-label">List Master</h3>
                    </div>
                    <div class="card-toolbar">
                        <ul class="nav nav-tabs nav-tabs-line nav-bold">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#sizeTab">
                                    <span class="nav-text">Size</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#floorSizeTab">
                                    <span class="nav-text">Floor Size</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#areaTab">
                                    <span class="nav-text">Area</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#locationTab">
                                    <span class="nav-text">Location</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#colorTab">
                                    <span class="nav-text">Color</span>
                                </a>
                            </li>
                        </ul>

                        <a href="javascript:;" class="btn btn-primary font-weight-bolder ml-10" data-toggle="modal" data-target="#createModal">
                            <i class="flaticon2-add icon-md"></i> New Record
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        {{-- SIZE --}}
                        <div class="tab-pane fade show active" id="sizeTab" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-separate table-head-custom table-checkable text-center" id="sizeTable">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- FLOOR SIZE --}}
                        <div class="tab-pane fade" id="floorSizeTab" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-separate table-head-custom table-checkable text-center" id="floorSizeTable">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- AREA --}}
                        <div class="tab-pane fade" id="areaTab" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-separate table-head-custom table-checkable text-center" id="areaTable">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- LOCATION --}}
                        <div class="tab-pane fade" id="locationTab" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-separate table-head-custom table-checkable text-center" id="locationTable">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- COLOR --}}
                        <div class="tab-pane fade" id="colorTab" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-separate table-head-custom table-checkable text-center" id="colorTable">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Name</th>
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
        </div>
    </div>

    <div class="modal fade" id="createModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form action="{{ url('admin-cms/products/installations/master/create') }}" method="POST" class="createForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Category</label>
                                <select name="category" class="form-control">
                                    <option value="" selected disabled>-- CHOOSE CATEGORY --</option>
                                    <option value="size">Size</option>
                                    <option value="floor_size">Floor Size</option>
                                    <option value="area">Area</option>
                                    <option value="location">Location</option>
                                    <option value="color">Color</option>
                                </select>
                            </div>
                        </div>

                        @php
                            $lang = ['id' => 'Indonesia', 'en' => 'English'];
                        @endphp
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @foreach ($lang as $key => $val)
                                <li class="nav-item">
                                    <a class="nav-link {{ $key == 'id' ? 'active' : '' }}" data-toggle="tab" role="tab" href="#{{ $key }}CreateTab">{{ $val }}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content mb-4" style="display: block !important;">
                            @foreach ($lang as $key => $val)
                                <div class="tab-pane {{ $key == 'id' ? 'active' : '' }}" id="{{ $key }}CreateTab" role="tabpanel">
                                    <div class="row mt-5">
                                        <div class="form-group col-md-12">
                                            <label>Name</label>
                                            <input type="text" class="form-control @if($errors->has('input.'.$key.'.name')) is-invalid @endif" placeholder="Enter name" name="input[{{ $key }}][name]" value="{{ old('input.'.$key.'.name') }}"/>
                                            @error('input.'.$key.'.name')
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form action="#" method="POST" class="editForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Category</label>
                                <select name="category_select" class="form-control" disabled>
                                    <option value="" disabled>-- CHOOSE CATEGORY --</option>
                                    <option value="size">Size</option>
                                    <option value="floor_size">Floor Size</option>
                                    <option value="area">Area</option>
                                    <option value="location">Location</option>
                                    <option value="color">Color</option>
                                </select>
                                <input type="hidden" name="category" value="">
                            </div>
                        </div>

                        @php
                            $lang = ['id' => 'Indonesia', 'en' => 'English'];
                        @endphp
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @foreach ($lang as $key => $val)
                                <li class="nav-item">
                                    <a class="nav-link {{ $key == 'id' ? 'active' : '' }}" data-toggle="tab" role="tab" href="#{{ $key }}EditTab">{{ $val }}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content mb-4" style="display: block !important;">
                            @foreach ($lang as $key => $val)
                                <div class="tab-pane {{ $key == 'id' ? 'active' : '' }}" id="{{ $key }}EditTab" role="tabpanel">
                                    <div class="row mt-5">
                                        <div class="form-group col-md-12">
                                            <label>Name</label>
                                            <input type="text" class="form-control @if($errors->has('input.'.$key.'.name')) is-invalid @endif" placeholder="Enter name" name="input[{{ $key }}][name]" value="{{ old('input.'.$key.'.name') }}"/>
                                            @error('input.'.$key.'.name')
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('#sizeTable').DataTable({
                responsive: true,
                searchDelay: 500,
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    url: "{{ url('admin-cms/products/installations/master/datatable') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "category": "size"
                    }
                },
                columns: [
                    {data: 'rownum'},
                    {data: 'name'},
                    {data: 'action', searchable: false, orderable: false},
                ]
            });

            setTimeout(() => {
                $('#floorSizeTable').DataTable({
                    responsive: true,
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    ordering: false,
                    ajax: {
                        url: "{{ url('admin-cms/products/installations/master/datatable') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "category": "floor_size"
                        }
                    },
                    columns: [
                        {data: 'rownum'},
                        {data: 'name'},
                        {data: 'action', searchable: false, orderable: false},
                    ]
                });
            }, 500);

            setTimeout(() => {
                $('#areaTable').DataTable({
                    responsive: true,
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    ordering: false,
                    ajax: {
                        url: "{{ url('admin-cms/products/installations/master/datatable') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "category": "area"
                        }
                    },
                    columns: [
                        {data: 'rownum'},
                        {data: 'name'},
                        {data: 'action', searchable: false, orderable: false},
                    ]
                });
            }, 1000);

            setTimeout(() => {
                $('#locationTable').DataTable({
                    responsive: true,
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    ordering: false,
                    ajax: {
                        url: "{{ url('admin-cms/products/installations/master/datatable') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "category": "location"
                        }
                    },
                    columns: [
                        {data: 'rownum'},
                        {data: 'name'},
                        {data: 'action', searchable: false, orderable: false},
                    ]
                });
            }, 1500);

            setTimeout(() => {
                $('#colorTable').DataTable({
                    responsive: true,
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    ordering: false,
                    ajax: {
                        url: "{{ url('admin-cms/products/installations/master/datatable') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "category": "color"
                        }
                    },
                    columns: [
                        {data: 'rownum'},
                        {data: 'name'},
                        {data: 'action', searchable: false, orderable: false},
                    ]
                });
            }, 1500);
        });

        $('.createForm').on('submit', function(e){
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
        })

        $('.editForm').on('submit', function(e){
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
        })

        $(document).on('click', '.btn-edit', function(e){
            e.preventDefault();

            var category = $(this).data('category');
            var action = $(this).attr('href');

            $.ajax({
                url: action,
                type: 'GET',
                data: {
                    "category": category
                },
                success: function(data){
                    var modal = $('#editModal');
                    modal.find('form').attr('action', action);
                    modal.find('form').find('select[name="category_select"]').val(data.category);
                    modal.find('form').find('input[name="category"]').val(data.category);

                    $.each(data.child, function(k, v) {
                        modal.find('form').find('input[name="input['+k+'][name]"]').val(v.name);
                    })

                    modal.modal('show')
                },
                error: function(data){
                    var result = data.responseJSON;

                    toastr.error('Something went wrong');
                }
            })
        })

        // $(document).on('click', '.btn-delete-master', function(e){
        //     e.preventDefault();

        //     var category =
        //     var href = $(this).attr('href');

        //     Swal.fire({
        //         title: "Are you sure you want to delete this?",
        //         text: "This will delete this data permanently. You cannot undo this action",
        //         icon: "info",
        //         buttonsStyling: false,
        //         confirmButtonText: "<i class='la la-thumbs-up'></i> Yes!",
        //         showCancelButton: true,
        //         cancelButtonText: "<i class='la la-thumbs-down'></i> No, thanks",
        //         customClass: {
        //             confirmButton: "btn btn-danger",
        //             cancelButton: "btn btn-default"
        //         }
        //     }).then(function(isConfirm) {
        //         if(isConfirm.isConfirmed){
        //             window.location.href = href;
        //         }
        //     });
        // })
    </script>
@endsection
