<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SyncFolio</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8f9fa; }
        .sidebar { width: 260px; background-color: #ffffff; }
        .nav-link { color: #6c757d; font-weight: 500; padding: 0.6rem 1rem; border-radius: 0.5rem; margin-bottom: 0.2rem; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { color: #4f46e5; background-color: #f0f0ff; }
        .hover-opacity:hover { opacity: 0.7; }
        .transition { transition: all 0.2s ease-in-out; }
        @media (min-width: 768px) {
            .sidebar { position: fixed; top: 0; bottom: 0; left: 0; z-index: 100; border-right: 1px solid #dee2e6; }
            .main-content { margin-left: 260px; padding: 2rem; min-height: 100vh;}
        }
        @media (max-width: 767.98px) {
            .main-content { margin-left: 0; padding: 1rem; width: 100%; overflow-x: hidden; }
        }
    </style>
</head>
<body>
    @php
        $unreadMessages = \App\Models\Message::where('receiver_id', Auth::id())->where('is_read', false)->count();
        $pendingRequests = \App\Models\CollaborationRequest::where('receiver_id', Auth::id())->where('status', 'pending')->count();
    @endphp

    <div class="d-md-none bg-white border-bottom p-3 d-flex justify-content-between align-items-center sticky-top shadow-sm" style="z-index: 1020;">
        <div class="d-flex align-items-center gap-2">
            <div class="bg-primary text-white rounded-3 d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 32px; height: 32px; background: linear-gradient(135deg, #4f46e5, #7c3aed) !important;">S</div>
            <h5 class="m-0 fw-bold text-dark" style="letter-spacing: -0.5px;">SyncFolio</h5>
        </div>
        <button class="btn btn-light border shadow-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu"><i class="bi bi-list fs-4"></i></button>
    </div>

    <div class="sidebar offcanvas-md offcanvas-start p-3 d-flex flex-column justify-content-between shadow-sm" tabindex="-1" id="sidebarMenu">
        <div>
            <div class="d-none d-md-flex align-items-center gap-2 px-2 py-3 border-bottom mb-3">
                <div class="bg-primary text-white rounded-3 d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 32px; height: 32px; background: linear-gradient(135deg, #4f46e5, #7c3aed) !important;">S</div>
                <h5 class="m-0 fw-bold text-dark" style="letter-spacing: -0.5px;">SyncFolio</h5>
            </div>
            <div class="d-md-none d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                <h6 class="m-0 fw-bold text-secondary">Main Menu</h6>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu"></button>
            </div>

            <nav class="nav flex-column">
                <a class="nav-link d-flex align-items-center gap-3 {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-compass-fill"></i> Discover</a>
                <a class="nav-link d-flex align-items-center gap-3 {{ request()->routeIs('collaboration.index') ? 'active' : '' }}" href="{{ route('collaboration.index') }}"><i class="bi bi-person-plus-fill"></i> Requests @if($pendingRequests > 0)<span class="badge bg-danger rounded-pill ms-auto shadow-sm" style="font-size: 0.65rem;">{{ $pendingRequests }}</span>@endif</a>
                <a class="nav-link d-flex align-items-center gap-3 {{ request()->routeIs('messages.index') ? 'active' : '' }}" href="{{ route('messages.index') }}"><i class="bi bi-chat-left-text-fill"></i> Messages @if($unreadMessages > 0)<span class="badge bg-danger rounded-pill ms-auto shadow-sm" style="font-size: 0.65rem;">{{ $unreadMessages }}</span>@endif</a>
                <a class="nav-link d-flex align-items-center gap-3 {{ request()->routeIs('talent.saved') ? 'active' : '' }}" href="{{ route('talent.saved') }}"><i class="bi bi-bookmark-star-fill"></i> Saved Talents</a>
                <a class="nav-link d-flex align-items-center gap-3 {{ request()->routeIs('projects.index') ? 'active' : '' }}" href="{{ route('projects.index') }}"><i class="bi bi-folder-fill"></i> Projects</a>

                @if(auth()->user()->is_admin)
                    <div class="border-top mt-3 pt-3">
                        <span class="text-muted fw-bold text-uppercase small d-block mb-2 px-2" style="font-size: 0.65rem;">Administrator</span>
                        <a class="nav-link d-flex align-items-center gap-3 text-danger fw-bold {{ request()->routeIs('admin.dashboard') ? 'active bg-danger-subtle text-danger' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-shield-lock-fill"></i> Control Panel</a>
                    </div>
                @endif
            </nav>
        </div>

        <div class="border-top pt-3 mt-3">
            <div class="px-2 mb-3 d-flex align-items-center gap-2">
                @if(Auth::user()->avatar)
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="rounded-circle object-fit-cover border shadow-sm" style="width: 36px; height: 36px;">
                @else
                    <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 36px; height: 36px;">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                @endif
                <div class="overflow-hidden">
                    <h6 class="m-0 fw-bold text-truncate" style="max-width: 140px;">{{ Auth::user()->name }}</h6>
                    <a href="{{ route('profile.edit') }}" class="text-muted text-decoration-none hover-opacity" style="font-size: 0.75rem;">Edit Profile</a>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger w-100 rounded-3 py-2 fw-bold"><i class="bi bi-box-arrow-left"></i> Logout</button>
            </form>
        </div>
    </div>

    <main class="main-content">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center border-bottom pb-3 mb-4 gap-3">
            <div>{{ $header ?? '' }}</div>
            <div class="d-flex align-items-center justify-content-between w-100 w-sm-auto gap-3">
                <a href="{{ route('collaboration.index') }}" class="text-dark position-relative hover-opacity transition d-flex align-items-center ms-sm-auto" title="Notifications">
                    <i class="bi bi-bell-fill fs-5" style="color: {{ $pendingRequests > 0 ? '#dc3545' : '#4f46e5' }};"></i>
                    @if($pendingRequests > 0)<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-white shadow-sm" style="font-size: 0.6rem; padding: 0.3em 0.5em;">{{ $pendingRequests }}</span>@endif
                </a>
                <span class="text-muted small fw-medium border-start ps-3">{{ now()->format('d M Y') }}</span>
            </div>
        </div>
        <div class="container-fluid p-0">{{ $slot }}</div>
    </main>
</body>
</html>