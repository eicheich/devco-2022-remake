@auth
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">DevCo</a>
            <!-- Mobile notifications: open offcanvas to avoid clipping -->
            <div class="me-3 d-lg-none">
                <button class="btn btn-link text-dark p-0 position-relative" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#mobileNotificationsOffcanvas" aria-controls="mobileNotificationsOffcanvas">
                    <i class="fas fa-bell fa-lg"></i>
                    @if (\App\Models\Notification::where('user_id', Auth::id())->unread()->count() > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ \App\Models\Notification::where('user_id', Auth::id())->unread()->count() }}
                        </span>
                    @endif
                </button>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="d-flex align-items-center ms-auto">
                    <!-- Notifications for desktop -->
                    <div class="dropdown me-3 d-none d-lg-block">
                        <button class="btn btn-link text-dark p-0 position-relative" type="button"
                            data-bs-toggle="dropdown">
                            <i class="fas fa-bell fa-lg"></i>
                            @if (\App\Models\Notification::where('user_id', Auth::id())->unread()->count() > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ \App\Models\Notification::where('user_id', Auth::id())->unread()->count() }}
                                </span>
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" style="min-width: 300px;">
                            @forelse(\App\Models\Notification::where('user_id', Auth::id())->latest()->take(10)->get() as $notification)
                                <li>
                                    <a class="dropdown-item {{ $notification->read_at ? '' : 'fw-bold' }}" href="#">
                                        @if ($notification->type === 'like')
                                            <i class="fas fa-heart text-danger me-2"></i>
                                            {{ $notification->fromUser->name }} liked your post
                                        @elseif($notification->type === 'repost')
                                            <i class="fas fa-retweet text-success me-2"></i>
                                            {{ $notification->fromUser->name }} reposted your post
                                        @elseif($notification->type === 'follow')
                                            <i class="fas fa-user-plus text-primary me-2"></i>
                                            {{ $notification->fromUser->name }} followed you
                                        @endif
                                        <small
                                            class="text-muted d-block">{{ $notification->created_at->diffForHumans() }}</small>
                                    </a>
                                </li>
                            @empty
                                <li><a class="dropdown-item text-muted">No notifications</a></li>
                            @endforelse
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('notifications.markRead') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-center">Mark all as read</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    <a href="{{ route('profile.show', Auth::id()) }}"
                        class="me-3 text-decoration-none d-flex align-items-center">
                        <img src="{{ Auth::user()->gender === 'male' ? 'https://assets.houselab.my.id/devco/man.png' : 'https://assets.houselab.my.id/devco/woman.png' }}"
                            alt="Profile" class="rounded-circle" style="width: 40px; height: 40px;">
                        <span class="navbar-text ms-2 d-none d-lg-inline">{{ '@' . Auth::user()->username }}</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile notifications offcanvas (bottom sheet) -->
    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="mobileNotificationsOffcanvas"
        aria-labelledby="mobileNotificationsOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="mobileNotificationsOffcanvasLabel">Notifications</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="list-group">
                @forelse(\App\Models\Notification::where('user_id', Auth::id())->latest()->take(50)->get() as $notification)
                    <a href="#"
                        class="list-group-item list-group-item-action {{ $notification->read_at ? '' : 'fw-bold' }}">
                        @if ($notification->type === 'like')
                            <i class="fas fa-heart text-danger me-2"></i>
                            {{ $notification->fromUser->name }} liked your post
                        @elseif($notification->type === 'repost')
                            <i class="fas fa-retweet text-success me-2"></i>
                            {{ $notification->fromUser->name }} reposted your post
                        @elseif($notification->type === 'follow')
                            <i class="fas fa-user-plus text-primary me-2"></i>
                            {{ $notification->fromUser->name }} followed you
                        @endif
                        <div class="small text-muted">{{ $notification->created_at->diffForHumans() }}</div>
                    </a>
                @empty
                    <div class="text-center text-muted py-3">No notifications</div>
                @endforelse
            </div>
            <div class="mt-3 text-center">
                <form method="POST" action="{{ route('notifications.markRead') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-secondary">Mark all as read</button>
                </form>
            </div>
        </div>
    </div>
@endauth

@guest
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">DevCo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto">
                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                    <a href="{{ route('register.email') }}" class="btn btn-primary">Sign Up</a>
                </div>
            </div>
        </div>
    </nav>
@endguest
