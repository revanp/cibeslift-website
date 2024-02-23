<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Cibeslift CMS</title>
        <meta name="description" content="Updates and statistics"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>

        <link href="{{ asset('public/backend/css/pages/login/classic/login-5.css?v=7.0.6') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('public/backend/plugins/global/plugins.bundle.css?v=7.0.6') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('public/backend/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.6') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('public/backend/css/style.bundle.css?v=7.0.6') }}" rel="stylesheet" type="text/css"/>

        <link rel="shortcut icon" href="{{ asset('public/favicon/favicon.ico') }}"/>
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('public/favicon/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('public/favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('public/favicon/favicon-16x16.png') }}">
    </head>
    <body  id="kt_body"  class="header-fixed header-mobile-fixed subheader-enabled page-loading"  >
        <div class="d-flex flex-column flex-root">
            <div class="login login-5 login-signin-on d-flex flex-row-fluid" id="kt_login">
                <div class="d-flex flex-center bgi-size-cover bgi-no-repeat flex-row-fluid" style="background-image: url('{{ asset('public/backend/media/bg/bg-2.jpg') }}');">
                    <div class="login-form text-center text-white p-7 position-relative overflow-hidden">
                        <div class="d-flex flex-center mb-15">
                            <a href="#">
                                <img src="{{ asset('public/backend/media/logos/cibes_logo.svg') }}" class="max-h-75px" alt=""/>
                            </a>
                        </div>

                        <div class="login-signin">
                            <div class="mb-20">
                                <h3 class="opacity-40 font-weight-normal">Sign In To Admin</h3>
                                <p class="opacity-40">Enter your details to login to your account:</p>
                            </div>
                            <form class="form" action="#" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8 @if($errors->has('email')) is-invalid @endif" type="text" placeholder="Email" name="email" autocomplete="off" value="{{ old('email') }}"/>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8 @if($errors->has('password')) is-invalid @endif" type="password" placeholder="Password" name="password"/>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group d-flex flex-wrap justify-content-between align-items-center px-8 opacity-60">
                                    <div class="checkbox-inline">
                                        <label class="checkbox checkbox-outline checkbox-white text-white m-0">
                                            <input type="checkbox" name="remember"/>
                                            <span></span>
                                            Remember me
                                        </label>
                                    </div>
                                    <a href="#" class="text-white font-weight-bold">Forget Password ?</a>
                                </div>
                                <div class="form-group text-center mt-10">
                                    <button class="btn btn-pill btn-primary opacity-90 px-15 py-3" type="submit">Sign In</button>
                                </div>
                            </form>
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
        <script>
            @if($message = Session::get('success'))
                $(document).ready(function(){
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

                    toastr.success("{{ $message }}");
                });
            @endif

            @if($message = Session::get('error'))
                $(document).ready(function(){
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

                    toastr.error("{{ $message }}");
                });
            @endif
        </script>
    </body>
</html>
