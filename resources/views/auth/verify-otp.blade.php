<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP | ProjectFlow</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #0b1f1a; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1rem; }
        .auth-card { background: #ffffff; border-radius: 24px; max-width: 420px; width: 100%; padding: 2.5rem; text-align: center; }
        .form-control-otp { border-radius: 16px; border: 2px solid #d1fae5; padding: 0.8rem; font-size: 1.6rem; letter-spacing: 12px; font-weight: 700; text-align: center; }
        .btn-emerald { background-color: #059669; color: #fff; border-radius: 9999px; padding: 0.7rem; font-weight: 500; border: none; width: 100%; }
        .btn-emerald:hover { background-color: #047857; color: #fff; }
    </style>
</head>
<body>
<div class="auth-card shadow-lg">
    <h4 class="fw-bold mb-1" style="color: #132a24;">Security Verification</h4>
    <p class="text-muted small mb-4">Enter the 6-digit OTP code</p>
@if(session('Failed'))
    <div class="alert alert-danger rounded-4 py-2 px-3 small">
        {{ session('Failed') }}
    </div>
@endif
    @if($errors->any())
        <div class="alert alert-danger rounded-4 small py-2 mb-3">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('password.reset') }}" method="POST">
        @csrf
        <input type="hidden" name="email" value="{{ request('email') }}">

        <div class="mb-4">
            <input type="text" name="otp_code" maxlength="6" class="form-control form-control-otp" placeholder="••••••" required autofocus>
        </div>

        <button type="submit" class="btn btn-emerald">Verify & Proceed</button>
    </form>
</div>

</body>
</html>