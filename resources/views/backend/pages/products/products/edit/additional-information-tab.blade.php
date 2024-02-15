<div class="card card-custom mt-5">
    <div class="card-header">
        <div class="card-title">Product USP</div>
    </div>
    <div class="card-body">
        <div class="usp-box">
            @if (!empty($data['product_usp_id']))
                @foreach ($data['product_usp_id'] as $key => $usp)
                    <input type="hidden" name="usp[{{ $key }}][id]" value="{{ $usp['id'] }}">
                    <div class="usp-item">
                        <div class="row">
                            <div class="form-group picture_upload col-md-6">
                                <label>USP Image</label>
                                <div class="form-group__file">
                                    <div class="file-wrapper">
                                        <input type="file" name="usp[{{ $key }}][image]" class="file-input"/>
                                        <div class="file-preview-background">+</div>
                                        <img src="{{ $usp['image']['path'] ?? '' }}" style="opacity: 1" width="240px" class="file-preview"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <ul class="nav nav-tabs" id="uspTab" role="tablist">
                                    @foreach ($lang as $langCode => $val)
                                        <li class="nav-item">
                                            <a class="nav-link {{ $langCode == 'id' ? 'active' : '' }}" data-toggle="tab" role="tab" href="#{{ $langCode }}-{{ $key }}-Usptab">{{ $val }}</a>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="tab-content mb-4" style="display: block !important;">
                                    @foreach ($lang as $langCode => $val)
                                        <div class="tab-pane {{ $langCode == 'id' ? 'active' : '' }}" id="{{ $langCode }}-{{ $key }}-Usptab" role="tabpanel">
                                            <div class="row mt-5">
                                                <div class="form-group col-md-12">
                                                    <label>Name</label>
                                                    <input type="text" class="form-control" placeholder="Enter name" name="usp[{{ $key }}][input][{{ $langCode }}][name]" value="{{ $usp['product_usp'][$langCode]['name'] }}"/>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Description</label>
                                                    <textarea name="usp[{{ $key }}][input][{{ $langCode }}][description]" class="form-control">{{ $usp['product_usp'][$langCode]['description'] ?? '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <a href="{{ url('admin-cms/products/products/edit/'.$data['id'].'/delete-usp/'.$usp['id']) }}" class="btn btn-danger btn-delete-item"><i class="flaticon2-delete"></i> Delete</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
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
                                        <a class="nav-link {{ $key == 'id' ? 'active' : '' }}" data-toggle="tab" role="tab" href="#{{ $key }}-0-UspTab">{{ $val }}</a>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="tab-content mb-4" style="display: block !important;">
                                @foreach ($lang as $key => $val)
                                    <div class="tab-pane {{ $key == 'id' ? 'active' : '' }}" id="{{ $key }}-0-UspTab" role="tabpanel">
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
            @endif
        </div>
        <div class="row justify-content-center">
            <a href="#" class="btn btn-primary w-20 mt-5 add-item-usp" data-count="{{ count($data['product_usp_id']) == 0 ? 1 : count($data['product_usp_id']) }}"><i class="flaticon2-plus"></i> Add Another USP</a>
        </div>
    </div>
</div>

<div class="card card-custom mt-5">
    <div class="card-header">
        <div class="card-title">Product Highlight</div>
    </div>
    <div class="card-body">
        <div class="highlight-box">
            @if (!empty($data['product_highlight_id']))
                @foreach ($data['product_highlight_id'] as $key => $highlight)
                    <input type="hidden" name="highlight[{{ $key }}][id]" value="{{ $highlight['id'] }}">
                    <div class="highlight-item">
                        <div class="row">
                            <div class="form-group picture_upload col-md-6">
                                <label>Highlight Image</label>
                                <div class="form-group__file">
                                    <div class="file-wrapper">
                                        <input type="file" name="highlight[{{ $key }}][image]" class="file-input"/>
                                        <div class="file-preview-background">+</div>
                                        <img src="{{ $highlight['image']['path'] ?? '' }}" style="opacity: 1" width="240px" class="file-preview"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <ul class="nav nav-tabs" id="HighlightTab" role="tablist">
                                    @foreach ($lang as $langCode => $val)
                                        <li class="nav-item">
                                            <a class="nav-link {{ $langCode == 'id' ? 'active' : '' }}" data-toggle="tab" role="tab" href="#{{ $langCode }}-{{ $key }}-HighlightTab">{{ $val }}</a>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="tab-content mb-4" style="display: block !important;">
                                    @foreach ($lang as $langCode => $val)
                                        <div class="tab-pane {{ $langCode == 'id' ? 'active' : '' }}" id="{{ $langCode }}-{{ $key }}-HighlightTab" role="tabpanel">
                                            <div class="row mt-5">
                                                <div class="form-group col-md-12">
                                                    <label>Name</label>
                                                    <input type="text" class="form-control" placeholder="Enter name" name="highlight[{{ $key }}][input][{{ $langCode }}][name]" value="{{ $highlight['product_highlight'][$langCode]['name'] }}"/>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Description</label>
                                                    <textarea name="highlight[{{ $key }}][input][{{ $langCode }}][description]" class="form-control" placeholder="Enter description">{{ $highlight['product_highlight'][$langCode]['description'] ?? '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <a href="{{ url('admin-cms/products/products/edit/'.$data['id'].'/delete-highlight/'.$highlight['id']) }}" class="btn btn-danger btn-delete-item"><i class="flaticon2-delete"></i> Delete</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="highlight-item">
                    <div class="row">
                        <div class="form-group picture_upload col-md-6">
                            <label>Highlight Image</label>
                            <div class="form-group__file">
                                <div class="file-wrapper">
                                    <input type="file" name="highlight[0][image]" class="file-input"/>
                                    <div class="file-preview-background">+</div>
                                    <img src="" width="240px" class="file-preview"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <ul class="nav nav-tabs" id="HighlightTab" role="tablist">
                                @foreach ($lang as $key => $val)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $key == 'id' ? 'active' : '' }}" data-toggle="tab" role="tab" href="#{{ $key }}-0-HighlightTab">{{ $val }}</a>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="tab-content mb-4" style="display: block !important;">
                                @foreach ($lang as $key => $val)
                                    <div class="tab-pane {{ $key == 'id' ? 'active' : '' }}" id="{{ $key }}-0-HighlightTab" role="tabpanel">
                                        <div class="row mt-5">
                                            <div class="form-group col-md-12">
                                                <label>Name</label>
                                                <input type="text" class="form-control" placeholder="Enter name" name="highlight[0][input][{{ $key }}][name]" value=""/>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>Description</label>
                                                <textarea name="highlight[0][input][{{ $key }}][description]" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="row justify-content-center">
            <a href="#" class="btn btn-primary w-20 mt-5 add-item-highlight" data-count="{{ count($data['product_highlight_id']) == 0 ? 1 : count($data['product_highlight_id']) }}"><i class="flaticon2-plus"></i> Add Another Highlight</a>
        </div>
    </div>
</div>

<div class="card card-custom mt-5">
    <div class="card-header">
        <div class="card-title">Product Feature</div>
    </div>
    <div class="card-body">
        <div class="feature-box">
            @if (!empty($data['product_feature_id']))
                @foreach ($data['product_feature_id'] as $key => $feature)
                    <input type="hidden" name="feature[{{ $key }}][id]" value="{{ $feature['id'] }}">
                    <div class="feature-item">
                        <div class="row">
                            <div class="form-group picture_upload col-md-6">
                                <label>Feature Image</label>
                                <div class="form-group__file">
                                    <div class="file-wrapper">
                                        <input type="file" name="feature[{{ $key }}][image]" class="file-input"/>
                                        <div class="file-preview-background">+</div>
                                        <img src="{{ $feature['image']['path'] ?? '' }}" style="opacity: 1" width="240px" class="file-preview"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <ul class="nav nav-tabs" id="FeatureTab" role="tablist">
                                    @foreach ($lang as $langCode => $val)
                                        <li class="nav-item">
                                            <a class="nav-link {{ $langCode == 'id' ? 'active' : '' }}" data-toggle="tab" role="tab" href="#{{ $langCode }}-{{ $key }}-FeatureTab">{{ $val }}</a>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="tab-content mb-4" style="display: block !important;">
                                    @foreach ($lang as $langCode => $val)
                                        <div class="tab-pane {{ $langCode == 'id' ? 'active' : '' }}" id="{{ $langCode }}-{{ $key }}-FeatureTab" role="tabpanel">
                                            <div class="row mt-5">
                                                <div class="form-group col-md-12">
                                                    <label>Name</label>
                                                    <input type="text" class="form-control" placeholder="Enter name" name="feature[{{ $key }}][input][{{ $langCode }}][name]" value="{{ $feature['product_feature'][$langCode]['name'] }}"/>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Description</label>
                                                    <textarea name="feature[{{ $key }}][input][{{ $langCode }}][description]" class="form-control">{{ $feature['product_feature'][$langCode]['description'] ?? '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <a href="{{ url('admin-cms/products/products/edit/'.$data['id'].'/delete-feature/'.$feature['id']) }}" class="btn btn-danger btn-delete-item"><i class="flaticon2-delete"></i> Delete</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
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
                                        <a class="nav-link {{ $key == 'id' ? 'active' : '' }}" data-toggle="tab" role="tab" href="#{{ $key }}-0-FeatureTab">{{ $val }}</a>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="tab-content mb-4" style="display: block !important;">
                                @foreach ($lang as $key => $val)
                                    <div class="tab-pane {{ $key == 'id' ? 'active' : '' }}" id="{{ $key }}-0-FeatureTab" role="tabpanel">
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
            @endif
        </div>
        <div class="row justify-content-center">
            <a href="#" class="btn btn-primary w-20 mt-5 add-item-feature" data-count="{{ count($data['product_feature_id']) == 0 ? 1 : count($data['product_feature_id']) }}"><i class="flaticon2-plus"></i> Add Another Feature</a>
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
