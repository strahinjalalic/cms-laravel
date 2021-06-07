@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <div class="card-header">
            {{ isset($post) ? 'Edit Post' : 'Create Post' }}
        </div>
        <div class="card-body">
            <form action="{{ isset($post) ?  route('posts.update', $post->id) : route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($post))
                    @method('PUT')
                @endif
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" id="" value="{{ isset($post) ? $post->title : "" }}">
                </div>
                @error('title')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="" cols="30" rows="6" class="form-control">{{ isset($post) ? $post->description : "" }}</textarea>
                </div>
                @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="content">Content</label>
                    <input id="content" value="{{ isset($post) ? $post->content : "" }}" type="hidden" name="content">
                    <trix-editor input="content"></trix-editor>
                </div>
                @error('content')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                {{-- <div class="form-group">
                    <label for="published_at">Published at</label>
                    <input type="text" name="published_at" class="form-control" id="published_at" value="{{ isset($post) ? $post->published_at : "" }}">
                </div>
                @error('published_at')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror --}}
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" id="" value="{{ isset($post) ? $post->image : "" }}">

                </div>
                @if (isset($post))
                    <img src="/storage/{{ $post->image }}" height="150" width="150">
                @endif
                @error('image')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category" id="" class="form-control">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                @if (isset($post))
                                    @if($category->id === $post->category->id)
                                        selected
                                    @endif
                                @endif >
                                 {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('category')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                @if ($tags->count() > 0)
                <div class="form-group">
                    <label for="tags">Tags</label>
                    <select name="tags[]" id="" class="form-control select_tag" multiple>
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}"
                                @if(isset($post))
                                    @if (in_array($tag->id, $post->tags->pluck('id')->toArray()))
                                        selected
                                    @endif
                                @endif
                                > {{ $tag->name }} </option>
                        @endforeach
                    </select>
                </div>
                @endif
                @error('tags')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <button class="btn btn-success">
                        {{ isset($post) ? "Edit Post" : "Add Post"}}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.3/trix.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        flatpickr('#published_at', {
            enableTime: true,
            enableSeconds: true
        });

        $(document).ready(function() {
            $('.select_tag').select2();
        });
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.3/trix.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection
