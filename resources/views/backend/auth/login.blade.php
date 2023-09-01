<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Cibeslift CMS</title>
        <meta name="description" content="Updates and statistics"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>

        <link href="{{ asset('public/backend/plugins/global/plugins.bundle.css?v=7.0.6" rel="stylesheet') }}" type="text/css"/>
        <link href="{{ asset('public/backend/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.6') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('public/backend/css/style.bundle.css?v=7.0.6') }}" rel="stylesheet" type="text/css"/>

        <link rel="shortcut icon" href="{{ asset('public/backend/media/logos/favicon.ico') }}"/>
    </head>
    <body  id="kt_body"  class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading"  >
        <div class="d-flex flex-column flex-root">
            <div class="login login-4 login-signin-on d-flex flex-row-fluid" id="kt_login">
                <div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat" style="background-image: url('{{ asset('public/backend/media/bg/bg-3.jpg') }}');">
                    <div class="login-form text-center p-7 position-relative overflow-hidden">
                        <div class="d-flex flex-center mb-15">
                            <a href="#">
                                <img src="{{ asset('public/backend/media/logos/logo-letter-13.png') }}" class="max-h-75px" alt=""/>
                            </a>
                        </div>
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
        <script src="{{ asset('public/backend/plugins/custom/fullcalendar/fullcalendar.bundle.js?v=7.0.6') }}"></script>
    </body>
</html>
