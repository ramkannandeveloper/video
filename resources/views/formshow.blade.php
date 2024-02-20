@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Video</h1>

        <p>{{ $video->title }}</p>
        {!! $video->content !!}
    </div>
@endsection

@push('scripts')
    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
@endpush
