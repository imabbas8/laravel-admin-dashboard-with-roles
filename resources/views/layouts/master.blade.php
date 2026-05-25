<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
    <head>
        <title>Sing In</title>
        <meta charset="utf-8" />
        <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
        <link href="{{url('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
        <style>
            body { background-image: url('assets/media/auth/bg4-dark.jpg'); }
            [data-bs-theme="dark"]
            body { background-image: url('assets/media/auth/bg4-dark.jpg'); }
        </style>
    </head>
    <body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat">
        <div class="d-flex flex-column flex-root" id="kt_app_root">
            <div class="d-flex flex-column  flex-lg-row" >
                <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
                    <div class="d-flex flex-center flex-lg-start flex-column">
                        <a href="{{url('/')}}" class="mb-7">
                            <img alt="Logo" src="{{url('assets/logos/logo.png')}}" width="200" />
                        </a>
                        <!-- <h2 class="text-white fw-normal m-0">Branding tools designed for your business</h2> -->
                    </div>
                </div>
                <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
                    <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-700px p-15">
                        <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>var hostUrl = "assets/";</script>
        <script src="{{url('assets/plugins/global/plugins.bundle.js')}}"></script>
        <script src="{{url('assets/js/scripts.bundle.js')}}"></script>
        @stack('scripts')
    </body>
</html>