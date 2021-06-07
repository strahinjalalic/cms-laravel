@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">My profile</div>
                <div class="card-body">
                <form action="{{ route('users.update-profile') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" id="">
                    </div>
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="about">About me</label>
                        <textarea name="about" id="" cols="30" rows="6" class="form-control"> {{ $user->about }} </textarea>
                    </div>
                    @error('about')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="btn btn-success">Update Profile</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
