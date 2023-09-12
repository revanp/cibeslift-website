@extends('backend.layouts.app')

@section('content')
    <div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <h5 class="text-dark font-weight-bold my-1 mr-5">
                        Translations
                    </h5>

                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-muted">Settings</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ url('admin-cms/settings/translations') }}" class="text-muted">Translations</a>
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
                        <span class="card-icon"><i class="flaticon2-sheet"></i></span>
                        <h3 class="card-label">List Translations</h3>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ url('admin-cms/settings/translations/publish') }}" class="btn btn-primary font-weight-bolder btn-publish">
                            <i class="flaticon2-paper-plane icon-md"></i> Publish
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills" id="myTab" role="tablist">
                        @foreach ($translationCategories as $key => $val)
                            <li class="nav-item">
                                <a class="nav-link {{ $key == 0 ? 'active' : '' }}" data-toggle="tab" role="tab" href="#{{ str_replace(' ', '', strtolower($val->name)) }}">{{ $val->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content mb-4" style="display: block !important;">
                        @foreach ($translationCategories as $key => $val)
                            <div class="tab-pane {{ $key == 0 ? 'active' : '' }}" id="{{ str_replace(' ', '', strtolower($val->name)) }}" role="tabpanel">
                                <table class="table table-bordered mt-5 text-center">
                                    <thead>
                                        <tr>
                                            <th>Key</th>
                                            <th>English</th>
                                            <th>Indonesian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($val->translationKey as $key2 => $val)
                                            <tr>
                                                <td class="align-middle">{{ $val->value }}</td>
                                                <td>
                                                    <input type="text" class="form-control translate-input" data-id="{{ $val->english_id }}" value="{{ $val->english_value }}">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control translate-input" data-id="{{ $val->indonesia_id }}" value="{{ $val->indonesia_value }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('.translate-input').on('change', function(e){
            e.preventDefault();

            var id = $(this).data('id');
            var value = $(this).val();

            Swal.fire({
                title: "Are you sure you want to update this?",
                text: "This will update this data. You cannot undo this action",
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
                    $.ajax({
                        url: "{{ url('admin-cms/settings/translations/update-value') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": id,
                            "value": value
                        },
                        type: 'POST',
                        success: function(res){
                            if(res.success == true){
                                toastr.success(res.message);
                            }else{
                                toastr.error(res.message);
                            }
                        },
                        error: function(res){
                            toastr.error(res.message);
                        }
                    });
                }else{
                    window.location.reload();
                }
            });
        })

        $('.btn-publish').on('click', function(e){
            e.preventDefault();

            Swal.fire({
                title: "Are you sure you want to publish this?",
                text: "This will publish this data. You cannot undo this action",
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
                    $.ajax({
                        url: "{{ url('admin-cms/settings/translations/publish') }}",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        type: 'POST',
                        success: function(res){
                            toastr.success(res.message);
                        },
                        error: function(res){
                            toastr.error(res.message);
                        }
                    });
                }
            });
        });
    </script>
@endsection
