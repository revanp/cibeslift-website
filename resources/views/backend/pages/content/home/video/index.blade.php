@extends('backend.layouts.app')

@section('content')
    <div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <h5 class="text-dark font-weight-bold my-1 mr-5">
                        Video
                    </h5>

                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-muted">Content</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#" class="text-muted">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ url('admin-cms/content/home/video') }}" class="text-muted">Video</a>
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
                        <h3 class="card-label">Video</h3>
                    </div>
                </div>
                <form action="{{ url('admin-cms/content/home/video/create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        @if (!empty($data))
                            <div class="row justify-content-center mb-5">
                                <div class="col-md-10">
                                    <video src="{{ $data['video']['path'] ?? '#' }}" class="w-100" controls autoplay>
                                        <source src="{{ $data['video']['path'] ?? '#' }}" type="video/mp4">
                                    </video>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Video</label>
                                <input type="file" class="form-control" placeholder="Upload video" name="video" accept="video/mp4"/>
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
    <script>
        $('form').submit(function(e){
            e.preventDefault();

            var action = $(this).attr('action');

            var formData = new FormData(this);

            $('button[type="submit"]').attr('disabled', true);

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

                    $('button[type="submit"]').attr('disabled', false);
                }
            })
        });
    </script>
@endsection
