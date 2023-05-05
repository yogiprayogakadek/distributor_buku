<!doctype html>
<html lang="en">

@include('templates.partials.head')

<body data-sidebar="dark" data-layout-mode="light">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">


        @include('templates.partials.header')

        <!-- ========== Left Sidebar Start ========== -->
        @include('templates.partials.sidebar')
        <!-- Left Sidebar End -->



        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">@yield('title')</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">@yield('sub-title')</a></li>
                                        <li class="breadcrumb-item active">@yield('title')</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    {{-- content --}}
                    @yield('content')

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            @include('templates.partials.footer')
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- JAVASCRIPT -->
    @include('templates.partials.script')

</body>

</html>
