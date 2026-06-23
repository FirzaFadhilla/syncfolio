<x-app-layout>
    <x-slot name="header">
        <h4 class="fw-bold m-0 text-dark">Edit Profile</h4>
    </x-slot>

    <div class="row g-4 justify-content-center">
        <div class="col-lg-8">
            
            <!-- Success Notification -->
            @if (session('status') === 'profile-updated')
                <div class="alert alert-success alert-dismissible fade show rounded-4 small p-3 mb-4 border-0 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> Profile updated successfully.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm rounded-4 p-4 p-sm-5">
                <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="vstack gap-4">
                    @csrf
                    @method('patch')

                    <!-- PROFILE PICTURE (AVATAR) -->
                    <div class="d-flex align-items-center gap-3">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" class="rounded-circle object-fit-cover shadow-sm border" style="width: 75px; height: 75px;">
                        @else
                            <div class="rounded-circle text-white fw-bold d-flex align-items-center justify-content-center shadow-sm" style="width: 75px; height: 75px; background: linear-gradient(135deg, #6366f1, #a855f7); font-size: 1.5rem;">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                        @endif
                        <div>
                            <label for="avatar" class="form-label small fw-bold text-dark m-0">Profile Picture (Avatar)</label>
                            <input type="file" id="avatar" name="avatar" class="form-control form-control-sm rounded-3 mt-2">
                            @error('avatar') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <hr class="text-muted m-0 opacity-25">

                    <!-- MAIN PERSONAL DATA -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label small fw-bold text-dark">Full Name</label>
                            <input type="text" id="name" name="name" class="form-control rounded-3" value="{{ old('name', $user->name) }}" required>
                            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label small fw-bold text-dark">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control rounded-3" value="{{ old('email', $user->email) }}" required>
                            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- BIO, LOCATION & STATUS -->
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label for="bio" class="form-label small fw-bold text-dark">Short Biography</label>
                            <textarea id="bio" name="bio" rows="4" class="form-control rounded-3" placeholder="Tell us a bit about your skills and interests... (Max 2-3 sentences)">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="location" class="form-label small fw-bold text-dark">Location</label>
                            <input type="text" id="location" name="location" class="form-control rounded-3 mb-3" value="{{ old('location', $user->location) }}" placeholder="e.g., South Jakarta">
                            @error('location') <span class="text-danger small">{{ $message }}</span> @enderror
                            
                            <label for="availability_status" class="form-label small fw-bold text-dark">Availability Status</label>
                            <select id="availability_status" name="availability_status" class="form-select rounded-3">
                                <option value="Terbuka Gabung Proyek" {{ old('availability_status', $user->availability_status) == 'Terbuka Gabung Proyek' ? 'selected' : '' }}>Open to Collaborate</option>
                                <option value="Mencari Kolaborator" {{ old('availability_status', $user->availability_status) == 'Mencari Kolaborator' ? 'selected' : '' }}>Looking for Collaborator</option>
                                <option value="Tidak Tersedia" {{ old('availability_status', $user->availability_status) == 'Tidak Tersedia' ? 'selected' : '' }}>Not Available</option>
                            </select>
                        </div>
                    </div>

                    <hr class="text-muted m-0 opacity-25">

                    <!-- SOCIAL MEDIA LINKS -->
                    <div class="bg-light/30 p-3 rounded-4 border border-light-subtle">
                        <label class="form-label small fw-bold text-dark d-block mb-3"><i class="bi bi-link-45deg"></i> Social & Professional Media Links</label>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="github" class="form-label small text-secondary fw-semibold"><i class="bi bi-github text-dark"></i> GitHub URL</label>
                                <input type="url" id="github" name="github" class="form-control rounded-3 text-sm" value="{{ old('github', $user->github) }}" placeholder="https://github.com/...">
                                @error('github') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="linkedin" class="form-label small text-secondary fw-semibold"><i class="bi bi-linkedin text-primary"></i> LinkedIn URL</label>
                                <input type="url" id="linkedin" name="linkedin" class="form-control rounded-3 text-sm" value="{{ old('linkedin', $user->linkedin) }}" placeholder="https://linkedin.com/in/...">
                                @error('linkedin') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="instagram" class="form-label small text-secondary fw-semibold"><i class="bi bi-instagram text-danger"></i> Instagram URL</label>
                                <input type="url" id="instagram" name="instagram" class="form-control rounded-3 text-sm" value="{{ old('instagram', $user->instagram) }}" placeholder="https://instagram.com/...">
                                @error('instagram') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <hr class="text-muted m-0 opacity-25">

                    <!-- SKILLS SELECTION -->
                    <div>
                        <label class="form-label small fw-bold text-dark mb-3"><i class="bi bi-tags-fill text-primary"></i> Select Your Primary Skills</label>
                        <div class="d-flex flex-wrap gap-2">
                            @php
                                $userSkills = $user->skills->pluck('id')->toArray();
                                $allSkills = \App\Models\Skill::all();
                            @endphp
                            @foreach($allSkills as $skill)
                                <div class="form-check border rounded-3 px-3 py-2 d-flex align-items-center gap-2 bg-light/30 hover-bg-light transition">
                                    <input class="form-check-input m-0" type="checkbox" name="skills[]" value="{{ $skill->id }}" id="skill_{{ $skill->id }}" 
                                        {{ in_array($skill->id, old('skills', $userSkills)) ? 'checked' : '' }}>
                                    <label class="form-check-label small fw-medium text-dark mt-0" for="skill_{{ $skill->id }}" style="cursor: pointer;">
                                        {{ $skill->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- SAVE BUTTON -->
                    <div class="d-flex justify-content-end pt-3">
                        <button type="submit" class="btn btn-primary rounded-3 px-4 py-2 fw-bold shadow-sm">
                            <i class="bi bi-floppy-fill me-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>

<style>
    .hover-bg-light:hover { 
        background-color: #f8f9fa !important; 
        border-color: #dee2e6 !important; 
    }
</style>