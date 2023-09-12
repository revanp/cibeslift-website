<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Cibeslift CMS</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>

        <link href="{{ asset('public/backend/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>

        <link href="{{ asset('public/backend/plugins/global/plugins.bundle.css') }}" rel="stylesheet type="text/css"/>
        <link href="{{ asset('public/backend/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('public/backend/css/style.bundle.css') }}" rel="stylesheet" type="text/css"/>

        {{-- <link rel="shortcut icon" href="{{ asset('public/backend/media/logos/favicon.ico') }}"/> --}}
    </head>
    <body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled page-loading">
        @include('backend.layouts.header-mobile')

        <div class="d-flex flex-column flex-root">
            <div class="d-flex flex-row flex-column-fluid page">
                <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                    @include('backend.layouts.header')

                    <div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>

        <script>
            var KTAppSettings = {
                "breakpoints": {
                    "sm": 576,
                    "md": 768,
                    "lg": 992,
                    "xl": 1200,
                    "xxl": 1200
                },
                "colors": {
                    "theme": {
                        "base": {
                            "white": "#ffffff",
                            "primary": "#0BB783",
                            "secondary": "#E5EAEE",
                            "success": "#1BC5BD",
                            "info": "#8950FC",
                            "warning": "#FFA800",
                            "danger": "#F64E60",
                            "light": "#F3F6F9",
                            "dark": "#212121"
                        },
                        "light": {
                            "white": "#ffffff",
                            "primary": "#D7F9EF",
                            "secondary": "#ECF0F3",
                            "success": "#C9F7F5",
                            "info": "#EEE5FF",
                            "warning": "#FFF4DE",
                            "danger": "#FFE2E5",
                            "light": "#F3F6F9",
                            "dark": "#D6D6E0"
                        },
                        "inverse": {
                            "white": "#ffffff",
                            "primary": "#ffffff",
                            "secondary": "#212121",
                            "success": "#ffffff",
                            "info": "#ffffff",
                            "warning": "#ffffff",
                            "danger": "#ffffff",
                            "light": "#464E5F",
                            "dark": "#ffffff"
                        }
                    },
                    "gray": {
                        "gray-100": "#F3F6F9",
                        "gray-200": "#ECF0F3",
                        "gray-300": "#E5EAEE",
                        "gray-400": "#D6D6E0",
                        "gray-500": "#B5B5C3",
                        "gray-600": "#80808F",
                        "gray-700": "#464E5F",
                        "gray-800": "#1B283F",
                        "gray-900": "#212121"
                    }
                },
                "font-family": "Poppins"
            };
        </script>
        <script src="{{ asset('public/backend/plugins/global/plugins.bundle.js?v=7.0.6') }}"></script>
        <script src="{{ asset('public/backend/plugins/custom/prismjs/prismjs.bundle.js?v=7.0.6') }}"></script>
        <script src="{{ asset('public/backend/js/scripts.bundle.js?v=7.0.6') }}"></script>
        <script src="{{ asset('public/backend/plugins/custom/datatables/datatables.bundle.js?v=7.0.6') }}"></script>
        <script>
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "500",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            @if($message = Session::get('success'))
                $(document).ready(function(){
                    toastr.success("{{ $message }}");
                });
            @endif

            @if($message = Session::get('error'))
                $(document).ready(function(){
                    toastr.error("{{ $message }}");
                });
            @endif
        </script>
        @yield('script')
    </body>
</html>
