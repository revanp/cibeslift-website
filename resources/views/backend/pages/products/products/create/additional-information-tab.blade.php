<div class="card card-custom mt-5">
    <div class="card-header">
        <div class="card-title">Product USP</div>
    </div>
    <div class="card-body">
        <div class="usp-box">
            <div class="usp-item">
                <div class="row">
                    <div class="form-group picture_upload col-md-6">
                        <label>USP Image</label>
                        <div class="form-group__file">
                            <div class="file-wrapper">
                                <input type="file" name="usp[0][image]" class="file-input"/>
                                <div class="file-preview-background">+</div>
                                <img src="" width="240px" class="file-preview"/>
                            </div>
                        </div>
                        @error('usp_image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <ul class="nav nav-tabs" id="uspTab" role="tablist">
                            @foreach ($lang as $key => $val)
                                <li class="nav-item">
                                    <a class="nav-link {{ $key == 'id' ? 'active' : '' }}" data-toggle="tab" role="tab" href="#{{ $key }}UspTab">{{ $val }}</a>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-content mb-4" style="display: block !important;">
                            @foreach ($lang as $key => $val)
                                <div class="tab-pane {{ $key == 'id' ? 'active' : '' }}" id="{{ $key }}UspTab" role="tabpanel">
                                    <div class="row mt-5">
                                        <div class="form-group col-md-12">
                                            <label>Name</label>
                                            <input type="text" class="form-control" placeholder="Enter name" name="usp[0][input][{{ $key }}][name]" value=""/>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Description</label>
                                            <textarea name="usp[0][input][{{ $key }}][description]" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <a href="#" class="btn btn-primary w-20 mt-5 add-item-usp" data-count="1"><i class="flaticon2-plus"></i> Add Another USP</a>
        </div>
    </div>
</div>

<div class="card card-custom mt-5">
    <div class="card-header">
        <div class="card-title">Product Feature</div>
    </div>
    <div class="card-body">
        <div class="feature-box">
            <div class="feature-item">
                <div class="row">
                    <div class="form-group picture_upload col-md-6">
                        <label>Feature Image</label>
                        <div class="form-group__file">
                            <div class="file-wrapper">
                                <input type="file" name="feature[0][image]" class="file-input"/>
                                <div class="file-preview-background">+</div>
                                <img src="" width="240px" class="file-preview"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <ul class="nav nav-tabs" id="featureTab" role="tablist">
                            @foreach ($lang as $key => $val)
                                <li class="nav-item">
                                    <a class="nav-link {{ $key == 'id' ? 'active' : '' }}" data-toggle="tab" role="tab" href="#{{ $key }}FeatureTab">{{ $val }}</a>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-content mb-4" style="display: block !important;">
                            @foreach ($lang as $key => $val)
                                <div class="tab-pane {{ $key == 'id' ? 'active' : '' }}" id="{{ $key }}FeatureTab" role="tabpanel">
                                    <div class="row mt-5">
                                        <div class="form-group col-md-12">
                                            <label>Name</label>
                                            <input type="text" class="form-control" placeholder="Enter name" name="feature[0][input][{{ $key }}][name]" value=""/>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Description</label>
                                            <textarea name="feature[0][input][{{ $key }}][description]" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <a href="#" class="btn btn-primary w-20 mt-5 add-item-feature" data-count="1"><i class="flaticon2-plus"></i> Add Another Feature</a>
        </div>
    </div>
</div>

<div class="card card-custom mt-5">
    <div class="card-header">
        <div class="card-title">Product Video</div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-6">
                <label>Video</label>
                <input type="text" class="form-control" name="video_url">
            </div>
            <div class="col-md-6">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @foreach ($lang as $key => $val)
                        <li class="nav-item">
                            <a class="nav-link {{ $key == 'id' ? 'active' : '' }}" data-toggle="tab" role="tab" href="#{{ $key }}VideoTab">{{ $val }}</a>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content mb-4" style="display: block !important;">
                    @foreach ($lang as $key => $val)
                        <div class="tab-pane {{ $key == 'id' ? 'active' : '' }}" id="{{ $key }}VideoTab" role="tabpanel">
                            <div class="row mt-5">
                                <div class="form-group col-md-12">
                                    <label>Video Description</label>
                                    <textarea name="input[{{ $key }}][video_description]" class="form-control @if($errors->has('input.'.$key.'.video_description')) is-invalid @endif">{{ old('input.'.$key.'.video_description') }}</textarea>
                                    @error('input.'.$key.'.video_description')
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
        </div>
    </div>
</div>
