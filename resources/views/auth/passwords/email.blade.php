<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    @vite(['resources/css/auth.css', 'resources/js/app.js'])
</head>
<body>

<div class="auth-card">

    <h1>Forgot password?</h1>
    <p class="subtitle">Enter your email and we'll send you a reset link.</p>

    @if(session('status'))
        <p class="status-msg">{{ session('status') }}</p>
    @endif

    @if($errors->any())
        <ul class="error-list">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="/forgot-password">
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

        <button type="submit" class="btn">Send reset link</button>

    </form>

    <div class="divider"></div>

    <div class="auth-footer">
        <a href="/login">Back to sign in</a>
    </div>

</div>

</body>
</html>
