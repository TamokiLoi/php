@extends('admin.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <a href="{{ route('admin.product.create') }}" class="btn btn-primary">Add New Product</a>
                </div>
                <br>
                <div class="card">
                    <div class="card-header">
                        <h3 style="margin: 0px;">List Products</h3>
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
                                    <th>Date Updated</th>
                                    <th>Options</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->code }}</td>
                                        <td>{{ $product->sale_price }}</td>
                                        <td>{{ $product->quantity }}</td>
                                        <td>{{ $product->image }}</td>
                                        <td>{{ $product->user->name }}</td>
                                        <td>{{ $product->updated_at }}</td>
                                        <td>
                                            <a href="{{ route('admin.product.show', ['id' => $product->id]) }}"
                                               class="btn btn-primary"><i class="far fa-edit"></i></a>
                                            <a href="{{ route('admin.product.delete', ['id' => $product->id]) }}"
                                               class="btn btn-danger" onclick="event.preventDefault();
                                                    document.getElementById('product-delete-{{ $product->id }}').submit();">
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