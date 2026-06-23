<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - SyncFolio</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
        }
        .auth-card {
            border: none;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04) !important;
        }
        .btn-gradient {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border: none;
            color: white;
            transition: all 0.2s ease;
        }
        .btn-gradient:hover {
            background: linear-gradient(135deg, #4338ca, #6d28d9);
            color: white;
            transform: translateY(-1px);
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 py-5">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card auth-card p-4 p-sm-5 bg-white">
                    
                    <div class="text-center mb-4">
                        <div class="bg-primary text-white rounded-3 d-inline-flex align-items-center justify-content-center fw-bold mb-3" style="width: 48px; height: 48px; background: linear-gradient(135deg, #4f46e5, #7c3aed) !important;">
                            <i class="bi bi-shield-lock-fill fs-5"></i>
                        </div>
                        <h4 class="fw-bold text-dark m-0 tracking-tight">Forgot Password?</h4>
                        <p class="text-muted small mt-2 leading-relaxed">
                            No problem. Just let us know your email address and we will email you a password reset link to choose a new one.
                        </p>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3 small p-3 border-0 shadow-sm" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" class="vstack gap-3">
                        @csrf

                        <div>
                            <label for="email" class="form-label small fw-bold text-secondary">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control rounded-3 py-2 text-sm" value="{{ old('email') }}" required autofocus placeholder="name@email.com">
                            @error('email')
                                <span class="text-danger small d-block mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-gradient w-100 rounded-3 py-2 fw-bold shadow-sm mt-2">
                            Send Reset Link
                        </button>

                        <div class="text-center mt-3 border-top pt-3">
                            <a href="{{ route('login') }}" class="text-decoration-none small fw-bold text-muted transition" onmouseover="this.style.color='#4f46e5'" onmouseout="this.style.color='#6c757d'">
                                <i class="bi bi-arrow-left me-1"></i> Back to Log In
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>