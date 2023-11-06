@php
    $lang = ['id' => 'Indonesia', 'en' => 'English'];
@endphp
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
                <div class="form-group col-md-6">
                    <label>Name</label>
                    <input type="text" class="form-control @if($errors->has('input.'.$key.'.name')) is-invalid @endif" placeholder="Enter name" name="input[{{ $key }}][name]" value="{{ old('input.'.$key.'.name') }}"/>
                    @error('input.'.$key.'.name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label>Page Title</label>
                    <input type="text" class="form-control @if($errors->has('input.'.$key.'.page_title')) is-invalid @endif" placeholder="Enter post title" name="input[{{ $key }}][page_title]" value="{{ old('input.'.$key.'.page_title') }}"/>
                    @error('input.'.$key.'.page_title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label>Short Description</label>
                    <textarea name="input[{{ $key }}][short_description]" class="form-control @if($errors->has('input.'.$key.'.short_description')) is-invalid @endif">{{ old('input.'.$key.'.short_description') }}</textarea>
                    @error('input.'.$key.'.short_description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label>Description</label>
                    <textarea name="input[{{ $key }}][description]" rows="5" class="form-control @if($errors->has('input.'.$key.'.description')) is-invalid @endif">{{ old('input.'.$key.'.description') }}</textarea>
                    @error('input.'.$key.'.description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="separator separator-dashed separator-border-2"></div>

            <h3 class="display-5 mt-5">SEO</h3>
            <div class="row mt-3">
                <div class="form-group col-md-6">
                    <label>SEO Title</label>
                    <input type="text" class="form-control @if($errors->has('input.'.$key.'.seo_title')) is-invalid @endif" placeholder="Enter SEO title" name="input[{{ $key }}][seo_title]" value="{{ old('input.'.$key.'.seo_title') }}"/>
                    @error('input.'.$key.'.seo_title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label>SEO Description</label>
                    <textarea name="input[{{ $key }}][seo_description]" rows="3" class="form-control @if($errors->has('input.'.$key.'.seo_description')) is-invalid @endif">{{ old('input.'.$key.'.seo_description') }}</textarea>
                    @error('input.'.$key.'.seo_title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label>SEO Keyword</label>
                    <input type="text" class="form-control @if($errors->has('input.'.$key.'.seo_keyword')) is-invalid @endif" placeholder="Enter SEO keyword" name="input[{{ $key }}][seo_keyword]" value="{{ old('input.'.$key.'.seo_keyword') }}"/>
                    @error('input.'.$key.'.seo_keyword')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label>SEO Canonical URL</label>
                    <input type="text" class="form-control @if($errors->has('input.'.$key.'.seo_canonical_url')) is-invalid @endif" placeholder="Enter SEO canonical URL" name="input[{{ $key }}][seo_canonical_url]" value="{{ old('input.'.$key.'.seo_canonical_url') }}"/>
                    @error('input.'.$key.'.seo_canonical_url')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    @endforeach
</div>
