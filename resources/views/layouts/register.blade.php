<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name', 'PEPRIS GB') }}</title>
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    {{-- <link rel="stylesheet" href="{{asset('css/style.css')}}"> --}}

    <link rel="stylesheet" type="text/css" href="{{ asset('public_theme/css/bootstrap.min.css') }}">
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css" rel="stylesheet" /> --}}
    <link href="{{ asset('public_theme/css/line-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public_theme/css/custom_style.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com"> --}}
    {{-- <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> --}}
    <link href="{{ asset('public_theme/css/google_fonts.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link href="https://fonts.googleapis.com/css2?family=Boldonse&family=Gravitas+One&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Libertinus+Sans:ital,wght@0,400;0,700;1,400&family=Manrope:wght@200..800&family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Oswald:wght@200..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet"> --}}
</head>

<body>

    <div class="container-fluid main-container">
        <div class="row mobile_web">
            <!-- Left Section -->
            <div class="col-md-6 col-12 left-section">
                <div class="left-heading d-flex flex-column justify-content-center align-items-center">
                    <img src="{{ asset('public_theme/images/main-logo.png') }}" class="img-fluid login_banner"
                        alt="E-School Logo" />
                    <h1 class="text-light mt-3 mb-0 main-heading">e-school</h1>
                    <h2 class="text-light main-heading1">Gilgit Baltistan</h2>
                </div>
            </div>

            <!-- Right Section -->

            {{ $slot }}

        </div>
    </div>

    <script src="{{ asset('public_theme/js/bootstrap.bundle.js') }}"></script>

    {{-- @include('layouts.notification') --}}

</body>

</html>
