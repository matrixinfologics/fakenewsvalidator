<aside class="main-sidebar">
    <section class="sidebar">
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Menus</li>
            <!-- Optionally, you can add icons to the links -->
             <li class="{{ Route::currentRouteName() == 'dashboard'?'active':'' }}"><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <li class="{{ Route::currentRouteName() == 'users.index'?'active':'' }}"><a href="{{ route('users.index') }}"><i class="fa fa-users"></i> <span>Users</span></a></li>
            @if (Auth::user()->isCompanyAdmin())
                <li class="{{ Route::currentRouteName() == 'companies.edit'?'active':'' }}"><a href="{{ route('companies.edit', Auth::user()->company->id) }}"><i class="fa fa-globe"></i> <span>My Company</span></a></li>
            @else
                <li class="{{ Route::currentRouteName() == 'companies.index'?'active':'' }}"><a href="{{ route('companies.index') }}"><i class="fa fa-globe"></i> <span>Companies</span></a></li>
                <li class="{{ Route::currentRouteName() == 'settings'?'active':'' }}"><a href="{{ route('settings') }}"><i class="fa fa-cog"></i> <span>Settings</span></a></li>
            @endif

        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
