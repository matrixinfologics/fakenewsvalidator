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
        <li class="{{ Route::currentRouteName() == 'author-profile'?'active':'' }}">
            <a href="{{ route('author-profile', $case) }}" >Author Profile</a>
        </li>
        <li class="{{ Route::currentRouteName() == 'author-posts'?'active':'' }}">
            <a href="{{ route('author-posts', $case) }}" >Author Latest Posts</a>
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
        <li class="{{ Route::currentRouteName() == 'image-search'?'active':'' }}">
            <a href="{{ route('image-search', $case) }}" >Image Search Verification</a>
        </li>
        <li class="{{ Route::currentRouteName() == 'source-cross'?'active':'' }}">
            <a href="{{ route('source-cross', $case) }}" >Source Cross Checking</a>
        </li>
        <li class="{{ Route::currentRouteName() == 'discussions'?'active':'' }}">
            <a href="{{ route('discussions', $case) }}" >Discussions</a>
        </li>
        <li class="{{ Route::currentRouteName() == 'results'?'active':'' }}">
            <a href="{{ route('results', $case) }}" >Result</a>
        </li>
        <li class="{{ Route::currentRouteName() == 'related'?'active':'' }}">
            <a href="{{ route('related', $case) }}" >Related Cases</a>
        </li>
    </ul>
</nav>

