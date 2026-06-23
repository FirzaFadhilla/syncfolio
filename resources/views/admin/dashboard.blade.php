<x-app-layout>
    <x-slot name="header">
        <h4 class="fw-bold m-0 text-danger"><i class="bi bi-shield-lock-fill me-2"></i>Admin Control Panel</h4>
    </x-slot>

    <div class="row g-4">
        <!-- Notifikasi -->
        <div class="col-12">
            @if (session('status') === 'user-suspended') 
                <div class="alert alert-warning small fw-bold"><i class="bi bi-pause-circle me-2"></i>User account suspended!</div> 
            @endif
            @if (session('status') === 'user-restored') 
                <div class="alert alert-success small fw-bold"><i class="bi bi-play-circle me-2"></i>User account restored!</div> 
            @endif
            @if (session('status') === 'user-deleted') 
                <div class="alert alert-danger small fw-bold"><i class="bi bi-trash-fill me-2"></i>User deleted permanently!</div> 
            @endif
        </div>

        <!-- TABEL LAPORAN PENGGUNA -->
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h6 class="fw-bold mb-4 text-dark"><i class="bi bi-flag-fill text-danger me-2"></i>User Reports</h6>
                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0">
                        <thead class="table-light">
                            <tr>
                                <th class="small text-muted text-uppercase">Reported User</th>
                                <th class="small text-muted text-uppercase">Reason & Details</th>
                                <th class="small text-muted text-uppercase">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($reports) && $reports->count() > 0)
                                @foreach($reports as $report)
                                <tr>
                                    <td>
                                        <span class="fw-bold text-dark text-sm">
                                            {{ optional($report->reportedUser)->name ?? optional($report->user)->name ?? 'Unknown User' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning-subtle text-warning-emphasis mb-1 border border-warning-subtle">{{ $report->reason ?? 'Reported' }}</span>
                                        <!-- BAGIAN INI SUDAH DIPERBAIKI MENJADI DESCRIPTION -->
                                        <p class="text-muted text-xs m-0 text-truncate" style="max-width: 300px;" title="{{ $report->description ?? '' }}">{{ $report->description ?? 'No additional details provided.' }}</p>
                                    </td>
                                    <td>
                                        <span class="text-muted text-xs">{{ $report->created_at ? $report->created_at->format('d M Y, H:i') : '-' }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            @elseif(isset($reports) && $reports->count() == 0)
                                <tr><td colspan="3" class="text-center text-muted py-4 small"><i class="bi bi-shield-check display-6 d-block mb-2 text-success opacity-50"></i>No user reports at this time. Safe and clean!</td></tr>
                            @else
                                <tr><td colspan="3" class="text-center text-danger py-4 small fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i>Variabel $reports belum dikirimkan dari AdminController Anda.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TABEL KELOLA PENGGUNA -->
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h6 class="fw-bold mb-4 text-dark"><i class="bi bi-people-fill text-primary me-2"></i>Manage All Users ({{ isset($users) ? $users->count() : 0 }})</h6>
                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0">
                        <thead class="table-light">
                            <tr>
                                <th class="small text-muted text-uppercase">Name & Email</th>
                                <th class="small text-muted text-uppercase">Location & Joined</th>
                                <th class="small text-muted text-uppercase">Status</th>
                                <th class="small text-muted text-uppercase text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($users))
                                @forelse($users as $u)
                                <tr>
                                    <td>
                                        <a href="{{ route('kreator.show', $u->id) }}" target="_blank" class="fw-bold {{ $u->is_suspended ? 'text-danger text-decoration-line-through' : 'text-dark text-decoration-none' }} text-sm">{{ $u->name }}</a>
                                        <div class="text-muted text-xs">{{ $u->email }}</div>
                                    </td>
                                    <td>
                                        <span class="text-secondary small d-block">{{ $u->location ?? 'Not Set' }}</span>
                                        <span class="text-muted text-xs">Since {{ $u->created_at->format('M Y') }}</span>
                                    </td>
                                    <td>
                                        @if($u->is_suspended) 
                                            <span class="badge bg-danger-subtle text-danger" style="cursor: help;" title="Reason: {{ $u->suspend_reason ?? 'Violating rules' }}">Suspended</span> 
                                        @else 
                                            <span class="badge bg-success-subtle text-success">Active</span> 
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <!-- Tombol Suspend / Restore -->
                                        <form action="{{ route('admin.user.suspend', $u->id) }}" method="POST" class="d-inline" id="suspend-form-{{ $u->id }}">
                                            @csrf @method('PATCH')
                                            @if($u->is_suspended)
                                                <button type="button" onclick="confirmAction('suspend-form-{{ $u->id }}', 'Restore User?', 'The user will regain access to their account.', 'success', 'Yes, Restore')" class="btn btn-sm btn-success fw-bold text-xs"><i class="bi bi-play-fill me-1"></i>Restore</button>
                                            @else
                                                <button type="button" onclick="suspendUser('suspend-form-{{ $u->id }}', '{{ addslashes($u->name) }}')" class="btn btn-sm btn-warning fw-bold text-xs text-dark"><i class="bi bi-pause-fill me-1"></i>Suspend</button>
                                            @endif
                                        </form>

                                        <!-- Tombol Delete -->
                                        <form action="{{ route('admin.user.destroy', $u->id) }}" method="POST" class="d-inline ms-1" id="delete-form-{{ $u->id }}">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="confirmAction('delete-form-{{ $u->id }}', 'Delete Account?', 'This action is permanent and cannot be undone!', 'error', 'Yes, Delete')" class="btn btn-sm btn-outline-danger fw-bold text-xs"><i class="bi bi-trash3-fill"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center text-muted py-4 small">No registered users found.</td></tr>
                                @endforelse
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- SWEETALERT2 SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmAction(formId, title, text, icon, confirmText) {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: icon === 'error' ? '#dc3545' : '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<span class="fw-bold">' + confirmText + '</span>',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }

        function suspendUser(formId, name) {
            Swal.fire({
                title: 'Suspend ' + name + '?',
                text: "Please provide a reason for suspension:",
                input: 'text',
                inputPlaceholder: 'e.g., Violating community guidelines...',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<span class="text-dark fw-bold">Yes, Suspend</span>',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                preConfirm: (reason) => {
                    if (!reason) {
                        Swal.showValidationMessage('A reason is required to suspend a user!')
                    }
                    return reason;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.getElementById(formId);
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'reason';
                    input.value = result.value;
                    form.appendChild(input);
                    form.submit();
                }
            });
        }
    </script>
</x-app-layout>