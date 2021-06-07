@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-end mb-2">
        <a href="{{ route('posts.create') }}" class="btn btn-success float-right">Add Post</a>
    </div>
    <div class="card card-default">
        <div class="card-header">Posts</div>
        <div class="card-body">
            @if ($posts->count() > 0)
                <table class="table">
                    <thead>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Image</th>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->category->name }}</td>
                                <td>{{ substr($post->description, 0 , 50) . "..."}}</td>
                                <td>
                                    <img src="/storage/{{ $post->image }}" height="70" width="70" alt="">
                                </td>
                                <td> @if(!$post->trashed())
                                        <a href="{{ route("posts.edit", $post->id) }}" class="btn btn-info">Edit</a>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">
                                            {{ $post->trashed() ? "Delete" : "Trash" }}
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    @if($post->trashed())
                                        <form action="{{ route('posts.restore', $post->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-info" type="submit">Restore</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h3 class="text-center">No Posts</h3>
            @endif
        </div>
    </div>
@endsection
