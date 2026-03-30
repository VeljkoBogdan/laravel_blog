<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    @vite(['resources/css/auth.css', 'resources/js/app.js'])
</head>
<body>

<div class="auth-card">

    <h1>Reset password</h1>
    <p class="subtitle">Choose a new password for your account.</p>

    @if($errors->any())
        <ul class="error-list">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="/reset-password">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="form-group">
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email', $request->email) }}"
                placeholder="you@example.com"
                autocomplete="email"
            >
        </div>

        <div class="form-group">
            <label for="password">New Password</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="••••••••"
                autocomplete="new-password"
            >
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm New Password</label>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                placeholder="••••••••"
                autocomplete="new-password"
            >
        </div>

        <button type="submit" class="btn">Reset password</button>

    </form>

</div>

</body>
</html>
