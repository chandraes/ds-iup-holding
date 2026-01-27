<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="{{asset('assets/icons/font-awesome/css/all.css')}}">
        <script src="{{asset('assets/js/jquery.js')}}"></script>
        <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
        {{-- <script src="./node_modules/preline/dist/preline.js"></script> --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- Scripts -->

    </head>
    <style>
        .dt-layout-row:has(.dt-search),
        .dt-layout-row:has(.dt-length),
        .dt-layout-row:has(.dt-paging),
        {
          display: none !important;
        }
        .dt-scroll-body thead {
            display: none !important;
        }

        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite; /* Safari */
            animation: spin 2s linear infinite;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        #loader {
            z-index: 9999; /* Ensure loader has the highest z-index */
        }
      </style>
    <body class="font-sans antialiased">
        <div id="loader" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
            <div class="loader"></div>
        </div>
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-center underline">
                        {{ $header }}
                    </div>
                </header>
            @endisset
            @include('swal')
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
            <script>
                window.addEventListener('swal',function(e){
                    Swal.fire(e.detail);
                });

                // window.addEventListener('load', () => {

                // const inputs = document.querySelectorAll('.dt-container thead input');

                // inputs.forEach((input) => {
                //     input.addEventListener('keydown', function (evt) {
                //     if ((evt.metaKey || evt.ctrlKey) && evt.key === 'a') this.select();
                //     });
                // });
                // });
            </script>

            @stack('js')
        </div>
    </body>
</html>
