@extends('backend.layouts.app')

@section('content')
    <div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <h5 class="text-dark font-weight-bold my-1 mr-5">
                        View Category
                    </h5>

                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-muted">Products</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin-cms/products/categories') }}" class="text-muted">Categories</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ url('admin-cms/products/categories/view/'.$data['id']) }}" class="text-muted">View Category</a>
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
                        <h3 class="card-label">View Category</h3>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ url('admin-cms/products/categories') }}" class="btn btn-danger font-weight-bolder">
                            <span class="svg-icon svg-icon-md"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                    <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-12.000003, -11.999999) "/>
                                </g>
                            </svg></span> Back
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
                                <td class="text-center"><strong>Thumbnail</strong></td>
                                <td>
                                    @if (!empty($data['thumbnail']))
                                        <a href="{{ $data['thumbnail']['path'] }}" target="_BLANK">
                                            <img src="{{ $data['thumbnail']['path'] }}" style="max-width: 500px" alt="">
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>Banner</strong></td>
                                <td>
                                    @if (!empty($data['banner']))
                                        <a href="{{ $data['banner']['path'] }}" target="_BLANK">
                                            <img src="{{ $data['banner']['path'] }}" style="max-width: 500px" alt="">
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>File Icon</strong></td>
                                <td>
                                    @if (!empty($data['file_icon']))
                                        <a href="{{ $data['file_icon']['path'] }}" target="_BLANK">
                                            <img src="{{ $data['file_icon']['path'] }}" style="max-width: 500px" alt="">
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>Video Thumbnail</strong></td>
                                <td>
                                    @if (!empty($data['video_thumbnail']))
                                        <a href="{{ $data['video_thumbnail']['path'] }}" target="_BLANK">
                                            <img src="{{ $data['video_thumbnail']['path'] }}" style="max-width: 500px" alt="">
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>Video URL</strong></td>
                                <td>{{ $data['video_url'] ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>Sort</strong></td>
                                <td>{{ $data['sort'] ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>Is Active</strong></td>
                                <td>{{ $data['is_active'] == 1 ? '✅' : '❌' }}</td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>Is Self Design</strong></td>
                                <td>{{ $data['is_self_design'] == 1 ? '✅' : '❌' }}</td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>Created At</strong></td>
                                <td>{{ date('Y-m-d H:i:s', strtotime($data['created_at'])) ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>Updated At</strong></td>
                                <td>{{ date('Y-m-d H:i:s', strtotime($data['updated_at'])) ?? '' }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="separator separator-solid separator-border-3 mb-5"></div>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="20%" class="text-center">#</th>
                                <th>Indonesia</th>
                                <th>English</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center"><strong>Name</strong></td>
                                <td>{{ $data['product_category']['id']['name'] ?? '' }}</td>
                                <td>{{ $data['product_category']['en']['name'] ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>Description</strong></td>
                                <td>{!! $data['product_category']['id']['description'] ?? '' !!}</td>
                                <td>{!! $data['product_category']['en']['description'] ?? '' !!}</td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>Post Title</strong></td>
                                <td>{{ $data['product_category']['id']['post_title'] ?? '' }}</td>
                                <td>{{ $data['product_category']['en']['post_title'] ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>Post Description</strong></td>
                                <td>{!! $data['product_category']['id']['post_description'] ?? '' !!}</td>
                                <td>{!! $data['product_category']['en']['post_description'] ?? '' !!}</td>
                            </tr>
                            <tr>
                                <td class="text-center" colspan="3"><strong>---- SEO ----</strong></td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>SEO Title</strong></td>
                                <td>{{ $data['product_category']['id']['seo_title'] ?? '' }}</td>
                                <td>{{ $data['product_category']['en']['seo_title'] ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>SEO Description</strong></td>
                                <td>{{ $data['product_category']['id']['seo_description'] ?? '' }}</td>
                                <td>{{ $data['product_category']['en']['seo_description'] ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>SEO Keyword</strong></td>
                                <td>{{ $data['product_category']['id']['seo_keyword'] ?? '' }}</td>
                                <td>{{ $data['product_category']['en']['seo_keyword'] ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>SEO Canonical URL</strong></td>
                                <td>{{ $data['product_category']['id']['seo_canonical_url'] ?? '' }}</td>
                                <td>{{ $data['product_category']['en']['seo_canonical_url'] ?? '' }}</td>
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
