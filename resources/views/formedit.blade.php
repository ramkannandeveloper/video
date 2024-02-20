@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Video</h1>

        <form action="{{ route('videos.update', $video->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $video->title ?? ''}}" required>
            </div>

            <div class="mb-3">
                <label for="video" class="form-label">Video: <a href="{{ asset($video->video_path)}}" target="_blanke">View</a></label>
                <input type="file" class="form-control" id="video" name="video" accept="video/*">
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Content:</label>
                <textarea class="form-control" id="content" name="content" rows="5">{{ $video->content ?? ''}}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
