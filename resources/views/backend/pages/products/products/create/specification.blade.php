<div class="card card-custom mt-5">
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
                        <img src="" width="240px" class="file-preview"/>
                    </div>
                </div>
                @error('specification_image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
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
                <label>Power Supply</label>
                <input type="text" class="form-control @if($errors->has('specification.power_supply')) is-invalid @endif" placeholder="Enter power supply" name="specification[power_supply]" value="{{ old('specification.power_supply') }}"/>
                @error('specification.power_supply')
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
                <label>Drive System</label>
                <input type="text" class="form-control @if($errors->has('specification.drive_system')) is-invalid @endif" placeholder="Enter drive system" name="specification[drive_system]" value="{{ old('specification.drive_system') }}"/>
                @error('specification.drive_system')
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
                <label>Door Configuration</label>
                <input type="text" class="form-control @if($errors->has('specification.door_configuration')) is-invalid @endif" placeholder="Enter door configuration" name="specification[door_configuration]" value="{{ old('specification.door_configuration') }}"/>
                @error('specification.door_configuration')
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
                <label>Speed Max.</label>
                <input type="text" class="form-control @if($errors->has('specification.speed_max')) is-invalid @endif" placeholder="Enter speed max." name="specification[speed_max]" value="{{ old('specification.speed_max') }}"/>
                @error('specification.speed_max')
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
                <label>Max. Travel</label>
                <input type="text" class="form-control @if($errors->has('specification.max_travel')) is-invalid @endif" placeholder="Enter max. travel" name="specification[max_travel]" value="{{ old('specification.max_travel') }}"/>
                @error('specification.max_travel')
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
        </div>
    </div>
</div>
