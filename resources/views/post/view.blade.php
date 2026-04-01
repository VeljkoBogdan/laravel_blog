<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $post->title }}</title>
    @vite(['resources/css/style.css', 'resources/js/app.js'])
    <style>
        body { align-items: flex-start; padding: 3rem 2rem; }

        .container {
            width: 100%;
            max-width: 680px;
            margin: 0 auto;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.825rem;
            color: var(--text-muted);
            text-decoration: none;
            margin-bottom: 2rem;
            transition: color var(--transition);
        }

        .back-link:hover { color: var(--text); }

        .post-header {
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border);
        }

        .post-header h1 {
            font-size: 2rem;
            font-weight: 600;
            letter-spacing: -0.03em;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .post-meta {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            font-size: 0.825rem;
            color: var(--text-muted);
        }

        .post-meta .author { color: var(--accent-hover); font-weight: 500; }

        .post-body {
            font-size: 0.975rem;
            line-height: 1.8;
            color: var(--text);
            white-space: pre-wrap;
        }

        .post-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 2.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border);
        }

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

        .btn-small:hover { background: var(--accent-hover); transform: translateY(-1px); }

        .btn-danger {
            padding: 0.55rem 1.1rem;
            width: auto;
            font-size: 0.85rem;
            margin-top: 0;
            background: rgba(255, 95, 95, 0.1);
            color: var(--danger);
            border: 1px solid rgba(255, 95, 95, 0.25);
            border-radius: var(--radius-sm);
            font-family: inherit;
            font-weight: 500;
            cursor: pointer;
            transition: background var(--transition);
        }

        .btn-danger:hover { background: rgba(255, 95, 95, 0.2); }
    </style>
</head>
<body>

<div class="container">

    <a href="{{ route('posts.index') }}" class="back-link">← Back to posts</a>

    @if(session('status'))
        <p class="status-msg">{{ session('status') }}</p>
    @endif

    <div class="post-header">
        <h1>{{ $post->title }}</h1>
        <div class="post-meta">
            <span class="author">{{ $post->user->name }}</span>
            <span>{{ $post->created_at->format('F j, Y') }}</span>
            @if($post->updated_at->ne($post->created_at))
                <span>Edited {{ $post->updated_at->diffForHumans() }}</span>
            @endif
        </div>
    </div>

    <div class="post-body">{{ $post->body }}</div>

    @if(auth()->id() === $post->user_id)
        <div class="post-actions">
            <a href="{{ route('posts.edit', $post) }}" class="btn-small">Edit post</a>

            <form method="POST" action="{{ route('posts.destroy', $post) }}">
                @csrf
                @method('DELETE')
                <button
                    type="submit"
                    class="btn-danger"
                    onclick="return confirm('Are you sure you want to delete this post?')"
                >
                    Delete
                </button>
            </form>
        </div>
    @endif

</div>

</body>
</html>
