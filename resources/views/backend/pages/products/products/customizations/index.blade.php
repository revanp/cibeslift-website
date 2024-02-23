@extends('backend.layouts.app')

@section('content')
    <div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <h5 class="text-dark font-weight-bold my-1 mr-5">
                        Customizations
                    </h5>

                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-muted">Products</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin-cms/products/products') }}" class="text-muted">Products</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ url('admin-cms/products/products/customizations/'.$id) }}" class="text-muted">Customizations</a>
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
                        <h3 class="card-label">List Customizations</h3>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ url('admin-cms/products/products/customizations/'.$id.'/create') }}" class="btn btn-primary font-weight-bolder">
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
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $key => $val)
                                    <tr>
                                        <td class="align-middle">{{ $key + 1 }}</td>
                                        <td class="align-middle">
                                            @if (!empty($val->productCustomizationId->image->path))
                                                <a href="{{ $val->productCustomizationId->image->path }}" target="_BLANK"><img src="{{ $val->productCustomizationId->image->path }}" style="width:200px;"></a>
                                            @endif
                                        </td>
                                        <td class="align-middle">{{ $val->name }}</td>
                                        <td class="align-middle">{{ $val->description }}</td>
                                        <td class="align-middle">
                                            <div class="dropdown dropdown-inline mr-1"><a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="false"><i class="flaticon2-menu-1 icon-2x"></i></a><div class="dropdown-menu dropdown-menu-sm dropdown-menu-right"><ul class="nav nav-hoverable flex-column">
                                                <li class="nav-item"><a class="nav-link" href="{{ url('admin-cms/products/products/customizations/'.$id.'/options/'.$val->productCustomizationId->id) }}"><i class="flaticon2-tag nav-icon"></i><span class="nav-text">Options</span></a></li>
                                                <li class="nav-item"><a class="nav-link" href="{{ url('admin-cms/products/products/customizations/'.$id.'/edit/'.$val->productCustomizationId->id) }}"><i class="flaticon2-edit nav-icon"></i><span class="nav-text">Edit</span></a></li>
                                                <li class="nav-item"><a class="nav-link btn-delete" href="{{ url('admin-cms/products/products/customizations/'.$id.'/delete/'.$val->productCustomizationId->id) }}"><i class="flaticon2-delete nav-icon"></i><span class="nav-text">Delete</span></a></li>
                                            </ul></div>
                                        </td>
                                    </tr>
                                @endforeach
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
        $(document).on('click', '.btn-delete', function(e){
            e.preventDefault();

            var href = $(this).attr('href');

            Swal.fire({
                title: "Are you sure you want to delete this?",
                text: "This will delete this data permanently. You cannot undo this action",
                icon: "info",
                buttonsStyling: false,
                confirmButtonText: "<i class='la la-thumbs-up'></i> Yes!",
                showCancelButton: true,
                cancelButtonText: "<i class='la la-thumbs-down'></i> No, thanks",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-default"
                }
            }).then(function(isConfirm) {
                if(isConfirm.isConfirmed){
                    window.location.href = href;
                }
            });
        })
    </script>
@endsection
