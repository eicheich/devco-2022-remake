@extends('layouts.app')

@section('title', $user->name . "'s Profile")

@section('content')
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
                            <div class="text-center" style="cursor: pointer;" data-bs-toggle="modal"
                                data-bs-target="#followersModal">
                                <strong
                                    class="fs-5">{{ \App\Models\Follow::where('followed_id', $user->id)->count() }}</strong><br><small
                                    class="text-muted">Followers</small>
                            </div>
                            <div class="text-center" style="cursor: pointer;" data-bs-toggle="modal"
                                data-bs-target="#followingModal">
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
                                <form method="POST" action="{{ route('follow.destroy', $user->id) }}" class="mt-3">
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

    <!-- Followers Modal -->
    <div class="modal fade" id="followersModal" tabindex="-1" aria-labelledby="followersModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="followersModalLabel">Followers</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="list-group">
                        @forelse(\App\Models\Follow::where('followed_id', $user->id)->with('follower')->get() as $follow)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">{{ $follow->follower->name }}</h6>
                                    <small class="text-muted">{{ $follow->follower->email }}</small>
                                </div>
                                @if (Auth::id() !== $follow->follower_id)
                                    @if (Auth::user()->isFollowing($follow->follower))
                                        <form method="POST" action="{{ route('follow.destroy', $follow->follower->id) }}"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-sm btn-outline-secondary">Unfollow</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('follow.store', $follow->follower->id) }}"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary">Follow</button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-user-friends fa-2x mb-3"></i>
                                <p>No followers yet</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Following Modal -->
    <div class="modal fade" id="followingModal" tabindex="-1" aria-labelledby="followingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="followingModalLabel">Following</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="list-group">
                        @forelse(\App\Models\Follow::where('follower_id', $user->id)->with('followed')->get() as $follow)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">{{ $follow->followed->name }}</h6>
                                    <small class="text-muted">{{ $follow->followed->email }}</small>
                                </div>
                                @if (Auth::id() !== $follow->followed_id)
                                    @if (Auth::user()->isFollowing($follow->followed))
                                        <form method="POST"
                                            action="{{ route('follow.destroy', $follow->followed->id) }}"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-sm btn-outline-secondary">Unfollow</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('follow.store', $follow->followed->id) }}"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary">Follow</button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-user-friends fa-2x mb-3"></i>
                                <p>Not following anyone yet</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
