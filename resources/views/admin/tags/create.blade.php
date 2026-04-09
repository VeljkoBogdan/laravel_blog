<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Tag</title>
    @vite(['resources/css/style.css', 'resources/js/app.js'])
    <style>
        body { align-items: flex-start; padding: 3rem 2rem; }

        .container {
            width: 100%;
            max-width: 520px;
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

        .slug-preview {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 0.4rem;
        }

        .slug-preview span {
            color: var(--accent-hover);
            font-weight: 500;
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

    <div class="nav-bar">
        <div class="nav-bar-links">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.tags.index') }}" class="active">Tags</a>
            <a href="{{ route('posts.index') }}">← Back to site</a>
        </div>
        <form method="POST" action="/logout">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>

    <a href="{{ route('admin.tags.index') }}" class="back-link">← Back to tags</a>

    <div class="page-card">

        <h1>New Tag</h1>
        <p class="subtitle">Tags help readers find related posts.</p>

        @if($errors->any())
            <ul class="error-list">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ route('admin.tags.store') }}">
            @csrf

            <div class="form-group">
                <label for="name">Tag name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="e.g. Laravel"
                    autofocus
                >
                <p class="slug-preview">
                    Slug: <span id="slug-preview">{{ old('name') ? Str::slug(old('name')) : '...' }}</span>
                </p>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">Create tag</button>
                <a href="{{ route('admin.tags.index') }}" class="btn-cancel">Cancel</a>
            </div>

        </form>

    </div>

</div>

<script>
    const nameInput = document.getElementById('name');
    const slugPreview = document.getElementById('slug-preview');

    nameInput.addEventListener('input', function () {
        const slug = this.value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');

        slugPreview.textContent = slug || '...';
    });
</script>

</body>
</html>
