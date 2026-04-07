<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Posts</title>
    @vite(['resources/css/style.css', 'resources/js/app.js'])
    <style>
        body { align-items: flex-start; padding: 3rem 2rem; }

        .container {
            width: 100%;
            max-width: 760px;
            margin: 0 auto;
        }

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .page-header h1 { font-size: 1.75rem; letter-spacing: -0.03em; }
        .page-header .subtitle { font-size: 0.875rem; color: var(--text-muted); margin-top: 0.2rem; }

        .btn-small {
            padding: 0.55rem 1.1rem;
            width: auto;
            font-size: 0.85rem;
            margin-top: 0;
            text-decoration: none;
            display: inline-block;
            background: var(--accent);
            color: #fff;
            border-radius: var(--radius-sm);
            font-weight: 500;
            transition: background var(--transition), transform var(--transition);
        }

        .btn-small:hover {
            background: var(--accent-hover);
            transform: translateY(-1px);
        }

        .post-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .post-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.5rem 1.75rem;
            transition: border-color var(--transition);
            text-decoration: none;
            color: inherit;
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .post-card:hover { border-color: var(--accent); }

        .post-card-img {
            width: 96px;
            height: 96px;
            object-fit: cover;
            border-radius: var(--radius-sm);
            flex-shrink: 0;
        }

        .post-card-title {
            font-size: 1.05rem;
            font-weight: 600;
            margin-bottom: 0.4rem;
            letter-spacing: -0.01em;
        }

        .post-card-content {
            flex: 1;
            min-width: 0;
        }

        .post-card-excerpt {
            font-size: 0.875rem;
            color: var(--text-muted);
            line-height: 1.6;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .post-card-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 1rem;
            font-size: 0.775rem;
            color: var(--text-muted);
        }

        .post-card-meta span { display: flex; align-items: center; gap: 0.3rem; }

        .empty-state {
            background: var(--surface);
            border: 1px dashed var(--border);
            border-radius: var(--radius);
            padding: 3rem;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .empty-state a { color: var(--accent-hover); text-decoration: none; font-weight: 500; }

        /* Pagination wrapper */
        nav {
            margin-top: 2rem;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.4rem;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        /* All page items */
        .page-item .page-link {
            display: block;
            padding: 0.45rem 0.85rem;
            border-radius: var(--radius-sm);
            font-size: 0.825rem;
            background: var(--surface);
            border: 1px solid var(--border);
            color: var(--text-muted);
            text-decoration: none;
            transition: border-color var(--transition), color var(--transition);
        }

        /* Hoverable links */
        .page-item a.page-link:hover {
            border-color: var(--accent);
            color: var(--text);
        }

        /* Active page */
        .page-item.active .page-link {
            border-color: var(--accent);
            color: var(--accent-hover);
            background: var(--surface);
        }

        /* Disabled items (Previous on page 1, Next on last page, ellipsis) */
        .page-item.disabled .page-link {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .text-muted {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .fw-semibold {
            font-weight: 600;
            color: var(--text);
        }

        /* Bootstrap layout helpers we need to keep working */
        .d-flex { display: flex; }
        .d-none { display: none; }
        .flex-fill { flex: 1; }
        .justify-content-between { justify-content: space-between; }
        .justify-items-center { justify-items: center; }
        .align-items-sm-center { align-items: center; }
        .justify-content-sm-between { justify-content: space-between; }
        .small { font-size: 0.8rem; }

        @media (min-width: 576px) {
            .d-sm-none { display: none !important; }
            .d-sm-flex { display: flex !important; }
            .flex-sm-fill { flex: 1; }
        }

        .nav-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            padding-bottom: 1.25rem;
            border-bottom: 1px solid var(--border);
            font-size: 0.825rem;
            color: var(--text-muted);
        }

        .nav-bar form button {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-family: inherit;
            font-size: 0.825rem;
            padding: 0;
            transition: color var(--transition);
        }

        .nav-bar form button:hover { color: var(--text); }

        .search-form {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            margin-bottom: 1.75rem;
            flex-wrap: wrap;
        }

        .search-form input[type="text"] {
            flex: 1;
            min-width: 180px;
            padding: 0.55rem 0.9rem;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text);
            font-family: inherit;
            font-size: 0.875rem;
            outline: none;
            transition: border-color var(--transition), box-shadow var(--transition);
        }

        .search-form input[type="text"]:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(124, 106, 255, 0.15);
        }

        .search-form select {
            padding: 0.55rem 0.9rem;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text);
            font-family: inherit;
            font-size: 0.875rem;
            outline: none;
            cursor: pointer;
            transition: border-color var(--transition);
        }

        .search-form select:focus {
            border-color: var(--accent);
        }

        .btn-cancel {
            font-size: 0.875rem;
            color: var(--text-muted);
            text-decoration: none;
            transition: color var(--transition);
            white-space: nowrap;
        }

        .btn-cancel:hover { color: var(--text); }
    </style>
</head>
<body>

<div class="container">

    <div class="nav-bar">
        <span>Logged in as <strong>{{ auth()->user()->name }}</strong></span>
        <form method="POST" action="/logout">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>

    @if(session('status'))
        <p class="status-msg">{{ session('status') }}</p>
    @endif

    <div class="page-header">
        <div>
            <h1>Posts</h1>
            <p class="subtitle">{{ $posts->total() }} {{ Str::plural('post', $posts->total()) }} total</p>
        </div>
        <a href="{{ route('posts.create') }}" class="btn-small">+ New Post</a>
    </div>

    <form method="get" action="{{ route('posts.index') }}" class="search-form">

        <input
            type="text"
            name="search"
            placeholder="Search posts..."
            value="{{ request('search') }}"
            >

        <select name="tag">
            <option value="">All Tags</option>
            @foreach($tags as $tag)
                <option
                    value="{{ $tag->id }}"
                    {{ request('tag') == $tag->id ? 'selected' : '' }}
                >
                    {{ $tag->name }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn-small">Search</button>

        @if(request('search') || request('tag'))
            <a href="{{ route('posts.index') }}" class="btn-cancel">Clear</a>
        @endif

    </form>

    @if($posts->isEmpty())
        <div class="empty-state">
            No posts yet. <a href="{{ route('posts.create') }}">Create the first one</a>.
        </div>
    @else
        <div class="post-list">
            @foreach($posts as $post)
                <a href="{{ route('posts.show', $post) }}" class="post-card">
                    @if($post->cover_image)
                        <img src="{{ Storage::url($post->cover_image) }}"
                             alt="{{ $post->title }}"
                             class="post-card-img"
                        >
                    @endif
                    <div class="post-card-content">
                        <div class="post-card-title">{{ $post->title }}</div>
                        <div class="post-card-excerpt">{{ $post->body }}</div>
                        <div class="post-card-meta">
                            <span>{{ $post->user->name }}</span>
                            <span>{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="pagination">
            {{ $posts->links() }}
        </div>
    @endif

</div>

</body>
</html>
