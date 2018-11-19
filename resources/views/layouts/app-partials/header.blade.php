<nav class="navbar navbar-expand-lg">
<div class="container">
    @if(!$withoutSidebar)
        <button type="button" id="sidebarCollapse" class="btn btn-info">
        </button>
    @endif
    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-new-case" href="{{ route('newcase') }}">New Case</a>
                </li>
                <li class="nav-item">
                    <a class="nav-search" href="{{ url('/') }}">Search Case</a>
                </li>
                <li class="nav-item">
                    <a class="nav-logout" href="{{ route('logout') }}">Logout</a>
                </li>
            </ul>
    </div>
</div>
</nav>
