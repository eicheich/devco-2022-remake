@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0" style="border-radius: 10px;">
                    <div class="card-body">
                        <h4 class="mb-4">Search Results for "{{ $query }}"</h4>

                        @if ($users->isEmpty())
                            <div class="text-center py-5">
                                <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No users found</p>
                                <a href="{{ route('home') }}" class="btn btn-primary">Back to Timeline</a>
                            </div>
                        @else
                            <div class="list-group">
                                @foreach ($users as $user)
                                    <a href="{{ route('profile.show', $user->id) }}"
                                        class="list-group-item list-group-item-action d-flex align-items-center py-3">
                                        <img src="{{ $user->gender === 'male' ? 'https://assets.houselab.my.id/devco/man.png' : 'https://assets.houselab.my.id/devco/woman.png' }}"
                                            alt="Avatar" class="rounded-circle me-3" style="width: 50px; height: 50px;">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">{{ $user->name }}</h6>
                                            <small class="text-muted">{{ '@' . $user->username }}</small>
                                        </div>
                                        @if (Auth::id() !== $user->id)
                                            @if (Auth::user()->isFollowing($user))
                                                <span class="badge bg-secondary">Following</span>
                                            @else
                                                <span class="badge bg-primary">Follow</span>
                                            @endif
                                        @endif
                                    </a>
                                @endforeach
                            </div>

                            <div class="mt-3 text-center">
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary">Back to Timeline</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
