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
                            @if (!empty($data['thumbnail']))
                                <tr>
                                    <td class="text-center">
                                        <strong>Thumbnail</strong>
                                    </td>
                                    <td>
                                        <a href="{{ $data['thumbnail']['path'] }}" target="_BLANK"><img src="{{ $data['thumbnail']['path'] }}" alt="" style="width:500px;"></a>
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
                            @if (!empty($data['product_summary_image']))
                                <tr>
                                    <td class="text-center">
                                        <strong>Product Summary Image</strong>
                                    </td>
                                    <td>
                                        <a href="{{ $data['product_summary_image']['path'] }}" target="_BLANK"><img src="{{ $data['product_summary_image']['path'] }}" alt="" style="width:500px;"></a>
                                    </td>
                                </tr>
                            @endif
                            @if (!empty($data['specification_image']))
                                <tr>
                                    <td class="text-center">
                                        <strong>Specification Image</strong>
                                    </td>
                                    <td>
                                        <a href="{{ $data['specification_image']['path'] }}" target="_BLANK"><img src="{{ $data['specification_image']['path'] }}" alt="" style="max-width:500px; max-height: 400px"></a>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td class="text-center">
                                    <strong>Active</strong>
                                </td>
                                <td>
                                    {!! $data['is_active'] == '1' ? '<span class="label label-lg font-weight-bolder label-rounded label-success label-inline">Active</span>' : '<span class="label label-lg font-weight-bolder label-rounded label-danger label-inline">Not Active</span>' !!}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card card-custom mt-5">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Product Identity</h3>
                    </div>
                </div>
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

            @if ($data['have_a_child'] != '1')
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-custom mt-5">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">Product Specification</h3>
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
                                            <td class="text-center">Size</td>
                                            <td>{!! $data['product_specification']['size'] ?? '' !!}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Installation</td>
                                            <td>{{ $data['product_specification']['installation'] ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Rated Load</td>
                                            <td>{{ $data['product_specification']['rated_load'] ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Power Supply</td>
                                            <td>{{ $data['product_specification']['power_supply'] ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Speed</td>
                                            <td>{{ $data['product_specification']['speed'] ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Min. Headroom</td>
                                            <td>{{ $data['product_specification']['min_headroom'] ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Lift Pit</td>
                                            <td>{{ $data['product_specification']['lift_pit'] ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Drive System</td>
                                            <td>{{ $data['product_specification']['drive_system'] ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Max. Travel</td>
                                            <td>{{ $data['product_specification']['max_travel'] ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Max. Number of Stops</td>
                                            <td>{{ $data['product_specification']['max_number_of_stops'] ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Lift Controls</td>
                                            <td>{{ $data['product_specification']['lift_controls'] ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Motor Power</td>
                                            <td>{{ $data['product_specification']['motor_power'] ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Machine Room</td>
                                            <td>{{ $data['product_specification']['machine_room'] ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Door Configuration</td>
                                            <td>{{ $data['product_specification']['door_configuration'] ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Directive and Standards</td>
                                            <td>{{ $data['product_specification']['directive_and_standards'] ?? '' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="card card-custom mt-5">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">Product Faq</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>No. </th>
                                        <th>Question</th>
                                        <th>Answer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['product_id_has_faq_id'] as $key => $val)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ $val['faq_id']['faq'][0]['title'] }}</td>
                                            <td>{{ $val['faq_id']['faq'][0]['description'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-custom mt-5">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">Product Tech</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>No. </th>
                                        <th>Tech</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['product_id_has_product_technology_id'] as $key => $val)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ $val['product_technology_id']['product_technology'][0]['name'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-custom mt-5">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">Product Customization</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>No. </th>
                                        <th width="30%">Name</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['product_customization_id'] as $key => $val)
                                        <tr class="bg-gray-100">
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ $val['product_customization'][0]['name'] }}</td>
                                            <td>{{ $val['product_customization'][0]['description'] }}</td>
                                            <td class="text-center">
                                                <a class="btn btn-primary btn-sm" href="{{ url('admin-cms/products/products/customizations/'.$data['id']) }}"><i class="flaticon-eye"></i></a>
                                            </td>
                                        </tr>
                                        @foreach ($val['product_customization_option_id'] as $key2 => $val2)
                                        <tr class="bg-gray-200">
                                                <td class="text-center">{{ $key + 1 }}.{{ $key2 + 1 }}</td>
                                                <td>{{ $val2['product_customization_option'][0]['name'] }}</td>
                                                <td></td>
                                                <td></td>
                                            </tr>

                                            @foreach ($val2['product_customization_option_variation_id'] as $key3 => $val3)
                                            <tr class="bg-gray-300">
                                                    <td class="text-center">{{ $key + 1 }}.{{ $key2 + 1 }}.{{ $key3 + 1 }}</td>
                                                    <td>{{ $val3['product_customization_option_variation'][0]['name'] }}</td>
                                                    <td>
                                                        <img src="{{ $val3['image']['path'] }}" alt="">
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection
