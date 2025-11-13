<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timeline</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body style="background-color: #f8f9fa;">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">DevCo</a>
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

    <div class="container-fluid mt-4">
        <div class="row">
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

            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Post Form -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="POST" action="{{ route('posts.store') }}">
                            @csrf
                            <div class="mb-3">
                                <textarea class="form-control" name="body" rows="3" placeholder="What's on your mind?"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Post</button>
                        </form>
                    </div>
                </div>

                <!-- Tabs -->
                <ul class="nav nav-tabs mb-4" id="timelineTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="for-you-tab" data-bs-toggle="tab"
                            data-bs-target="#for-you" type="button" role="tab">For You</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="following-tab" data-bs-toggle="tab" data-bs-target="#following"
                            type="button" role="tab">Following</button>
                    </li>
                </ul>
                <div class="tab-content mt-4" id="timelineTabsContent">
                    <!-- For You Tab -->
                    <div class="tab-pane fade show active" id="for-you" role="tabpanel">
                        @foreach ($forYouPosts as $post)
                            @include('partials.post', ['post' => $post, 'showFollow' => true])
                        @endforeach
                    </div>
                    <!-- Following Tab -->
                    <div class="tab-pane fade" id="following" role="tabpanel">
                        @foreach ($followingPosts as $post)
                            @include('partials.post', ['post' => $post, 'showFollow' => false])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings Modal -->
    <div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="settingsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="settingsModalLabel">Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="list-group">
                        <a href="{{ route('profile.edit', Auth::id()) }}"
                            class="list-group-item list-group-item-action">
                            <i class="fas fa-user-edit me-2"></i>Edit Profile
                        </a>
                        @if (Auth::user()->email === 'admin@devco.com')
                            <a href="{{ route('updates.index') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-newspaper me-2"></i>Manage Updates
                            </a>
                        @endif
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fas fa-lock me-2"></i>Change Password
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fas fa-bell me-2"></i>Notification Settings
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fas fa-paint-brush me-2"></i>Theme
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fas fa-lock-open me-2"></i>Privacy & Security
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- About Modal -->
    <div class="modal fade" id="aboutModal" tabindex="-1" aria-labelledby="aboutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="aboutModalLabel">About DevCo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <h3 class="mb-3">DevCo</h3>
                    <p class="text-muted mb-3">A modern social media platform to connect with friends and share your
                        thoughts.</p>
                    <div class="mb-3">
                        <p class="mb-1"><strong>Version:</strong> 1.0.2</p>
                        <p class="mb-1"><strong>Developer:</strong> Houselab</p>
                        <p class="mb-3"><strong>Website:</strong> <a href="https://houselab.my.id"
                                target="_blank">houselab.my.id</a></p>
                    </div>
                    <hr>
                    <p class="small text-muted">&copy; 2022 Houselab. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
    <p class="mb-0">&copy; 2022 <a href="https://houselab.my.id" target="_blank"
            class="text-decoration-none">Houselab</a>
    </p>
    </footer>

    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
