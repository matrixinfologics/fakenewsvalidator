<!-- Sidebar  -->
<nav id="sidebar">
    <div class="sidebar-header">
        <h3>Fake News Validator</h3>
    </div>

    <ul class="list-unstyled components">
        <li class="{{ Route::currentRouteName() == 'caseinfo'?'active':'' }}">
            <a href="{{ route('caseinfo', $case) }}" >Info</a>
        </li>
        <li>
            <a href="#">Post Analysis</a>
        </li>
        <li>
            <a href="#">Replies</a>
        </li>
        <li>
            <a href="#">Author Profile</a>
        </li>
        <li>
            <a href="#">Author Latest Post</a>
        </li>
        <li>
            <a href="#">Post Geo Location</a>
        </li>
        <li>
            <a href="#">Similar Posts</a>
        </li>
        <li>
            <a href="#">Similar Posts From Same Area</a>
        </li>
        <li>
            <a href="#">Image Search Verification</a>
        </li>
        <li>
            <a href="#">Source Cross Checking</a>
        </li>
        <li>
            <a href="#">Discussions</a>
        </li>
        <li>
            <a href="#">Result</a>
        </li>
    </ul>
</nav>
