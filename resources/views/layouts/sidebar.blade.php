<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                @if (empty(Auth::user()->image))
                <img src="{{ asset('user.png') }} " class="img-circle" alt="User Image">
                @else
                <img src="{{ asset(Auth::user()->image) }} " class="img-circle" alt="User Image">
                @endif

            </div>
            <div class="pull-left info">
                <p>{{ \Auth::user()->name  }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu tree" data-widget="tree">
            <li class="header">Fungsi</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="{{ request()->is('home') ?  'active' : '' }}"><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <li class="{{ request()->is('user')
            || request()->is('user/create')
            || request()->is('user/show')
            || request()->is('user/*/edit')
            || request()->is('user/detail/*')
            || request()->is('cari/user')
            ?  'active' : '' }}"><a href="{{ route('user.index') }}"><i class="fa fa-users"></i> <span>Users</span></a></li>


            <li class="{{ request()->is('products')
            || request()->is('products/create')
            || request()->is('products/show')
            || request()->is('products/*/edit')
            || request()->is('products/detail/*')
            || request()->is('cari/product')
            ? 'active' : '' }}">
            <a href="{{ route('products.index') }}"><i class="fa fa-cubes"></i> <span>Product</span></a>
            </li>
            <li class="{{ request()->is('customers')
                || request()->is('customers/create')
                || request()->is('customers/*/edit')
                || request()->is('cari/customers')
                ? 'active' : '' }}"><a href="{{ route('customers.index') }}"><i class="fa fa-users"></i> <span>Product Users</span></a>
            </li>

            <li class="{{ request()->is('sales')
            || request()->is('sales/create')
            || request()->is('sales/show')
            || request()->is('sales/*/edit')
            || request()->is('cari/sales')
            ? 'active' : '' }}"><a href="{{ route('sales.index') }}"><i class="fa fa-cart-plus"></i> <span>Sale</span></a></li>
            <li class="{{ request()->is('suppliers')
            || request()->is('suppliers/create')
            || request()->is('suppliers/show')
            || request()->is('suppliers/*/edit')
            || request()->is('cari/suppliers')
            ? 'active' : '' }}"><a href="{{ route('suppliers.index') }}"><i class="fa fa-truck"></i> <span>Product Supplier</span></a></li>
            <li class="{{ request()->is('productsOut')
            || request()->is('productsOut/create')
            || request()->is('productsOut/show')
            || request()->is('productsOut/*/edit')
            || request()->is('cari/productsOut')
            ? 'active' : '' }}"><a href="{{ route('productsOut.index') }}"><i class="fa fa-minus"></i> <span>Product Out</span></a></li>

            <li class="{{ request()->is('productsIn')
            || request()->is('productsIn/create')
            || request()->is('productsIn/show')
            || request()->is('productsIn/*/edit')
            || request()->is('cari/productsIn')
            ? 'active' : '' }}"><a href="{{ route('productsIn.index') }}"><i class="fa fa-plus"></i> <span>Product In</span></a></li>

<li class="treeview {{
    request()->is('divisi')
    || request()->is('divisi/create')
    || request()->is('divisi/show')
    || request()->is('divisi/*/edit')
    || request()->is('cari/assets')
    || request()->is('wilayah')
    || request()->is('wilayah/create')
    || request()->is('wilayah/show')
    || request()->is('wilayah/*/edit')
    || request()->is('cari/wilayah')
    || request()->is('lokasi')
    || request()->is('lokasi/create')
    || request()->is('lokasi/show')
    || request()->is('lokasi/*/edit')
    || request()->is('cari/lokasi')
    || request()->is('kategori')
    || request()->is('kategori/create')
    || request()->is('kategori/show')
    || request()->is('kategori/*/edit')
    || request()->is('cari/kategori')
    || request()->is('rak')
    || request()->is('rak/create')
    || request()->is('rak/show')
    || request()->is('rak/*/edit')
    || request()->is('cari/rak')
    || request()->is('ruangan')
    || request()->is('ruangan/create')
    || request()->is('ruangan/show')
    || request()->is('ruangan/*/edit')
    || request()->is('cari/ruangan')
    ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-server"></i>
        <span>Data Master</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ request()->is('divisi')
            || request()->is('divisi/create')
            || request()->is('divisi/show')
            || request()->is('divisi/*/edit')
            || request()->is('cari/assets')
            ? 'active' : '' }} ">
            <a href="{{ route('divisi.index') }}"><i class="fa fa-building"></i> <span>Division</span></a>
        </li>
        <li class="{{ request()->is('kategori')
            || request()->is('kategori/create')
            || request()->is('kategori/show')
            || request()->is('kategori/*/edit')
            || request()->is('cari/kategori')
            ? 'active' : '' }}"><a href="{{ route('kategori.index') }}"><i class="fa fa-list"></i> <span>Category</span></a>
        </li>

        <li class="{{ request()->is('wilayah')
            || request()->is('wilayah/create')
            || request()->is('wilayah/show')
            || request()->is('wilayah/*/edit')
            || request()->is('cari/wilayah')
            ? 'active' : '' }}"><a href="{{ route('wilayah.index') }}"><i class="fa fa-location-arrow""></i> <span>Region</span>
            </a>
        </li>

        <li class="{{ request()->is('ruangan')
            || request()->is('ruangan/create')
            || request()->is('ruangan/show')
            || request()->is('ruangan/*/edit')
            || request()->is('cari/ruangan')
            ? 'active' : '' }} "><a href="{{ route('ruangan.index') }}"><i class="fa fa-university"></i> <span>Room</span></a>
        </li>

        <li class="{{ request()->is('rak')
            || request()->is('rak/create')
            || request()->is('rak/show')
            || request()->is('rak/*/edit')
            || request()->is('cari/rak')
            ? 'active' : '' }} "><a href="{{ route('rak.index') }}"><i class="fa fa-codepen"></i> <span>Rack</span></a>
        </li>


    </ul>


</li>




        </ul>

        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
