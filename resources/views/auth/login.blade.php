<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | ProjectFlow</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #0b1f1a; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1rem; }
        .auth-card { background: #ffffff; border-radius: 24px; max-width: 420px; width: 100%; padding: 2.5rem; }
        .form-control-pill { border-radius: 9999px; border: 1px solid #d1fae5; padding: 0.7rem 1.4rem; font-size: 0.9rem; }
        .form-control-pill:focus { border-color: #059669; box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.15); outline: none; }
        .btn-emerald { background-color: #059669; color: #fff; border-radius: 9999px; padding: 0.7rem; font-weight: 500; border: none; width: 100%; }
        .btn-emerald:hover { background-color: #047857; color: #fff; }
    </style>
</head>
<body>

<div class="auth-card shadow-lg">
    <div class="text-center mb-4">
        <h4 class="fw-bold mb-1" style="color: #132a24;">Welcome Back</h4>
        <p class="text-muted small">Sign in to access your projects</p>
    </div>
@if (session('success'||'faild'))
    <div class="alert alert-danger rounded-4 small py-2 mb-3">
        {{ session('success'||'faild') }}
    </div>
@endif
    @if($errors->any())
        <div class="alert alert-danger rounded-4 small py-2 mb-3">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('login,post') }}" method="POST">
        @csrf
        <div class="mb-3">
            <input type="email" name="email" class="form-control form-control-pill" placeholder="Email Address" required autofocus>
        </div>

        <div class="mb-3">
            <input type="password" name="password" class="form-control form-control-pill" placeholder="Password" required>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4 px-2">
            <div class="form-check">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label small text-muted" for="remember">Remember me</label>
            </div>
            <a href="{{ route('showForgotForm') }}" class="small text-decoration-none" style="color: #059669;">Forgot?</a>
        </div>

        <button type="submit" class="btn btn-emerald mb-3">Sign In</button>
    </form>
</div>

</body>
</html>