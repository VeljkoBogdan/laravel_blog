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

        .post-img {
            width: 256px;
            height: 256px;
            object-fit: cover;
            border-radius: var(--radius);
            margin-top: 1.5rem;
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

        /* Comments section */
        .post-comments {
            padding-top: 1.25rem;
            margin-top: 1.5rem;
            margin-bottom: 1.25rem;
            border-top: 1px solid var(--border);
        }

        .comments-header {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-muted);
            margin-bottom: 1.25rem;
        }

        .comment {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
            padding: 1rem 1.25rem;
            background: var(--surface-2);
            border-radius: var(--radius);
            margin-bottom: 0.75rem;
        }

        .comment-meta {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .comment-author {
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--accent-hover);
        }

        .comment-body {
            font-size: 0.9rem;
            color: var(--text);
            line-height: 1.6;
        }

        .no-comments {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-bottom: 1.25rem;
        }

        /* Comment form */
        .comment-form {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.25rem 1.5rem;
            margin-top: 1.25rem;
        }

        .comment-form-title {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text);
            margin-bottom: 1rem;
        }

        .comment-form textarea {
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text);
            font-family: inherit;
            font-size: 0.9rem;
            padding: 0.7rem 0.9rem;
            width: 100%;
            resize: vertical;
            min-height: 100px;
            line-height: 1.6;
            transition: border-color var(--transition), box-shadow var(--transition);
            outline: none;
        }

        .comment-form textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(124, 106, 255, 0.15);
        }

        .comment-form .btn {
            width: auto;
            padding: 0.6rem 1.5rem;
            margin-top: 0.75rem;
            font-size: 0.875rem;
        }
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
        </div> <br>

        @if($post->tags->isNotEmpty())
            <div class="tags-grid">
                @foreach($post->tags as $tag)
                    <span class="tag-badge">{{ $tag->name }}</span>
                @endforeach
            </div>
        @endif

        @if($post->cover_image)
            <img src="{{ Storage::url($post->cover_image) }}"
                 alt="{{ $post->title }}"
                 class="post-img"
            >
        @endif
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

    <div class="post-comments">

        <p class="comments-header">
            {{ $post->comments->count() }} {{ Str::plural('comment', $post->comments->count()) }}
        </p>

        @if($post->comments->isNotEmpty())
            @foreach($post->comments as $comment)
                <div class="comment">
                    <div class="comment-meta">
                        <span class="comment-author">{{ $comment->user->name }}</span>
                        <span>{{ $comment->created_at->format('F j, Y') }}</span>
                    </div>
                    <p class="comment-body">{{ $comment->body }}</p>
                </div>
            @endforeach
        @else
            <p class="no-comments">No comments yet. Be the first!</p>
        @endif

        <div class="comment-form">
            <p class="comment-form-title">Leave a comment</p>

            @if($errors->has('body'))
                <ul class="error-list" style="margin-bottom: 1rem;">
                    <li>{{ $errors->first('body') }}</li>
                </ul>
            @endif

            <form method="POST" action="{{ route('comments.store', $post) }}">
                @csrf
                <div class="form-group" style="margin-bottom: 0;">
                    <textarea
                        name="body"
                        placeholder="Write a comment..."
                    >{{ old('body') }}</textarea>
                </div>
                <button type="submit" class="btn">Post comment</button>
            </form>
        </div>

    </div>

</div>

</body>
</html>
