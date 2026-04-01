<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Post</title>
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

        .page-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 2.5rem 2.25rem;
            box-shadow: 0 8px 48px rgba(0,0,0,0.4);
        }

        .page-card h1 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.4rem;
            letter-spacing: -0.02em;
        }

        .page-card .subtitle {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-bottom: 2rem;
        }

        textarea {
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text);
            font-family: inherit;
            font-size: 0.925rem;
            padding: 0.7rem 0.9rem;
            width: 100%;
            resize: vertical;
            min-height: 200px;
            line-height: 1.6;
            transition: border-color var(--transition), box-shadow var(--transition);
            outline: none;
        }

        textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(124, 106, 255, 0.15);
        }

        .form-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .btn { width: auto; padding: 0.7rem 1.75rem; margin-top: 0; }

        .btn-cancel {
            font-size: 0.875rem;
            color: var(--text-muted);
            text-decoration: none;
            transition: color var(--transition);
        }

        .btn-cancel:hover { color: var(--text); }
    </style>
</head>
<body>

<div class="container">

    <a href="{{ route('posts.show', $post) }}" class="back-link">← Back to post</a>

    <div class="page-card">

        <h1>Edit Post</h1>
        <p class="subtitle">Make your changes below.</p>

        @if($errors->any())
            <ul class="error-list">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ route('posts.update', $post) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Title</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title', $post->title) }}"
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="body">Body</label>
                <textarea
                    id="body"
                    name="body"
                >{{ old('body', $post->body) }}</textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">Save changes</button>
                <a href="{{ route('posts.show', $post) }}" class="btn-cancel">Cancel</a>
            </div>

        </form>

    </div>

</div>

</body>
</html>
