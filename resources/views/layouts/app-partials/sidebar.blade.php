<!-- Sidebar  -->
<nav id="sidebar">
    <div class="sidebar-header">
        <h3>Fake News Validator</h3>
    </div>

    <ul class="list-unstyled components">
        <li class="{{ Route::currentRouteName() == 'caseinfo'?'active':'' }}">
            <a href="{{ route('caseinfo', $case) }}" >Info</a>
        </li>
        <li class="{{ Route::currentRouteName() == 'analysis'?'active':'' }}">
            <a href="{{ route('analysis', $case) }}" >Post Analysis</a>
        </li>
        <li>
            <a href="#">Replies</a>
        </li>
        <li class="{{ Route::currentRouteName() == 'author-profile'?'active':'' }}">
            <a href="{{ route('author-profile', $case) }}" >Author Profile</a>
        </li>
        <li class="{{ Route::currentRouteName() == 'author-posts'?'active':'' }}">
            <a href="{{ route('author-posts', $case) }}" >Author Latest Post</a>
        </li>
        <li class="{{ Route::currentRouteName() == 'post-location'?'active':'' }}">
            <a href="{{ route('post-location', $case) }}" >Post Geo Location</a>
        </li>
        <li class="{{ Route::currentRouteName() == 'similar-posts'?'active':'' }}">
            <a href="{{ route('similar-posts', $case) }}" >Similar Posts</a>
        </li>
        <li class="{{ Route::currentRouteName() == 'samearea-posts'?'active':'' }}">
            <a href="{{ route('samearea-posts', $case) }}" >Similar Posts From Same Area</a>
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

