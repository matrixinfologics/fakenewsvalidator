<aside class="main-sidebar">
    <section class="sidebar">
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Menus</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="{{ Route::currentRouteName() == 'users.index'?'active':'' }}"><a href="{{ route('users.index') }}"><i class="fa fa-users"></i> <span>Users</span></a></li>
            <li class="{{ Route::currentRouteName() == 'settings'?'active':'' }}"><a href="{{ route('settings') }}"><i class="fa fa-cog"></i> <span>Settings</span></a></li>
            <li><a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a></li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
