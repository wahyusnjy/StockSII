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

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Fungsi</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="{{ request()->is('home') ?  'active' : '' }}"><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <li class="{{ request()->is('user')
            || request()->is('user/create')
            || request()->is('user/show')
            || request()->is('user/*/edit')
            || request()->is('user/detail/*')
            ?  'active' : '' }}"><a href="{{ route('user.index') }}"><i class="fa fa-users"></i> <span>Users</span></a></li>
            <li class="{{ request()->is('categories')
            || request()->is('categories/create')
            || request()->is('categories/show')
            || request()->is('categories/*/edit')
            ? 'active' : '' }}"><a href="{{ route('categories.index') }}"><i class="fa fa-list"></i> <span>Kategori</span></a></li>
            <li class="{{ request()->is('products')
            || request()->is('products/create')
            || request()->is('products/show')
            || request()->is('products/*/edit')
            || request()->is('products/detail/*')
            ? 'active' : '' }}">
            <a href="{{ route('products.index') }}"><i class="fa fa-cubes"></i> <span>Product</span></a>
            </li>
            <li class="{{ request()->is('customers')
            || request()->is('customers/create')
            || request()->is('customers/*/edit')
            ? 'active' : '' }}"><a href="{{ route('customers.index') }}"><i class="fa fa-users"></i> <span>Customer</span></a></li>
            <li class="{{ request()->is('sales')
            || request()->is('sales/create')
            || request()->is('sales/show')
            || request()->is('sales/*/edit')
            ? 'active' : '' }}"><a href="{{ route('sales.index') }}"><i class="fa fa-cart-plus"></i> <span>Penjualan</span></a></li>
            <li class="{{ request()->is('suppliers')
            || request()->is('suppliers/create')
            || request()->is('suppliers/show')
            || request()->is('suppliers/*/edit')
            ? 'active' : '' }}"><a href="{{ route('suppliers.index') }}"><i class="fa fa-truck"></i> <span>Supplier</span></a></li>
            <li class="{{ request()->is('productsOut')
            || request()->is('productsOut/create')
            || request()->is('productsOut/show')
            || request()->is('productsOut/*/edit')
            ? 'active' : '' }}"><a href="{{ route('productsOut.index') }}"><i class="fa fa-minus"></i> <span>Product Keluar</span></a></li>

            <li class="{{ request()->is('productsIn')
            || request()->is('productsIn/create')
            || request()->is('productsIn/show')
            || request()->is('productsIn/*/edit')
            ? 'active' : '' }}"><a href="{{ route('productsIn.index') }}"><i class="fa fa-plus"></i> <span>Product Masuk</span></a></li>

            <li class="{{ request()->is('lokasi')
            || request()->is('lokasi/create')
            || request()->is('lokasi/show')
            || request()->is('lokasi/*/edit')
            ? 'active' : '' }}"><a href="{{ route('lokasi.index') }}"><i class="fa fa-search"></i> <span>Lokasi</span></a></li>

            <li class="{{ request()->is('assetinventory')
            || request()->is('assetinventory/create')
            || request()->is('assetinventory/show')
            || request()->is('assetinventory/*/edit')
            ? 'active' : '' }}"><a href="{{ route('assetinventory.index') }}"><i class="fa fa-inbox"></i> <span>Assets / Inventory</span></a></li>








        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
