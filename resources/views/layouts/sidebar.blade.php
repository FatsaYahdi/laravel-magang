<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        @if (auth()->user())
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('storage/images/'.auth()->user()->pp ) }}" class="rounded-sm elevation-2">
            </div>
        @endif

            @if(Auth::user())
                <div class="info">
                    <a href="{{ route('my.profile.index') }}" class="d-block">{{ auth()->user()->name }}</a>
                </div>
            @endif
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ Route::is('home') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-home"></i>
                        <p>
                            Home
                        </p>
                    </a>
                </li>
               <li class="nav-item">
                    <a href="/my-profile" class="nav-link {{ Route::is('my.profile.index') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-pen"></i>
                        <p>
                            Edit
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/show" class="nav-link {{ Route::is('show') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-user"></i>
                        <p>
                            User
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>