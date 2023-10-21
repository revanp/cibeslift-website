@extends('backend.layouts.app')

@section('content')
    <div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <h5 class="text-dark font-weight-bold my-1 mr-5">
                        Products
                    </h5>

                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-muted">Products</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ url('admin-cms/products/products') }}" class="text-muted">Products</a>
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
                        <h3 class="card-label">List Product</h3>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ url('admin-cms/products/products/create') }}" class="btn btn-primary font-weight-bolder">
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
                                    <th>Category</th>
                                    <th>Name</th>
                                    <th>Slug</th>
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
            $('#table').DataTable({
                responsive: true,
                searchDelay: 500,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('admin-cms/products/products/datatable') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    }
                },
                columns: [
                    {data: 'rownum'},
                    {data: 'category'},
                    {data: 'name'},
                    {data: 'slug'},
                    {data: 'is_active', searchable: false, orderable: false},
                    {data: 'action', searchable: false, orderable: false},
                ]
            });
        });

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

        $(document).on('change', '.btn-activate', function(e){
            event.preventDefault();

            var t      = $(this);
            var id     = t.attr("data-id");
            var status = t.prop('checked') ? 1 : 0;

            $.ajax({
                url: "{{ url('admin-cms/products/products/change-status') }}",
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
