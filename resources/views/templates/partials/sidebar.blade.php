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

                
                @cannot('distributor')
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
                <li>
                    <a href="{{route('transaksi.index')}}" class="waves-effect {{Request::is('/transaksi') ? 'active' : '' }}">
                        <i class="bx bx-cart-alt"></i>
                        <span key="t-cart">Transaksi</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('pembayaran.index')}}" class="waves-effect {{Request::is('/pembayaran') ? 'active' : '' }}">
                        <i class="bx bx-money"></i>
                        <span key="t-cart">Pembayaran</span>
                    </a>
                </li>
                @endcannot

                @can('distributor')
                <li>
                    <a href="{{route('distributor.katalog.index')}}" class="waves-effect {{Request::is('/distributor/katalog') ? 'active' : '' }}">
                        <i class="bx bx-book-open"></i>
                        <span key="t-book">Katalog</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('distributor.keranjang.index')}}" class="waves-effect {{Request::is('/distributor/keranjang') ? 'active' : '' }}">
                        <i class="bx bx-cart-alt"></i>
                        <span key="t-cart">Keranjang Belanja</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('distributor.transaksi.index')}}" class="waves-effect {{Request::is('/distributor/transaksi') ? 'active' : '' }}">
                        <i class="bx bx-cart-alt"></i>
                        <span key="t-cart">Transaksi</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('distributor.pembayaran.index')}}" class="waves-effect {{Request::is('/distributor/pembayaran') ? 'active' : '' }}">
                        <i class="bx bx-money"></i>
                        <span key="t-cart">Pembayaran</span>
                    </a>
                </li>
                @endcan
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
