<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    @vite(['resources/css/style.css', 'resources/js/app.js'])
    <style>
        body { align-items: flex-start; padding: 3rem 2rem; }

        .container {
            width: 100%;
            max-width: 860px;
            margin: 0 auto;
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

        .nav-bar-links {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .nav-bar-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.825rem;
            transition: color var(--transition);
        }

        .nav-bar-links a:hover { color: var(--text); }
        .nav-bar-links a.active { color: var(--accent-hover); font-weight: 500; }

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

        /* Page header */
        .page-header {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-size: 1.75rem;
            letter-spacing: -0.03em;
        }

        .admin-badge {
            font-size: 0.75rem;
            font-weight: 500;
            background: rgba(124, 106, 255, 0.12);
            color: var(--accent-hover);
            border: 1px solid rgba(124, 106, 255, 0.25);
            border-radius: 999px;
            padding: 0.25rem 0.75rem;
        }

        /* Stats grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.25rem 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .stat-label {
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 600;
            color: var(--text);
            letter-spacing: -0.03em;
            line-height: 1;
        }

        /* Section header */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
            margin-top: 2rem;
        }

        .section-header h2 {
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: -0.01em;
        }

        .section-header a {
            font-size: 0.8rem;
            color: var(--accent-hover);
            text-decoration: none;
            transition: color var(--transition);
        }

        .section-header a:hover { color: var(--text); }

        /* Two column layout */
        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-top: 2rem;
        }

        /* Post list */
        .post-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .post-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1rem 1.25rem;
            transition: border-color var(--transition);
            text-decoration: none;
            color: inherit;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .post-card:hover { border-color: var(--accent); }

        .post-card-img {
            width: 52px;
            height: 52px;
            object-fit: cover;
            border-radius: var(--radius-sm);
            flex-shrink: 0;
        }

        .post-card-content { flex: 1; min-width: 0; }

        .post-card-title {
            font-size: 0.9rem;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .post-card-meta {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-top: 0.3rem;
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .comment-count {
            background: rgba(124, 106, 255, 0.1);
            color: var(--accent-hover);
            border-radius: 999px;
            padding: 0.15rem 0.6rem;
            font-size: 0.75rem;
            font-weight: 500;
            white-space: nowrap;
            flex-shrink: 0;
        }

        /* Tag list */
        .tag-list {
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }

        .tag-row {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 0.85rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .tag-name {
            font-size: 0.9rem;
            font-weight: 500;
        }

        .tag-count {
            font-size: 0.775rem;
            color: var(--text-muted);
        }

        /* User list */
        .user-list {
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
            margin-top: 2rem;
        }

        .user-row {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 0.85rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .user-name {
            font-size: 0.9rem;
            font-weight: 500;
        }

        .user-meta {
            font-size: 0.775rem;
            color: var(--text-muted);
            margin-top: 0.15rem;
        }

        .user-joined {
            font-size: 0.775rem;
            color: var(--text-muted);
        }
    </style>
</head>
<body>

<div class="container">

    <div class="nav-bar">
        <div class="nav-bar-links">
            <a href="{{ route('admin.dashboard') }}" class="active">Dashboard</a>
            <a href="{{ route('admin.tags.index') }}">Tags</a>
            <a href="{{ route('posts.index') }}">← Back to site</a>
        </div>
        <form method="POST" action="/logout">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>

    @if(session('status'))
        <p class="status-msg">{{ session('status') }}</p>
    @endif

    <div class="page-header">
        <h1>Dashboard</h1>
        <span class="admin-badge">Admin</span>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <span class="stat-label">Users</span>
            <span class="stat-value">{{ $stats['users'] }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Posts</span>
            <span class="stat-value">{{ $stats['posts'] }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Comments</span>
            <span class="stat-value">{{ $stats['comments'] }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Tags</span>
            <span class="stat-value">{{ $stats['tags'] }}</span>
        </div>
    </div>

    <div class="two-col">

        <div>
            <div class="section-header">
                <h2>Most commented posts</h2>
            </div>
            <div class="post-list">
                @forelse($popularPosts as $post)
                    <a href="{{ route('posts.show', $post) }}" class="post-card">
                        @if($post->cover_image)
                            <img src="{{ Storage::url($post->cover_image) }}"
                                 alt="{{ $post->title }}"
                                 class="post-card-img"
                            >
                        @endif
                        <div class="post-card-content">
                            <div class="post-card-title">{{ $post->title }}</div>
                            <div class="post-card-meta">
                                <span>{{ $post->user->name }}</span>
                                <span>{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <span class="comment-count">{{ $post->comments_count }} comments</span>
                    </a>
                @empty
                    <p style="font-size: 0.875rem; color: var(--text-muted);">No posts yet.</p>
                @endforelse
            </div>
        </div>

        <div>
            <div class="section-header">
                <h2>Most used tags</h2>
                <a href="{{ route('admin.tags.index') }}">Manage tags →</a>
            </div>
            <div class="tag-list">
                @forelse($popularTags as $tag)
                    <div class="tag-row">
                        <span class="tag-name">{{ $tag->name }}</span>
                        <span class="tag-count">{{ $tag->posts_count }} {{ Str::plural('post', $tag->posts_count) }}</span>
                    </div>
                @empty
                    <p style="font-size: 0.875rem; color: var(--text-muted);">No tags yet.</p>
                @endforelse
            </div>
        </div>

    </div>

    <div class="section-header" style="margin-top: 2.5rem;">
        <h2>Latest users</h2>
    </div>
    <div class="user-list" style="margin-top: 0;">
        @forelse($latestUsers as $user)
            <div class="user-row">
                <div>
                    <div class="user-name">{{ $user->name }}</div>
                    <div class="user-meta">{{ $user->email }}</div>
                </div>
                <span class="user-joined">Joined {{ $user->created_at->diffForHumans() }}</span>
            </div>
        @empty
            <p style="font-size: 0.875rem; color: var(--text-muted);">No users yet.</p>
        @endforelse
    </div>

</div>

</body>
</html>
