<!-- Right Sidebar -->
<div class="col-lg-2 mb-4">
    <!-- Search Box -->
    <div class="card shadow-sm border-0 mb-3" style="border-radius: 10px;">
        <div class="card-body">
            <h6 class="card-title fw-bold mb-3">
                <i class="fas fa-search me-2"></i>Search Users
            </h6>
            <form method="GET" action="{{ route('search') }}">
                <div class="input-group">
                    <input type="text" class="form-control" name="q" placeholder="Username or name..."
                        value="{{ request('q') }}" required>
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Friends List -->
    <div class="card shadow-sm border-0" style="border-radius: 10px;">
        <div class="card-body">
            <h6 class="card-title fw-bold mb-3">
                <i class="fas fa-user-friends me-2"></i>Friends
            </h6>
            <div class="list-group list-group-flush">
                @php
                    $friends = \App\Models\Follow::where('follower_id', Auth::id())
                        ->with('followed')
                        ->latest()
                        ->take(5)
                        ->get();
                @endphp

                @forelse($friends as $follow)
                    <a href="{{ route('profile.show', $follow->followed->id) }}"
                        class="list-group-item list-group-item-action border-0 px-0 py-2 d-flex align-items-center">
                        <img src="{{ $follow->followed->gender === 'male' ? 'https://assets.houselab.my.id/devco/man.png' : 'https://assets.houselab.my.id/devco/woman.png' }}"
                            alt="Avatar" class="rounded-circle me-2" style="width: 32px; height: 32px;">
                        <div class="flex-grow-1">
                            <div class="fw-bold small">{{ $follow->followed->name }}</div>
                            <div class="text-muted" style="font-size: 0.75rem;">{{ '@' . $follow->followed->username }}
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="text-muted small mb-0">No friends yet</p>
                @endforelse

                @if ($friends->count() >= 5)
                    <a href="{{ route('profile.show', Auth::id()) }}"
                        class="list-group-item list-group-item-action border-0 px-0 py-2 text-center text-primary small">
                        <i class="fas fa-angle-right me-1"></i>See More
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
