@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <div class="card-header">Users</div>
        <div class="card-body">
            @if ($users->count() > 0)
                <table class="table">
                    <thead>
                        <th>Image</th>
                        <th>Name</th>
                        <th>E-mail</th>
                        <th>Role</th>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td><img style="border-radius: 50px;" src="{{ Gravatar::src($user->email) }}" alt=""></td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                @if(!$user->isAdmin())
                                    <td>
                                        <form action="{{ route('users.make-admin', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Make Admin</button>
                                        </form>
                                    </td>
                                @else
                                    <td>
                                        Admin
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h3 class="text-center">No Users</h3>
            @endif
        </div>
    </div>
@endsection
