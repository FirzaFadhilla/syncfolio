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

        <!-- TABEL KELOLA PENGGUNA -->
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h6 class="fw-bold mb-4 text-dark"><i class="bi bi-people-fill text-primary me-2"></i>Manage All Users ({{ $users->count() }})</h6>
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
                                        <!-- Tambahan title agar admin bisa melihat alasan suspend saat mouse diarahkan ke badge -->
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
                                            <!-- Tombol Restore (Normal Alert) -->
                                            <button type="button" onclick="confirmAction('suspend-form-{{ $u->id }}', 'Restore User?', 'The user will regain access to their account.', 'success', 'Yes, Restore')" class="btn btn-sm btn-success fw-bold text-xs"><i class="bi bi-play-fill me-1"></i>Restore</button>
                                        @else
                                            <!-- Tombol Suspend (Pop-up minta alasan) -->
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- SWEETALERT2 SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Alert Pop-up Biasa (Untuk Delete atau Restore)
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

        // Alert Pop-up Khusus Suspend (Untuk Meminta Input Alasan)
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
                    // Membuat input hidden berisi alasan yang diketik Admin, lalu memasukannya ke form
                    let form = document.getElementById(formId);
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'reason';
                    input.value = result.value;
                    form.appendChild(input);
                    
                    // Eksekusi form
                    form.submit();
                }
            });
        }
    </script>
</x-app-layout>