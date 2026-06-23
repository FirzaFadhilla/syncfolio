<x-app-layout>
    <x-slot name="header">
        <h4 class="fw-bold m-0 text-dark"><i class="bi bi-bookmark-dash-fill text-warning me-2"></i>Saved Talents</h4>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="d-flex flex-column gap-3">
                @forelse ($savedTalents as $u)
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
                                            <h5 class="m-0 fw-bold text-dark hover-primary transition d-inline-block align-middle">{{ $u->name }}</h5>
                                        </a>
                                        <p class="text-muted small m-0 mt-1"><i class="bi bi-geo-alt"></i> {{ $u->location ?? 'Remote' }}</p>
                                    </div>

                                    <form action="{{ route('talent.bookmark', $u->id) }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-link text-danger text-decoration-none p-0 fw-semibold small">
                                            <i class="bi bi-trash3-fill me-1"></i> Remove
                                        </button>
                                    </form>
                                </div>

                                <p class="text-secondary small mb-3">
                                    {{ $u->bio ?? "This creator hasn't written a bio yet." }}
                                </p>

                                <div class="d-flex flex-wrap gap-1.5">
                                    @foreach ($u->skills as $s)
                                        <span class="badge bg-light text-dark border rounded-2 px-2.5 py-1.5 text-xs font-medium">
                                            {{ $s->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="card border-0 shadow-sm rounded-4 p-5 text-center text-muted small bg-white">
                        <i class="bi bi-bookmark display-5 d-block mb-3 text-secondary opacity-30"></i>
                        <h5>No Saved Talents Yet</h5>
                        <p class="text-muted m-0">Explore the main page and bookmark profiles of great creators you'd like to collaborate with in the future.</p>
                        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-primary rounded-3 fw-bold px-4 py-2 mt-3 shadow-sm">Explore Talents</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .hover-primary:hover { color: #4f46e5 !important; }
</style>