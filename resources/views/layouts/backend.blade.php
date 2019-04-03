<!doctype html>
<html lang="{{ config('app.locale') }}">
    @include('layouts._head')
    <body>
    @include('layouts._body_div')

    {{-- RIGHT-SIDE FLYOUT OVERLAY --}}
    @include('layouts._side_overlay')
    @include('layouts._sidebar')


            <!-- Header -->
    @include('layouts._header')

            <!-- Main Container -->
            <main id="main-container">
                @yield('side_content')
                @yield('content')
            </main>
            <!-- END Main Container -->

            <!-- Footer -->
    @include('layouts._footer')

        </div>
        <!-- END Page Container -->

    @include('layouts._js')

        @yield('js_after')
   </body>
</html>
