<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>

                <li>
                    <a href="{{route('dashboard.index')}}" class="waves-effect {{Request::is('/') ? 'mm-active' : '' }}">
                        <i class="bx bx-home"></i>
                        <span key="t-home">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('kategori.index')}}" class="waves-effect {{Request::is('/kategori') ? 'active' : '' }}">
                        <i class="bx bx-file"></i>
                        <span key="t-file-manager">Kategori</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('buku.index')}}" class="waves-effect {{Request::is('/buku') ? 'active' : '' }}">
                        <i class="bx bx-book-open"></i>
                        <span key="t-book">Buku</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>