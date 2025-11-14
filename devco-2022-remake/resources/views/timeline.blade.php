@extends('layouts.app')

@section('title', 'Timeline')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            @include('partials.timeline-sidebar')

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

            @include('partials.timeline-right-sidebar')
        </div>
    </div>

    @include('partials.settings-modal')
    @include('partials.about-modal')
@endsection
