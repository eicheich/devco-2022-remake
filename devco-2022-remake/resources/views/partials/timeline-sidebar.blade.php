<!-- Left Sidebar -->
<div class="col-lg-2 mb-4">
    <div class="card shadow-sm border-0 mb-3" style="border-radius: 10px;">
        <div class="card-body">
            <h6 class="card-title fw-bold mb-3">
                <i class="fas fa-info-circle me-2"></i>Updates
            </h6>
            <div class="small">
                @forelse(\App\Models\Update::latest()->take(3)->get() as $update)
                    <div class="mb-3 pb-2 border-bottom">
                        <p class="mb-1 fw-bold">{{ $update->title }}</p>
                        <p class="mb-1 text-muted" style="font-size: 0.85rem;">
                            {{ Str::limit($update->description, 60) }}
                        </p>
                        @if ($update->version)
                            <small class="text-muted">v{{ $update->version }}</small>
                        @endif
                    </div>
                @empty
                    <p class="text-muted mb-0">No updates available</p>
                @endforelse
                <a href="{{ route('updates.index') }}" class="btn btn-sm btn-outline-primary w-100 mt-2">
                    Read More
                </a>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 10px;">
        <div class="card-body">
            <h6 class="card-title fw-bold mb-3">
                <i class="fas fa-cog me-2"></i>Menu
            </h6>
            <div class="list-group list-group-flush">
                <a href="{{ route('profile.show', Auth::id()) }}"
                    class="list-group-item list-group-item-action border-0 px-0 py-2">
                    <i class="fas fa-user me-2"></i>My Profile
                </a>
                <a href="#" class="list-group-item list-group-item-action border-0 px-0 py-2"
                    data-bs-toggle="modal" data-bs-target="#settingsModal">
                    <i class="fas fa-sliders-h me-2"></i>Settings
                </a>
                <a href="#" class="list-group-item list-group-item-action border-0 px-0 py-2"
                    data-bs-toggle="modal" data-bs-target="#aboutModal">
                    <i class="fas fa-question-circle me-2"></i>About
                </a>
                <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                    @csrf
                    <button type="submit"
                        class="list-group-item list-group-item-action border-0 px-0 py-2 w-100 text-start text-danger">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
