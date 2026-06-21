<x-app-layout>
    <x-slot name="header">
        <h4 class="fw-bold m-0 text-dark">Discover Connections</h4>
    </x-slot>

    <div class="row g-4">
        <div class="col-lg-8">
            
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <form action="{{ route('dashboard') }}" method="GET" class="mb-4">
                    @if(request('skill'))
                        <input type="hidden" name="skill" value="{{ request('skill') }}">
                    @endif
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0 rounded-start-3"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control bg-light border-start-0 border-end-0 text-sm py-2" placeholder="Search by name, location, or bio keywords..." value="{{ request('search') }}">
                        @if(request('search'))
                            <a href="{{ route('dashboard', request()->only('skill')) }}" class="btn btn-light border-top border-bottom text-muted d-flex align-items-center justify-content-center px-2"><i class="bi bi-x-circle-fill"></i></a>
                        @endif
                        <button type="submit" class="btn btn-dark rounded-end-3 text-sm px-4 fw-bold">Search</button>
                    </div>
                </form>
                <span class="text-muted fw-bold text-uppercase small d-block mb-2" style="font-size: 0.7rem;">Filter by Skill</span>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('dashboard') }}" class="btn btn-sm rounded-3 px-3 py-2 fw-semibold {{ !request('skill') ? 'btn-dark' : 'btn-light border text-secondary' }}">
                        All
                    </a>
                    @foreach($skills as $skill)
                        <a href="{{ route('dashboard', ['skill' => $skill->slug]) }}" class="btn btn-sm rounded-3 px-3 py-2 fw-semibold {{ request('skill') == $skill->slug ? 'btn-primary' : 'btn-light border text-secondary' }}">
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
                                        <a href="{{ route('kreator.show', $u->id) }}" class="text-decoration-none">
                                            <h5 class="m-0 fw-bold text-dark d-inline-block align-middle hover-primary transition">{{ $u->name }}</h5>
                                        </a>
                                        <p class="text-muted small m-0 mt-1"><i class="bi bi-geo-alt"></i> {{ $u->location ?? 'Location not set' }}</p>
                                    </div>

                                    @php
                                        // Translator status ke Bahasa Inggris
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
                                    <span class="badge {{ $badgeClass }} px-2.5 py-1.5 rounded-3 fw-semibold text-xs">
                                        ● {{ $badgeText }}
                                    </span>

                                    <div class="mt-2 text-end">
                                        <form action="{{ route('talent.bookmark', $u->id) }}" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit" class="btn btn-sm p-0 border-0 shadow-none" title="{{ in_array($u->id, $bookmarkIds) ? 'Remove from Saved' : 'Save Talent' }}">
                                                @if(in_array($u->id, $bookmarkIds))
                                                    <i class="bi bi-bookmark-fill text-warning fs-5"></i> <span class="text-xs text-muted fw-medium">Saved</span>
                                                @else
                                                    <i class="bi bi-bookmark text-secondary fs-5"></i> <span class="text-xs text-muted">Save</span>
                                                @endif
                                            </button>
                                        </form>
                                    </div>

                                </div>

                                <p class="text-secondary small mb-3">
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

                                <div class="border-top pt-3 d-flex justify-content-end gap-2">
                                    <a href="{{ route('messages.index', ['user' => $u->id]) }}" class="btn btn-sm btn-light border rounded-3 fw-bold px-3 py-2 text-secondary">
                                        Send Message
                                    </a>

                                    @if(in_array($u->id, $sentRequestUserIds))
                                        <button disabled class="btn btn-sm btn-secondary opacity-50 rounded-3 fw-bold px-3 py-2">
                                            Requested
                                        </button>
                                    @else
                                        <form action="{{ route('collaboration.request', $u->id) }}" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary rounded-3 fw-bold px-3 py-2 shadow-sm">
                                                Request Collaboration
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="card border-0 shadow-sm rounded-4 p-5 text-center text-muted small">
                        No collaborators found matching your filter criteria.
                    </div>
                @endforelse
            </div>
            
            <!-- TOMBOL PAGINATION (PEMBAGIAN HALAMAN) -->
            @if ($users->hasPages())
                <div class="d-flex justify-content-center mt-5 mb-4">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

       <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <span class="text-muted fw-bold text-uppercase small d-block mb-3" style="font-size: 0.7rem; letter-spacing: 0.05em;">Suggested For You</span>
                
                <div class="vstack gap-3">
                    @forelse($suggestedUsers as $suggested)
                        <div class="d-flex align-items-center justify-content-between gap-2 border-bottom pb-2 last-border-0">
                            <div class="d-flex align-items-center gap-2 overflow-hidden">
                                <div class="rounded-circle text-white fw-bold d-flex align-items-center justify-content-center shrink-0" 
                                     style="width: 36px; height: 36px; background: linear-gradient(135deg, #4f46e5, #a855f7); font-size: 0.8rem;">
                                    {{ strtoupper(substr($suggested->name, 0, 2)) }}
                                </div>
                                <div class="overflow-hidden">
                                    <h6 class="m-0 fw-bold text-dark text-truncate small">{{ $suggested->name }}</h6>
                                    <span class="text-muted text-truncate d-block" style="font-size: 0.7rem;">
                                        {{ $suggested->skills->first()->name ?? 'Creator' }} • {{ $suggested->location ?? 'Remote' }}
                                    </span>
                                </div>
                            </div>
                            
                            <a href="{{ route('messages.index', ['user' => $suggested->id]) }}" class="btn btn-sm btn-outline-primary rounded-3 py-1 px-2 text-xs fw-bold">
                                <i class="bi bi-chat-fill"></i> Connect
                            </a>
                        </div>
                    @empty
                        <p class="text-muted text-center small m-0 py-2">No suggested profiles available yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- START: SKILL SPOTLIGHTS DINAMIS -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <span class="text-muted fw-bold text-uppercase small d-block mb-3" style="font-size: 0.7rem;">Skill Spotlights</span>
                <div class="vstack gap-3">
                    @forelse($topSkills as $index => $topSkill)
                        @php
                            // Hitung persentase untuk panjang progress bar
                            $percentage = $totalUsersCount > 0 ? round(($topSkill->users_count / $totalUsersCount) * 100) : 0;
                            
                            // Variasi warna progress bar secara otomatis
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
                        <p class="small text-muted m-0">No skill statistics available.</p>
                    @endforelse
                </div>
                
            </div>
            <!-- END: SKILL SPOTLIGHTS DINAMIS -->

            <div class="card border-0 text-white rounded-4 p-4" style="background: linear-gradient(135deg, #312e81, #581c87);">
                <h6 class="fw-bold mb-2">Smart Recommendation</h6>
                <p class="small m-0 text-white-50 leading-relaxed" style="font-size: 0.75rem;">
                    The system automatically analyzes your active skills and matches them with cross-functional talents ready to collaborate to complete your project needs.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>