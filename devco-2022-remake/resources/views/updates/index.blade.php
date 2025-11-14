<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Updates - DevCo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body style="background-color: #f8f9fa;">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">DevCo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto">
                    <a href="{{ route('home') }}" class="btn btn-outline-primary me-2">Back to Timeline</a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Updates</h2>
                    @if (Auth::check() && Auth::user()->isAdmin())
                        <a href="{{ route('updates.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>New Update
                        </a>
                    @endif
                </div>

                @if ($updates->isEmpty())
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No updates available yet</p>
                        </div>
                    </div>
                @else
                    @foreach ($updates as $update)
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h5 class="card-title mb-1">{{ $update->title }}</h5>
                                        @if ($update->version)
                                            <span class="badge bg-info">v{{ $update->version }}</span>
                                        @endif
                                    </div>
                                    @if (Auth::check() && Auth::user()->isAdmin())
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-link text-dark" type="button"
                                                data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('updates.edit', $update->id) }}">
                                                        <i class="fas fa-edit me-2"></i>Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <form method="POST"
                                                        action="{{ route('updates.destroy', $update->id) }}"
                                                        class="d-inline" onsubmit="return confirm('Are you sure?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="fas fa-trash me-2"></i>Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                <p class="card-text">{{ $update->description }}</p>
                                <small class="text-muted">{{ $update->created_at->format('M d, Y H:i') }}</small>
                            </div>
                        </div>
                    @endforeach

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $updates->links() }}
                    </div>
                @endif
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
