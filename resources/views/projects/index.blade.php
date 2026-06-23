<x-app-layout>
    <x-slot name="header">
        <h4 class="fw-bold m-0 text-dark"><i class="bi bi-folder-fill text-primary me-2"></i>Portfolio Management</h4>
    </x-slot>

    <div class="row g-4">
        
        <div class="col-lg-4">
            @if (session('status') === 'project-added')
                <div class="alert alert-success alert-dismissible fade show rounded-4 small p-3 mb-3 border-0 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> New project successfully added!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('status') === 'project-deleted')
                <div class="alert alert-danger alert-dismissible fade show rounded-4 small p-3 mb-3 border-0 shadow-sm" role="alert">
                    <i class="bi bi-trash-fill me-2"></i> Project successfully deleted.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 100px; z-index: 10;">
                <h6 class="fw-bold text-dark mb-3 border-bottom pb-2"><i class="bi bi-plus-circle-fill text-primary me-2"></i> Add New Project</h6>
                
                <form action="{{ route('projects.store') }}" method="POST" class="vstack gap-3">
                    @csrf
                    
                    <div>
                        <label for="title" class="form-label small fw-bold text-secondary">Project / App Title</label>
                        <input type="text" id="title" name="title" class="form-control rounded-3 text-sm py-2" placeholder="e.g., E-Commerce Livestock Laravel" required autocomplete="off">
                        @error('title') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="link" class="form-label small text-secondary fw-bold">Project Link (Optional)</label>
                        <input type="url" id="link" name="link" class="form-control rounded-3 text-sm py-2" placeholder="https://github.com/... or https://demo.com">
                        <small class="text-muted" style="font-size: 0.7rem;">Must start with http:// or https://</small>
                        @error('link') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="description" class="form-label small fw-bold text-secondary">Short Project Description</label>
                        <textarea id="description" name="description" rows="5" class="form-control rounded-3 text-sm" placeholder="Describe the technologies used, main features, or your role in developing this project..." required></textarea>
                        @error('description') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary rounded-3 py-2 fw-bold shadow-sm mt-2">
                        <i class="bi bi-cloud-arrow-up-fill me-1"></i> Publish Project
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h6 class="fw-bold text-dark mb-4 border-bottom pb-2"><i class="bi bi-grid-3x3-gap-fill text-primary me-2"></i> Your Active Portfolio Collection ({{ $projects->count() }})</h6>
                
                <div class="vstack gap-3">
                    @forelse($projects as $proj)
                        <div class="p-4 border border-light-subtle rounded-4 bg-light/20 transition d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                    <h6 class="fw-bold text-dark m-0 d-flex align-items-center gap-2">
                                        <i class="bi bi-journal-code text-indigo" style="color: #4f46e5;"></i> {{ $proj->title }}
                                    </h6>
                                    
                                    <form action="{{ route('projects.destroy', $proj->id) }}" method="POST" class="m-0" onsubmit="return confirm('Are you sure you want to delete this portfolio project?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-link text-danger text-decoration-none p-0" title="Delete Project">
                                            <i class="bi bi-trash3-fill fs-6"></i>
                                        </button>
                                    </form>
                                </div>
                                <p class="text-secondary small mb-3" style="white-space: pre-line; line-height: 1.6;">
                                    {{ $proj->description }}
                                </p>
                            </div>

                            @if($proj->link)
                                <div class="pt-2">
                                    <a href="{{ $proj->link }}" target="_blank" class="btn btn-sm btn-dark rounded-3 px-3 fw-semibold text-xs shadow-sm">
                                        <i class="bi bi-box-arrow-up-right me-1"></i> View Live Demo / Repository ↗
                                    </a>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted border border-dashed rounded-4 bg-light/40">
                            <i class="bi bi-folder-x display-4 d-block mb-3 opacity-30 text-secondary"></i>
                            <h6 class="fw-bold text-dark mb-1">Portfolio is Empty</h6>
                            <p class="small text-muted m-0" style="max-width: 340px; margin: 0 auto !important;">
                                You haven't showcased any projects yet. Fill out the form on the left to start building your own professional gallery!
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</x-app-layout>

<style>
    .border-dashed { border-style: dashed !important; }
</style>