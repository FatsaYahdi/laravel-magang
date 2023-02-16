<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">

            @if(Auth::user())
                <div class="info">
                    <a href="{{ route('my.profile.index') }}">{{ auth()->user()->name }}</a>
                </div>
            @endif
        </div>

        
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                {{-- Home --}}
               <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ Route::is('home') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-home"></i>
                        <p>
                            Home
                        </p>
                    </a>
                </li>

                {{-- Tag --}}
                <li class="nav-item {{ Request::is('tag*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('tag*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tag"></i>
                        <p>
                        Tag
                        <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                        <a href="{{ route('tag.index') }}" class="nav-link {{ (Route::is('tag.index') || Route::is('tag.edit')) ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('tag.create') }}" class="nav-link {{ Route::is('tag.create')  ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create</p>
                        </a>
                    </li>
                    </ul>
                </li>

                {{-- Category --}}
                <li class="nav-item {{ Request::is('category*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('category*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                        Category
                        <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                        <a href="{{ route('category.index') }}" class="nav-link {{ (Route::is('category.index') || Route::is('category.edit')) ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('category.create') }}" class="nav-link {{ Route::is('category.create')  ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create</p>
                        </a>
                    </li>
                    </ul>
                </li>
                @if(Auth::user()->role == "superadmin")
                <li class="nav-item">
                    <a href="/user" class="nav-link {{ (Route::is('user.index') || Route::is('show.show')) ? 'active' : '' }}">
                        <i class="nav-icon fa fa-users"></i>
                        <p>
                            User
                        </p>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>