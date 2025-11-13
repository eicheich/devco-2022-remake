<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex align-items-center mb-2">
            <a href="{{ route('profile.show', $post->user->id) }}"
                class="d-flex align-items-center text-decoration-none text-dark">
                <img src="{{ $post->user->gender === 'male' ? 'https://assets.houselab.my.id/devco/man.png' : 'https://assets.houselab.my.id/devco/woman.png' }}"
                    alt="Avatar" class="rounded-circle me-2" style="width: 32px; height: 32px;">
                <h6 class="card-title mb-0">{{ $post->user->name }}</h6>
            </a>
            <div class="ms-auto">
                @if ($post->user->id == Auth::id())
                    <!-- Dropdown for own posts -->
                    <div class="dropdown">
                        <button class="btn btn-link text-dark p-0" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('posts.edit', $post) }}">Edit</a></li>
                            <li>
                                <form method="POST" action="{{ route('posts.destroy', $post) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @elseif(isset($showFollow) && $showFollow)
                    @if (Auth::user()->isFollowing($post->user))
                        <form method="POST" action="{{ route('follow.destroy', $post->user->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-secondary btn-sm">Unfollow</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('follow.store', $post->user->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">Follow</button>
                        </form>
                    @endif
                @endif
            </div>
        </div>
        <p class="card-text">{{ $post->body }}</p>
        <div class="d-flex gap-4 mt-3">
            <form method="POST" action="{{ route('likes.toggle', $post->id) }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-link p-0 text-decoration-none d-flex align-items-center">
                    <i
                        class="fas fa-heart {{ $post->likes()->where('user_id', Auth::id())->exists() ? 'text-danger' : 'text-muted' }} me-1"></i>
                    <small>{{ $post->likes()->count() }}</small>
                </button>
            </form>
            <button class="btn btn-link p-0 text-decoration-none d-flex align-items-center" data-bs-toggle="modal"
                data-bs-target="#commentModal{{ $post->id }}">
                <i class="fas fa-comment text-muted me-1"></i>
                <small>{{ $post->comments()->count() }}</small>
            </button>
            <form method="POST" action="{{ route('reposts.store', $post->id) }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-link p-0 text-decoration-none d-flex align-items-center">
                    <i
                        class="fas fa-retweet {{ $post->reposts()->where('user_id', Auth::id())->exists() ? 'text-success' : 'text-muted' }} me-1"></i>
                    <small>{{ $post->reposts()->count() }}</small>
                </button>
            </form>
        </div>
        <small class="text-muted">
            {{ $post->created_at->diffForHumans() }}
            @if ($post->updated_at != $post->created_at)
                (edited)
            @endif
        </small>
    </div>
</div>

<!-- Comment Modal -->
<div class="modal fade" id="commentModal{{ $post->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Comments</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @foreach ($post->comments as $comment)
                    <div class="mb-3">
                        <strong>{{ $comment->user->name }}</strong>: {{ $comment->body }}
                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                    </div>
                @endforeach
                <form method="POST" action="{{ route('comments.store', $post->id) }}">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="body" class="form-control" placeholder="Add a comment..."
                            required>
                        <button type="submit" class="btn btn-primary">Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
