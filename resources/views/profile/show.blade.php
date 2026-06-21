<x-app-layout>
    <x-slot name="header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted"><i class="bi bi-arrow-left me-1"></i> Back to Discover</a></li>
                <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">Creator Profile</li>
            </ol>
        </nav>
    </x-slot>

    <div class="row justify-content-center g-4">
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="bg-primary" style="height: 120px; background: linear-gradient(135deg, #4f46e5, #7c3aed);"></div>
                
                <div class="card-body px-4 pb-4 pt-0 text-center relative">
                    <div class="mx-auto bg-white p-1 rounded-circle shadow-sm" style="width: 100px; height: 100px; margin-top: -50px; position: relative; z-index: 2;">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" class="rounded-circle object-fit-cover w-100 h-100">
                        @else
                            <div class="rounded-circle text-white fw-bold d-flex align-items-center justify-content-center w-100 h-100" style="background: linear-gradient(135deg, #6366f1, #a855f7); font-size: 2rem;">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                        @endif
                    </div>

                    <h4 class="fw-bold text-dark m-0">{{ $user->name }}</h4>
                    <p class="text-muted small m-0 mt-1"><i class="bi bi-geo-alt-fill me-1"></i>{{ $user->location ?? 'Location not set' }}</p>
                    
                    <p class="text-secondary small m-0 mt-1"><i class="bi bi-calendar-check-fill me-1"></i>Joined {{ $user->created_at->format('F Y') }}</p>
                    
                    @php
                        // Translating the database status into English display
                        $badgeClass = match($user->availability_status) {
                            'Mencari Kolaborator' => 'bg-primary-subtle text-primary border border-primary-subtle',
                            'Terbuka Gabung Proyek' => 'bg-success-subtle text-success border border-success-subtle',
                            default => 'bg-secondary-subtle text-secondary border border-secondary-subtle',
                        };
                        $badgeText = match($user->availability_status) {
                            'Mencari Kolaborator' => 'Looking for Collaborator',
                            'Terbuka Gabung Proyek' => 'Open to Collaborate',
                            default => 'Not Available',
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }} px-3 py-2 rounded-pill fw-semibold text-xs mb-4 mt-2">
                        ● {{ $badgeText }}
                    </span>

                    @if($user->github || $user->linkedin || $user->instagram)
                        <div class="border-top pt-3 d-flex justify-content-center gap-3">
                            @if($user->github)
                                <a href="{{ $user->github }}" target="_blank" class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;" title="GitHub">
                                    <i class="bi bi-github text-dark fs-5"></i>
                                </a>
                            @endif
                            @if($user->linkedin)
                                <a href="{{ $user->linkedin }}" target="_blank" class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;" title="LinkedIn">
                                    <i class="bi bi-linkedin text-primary fs-5"></i>
                                </a>
                            @endif
                            @if($user->instagram)
                                <a href="{{ $user->instagram }}" target="_blank" class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;" title="Instagram">
                                    <i class="bi bi-instagram text-danger fs-5"></i>
                                </a>
                            @endif
                        </div>
                    @else
                        <div class="border-top pt-3">
                            <span class="text-muted small">No social media linked yet.</span>
                        </div>
                    @endif

                </div>
            </div>

            @if($user->id !== auth()->id())
                <div class="vstack gap-2">
                    <a href="{{ route('messages.index', ['user' => $user->id]) }}" class="btn btn-outline-primary rounded-3 fw-bold py-2 bg-white">
                        <i class="bi bi-chat-text-fill me-1"></i> Send Message
                    </a>
                    
                    @if(in_array($user->id, $sentRequestUserIds))
                        <button disabled class="btn btn-secondary opacity-50 rounded-3 fw-bold py-2">
                            Request Sent
                        </button>
                    @else
                        <form action="{{ route('collaboration.request', $user->id) }}" method="POST" class="m-0 d-grid">
                            @csrf
                            <button type="submit" class="btn btn-primary rounded-3 fw-bold py-2 shadow-sm">
                                <i class="bi bi-person-plus-fill me-1"></i> Request Collaboration
                            </button>
                        </form>
                    @endif
                </div>
            @endif
            <div class="mt-4 pt-3 border-top text-center w-100">
                <button type="button" class="btn btn-link text-danger text-decoration-none small fw-semibold" data-bs-toggle="modal" data-bs-target="#reportModal">
                    <i class="bi bi-flag-fill me-1"></i> Report This Profile
                </button>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-person-lines-fill text-primary me-2"></i> About Me</h6>
                <p class="text-secondary small leading-relaxed m-0" style="white-space: pre-line;">
                    {{ $user->bio ?? "This creator hasn't written a bio yet." }}
                </p>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-tools text-primary me-2"></i> Active Skills</h6>
                <div class="d-flex flex-wrap gap-2">
                    @forelse ($user->skills as $s)
                        <span class="badge bg-light text-dark border rounded-2 px-3 py-2 text-sm font-medium shadow-sm">
                            {{ $s->name }}
                        </span>
                    @empty
                        <span class="text-muted small">No skill tags set yet.</span>
                    @endforelse
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h6 class="fw-bold text-dark border-bottom pb-2 mb-4"><i class="bi bi-briefcase-fill text-primary me-2"></i> Project & Portfolio History ({{ $user->projects->count() }})</h6>
                
                <div class="vstack gap-3">
                    @forelse($user->projects as $proj)
                        <div class="p-4 border border-light-subtle rounded-4 bg-light/30 hover-shadow transition">
                            <h6 class="fw-bold text-dark mb-2 d-flex align-items-center gap-2">
                                <i class="bi bi-journal-code text-indigo" style="color: #4f46e5;"></i> {{ $proj->title }}
                            </h6>
                            <p class="text-secondary small mb-3" style="white-space: pre-line;">
                                {{ $proj->description }}
                            </p>
                            @if($proj->link)
                                <a href="{{ $proj->link }}" target="_blank" class="btn btn-sm btn-dark rounded-3 px-3 fw-semibold text-xs shadow-sm">
                                    <i class="bi bi-box-arrow-up-right me-1"></i> Visit Project ↗
                                </a>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted bg-light rounded-4 border border-dashed">
                            <i class="bi bi-folder-x display-6 d-block mb-2 opacity-40"></i>
                            <p class="small m-0">This creator hasn't uploaded any portfolio projects yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    <!-- Modal Report User -->
    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0">
                    <h1 class="modal-title fs-5 fw-bold text-dark d-flex align-items-center gap-2" id="reportModalLabel">
                        <i class="bi bi-shield-exclamation text-danger"></i> Report User
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('report.store', $user->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p class="small text-muted mb-4">Help us keep SyncFolio safe. Report this profile if it contains spam, fraud, or inappropriate content.</p>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">Reason for Reporting</label>
                            <select name="reason" class="form-select text-sm" required>
                                <option value="Spam / Fake Account">Spam / Fake Account</option>
                                <option value="Inappropriate Content">Inappropriate Content</option>
                                <option value="Fraud / Scam">Fraud / Scam</option>
                                <option value="Harassment">Harassment</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">Details (Optional)</label>
                            <textarea name="details" class="form-control text-sm" rows="3" placeholder="Provide additional context..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light border fw-bold text-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger fw-bold text-sm">Submit Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SWEETALERT TOAST NOTIFICATION -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                customClass: {
                    popup: 'rounded-4 shadow-sm border'
                }
            });
        </script>
    @endif

</x-app-layout>

<style>
    .border-dashed { border-style: dashed !important; }
    .leading-relaxed { line-height: 1.6; }
</style>