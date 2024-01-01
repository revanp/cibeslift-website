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
                        <label class="checkbox checkbox-success checkbox-disabled">
                            <input type="checkbox" name="have_a_child" readonly {{ $data['have_a_child'] ? 'checked' : '' }} disabled/>
                            <input type="hidden" name="have_a_child" value="{{ $data['have_a_child'] ? 'on' : '' }}">
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
                            <input type="checkbox" name="is_active" {{ $data['is_active'] ? 'checked' : '' }}/>
                            <span></span>
                            Active
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @if (!$data['have_a_child'])
                <div class="form-group col-md-6 hide-have-a-child">
                    <label>Parent Product</label>
                    <select name="parent_id" class="form-control @if($errors->has('parent_id')) is-invalid @endif">
                        @php
                            $parentIdData = $data['parent_id'];
                        @endphp
                        <option value="">-- SELECT PARENT PRODUCT --</option>
                        @foreach ($parents as $key => $val)
                            <option value="{{ $val->productId->id }}" {{ $parentIdData == $val->productId->id ? 'selected' : '' }}>{{ $val->name }}</option>
                        @endforeach
                    </select>
                    <span class="form-text text-muted">Empty this field if product is standalone.</span>
                    @error('parent_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            @endif

            <div class="form-group col-md-6 hide-parent-not-null {{ (!empty($data['parent_id']) && !$data['have_a_child']) ? 'd-none' : '' }}">
                <label>*Product Summary Type</label>
                <select name="product_summary_type" class="form-control @if($errors->has('product_summary_type')) is-invalid @endif">
                    @php
                        $productSummaryTypeData = $data['product_summary_type'];
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
                <label>Technologies</label>
                <select name="technologies[]" multiple class="select2 form-control @if($errors->has('technologies')) is-invalid @endif">
                    @foreach ($technologies as $key => $val)
                        <option value="{{ $val->id_product_technology_id }}" {{ in_array($val->id_product_technology_id, $data['product_id_has_product_technology_id']) ? 'selected' : '' }}>{{ $val->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>Faq</label>
                <select name="faqs[]" multiple class="select2 form-control @if($errors->has('faqs')) is-invalid @endif">
                    @foreach ($faqs as $key => $val)
                        <option value="{{ $val->id_faq_id }}" {{ in_array($val->id_faq_id, $data['product_id_has_faq_id']) ? 'selected' : '' }}>{{ $val->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6">
                <label>Sort</label>
                <select name="sort" id="" class="form-control @if($errors->has('sort')) is-invalid @endif">
                    @php
                        $sortData = $data['sort'];
                    @endphp
                    @for($i = 1; $i <= $sort; $i++)
                        <option value="{{ $i }}" {{ $sortData == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
                @error('sort')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
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
                            <input type="text" class="form-control @if($errors->has('input.'.$key.'.name')) is-invalid @endif" placeholder="Enter name" name="input[{{ $key }}][name]" value="{{ $data['product'][$key]['name'] ?? '' }}"/>
                            @error('input.'.$key.'.name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Page Title</label>
                            <input type="text" class="form-control @if($errors->has('input.'.$key.'.page_title')) is-invalid @endif" placeholder="Enter post title" name="input[{{ $key }}][page_title]" value="{{ $data['product'][$key]['page_title'] ?? '' }}"/>
                            @error('input.'.$key.'.page_title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Short Description</label>
                            <textarea name="input[{{ $key }}][short_description]" class="form-control @if($errors->has('input.'.$key.'.short_description')) is-invalid @endif">{{ $data['product'][$key]['short_description'] ?? '' }}</textarea>
                            @error('input.'.$key.'.short_description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Description</label>
                            <textarea name="input[{{ $key }}][description]" rows="5" class="form-control @if($errors->has('input.'.$key.'.description')) is-invalid @endif">{{ $data['product'][$key]['description'] ?? '' }}</textarea>
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
                            <input type="text" class="form-control @if($errors->has('input.'.$key.'.seo_title')) is-invalid @endif" placeholder="Enter SEO title" name="input[{{ $key }}][seo_title]" value="{{ $data['product'][$key]['seo_title'] ?? '' }}"/>
                            @error('input.'.$key.'.seo_title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>SEO Description</label>
                            <textarea name="input[{{ $key }}][seo_description]" rows="3" class="form-control @if($errors->has('input.'.$key.'.seo_description')) is-invalid @endif">{{ $data['product'][$key]['seo_description'] ?? '' }}</textarea>
                            @error('input.'.$key.'.seo_title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>SEO Keyword</label>
                            <input type="text" class="form-control @if($errors->has('input.'.$key.'.seo_keyword')) is-invalid @endif" placeholder="Enter SEO keyword" name="input[{{ $key }}][seo_keyword]" value="{{ $data['product'][$key]['seo_keyword'] ?? '' }}"/>
                            @error('input.'.$key.'.seo_keyword')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>SEO Canonical URL</label>
                            <input type="text" class="form-control @if($errors->has('input.'.$key.'.seo_canonical_url')) is-invalid @endif" placeholder="Enter SEO canonical URL" name="input[{{ $key }}][seo_canonical_url]" value="{{ $data['product'][$key]['seo_canonical_url'] ?? '' }}"/>
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
