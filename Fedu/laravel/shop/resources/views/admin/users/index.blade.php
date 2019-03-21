@extends('admin.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <a href="{{ route('admin.user.create') }}" class="btn btn-primary">Add New User</a>
                </div>
                <br>
                <div class="card">
                    <div class="card-header">
                        <h3 style="margin: 0px;">List Users</h3>
                    </div>
                    <div class="card-body">
                        @if(session('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Date Created</th>
                                <th>Date Updated</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>{{ $user->updated_at }}</td>
                                    <td>
                                        <a href="{{ route('admin.user.show', ['id' => $user->id]) }}"
                                           class="btn btn-primary"><i class="far fa-edit"></i></a>
                                        <a href="{{ route('admin.user.delete', ['id' => $user->id]) }}"
                                           class="btn btn-danger" onclick="event.preventDefault();
                                                document.getElementById('user-delete-{{ $user->id }}').submit();">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        <form action="{{ route('admin.user.delete', ['id' => $user->id]) }}"
                                              method="POST" id="user-delete-{{ $user->id }}">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No data</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12 center">
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection