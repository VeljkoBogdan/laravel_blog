<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Tags</title>
    @vite(['resources/css/style.css', 'resources/js/app.js'])
    <style>
        body { align-items: flex-start; padding: 3rem 2rem; }

        .container {
            width: 100%;
            max-width: 760px;
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

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-size: 1.75rem;
            letter-spacing: -0.03em;
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

        .tag-table {
            width: 100%;
            border-collapse: collapse;
        }

        .tag-table thead tr {
            border-bottom: 1px solid var(--border);
        }

        .tag-table th {
            text-align: left;
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding: 1.25rem 1.25rem 0.85rem;
        }

        .tag-table th:last-child { text-align: right; }

        .tag-table tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background var(--transition);
        }

        .tag-table tbody tr:last-child { border-bottom: none; }
        .tag-table tbody tr:hover { background: var(--surface-2); }

        .tag-table td {
            padding: 1rem 1.25rem;
            font-size: 0.9rem;
            color: var(--text);
            vertical-align: middle;
        }

        .tag-table td:last-child {
            text-align: right;
        }

        .tag-pill {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            border: 1px solid var(--accent);
            background: rgba(124, 106, 255, 0.1);
            color: var(--accent-hover);
            font-size: 0.8rem;
            font-weight: 500;
        }

        .post-count {
            font-size: 0.825rem;
            color: var(--text-muted);
        }

        .btn-danger-sm {
            padding: 0.35rem 0.85rem;
            font-size: 0.8rem;
            background: rgba(255, 95, 95, 0.08);
            color: var(--danger);
            border: 1px solid rgba(255, 95, 95, 0.2);
            border-radius: var(--radius-sm);
            font-family: inherit;
            font-weight: 500;
            cursor: pointer;
            transition: background var(--transition);
        }

        .btn-danger-sm:hover { background: rgba(255, 95, 95, 0.18); }

        .table-wrapper {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
        }

        .empty-state {
            background: var(--surface);
            border: 1px dashed var(--border);
            border-radius: var(--radius);
            padding: 3rem;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .empty-state a {
            color: var(--accent-hover);
            text-decoration: none;
            font-weight: 500;
        }
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

    @if(session('status'))
        <p class="status-msg">{{ session('status') }}</p>
    @endif

    <div class="page-header">
        <h1>Tags</h1>
        <a href="{{ route('admin.tags.create') }}" class="btn-small">+ New Tag</a>
    </div>

    @if($tags->isEmpty())
        <div class="empty-state">
            No tags yet. <a href="{{ route('admin.tags.create') }}">Create the first one</a>.
        </div>
    @else
        <div class="table-wrapper">
            <table class="tag-table">
                <thead>
                    <tr>
                        <th>Tag</th>
                        <th>Slug</th>
                        <th>Posts</th>
                        <th>Created</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($tags as $tag)
                    <tr>
                        <td><span class="tag-pill">{{ $tag->name }}</span></td>
                        <td style="color: var(--text-muted); font-size: 0.825rem;">{{ $tag->slug }}</td>
                        <td>
                                <span class="post-count">
                                    {{ $tag->posts_count }} {{ Str::plural('post', $tag->posts_count) }}
                                </span>
                        </td>
                        <td style="color: var(--text-muted); font-size: 0.825rem;">
                            {{ $tag->created_at->format('M j, Y') }}
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.tags.destroy', $tag) }}">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="btn-danger-sm"
                                    onclick="return confirm('Delete tag \'{{ $tag->name }}\'? It will be removed from all posts.')"
                                >
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>

</body>
</html>
