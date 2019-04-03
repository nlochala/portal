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
                <!-- Page Content -->
                <div class="row no-gutters flex-md-10-auto">
                    @include('layouts._side_start')
                                <p>Your side content..</p>
                    @include('layouts._side_end')
                    <div class="col-md-8 col-lg-7 col-xl-9 order-md-0 bg-body-dark">
                        <!-- Main Content -->
                        <div class="content content-full">
                            <div class="block block-fx-pop">
                                <div class="block-content">
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                        <!-- END Main Content -->
                    </div>
                    <div class="col-md-8 col-lg-7 col-xl-9 order-md-0 bg-body-dark">
                        <!-- Main Content -->
                        <div class="content content-full">
                            <div class="block block-fx-pop">
                                <div class="block-content">
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                        <!-- END Main Content -->
                    </div>
                </div>
                <!-- END Page Content -->
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
