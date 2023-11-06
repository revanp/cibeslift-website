<div class="card card-custom">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">Product</h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-3">
                <div class="col-12 col-form-label">
                    <div class="checkbox-inline">
                        <label class="checkbox checkbox-success">
                            <input type="checkbox" name="have_a_child"/>
                            <span></span>
                            Have a child product?
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-3">
                <div class="col-12 col-form-label">
                    <div class="checkbox-inline">
                        <label class="checkbox checkbox-success">
                            <input type="checkbox" name="is_active"/>
                            <span></span>
                            Active
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6 hide-have-a-child">
                <label>Parent Product</label>
                <select name="parent_id" class="form-control @if($errors->has('parent_id')) is-invalid @endif">
                    @php
                        $parentIdData = !empty(old('parent_id')) ? old('parent_id') : '';
                    @endphp
                    <option value="">-- SELECT PARENT PRODUCT --</option>
                    @foreach ($parents as $key => $val)
                        <option value="{{ $val->productId->id }}" {{ $parentIdData == '0' ? 'selected' : '' }}>{{ $val->name }}</option>
                    @endforeach
                </select>
                <span class="form-text text-muted">Empty this field if product is standalone.</span>
                @error('parent_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group col-md-6 hide-parent-not-null">
                <label>*Product Summary Type</label>
                <select name="product_summary_type" class="form-control @if($errors->has('product_summary_type')) is-invalid @endif">
                    @php
                        $productSummaryTypeData = !empty(old('product_summary_type')) ? old('product_summary_type') : '';
                    @endphp
                    <option value="">-- SELECT PRODUCT SUMMARY TYPE --</option>
                    <option value="0" {{ $productSummaryTypeData == '0' ? 'selected' : '' }}>List Product</option>
                    <option value="1" {{ $productSummaryTypeData == '1' ? 'selected' : '' }}>Big Banner With Text on The Left</option>
                    <option value="2" {{ $productSummaryTypeData == '2' ? 'selected' : '' }}>Big Banner With Overlay and Center Text</option>
                    <option value="3" {{ $productSummaryTypeData == '3' ? 'selected' : '' }}>Big Banner Without Overlay and Black Text</option>
                </select>
                @error('product_summary_type')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label>Sort</label>
                <select name="sort" id="" class="form-control @if($errors->has('sort')) is-invalid @endif">
                    <option value="">-- LAST ORDER --</option>
                    @for($i = 1; $i <= $sort; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
                @error('sort')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label>Technologies</label>
                <select name="technologies[]" multiple class="select2 form-control @if($errors->has('technologies')) is-invalid @endif">
                    @foreach ($technologies as $key => $val)
                        <option value="{{ $val->id_product_technology_id }}">{{ $val->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="separator separator-solid separator-border-3 mb-5"></div>

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

                    <h3 class="display-5 mt-3">SEO</h3>
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
    </div>
</div>
