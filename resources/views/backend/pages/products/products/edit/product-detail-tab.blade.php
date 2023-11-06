<div class="card card-custom">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">Product Detail</h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group picture_upload col-md-6">
                <label>*Banner</label>
                <div class="form-group__file">
                    <div class="file-wrapper">
                        <input type="file" name="banner" class="file-input"/>
                        <div class="file-preview-background">+</div>
                        <img src="{{ $data['banner']['path'] ?? '' }}" style="opacity: 1" width="240px" class="file-preview"/>
                    </div>
                </div>
            </div>
            <div class="form-group picture_upload col-md-6">
                <label>Thumbnail</label>
                <div class="form-group__file">
                    <div class="file-wrapper">
                        <input type="file" name="thumbnail" class="file-input"/>
                        <div class="file-preview-background">+</div>
                        @if (!empty($data['thumbnail']))
                            <img src="{{ $data['thumbnail']['path'] ?? '' }}" style="opacity: 1" width="240px" class="file-preview"/>
                        @else
                            <img src="" width="240px" class="file-preview"/>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group picture_upload col-md-6">
                <label>Menu Icon</label>
                <div class="form-group__file">
                    <div class="file-wrapper">
                        <input type="file" name="menu_icon" class="file-input"/>
                        <div class="file-preview-background">+</div>
                        @if (!empty($data['menu_icon']))
                            <img src="{{ $data['menu_icon']['path'] ?? '' }}" style="opacity: 1" width="240px" class="file-preview"/>
                        @else
                            <img src="" width="240px" class="file-preview"/>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group picture_upload col-md-6 hide-parent-not-null">
                <label>Product Summary Image</label>
                <div class="form-group__file">
                    <div class="file-wrapper">
                        <input type="file" name="product_summary_image" class="file-input"/>
                        <div class="file-preview-background">+</div>
                        @if (!empty($data['product_summary_image']))
                            <img src="{{ $data['product_summary_image']['path'] ?? '' }}" style="opacity: 1" width="240px" class="file-preview"/>
                        @else
                            <img src="" width="240px" class="file-preview"/>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if (!$data['have_a_child'])
    <div class="card card-custom mt-5 hide-have-a-child">
        <div class="card-header">
            <div class="card-title">Product Specification</div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group picture_upload col-md-6">
                    <label>Spesification Image</label>
                    <div class="form-group__file">
                        <div class="file-wrapper">
                            <input type="file" name="specification_image" class="file-input"/>
                            <div class="file-preview-background">+</div>
                            @if (!empty($data['specification_image']))
                            <img src="{{ $data['specification_image']['path'] ?? '' }}" style="opacity: 1" width="240px" class="file-preview"/>
                        @else
                            <img src="" width="240px" class="file-preview"/>
                        @endif
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label>Size</label>
                    <textarea name="specification[size]" class="ckeditor-size @if($errors->has('specification.size')) is-invalid @endif">{{ old('specification.size') }}</textarea>
                    @error('specification.size')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label>Installation</label>
                    <input type="text" class="form-control @if($errors->has('specification.installation')) is-invalid @endif" placeholder="Enter installation" name="specification[installation]" value="{{ old('specification.installation') }}"/>
                    @error('specification.installation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label>Rated Load</label>
                    <input type="text" class="form-control @if($errors->has('specification.rated_load')) is-invalid @endif" placeholder="Enter rated load" name="specification[rated_load]" value="{{ old('specification.rated_load') }}"/>
                    @error('specification.rated_load')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label>Power Supply</label>
                    <input type="text" class="form-control @if($errors->has('specification.power_supply')) is-invalid @endif" placeholder="Enter power supply" name="specification[power_supply]" value="{{ old('specification.power_supply') }}"/>
                    @error('specification.power_supply')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label>Speed</label>
                    <input type="text" class="form-control @if($errors->has('specification.speed')) is-invalid @endif" placeholder="Enter speed" name="specification[speed]" value="{{ old('specification.speed') }}"/>
                    @error('specification.speed')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label>Min. Headroom</label>
                    <input type="text" class="form-control @if($errors->has('specification.min_headroom')) is-invalid @endif" placeholder="Enter min. headroom" name="specification[min_headroom]" value="{{ old('specification.min_headroom') }}"/>
                    @error('specification.min_headroom')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label>Lift Pit</label>
                    <input type="text" class="form-control @if($errors->has('specification.lift_pit')) is-invalid @endif" placeholder="Enter lift pit" name="specification[lift_pit]" value="{{ old('specification.lift_pit') }}"/>
                    @error('specification.lift_pit')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label>Drive System</label>
                    <input type="text" class="form-control @if($errors->has('specification.drive_system')) is-invalid @endif" placeholder="Enter drive system" name="specification[drive_system]" value="{{ old('specification.drive_system') }}"/>
                    @error('specification.drive_system')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label>Max. Travel</label>
                    <input type="text" class="form-control @if($errors->has('specification.max_travel')) is-invalid @endif" placeholder="Enter max. travel" name="specification[max_travel]" value="{{ old('specification.max_travel') }}"/>
                    @error('specification.max_travel')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label>Max. Number of Stops</label>
                    <input type="text" class="form-control @if($errors->has('specification.max_number_of_stops')) is-invalid @endif" placeholder="Enter max. number of stops" name="specification[max_number_of_stops]" value="{{ old('specification.max_number_of_stops') }}"/>
                    @error('specification.max_number_of_stops')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label>Lift Controls</label>
                    <input type="text" class="form-control @if($errors->has('specification.lift_controls')) is-invalid @endif" placeholder="Enter lift controls" name="specification[lift_controls]" value="{{ old('specification.lift_controls') }}"/>
                    @error('specification.lift_controls')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label>Motor Power</label>
                    <input type="text" class="form-control @if($errors->has('specification.motor_power')) is-invalid @endif" placeholder="Enter motor power" name="specification[motor_power]" value="{{ old('specification.motor_power') }}"/>
                    @error('specification.motor_power')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label>Machine Room</label>
                    <input type="text" class="form-control @if($errors->has('specification.machine_room')) is-invalid @endif" placeholder="Enter machine room" name="specification[machine_room]" value="{{ old('specification.machine_room') }}"/>
                    @error('specification.machine_room')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label>Door Configuration</label>
                    <input type="text" class="form-control @if($errors->has('specification.door_configuration')) is-invalid @endif" placeholder="Enter door configuration" name="specification[door_configuration]" value="{{ old('specification.door_configuration') }}"/>
                    @error('specification.door_configuration')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label>Directive and Standards</label>
                    <input type="text" class="form-control @if($errors->has('specification.directive_and_standards')) is-invalid @endif" placeholder="Enter directive and standards" name="specification[directive_and_standards]" value="{{ old('specification.directive_and_standards') }}"/>
                    @error('specification.directive_and_standards')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
@endif

<div class="card card-custom mt-5">
    <div class="card-header">
        <div class="card-title">Product USP</div>
    </div>
    <div class="card-body">
        <div class="usp-box">
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
                                        <a class="nav-link {{ $langCode == 'id' ? 'active' : '' }}" data-toggle="tab" role="tab" href="#{{ $langCode }}UspTab">{{ $val }}</a>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="tab-content mb-4" style="display: block !important;">
                                @foreach ($lang as $langCode => $val)
                                    <div class="tab-pane {{ $langCode == 'id' ? 'active' : '' }}" id="{{ $langCode }}UspTab" role="tabpanel">
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
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row justify-content-center">
            <a href="#" class="btn btn-primary w-20 mt-5 add-item-usp" data-count="{{ count($data['product_usp_id']) }}"><i class="flaticon2-plus"></i> Add Another USP</a>
        </div>
    </div>
</div>

<div class="card card-custom mt-5">
    <div class="card-header">
        <div class="card-title">Product Feature</div>
    </div>
    <div class="card-body">
        <div class="feature-box">
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
                                        <a class="nav-link {{ $langCode == 'id' ? 'active' : '' }}" data-toggle="tab" role="tab" href="#{{ $langCode }}FeatureTab">{{ $val }}</a>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="tab-content mb-4" style="display: block !important;">
                                @foreach ($lang as $langCode => $val)
                                    <div class="tab-pane {{ $langCode == 'id' ? 'active' : '' }}" id="{{ $langCode }}FeatureTab" role="tabpanel">
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
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row justify-content-center">
            <a href="#" class="btn btn-primary w-20 mt-5 add-item-feature" data-count="{{ count($data['product_feature_id']) }}"><i class="flaticon2-plus"></i> Add Another Feature</a>
        </div>
    </div>
</div>
