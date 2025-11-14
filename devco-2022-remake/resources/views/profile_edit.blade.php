<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
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
                        <span class="navbar-text ms-2 d-none d-lg-inline">{{ '@' . Auth::user()->username }}</span>
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
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow border-0" style="border-radius: 10px;">
                    <div class="card-body p-4">
                        <h2 class="card-title text-center mb-4">Edit Profile</h2>
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <form method="POST" action="{{ route('profile.update', $user->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $user->name) }}" required style="border-radius: 8px;">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    value="{{ old('username', $user->username) }}" required
                                    style="border-radius: 8px;">
                                @error('username')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email', $user->email) }}" required style="border-radius: 8px;">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-control" id="gender" name="gender" required
                                    style="border-radius: 8px;">
                                    <option value="male"
                                        {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female"
                                        {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>Female
                                    </option>
                                </select>
                                @error('gender')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                    value="{{ old('date_of_birth', $user->date_of_birth) }}" required
                                    style="border-radius: 8px;">
                                @error('date_of_birth')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('profile.show', $user->id) }}" class="btn btn-secondary"
                                    style="border-radius: 8px;">Cancel</a>
                                <button type="submit" class="btn btn-primary" style="border-radius: 8px;">Update
                                    Profile</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-light text-center py-3 mt-5">
        <p class="mb-0">&copy; 2022 <a href="https://houselab.my.id" target="_blank"
                class="text-decoration-none">Houselab</a>
        </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
