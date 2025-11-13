<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->name }}'s Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body style="background-color: #f8f9fa;">
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
                                    <a class="dropdown-item {{ $notification->read_at ? '' : 'fw-bold' }}"
                                        href="#">
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
                        <span class="navbar-text ms-2 d-none d-lg-inline">{{ Auth::user()->name }}</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
                    </form>
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

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card shadow border-0" style="border-radius: 10px;">
                    <div class="card-body text-center p-4">
                        <img src="{{ $user->gender === 'male' ? 'https://assets.houselab.my.id/devco/man.png' : 'https://assets.houselab.my.id/devco/woman.png' }}"
                            alt="Profile Picture" class="rounded-circle mb-3" style="width: 120px; height: 120px;">
                        <h4>{{ $user->name }}</h4>
                        <p class="text-muted">{{ $user->email }}</p>
                        <div class="d-flex justify-content-around mt-4">
                            <div class="text-center">
                                <strong class="fs-5">{{ $posts->count() }}</strong><br><small
                                    class="text-muted">Posts</small>
                            </div>
                            <div class="text-center">
                                <strong
                                    class="fs-5">{{ \App\Models\Follow::where('followed_id', $user->id)->count() }}</strong><br><small
                                    class="text-muted">Followers</small>
                            </div>
                            <div class="text-center">
                                <strong
                                    class="fs-5">{{ \App\Models\Follow::where('follower_id', $user->id)->count() }}</strong><br><small
                                    class="text-muted">Following</small>
                            </div>
                        </div>
                        @if (Auth::id() === $user->id)
                            <a href="{{ route('profile.edit', $user->id) }}" class="btn btn-primary mt-3 w-100"
                                style="border-radius: 10px;">Edit Profile</a>
                        @else
                            @if (Auth::user()->isFollowing($user))
                                <form method="POST" action="{{ route('follow.destroy', $user->id) }}"
                                    class="mt-3">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-secondary w-100"
                                        style="border-radius: 10px;">Unfollow</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('follow.store', $user->id) }}" class="mt-3">
                                    @csrf
                                    <button type="submit" class="btn btn-primary w-100"
                                        style="border-radius: 10px;">Follow</button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-8 mt-4 mt-md-0">
                <h3 class="mb-4">Posts & Reposts</h3>
                @forelse($reposts as $repost)
                    <div class="card mb-3">
                        <div class="card-body">
                            <small class="text-muted"><i class="fas fa-retweet"></i> You reposted</small>
                            @include('partials.post', ['post' => $repost->post, 'showFollow' => false])
                        </div>
                    </div>
                @empty
                    <div class="text-center mt-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No reposts yet</h5>
                        <p class="text-muted">Start sharing posts!</p>
                    </div>
                @endforelse
                @forelse($posts as $post)
                    @include('partials.post', ['post' => $post, 'showFollow' => false])
                @empty
                    @if ($reposts->isEmpty())
                        <div class="text-center mt-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No posts yet</h5>
                            <p class="text-muted">Start sharing your thoughts!</p>
                        </div>
                    @endif
                @endforelse
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
