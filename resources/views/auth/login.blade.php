<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in to SyncFolio</title>
    
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
<body class="d-flex align-items-center justify-content-center min-vh-100">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card auth-card p-4 p-sm-5 bg-white">
                    
                    <div class="text-center mb-4">
                        <div class="bg-primary text-white rounded-3 d-inline-flex align-items-center justify-content-center fw-bold mb-2" style="width: 40px; height: 40px; background: linear-gradient(135deg, #4f46e5, #7c3aed) !important;">
                            S
                        </div>
                        <h4 class="fw-bold text-dark m-0 tracking-tight">Welcome Back</h4>
                        <p class="text-muted small">Log in to explore & collaborate</p>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3 small p-2" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="vstack gap-3">
                        @csrf

                        <div>
                            <label for="email" class="form-label small fw-bold text-secondary">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control rounded-3 py-2 text-sm" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="name@email.com">
                            @error('email')
                                <span class="text-danger small d-block mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="form-label small fw-bold text-secondary">Password</label>
                            <input type="password" id="password" name="password" class="form-control rounded-3 py-2 text-sm" required autocomplete="current-password" placeholder="••••••••">
                            @error('password')
                                <span class="text-danger small d-block mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-1">
                            <div class="form-check m-0">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                                <label class="form-check-label small text-secondary" for="remember_me">
                                    Remember me
                                </label>
                            </div>
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none small fw-semibold" style="color: #4f46e5;" href="{{ route('password.request') }}">
                                    Forgot password?
                                </a>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-gradient w-100 rounded-3 py-2 fw-bold shadow-sm mt-2">
                            Log In
                        </button>

                        <div class="text-center mt-3 border-top pt-3">
                            <span class="small text-muted">Don't have an account?</span>
                            <a href="{{ route('register') }}" class="text-decoration-none small fw-bold ms-1" style="color: #4f46e5;">Register Now</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>