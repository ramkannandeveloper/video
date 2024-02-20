@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Video</h1>
        <a href="{{ route('videos.create') }}">Create</a>


        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Video</th>
                    <th scope="col">Screenshot</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($videos as $k => $v)
                    <tr>
                        <th scope="row">1</th>
                        <td>{{ $v->title }}</td>
                        <td><a href="{{ asset($v->video_path) }}" target="_blanke">View</a></td>
                        <td><a href="{{ asset($v->screenshot) }}" target="_blank">View</a></td>
                        <td><a href="{{ route('videos.edit', $v->id) }}">Edit</a>
                            <a href="{{ route('videos.show', $v->id) }}">View</a>
                        
                            <form action="{{ route('videos.destroy', $v->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
