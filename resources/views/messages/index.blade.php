<x-app-layout>
    <x-slot name="header">
        <h4 class="fw-bold m-0 text-dark">Messages</h4>
    </x-slot>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="height: calc(100vh - 160px);">
        <div class="row g-0 h-100">
            
            <!-- LEFT COLUMN: CHAT LIST -->
            <!-- Hidden on mobile (d-none) ONLY if a user is selected (request('user') exists) -->
            <div class="col-12 col-md-4 border-end bg-white h-100 d-flex flex-column {{ request('user') ? 'd-none d-md-flex' : '' }}">
                <div class="p-3 border-bottom bg-light/30">
                    <h6 class="fw-bold text-dark m-0 d-flex align-items-center gap-2">
                        <i class="bi bi-chat-text-fill text-indigo" style="color: #4f46e5;"></i> Collaboration Chat
                    </h6>
                </div>
                
                <div class="flex-grow-1 overflow-y-auto p-2" style="max-height: 100%;">
                    @forelse($activeChats as $chat)
                        @php
                            $unreadCount = \App\Models\Message::where('sender_id', $chat->id)
                                ->where('receiver_id', auth()->id())
                                ->where('is_read', false)
                                ->count();
                        @endphp

                        <a href="{{ route('messages.index', ['user' => $chat->id]) }}" 
                           class="d-flex align-items-center gap-3 p-3 rounded-4 text-decoration-none transition mb-1
                           {{ isset($selectedUser) && $selectedUser->id == $chat->id ? 'bg-primary-subtle text-primary' : 'text-secondary hover-bg-light' }}"
                           style="background-color: {{ isset($selectedUser) && $selectedUser->id == $chat->id ? '#f0f0ff' : 'transparent' }};">
                           
                            <div class="rounded-circle text-white fw-bold d-flex align-items-center justify-content-center shadow-sm shrink-0 position-relative" 
                                 style="width: 40px; height: 40px; background: linear-gradient(135deg, #6366f1, #a855f7); font-size: 0.9rem;">
                                @if($chat->avatar)
                                    <img src="{{ asset('storage/' . $chat->avatar) }}" class="rounded-circle object-fit-cover w-100 h-100">
                                @else
                                    {{ strtoupper(substr($chat->name, 0, 2)) }}
                                @endif

                                @if($unreadCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-white rounded-circle" style="width: 10px; height: 10px;"></span>
                                @endif
                            </div>
                            
                            <div class="overflow-hidden flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 {{ $unreadCount > 0 ? 'fw-bold text-dark' : 'fw-medium text-dark' }} {{ isset($selectedUser) && $selectedUser->id == $chat->id ? 'text-primary fw-bold' : '' }} text-truncate">
                                        {{ $chat->name }}
                                    </h6>
                                    @if($unreadCount > 0)
                                        <span class="badge bg-danger rounded-pill" style="font-size: 0.6rem;">{{ $unreadCount }}</span>
                                    @endif
                                </div>
                                <span class="{{ $unreadCount > 0 ? 'text-dark fw-bold' : 'text-muted' }} text-truncate d-block" style="font-size: 0.75rem;">
                                    {{ $unreadCount > 0 ? 'New message...' : 'Click to open chat' }}
                                </span>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-5 px-3 text-muted">
                            <i class="bi bi-chat-dots display-6 d-block mb-2 opacity-30"></i>
                            <p class="small m-0">No message history yet.<br>Contact other creators via the 'Message' button on the Discover page.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- RIGHT COLUMN: CHAT ROOM -->
            <!-- Hidden on mobile (d-none) IF NO user is selected -->
            <div class="col-12 col-md-8 h-100 d-flex flex-column bg-light/40 {{ request('user') ? '' : 'd-none d-md-flex' }}" style="background-color: #fafafa;">
                @if($selectedUser)
                    
                    <div class="p-3 border-bottom bg-white d-flex align-items-center gap-3">
                        <!-- MOBILE ONLY BACK BUTTON -->
                        <a href="{{ route('messages.index') }}" class="btn btn-sm btn-light border d-md-none me-1 shadow-sm px-2 py-1 rounded-3">
                            <i class="bi bi-chevron-left fw-bold"></i>
                        </a>

                        <div class="rounded-circle text-white fw-bold d-flex align-items-center justify-content-center shadow-sm" 
                             style="width: 42px; height: 42px; background: linear-gradient(135deg, #6366f1, #a855f7); font-size: 0.9rem;">
                            @if($selectedUser->avatar)
                                <img src="{{ asset('storage/' . $selectedUser->avatar) }}" class="rounded-circle object-fit-cover w-100 h-100">
                            @else
                                {{ strtoupper(substr($selectedUser->name, 0, 2)) }}
                            @endif
                        </div>
                        <div>
                            <h6 class="m-0 fw-bold text-dark shadow-none">{{ $selectedUser->name }}</h6>
                            <small class="text-success fw-semibold" style="font-size: 0.7rem;">
                                <i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i> Collaboration Team
                            </small>
                        </div>
                    </div>

                    <div class="flex-grow-1 overflow-y-auto p-4 d-flex flex-column gap-3" style="background-color: #f8f9fa;">
                        @foreach($messages as $msg)
                            @if($msg->sender_id == auth()->id())
                                <div class="d-flex justify-content-end w-100">
                                    <div class="card border-0 text-white p-3 rounded-4 shadow-sm" 
                                         style="background: linear-gradient(135deg, #4f46e5, #6366f1); max-width: 85%; border-top-right-radius: 0px !important;">
                                        <p class="m-0 small leading-relaxed">{{ $msg->body }}</p>
                                        <span class="text-white-50 d-block text-end mt-1" style="font-size: 0.65rem;">
                                            {{ $msg->created_at->format('H:i') }}
                                        </span>
                                    </div>
                               </div>
                            @else
                                <div class="d-flex justify-content-start w-100">
                                    <div class="card border border-light-subtle bg-white p-3 rounded-4 shadow-sm" 
                                         style="max-width: 85%; border-top-left-radius: 0px !important;">
                                        <p class="m-0 small text-dark leading-relaxed">{{ $msg->body }}</p>
                                        <span class="text-muted d-block text-start mt-1" style="font-size: 0.65rem;">
                                            {{ $msg->created_at->format('H:i') }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="p-3 bg-white border-top">
                        <form action="{{ route('messages.store', $selectedUser->id) }}" method="POST" class="m-0">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="body" class="form-control border-zinc-200 rounded-start-4 px-3 text-sm py-2" 
                                       placeholder="Write a message..." required autocomplete="off">
                                <button type="submit" class="btn btn-primary rounded-end-4 px-3 fw-bold text-sm">
                                    <i class="bi bi-send-fill d-none d-sm-inline me-1"></i> 
                                    <i class="bi bi-send-fill d-inline d-sm-none"></i> <!-- Only icon on very small screens -->
                                    <span class="d-none d-sm-inline">Send</span>
                                </button>
                            </div>
                        </form>
                    </div>

                @else
                    <div class="flex-grow-1 d-flex flex-column align-items-center justify-content-center text-center p-5 text-muted">
                        <div class="rounded-circle bg-white shadow-sm d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-chat-left-dots text-secondary opacity-40 fs-2"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1">Start a Project Discussion</h6>
                        <p class="small text-muted m-0" style="max-width: 320px;">
                            Select an active partner on the left sidebar or send a new message via a creator's profile card on the main page.
                        </p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

<style>
    .hover-bg-light:hover {
        background-color: #f8f9fa;
    }
</style>