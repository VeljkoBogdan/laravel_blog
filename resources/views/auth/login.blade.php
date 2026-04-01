<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    @vite(['resources/css/style.css', 'resources/js/app.js'])
</head>
<body>

<div class="auth-card">

    <h1>Welcome back</h1>
    <p class="subtitle">Sign in to your account to continue.</p>

    @if($errors->any())
        <ul class="error-list">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="/login">
        @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="you@example.com"
                autocomplete="email"
            >
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="••••••••"
                autocomplete="current-password"
            >
        </div>

        <div class="checkbox-row">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Remember me</label>
        </div>

        <button type="submit" class="btn">Sign in</button>

    </form>

    <div class="auth-footer">
        <a href="/forgot-password">Forgot your password?</a>
    </div>

    <div class="divider"></div>

    <div class="auth-footer">
        Don't have an account? <a href="/register">Create one</a>
    </div>

</div>

</body>
</html>
