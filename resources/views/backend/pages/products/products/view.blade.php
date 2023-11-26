@extends('backend.layouts.app')

@section('content')
    <div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <h5 class="text-dark font-weight-bold my-1 mr-5">
                        View Product
                    </h5>

                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-muted">Products</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin-cms/products/products') }}" class="text-muted">Products</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ url('admin-cms/products/products/view/'.$data['id']) }}" class="text-muted">View Product</a>
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
                        <h3 class="card-label">View Product</h3>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ url('admin-cms/products/products') }}" class="btn btn-danger font-weight-bolder">
                            <span class="svg-icon svg-icon-md"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                    <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-12.000003, -11.999999) "/>
                                </g>
                            </svg></span> Back
                        </a>
                        <a href="{{ url('admin-cms/products/products/edit/'.$data['id']) }}" class="btn btn-primary font-weight-bolder ml-3">
                            <i class="flaticon2-edit icon-md"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="20%" class="text-center">#</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">
                                    <strong>Have a Child Product?</strong>
                                </td>
                                <td>
                                    {!! $data['have_a_child'] == '1' ? '<span class="label label-lg font-weight-bolder label-rounded label-success label-inline">Yes</span>' : '<span class="label label-lg font-weight-bolder label-rounded label-danger label-inline">No</span>' !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <strong>Level</strong>
                                </td>
                                <td>
                                    <span class="label label-rounded">{{ $data['level'] }}</span>
                                </td>
                            </tr>
                            @if ($data['level'] == 1)
                                <tr>
                                    <td class="text-center">
                                        <strong>Product Summary Type</strong>
                                    </td>
                                    <td>
                                        @if ($data['product_summary_type'] == '0')
                                            <span class="label label-lg font-weight-bolder label-rounded label-light-warning label-inline">List Product</span>
                                        @elseif ($data['product_summary_type'] == '1')
                                            <span class="label label-lg font-weight-bolder label-rounded label-light-success label-inline">Big Banner With Text on The Left</span>
                                        @elseif ($data['product_summary_type'] == '2')
                                            <span class="label label-lg font-weight-bolder label-rounded label-light-primary label-inline">Big Banner With Overlay and Center Text</span>
                                        @elseif ($data['product_summary_type'] == '3')
                                            <span class="label label-lg font-weight-bolder label-rounded label-light-primary label-inline">Big Banner Without Overlay and Black Text</span>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                            @if (!empty($data['banner']))
                                <tr>
                                    <td class="text-center">
                                        <strong>Banner</strong>
                                    </td>
                                    <td>
                                        <a href="{{ $data['banner']['path'] }}" target="_BLANK"><img src="{{ $data['banner']['path'] }}" alt="" style="width:500px;"></a>
                                    </td>
                                </tr>
                            @endif
                            @if (!empty($data['menu_icon']))
                                <tr>
                                    <td class="text-center">
                                        <strong>Menu Icon</strong>
                                    </td>
                                    <td>
                                        <a href="{{ $data['menu_icon']['path'] }}" target="_BLANK"><img src="{{ $data['menu_icon']['path'] }}" alt="" style="width:500px;"></a>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card card-custom mt-5">
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="20%" class="text-center">#</th>
                                <th>English</th>
                                <th>Indonesia</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">
                                    <strong>Name</strong>
                                </td>
                                <td>
                                    {{ $data['product']['en']['name'] ?? '' }}
                                </td>
                                <td>
                                    {{ $data['product']['id']['name'] ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <strong>Slug</strong>
                                </td>
                                <td>
                                    {{ $data['product']['en']['slug'] ?? '' }}
                                </td>
                                <td>
                                    {{ $data['product']['id']['slug'] ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <strong>Short Description</strong>
                                </td>
                                <td>
                                    {{ $data['product']['en']['short_description'] ?? '' }}
                                </td>
                                <td>
                                    {{ $data['product']['id']['short_description'] ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <strong>Page Title</strong>
                                </td>
                                <td>
                                    {{ $data['product']['en']['page_title'] ?? '' }}
                                </td>
                                <td>
                                    {{ $data['product']['id']['page_title'] ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <strong>Description</strong>
                                </td>
                                <td>
                                    {{ $data['product']['en']['description'] ?? '' }}
                                </td>
                                <td>
                                    {{ $data['product']['id']['description'] ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <strong>Video Description</strong>
                                </td>
                                <td>
                                    {{ $data['product']['en']['video_description'] ?? '' }}
                                </td>
                                <td>
                                    {{ $data['product']['id']['video_description'] ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <strong>SEO Title</strong>
                                </td>
                                <td>
                                    {{ $data['product']['en']['seo_title'] ?? '' }}
                                </td>
                                <td>
                                    {{ $data['product']['id']['seo_title'] ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <strong>SEO Description</strong>
                                </td>
                                <td>
                                    {{ $data['product']['en']['seo_description'] ?? '' }}
                                </td>
                                <td>
                                    {{ $data['product']['id']['seo_description'] ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <strong>SEO Keyword</strong>
                                </td>
                                <td>
                                    {{ $data['product']['en']['seo_keyword'] ?? '' }}
                                </td>
                                <td>
                                    {{ $data['product']['id']['seo_keyword'] ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <strong>SEO Canonical URL</strong>
                                </td>
                                <td>
                                    {{ $data['product']['en']['seo_canonical_url'] ?? '' }}
                                </td>
                                <td>
                                    {{ $data['product']['id']['seo_canonical_url'] ?? '' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection
