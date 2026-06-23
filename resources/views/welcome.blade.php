<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SyncFolio - Portfolio & Collaboration Network</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8f9fa;
        }
<<<<<<< HEAD
=======
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            width: 260px;
            background-color: #ffffff;
            border-right: 1px solid #dee2e6;
        }
        .main-content {
            margin-left: 260px;
            padding: 2rem;
        }
>>>>>>> e8d3b2e42b6a00a90d15dab6699a4c22a5e4b31a
        .nav-link {
            color: #6c757d;
            font-weight: 500;
            padding: 0.6rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 0.2rem;
        }
        .nav-link:hover, .nav-link.active {
            color: #4f46e5;
            background-color: #f0f0ff;
        }
<<<<<<< HEAD

        /* --- MAGIC RESPONSIVE --- */
        /* Untuk Layar Besar (Laptop/PC) */
        @media (min-width: 992px) {
            .sidebar-desktop {
                position: fixed;
                top: 0;
                bottom: 0;
                left: 0;
                z-index: 100;
                width: 260px;
                background-color: #ffffff;
                border-right: 1px solid #dee2e6;
                overflow-y: auto;
            }
            .main-content {
                margin-left: 260px;
                padding: 2rem;
            }
        }

        /* Untuk Layar Kecil (HP/Tablet) */
        @media (max-width: 991.98px) {
            .main-content {
                padding: 1.5rem 1rem;
                padding-top: 80px; /* Memberi ruang untuk navbar atas di HP */
            }
        }
=======
>>>>>>> e8d3b2e42b6a00a90d15dab6699a4c22a5e4b31a
    </style>
</head>
<body>

<<<<<<< HEAD
    <nav class="navbar bg-white border-bottom fixed-top d-lg-none px-3 py-2 z-3 shadow-sm">
        <div class="container-fluid p-0 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <div class="bg-primary text-white rounded-3 d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; background: linear-gradient(135deg, #4f46e5, #7c3aed) !important;">
                    S
                </div>
                <h5 class="m-0 fw-bold text-dark">SyncFolio</h5>
            </div>
            <button class="btn btn-light border-0 shadow-none px-2 py-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas">
                <i class="bi bi-list fs-3"></i>
            </button>
        </div>
    </nav>

    <div class="offcanvas-lg offcanvas-start sidebar-desktop bg-white p-3 d-flex flex-column justify-content-between" tabindex="-1" id="sidebarOffcanvas">
        <div>
            <div class="d-none d-lg-flex align-items-center gap-2 px-2 py-3 border-bottom mb-3">
=======
    <div class="sidebar p-3 d-flex flex-column justify-content-between">
        <div>
            <div class="d-flex align-items-center gap-2 px-2 py-3 border-bottom mb-3">
>>>>>>> e8d3b2e42b6a00a90d15dab6699a4c22a5e4b31a
                <div class="bg-primary text-white rounded-3 d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; background: linear-gradient(135deg, #4f46e5, #7c3aed) !important;">
                    S
                </div>
                <h5 class="m-0 fw-bold text-dark">SyncFolio</h5>
            </div>

<<<<<<< HEAD
            <div class="d-flex d-lg-none justify-content-between align-items-center border-bottom pb-3 mb-3">
                <h6 class="m-0 fw-bold text-dark">Main Menu</h6>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas" data-bs-target="#sidebarOffcanvas"></button>
            </div>

=======
>>>>>>> e8d3b2e42b6a00a90d15dab6699a4c22a5e4b31a
            <nav class="nav flex-column">
                <a class="nav-link d-flex align-items-center gap-3 active" href="/">
                    <i class="bi bi-compass-fill"></i> Explore Talents
                </a>
                <a class="nav-link d-flex align-items-center gap-3" href="{{ route('login') }}">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </a>
                <a class="nav-link d-flex align-items-center gap-3" href="{{ route('register') }}">
                    <i class="bi bi-person-plus-fill"></i> Register
                </a>
            </nav>
        </div>

<<<<<<< HEAD
        <div class="card border-0 bg-light p-3 rounded-4 text-center mt-4 mt-lg-0">
=======
        <div class="card border-0 bg-light p-3 rounded-4 text-center">
>>>>>>> e8d3b2e42b6a00a90d15dab6699a4c22a5e4b31a
            <span class="small fw-bold text-dark d-block mb-2">Have a Portfolio?</span>
            <a href="{{ route('register') }}" class="btn btn-sm btn-primary rounded-3 fw-bold w-100">Join Now</a>
        </div>
    </div>

    <main class="main-content">
<<<<<<< HEAD
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center border-bottom pb-3 mb-4 gap-3">
            <div>
                <h4 class="fw-bold m-0 text-dark">Explore Creative Talents</h4>
            </div>
            <div class="d-flex gap-2 w-100 w-sm-auto justify-content-end">
=======
        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
            <div>
                <h4 class="fw-bold m-0 text-dark">Explore Creative Talents</h4>
            </div>
            <div class="d-flex gap-2">
>>>>>>> e8d3b2e42b6a00a90d15dab6699a4c22a5e4b31a
                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-secondary rounded-3 fw-bold px-3">Login</a>
                <a href="{{ route('register') }}" class="btn btn-sm btn-primary rounded-3 fw-bold px-3">Register</a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <form action="/" method="GET" class="mb-4">
                        @if(request('skill'))
                            <input type="hidden" name="skill" value="{{ request('skill') }}">
                        @endif
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0 rounded-start-3"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control bg-light border-start-0 border-end-0 text-sm py-2" placeholder="Search by talent name, location, or bio keywords..." value="{{ request('search') }}">
                            @if(request('search'))
                                <a href="/" class="btn btn-light border-top border-bottom text-muted d-flex align-items-center justify-content-center px-2"><i class="bi bi-x-circle-fill"></i></a>
                            @endif
                            <button type="submit" class="btn btn-dark rounded-end-3 text-sm px-4 fw-bold">Search</button>
                        </div>
                    </form>
                    <span class="text-muted fw-bold text-uppercase small d-block mb-2" style="font-size: 0.7rem;">Filter by Skill</span>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="/" class="btn btn-sm rounded-3 px-3 py-2 fw-semibold {{ !request('skill') ? 'btn-dark' : 'btn-light border text-secondary' }}">
                            All
                        </a>
                        @foreach($skills as $skill)
                            <a href="/?skill={{ $skill->slug }}" class="btn btn-sm rounded-3 px-3 py-2 fw-semibold {{ request('skill') == $skill->slug ? 'btn-primary' : 'btn-light border text-secondary' }}">
                                {{ $skill->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="d-flex flex-column gap-3">
                    @forelse ($users as $u)
                        <div class="card border-0 shadow-sm rounded-4 p-4">
                            <div class="d-flex flex-column flex-sm-row gap-3 align-items-start">
                                
                                @if($u->avatar)
                                    <img src="{{ asset('storage/' . $u->avatar) }}" class="rounded-3 object-fit-cover shadow-sm" style="width: 54px; height: 54px; flex-shrink: 0;">
                                @else
                                    <div class="rounded-3 text-white fw-bold d-flex align-items-center justify-content-center shadow-sm" style="width: 54px; height: 54px; background: linear-gradient(135deg, #6366f1, #a855f7); font-size: 1.2rem; flex-shrink: 0;">
                                        {{ strtoupper(substr($u->name, 0, 2)) }}
                                    </div>
                                @endif

                                <div class="flex-grow-1 w-100">
                                    <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-2">
                                        <div>
                                            <h5 class="m-0 fw-bold text-dark d-inline-block align-middle">{{ $u->name }}</h5>
                                            <div class="mt-1">
                                                <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 text-primary fw-semibold small" style="color: #4f46e5 !important;" data-bs-toggle="modal" data-bs-target="#portfolioModal{{ $u->id }}">
                                                    <i class="bi bi-collection-play-fill me-1"></i> View Portfolio ({{ $u->projects->count() }} Projects)
                                                </button>
                                            </div>
                                            <p class="text-muted small m-0 mt-1"><i class="bi bi-geo-alt"></i> {{ $u->location ?? 'Location not set' }}</p>
                                        </div>

                                        @php
<<<<<<< HEAD
=======
                                            // Translating database status to English display
>>>>>>> e8d3b2e42b6a00a90d15dab6699a4c22a5e4b31a
                                            $badgeClass = match($u->availability_status) {
                                                'Mencari Kolaborator' => 'bg-primary-subtle text-primary border border-primary-subtle',
                                                'Terbuka Gabung Proyek' => 'bg-success-subtle text-success border border-success-subtle',
                                                default => 'bg-secondary-subtle text-secondary border border-secondary-subtle',
                                            };
                                            $badgeText = match($u->availability_status) {
                                                'Mencari Kolaborator' => 'Looking for Collaborator',
                                                'Terbuka Gabung Proyek' => 'Open to Collaborate',
                                                default => 'Not Available',
                                            };
                                        @endphp
<<<<<<< HEAD
                                        <span class="badge {{ $badgeClass }} px-2.5 py-1.5 rounded-3 fw-semibold text-xs mt-2 mt-sm-0">
=======
                                        <span class="badge {{ $badgeClass }} px-2.5 py-1.5 rounded-3 fw-semibold text-xs">
>>>>>>> e8d3b2e42b6a00a90d15dab6699a4c22a5e4b31a
                                            ● {{ $badgeText }}
                                        </span>
                                    </div>

<<<<<<< HEAD
                                    <p class="text-secondary small mb-3 mt-2 mt-sm-0">
=======
                                    <p class="text-secondary small mb-3">
>>>>>>> e8d3b2e42b6a00a90d15dab6699a4c22a5e4b31a
                                        {{ $u->bio ?? "This creator hasn't written a bio yet." }}
                                    </p>

                                    <div class="d-flex flex-wrap gap-1.5 mb-3">
                                        @forelse ($u->skills as $s)
                                            <span class="badge bg-light text-dark border rounded-2 px-2.5 py-1.5 text-xs font-medium">
                                                {{ $s->name }}
                                            </span>
                                        @empty
                                            <span class="text-muted text-xs">No skills set</span>
                                        @endforelse
                                    </div>

<<<<<<< HEAD
                                    <div class="border-top pt-3 d-flex flex-wrap justify-content-end gap-2">
=======
                                    <div class="border-top pt-3 d-flex justify-content-end gap-2">
>>>>>>> e8d3b2e42b6a00a90d15dab6699a4c22a5e4b31a
                                        <a href="{{ route('login') }}" class="btn btn-sm btn-light border rounded-3 fw-bold px-3 py-2 text-secondary">
                                            Send Message
                                        </a>
                                        <a href="{{ route('login') }}" class="btn btn-sm btn-primary rounded-3 fw-bold px-3 py-2 shadow-sm">
                                            Request Collaboration
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>

<<<<<<< HEAD
=======
                        <!-- MODAL PORTFOLIO -->
>>>>>>> e8d3b2e42b6a00a90d15dab6699a4c22a5e4b31a
                        <div class="modal fade" id="portfolioModal{{ $u->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content rounded-4 border-0 shadow">
                                    <div class="modal-header border-bottom p-4 bg-light/50">
                                        <h5 class="modal-title fw-bold text-dark">{{ $u->name }}'s Portfolio</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4 overflow-y-auto" style="max-height: 400px;">
                                        <div class="vstack gap-3">
                                            @forelse($u->projects as $proj)
                                                <div class="p-3 border rounded-4 bg-light/30">
                                                    <h6 class="fw-bold text-dark mb-1"><i class="bi bi-journal-bookmark-fill text-primary me-2"></i>{{ $proj->title }}</h6>
                                                    <p class="text-secondary small m-0" style="white-space: pre-line;">{{ $proj->description }}</p>
                                                </div>
                                            @empty
                                                <p class="text-muted text-center small my-3">This creator hasn't added any portfolio projects yet.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @empty
                        <div class="card border-0 shadow-sm rounded-4 p-5 text-center text-muted small">
                            No creative talents registered at the moment.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="col-lg-4">
<<<<<<< HEAD
=======
                <!-- START: SKILL SPOTLIGHTS DINAMIS -->
>>>>>>> e8d3b2e42b6a00a90d15dab6699a4c22a5e4b31a
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <span class="text-muted fw-bold text-uppercase small d-block mb-3" style="font-size: 0.7rem;">Skill Spotlights</span>
                    <div class="vstack gap-3">
                        @forelse($topSkills as $index => $topSkill)
                            @php
<<<<<<< HEAD
                                $percentage = $totalUsersCount > 0 ? round(($topSkill->users_count / $totalUsersCount) * 100) : 0;
=======
                                // Hitung persentase untuk panjang progress bar
                                $percentage = $totalUsersCount > 0 ? round(($topSkill->users_count / $totalUsersCount) * 100) : 0;
                                
                                // Variasi warna progress bar secara otomatis
>>>>>>> e8d3b2e42b6a00a90d15dab6699a4c22a5e4b31a
                                $colors = ['bg-primary', 'bg-info', 'bg-success'];
                                $bgColor = $colors[$index % count($colors)];
                            @endphp
                            <div>
                                <div class="d-flex justify-content-between text-xs mb-1 fw-medium">
                                    <span class="text-dark fw-bold">#{{ $topSkill->name }}</span>
                                    <span class="text-muted">{{ $topSkill->users_count }} devs</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar {{ $bgColor }}" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @empty
                            <p class="small text-muted m-0">No skill statistics available yet.</p>
                        @endforelse
                    </div>
                </div>
<<<<<<< HEAD
=======
                <!-- END: SKILL SPOTLIGHTS DINAMIS -->

>>>>>>> e8d3b2e42b6a00a90d15dab6699a4c22a5e4b31a
                <div class="card border-0 text-white rounded-4 p-4" style="background: linear-gradient(135deg, #312e81, #581c87);">
                    <h6 class="fw-bold mb-2">Want to Collaborate?</h6>
                    <p class="small m-0 text-white-50" style="font-size: 0.75rem;">
                        Register your SyncFolio account today to start interacting, showcasing your best work, and building your dream project team with hundreds of other talents!
                    </p>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>