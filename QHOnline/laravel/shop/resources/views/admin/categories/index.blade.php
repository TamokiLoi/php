@extends('admin.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3">
                            <h3 style="margin: 0px; font-weight: bold;">List Categories</h3>
                        </div>
                        <div class="col-md-9 text-right">
                            <a href="{{ route('admin.category.create') }}" class="btn btn-primary">Add New Category</a>
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
                                    <th>Slug</th>
                                    <th>Order</th>
                                    <th>Parent</th>
                                    <th>Date Created</th>
                                    <th>Date Updated</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td class="text-center">{{ $category->order }}</td>
                                    <td class="text-center">{{ $category->parent }}</td>
                                    <td>{{ $category->created_at }}</td>
                                    <td>{{ $category->updated_at }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.category.show', ['id' => $category->id]) }}"
                                            class="btn btn-primary"><i class="far fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.category.delete', ['id' => $category->id]) }}"
                                            class="btn btn-danger"
                                            onclick="event.preventDefault();
                                            window.confirm('Bạn có chắc chắn xóa chuyên mục này không?') ? 
                                            document.getElementById('category-delete-{{ $category->id }}').submit() : 0;">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                        <form action="{{ route('admin.category.delete', ['id' => $category->id]) }}"
                                            method="POST" id="category-delete-{{ $category->id }}">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div style="margin: 0 30%;">
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection