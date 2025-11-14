<!-- Settings Modal -->
<div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="settingsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="settingsModalLabel">Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="list-group list-group-flush">
                    <a href="{{ route('profile.edit', Auth::id()) }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-user-edit me-2"></i>Edit Profile
                    </a>
                    @if (Auth::user()->isAdmin())
                        <a href="{{ route('updates.index') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-megaphone me-2"></i>Manage Updates
                        </a>
                    @endif
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-lock me-2"></i>Change Password
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-bell me-2"></i>Notification Settings
                    </a>
                    <div class="list-group-item d-flex align-items-center justify-content-between opacity-50"
                        style="cursor: not-allowed;">
                        <div>
                            <i class="fas fa-moon me-2"></i>Dark Mode
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="darkModeToggle" disabled
                                {{ session('dark_mode') || request()->cookie('dark_mode') === 'true' ? 'checked' : '' }}>
                        </div>
                    </div>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-lock-open me-2"></i>Privacy & Security
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
