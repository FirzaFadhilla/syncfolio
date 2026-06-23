<x-app-layout>
    <x-slot name="header">
        <h4 class="fw-bold m-0 text-dark">Collaboration Requests</h4>
    </x-slot>

    <div class="row">
        <div class="col-100">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                
                <div class="d-flex align-items-center gap-2 border-bottom pb-3 mb-4">
                    <h5 class="fw-bold text-dark m-0">
                        <i class="bi bi-envelope-paper-heart-fill text-indigo me-2" style="color: #4f46e5;"></i> 
                        Incoming Requests (Pending)
                    </h5>
                </div>

                <div class="vstack gap-3">
                    @forelse($incomingRequests as $request)
                        <div class="p-4 border rounded-4 bg-white hover-shadow transition">
                            <div class="d-flex flex-col flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                                
                                <div class="d-flex gap-3 align-items-start">
                                    <div class="rounded-3 text-white fw-bold d-flex align-items-center justify-content-center shadow-sm" 
                                         style="width: 48px; height: 48px; background: linear-gradient(135deg, #4f46e5, #7c3aed); font-size: 1.1rem; flex-shrink: 0;">
                                        {{ strtoupper(substr($request->sender->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-dark m-0 mb-1">{{ $request->sender->name }}</h6>
                                        <p class="text-muted small m-0 mb-2">
                                            <i class="bi bi-geo-alt me-1"></i> {{ $request->sender->location ?? 'Remote / Location not set' }}
                                        </p>
                                        
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($request->sender->skills as $skill)
                                                <span class="badge bg-light text-secondary border rounded-2 px-2 py-1 text-xs" style="font-weight: 500;">
                                                    {{ $skill->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex gap-2 w-100 w-md-auto justify-content-end pt-3 pt-md-0 border-top border-md-0">
                                    <form action="{{ route('collaboration.accept', $request->id) }}" method="POST" class="m-0">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success rounded-3 fw-bold px-3 py-2 d-flex align-items-center gap-1.5 shadow-sm">
                                            <i class="bi bi-check-circle-fill"></i> Accept
                                        </button>
                                    </form>

                                    <form action="{{ route('collaboration.reject', $request->id) }}" method="POST" class="m-0">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 fw-bold px-3 py-2 d-flex align-items-center gap-1.5">
                                            <i class="bi bi-x-circle-fill"></i> Reject
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                                <i class="bi bi-inbox text-secondary fs-3 opacity-50"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1">Inbox Empty</h6>
                            <p class="small text-muted m-0">You don't have any pending project collaboration requests at the moment.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</x-app-layout>