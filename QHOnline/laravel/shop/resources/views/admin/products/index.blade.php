@extends('admin.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3">
                            <h3 style="margin: 0px; font-weight: bold;">List Products</h3>
                        </div>
                        <div class="col-md-9 text-right">
                            <a href="{{ route('admin.product.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                                Add New Product
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding-bottom: 0;">
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
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Sale Price</th>
                                    <th>Quantity</th>
                                    <th>Image</th>
                                    <th>Author</th>
                                    <th>Category</th>
                                    <th>Date Updated</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                <tr>
                                    <td class="align-middle">{{ $product->id }}</td>
                                    <td class="align-middle">{{ $product->name }}</td>
                                    <td class="align-middle">{{ $product->code }}</td>
                                    <td class="align-middle">{{ $product->sale_price }}</td>
                                    <td class="align-middle">{{ $product->quantity }}</td>
                                    <td class="text-center align-middle">
                                        @if ($product->image &&
                                        file_exists(public_path(get_thumbnail("uploads/$product->image"))))
                                        <img src="{{ asset(get_thumbnail("uploads/$product->image")) }}" alt="image"
                                            class="img-fluid img-thumbnail" width="100" height="75">
                                        @else
                                        <img src="{{ asset('images/no-img.png') }}" alt="no image"
                                            class="img-fluid img-thumbnail" width="100" height="75">
                                        @endif
                                    </td>
                                    <td class="align-middle">{{ $product->user->name }}</td>
                                    <td class="align-middle">{{ $product->category->name }}</td>
                                    <td class="align-middle" style="padding: 0 0 0 5px; width: 155px;">{{ $product->updated_at }}</td>
                                    <td class="text-center align-middle" style="padding: 0; width: 100px;">
                                        <a href="{{ route('admin.product.show', ['id' => $product->id]) }}"
                                            class="btn btn-primary"><i class="far fa-edit"></i></a>
                                        <a href="{{ route('admin.product.delete', ['id' => $product->id]) }}"
                                            class="btn btn-danger"
                                            onclick="event.preventDefault();
                                               window.confirm('Bạn có chắc chắn xóa sản phẩm này không?') ? 
                                                    document.getElementById('product-delete-{{ $product->id }}').submit() : 0;">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        <form action="{{ route('admin.product.delete', ['id' => $product->id]) }}"
                                            method="POST" id="product-delete-{{ $product->id }}">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8">No data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div style="margin: 0 30%;">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection