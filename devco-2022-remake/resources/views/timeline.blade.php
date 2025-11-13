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
            <div class="d-flex align-items-center">
                <!-- Notifications -->
                <div class="dropdown me-3">
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
                        <li><a class="dropdown-item text-center" href="#">View all</a></li>
                    </ul>
                </div>
                <a href="{{ route('profile.show', Auth::id()) }}" class="me-3 text-decoration-none">
                    <img src="{{ Auth::user()->gender === 'male' ? 'https://assets.houselab.my.id/devco/man.png' : 'https://assets.houselab.my.id/devco/woman.png' }}"
                        alt="Profile" class="rounded-circle" style="width: 40px; height: 40px;">
                </a>
                <span class="navbar-text me-3">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
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
                <button class="nav-link active" id="for-you-tab" data-bs-toggle="tab" data-bs-target="#for-you"
                    type="button" role="tab">For You</button>
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

    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
