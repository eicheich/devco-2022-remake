<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background-color: #f8f9fa;">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow border-0" style="border-radius: 10px;">
                    <div class="card-header bg-white border-0 text-center py-3">
                        <h3 class="mb-0">Edit Post</h3>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('posts.update', $post) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="body" class="form-label">Post Content</label>
                                <textarea class="form-control" id="body" name="body" rows="4" required>{{ old('body', $post->body) }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100" style="border-radius: 10px;">Update
                                Post</button>
                            <a href="{{ route('home') }}" class="btn btn-secondary w-100 mt-2"
                                style="border-radius: 10px;">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
