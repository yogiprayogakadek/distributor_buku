<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{route('index')}}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{asset('assets/images/web/logo_pt.png')}}" alt="" height="15">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('assets/images/web/logo_pt.png')}}" alt="" height="17">
                    </span>
                </a>

                <a href="{{route('index')}}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{asset('assets/images/web/logo_pt.png')}}" alt="" height="15">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('assets/images/web/logo_pt.png')}}" alt="" height="35">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>

        <div class="d-flex">

            {{-- HIDDEN MENU --}}
                {{-- @can('distributor')
                <div class="dropdown d-inline-block cart-render">
                    <!-- render cart -->
                </div>
                @endcan --}}


            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{asset(auth()->user()->foto)}}" alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{auth()->user()->username}}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    @can('distributor')
                    <a class="dropdown-item" href="{{route('profil.index')}}"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-user">Profil</span></a>
                    @endcan
                    <a class="dropdown-item text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="{{route('logout')}}"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>
