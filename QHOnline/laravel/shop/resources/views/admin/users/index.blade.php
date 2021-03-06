@extends('admin.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3">
                            <h3 style="margin: 0px; font-weight: bold;">List Users</h3>
                        </div>
                        <div class="col-md-9 text-right">
                            <a href="{{ route('admin.user.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                                Add New User
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding-bottom: 0;">
                    @if(session('message'))
                    <div class="alert alert-success" style="font-weight: bold">
                        {{ session('message') }}
                    </div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger" style="font-weight: bold">
                        {{ session('error') }}
                    </div>
                    @endif
                    <div class="table-responsive">
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
                                @forelse ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>{{ $user->updated_at }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.user.show', ['id' => $user->id]) }}"
                                            class="btn btn-primary"><i class="far fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.user.delete', ['id' => $user->id]) }}"
                                            class="btn btn-danger" onclick="event.preventDefault();
                                            window.confirm('Bạn có chắc chắn xóa người dùng này không?') ? 
                                            document.getElementById('user-delete-{{ $user->id }}').submit() : 0;">
                                            <i class="far fa-trash-alt"></i>
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
                                    <td colspan="5" class="text-center">No data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div style="margin: 0 30%;">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection