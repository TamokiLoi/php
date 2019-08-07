@extends('admin.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div>
                <a href="{{ route('admin.product.index') }}" class="btn btn-primary">Back To List Products</a>
            </div>
            <br>
            <div class="card">
                <div class="card-header">
                    <h3 style="margin: 0px;">Create New Product</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                id="name" name="name" placeholder="Enter name Product" value="{{ old('name') }}">
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        </div>

                        <div class="form-group">
                            <label for="code">Code</label>
                            <input type="text" class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}"
                                id="code" name="code" placeholder="Enter code Product" value="{{ old('code') }}">
                            <div class="invalid-feedback">{{ $errors->first('code') }}</div>
                        </div>

                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea value="{{ old('content') }}" name="content" id="content" rows="5"
                                class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}"
                                placeholder="Enter content" style="resize: none;"></textarea>
                            <div class="invalid-feedback">{{ $errors->first('content') }}</div>
                        </div>

                        <div class="form-group">
                            <label for="regular_price">Regular Price</label>
                            <input type="number" min="0"
                                class="form-control {{ $errors->has('regular_price') ? 'is-invalid' : '' }}"
                                id="regular_price" name="regular_price" placeholder="Enter Regular Price"
                                value="{{ old('regular_price') }}">
                            <div class="invalid-feedback">{{ $errors->first('regular_price') }}</div>
                        </div>

                        <div class="form-group">
                            <label for="sale_price">Sale Price</label>
                            <input type="number" min="0"
                                class="form-control {{ $errors->has('sale_price') ? 'is-invalid' : '' }}"
                                id="sale_price" name="sale_price" placeholder="Enter Sale Price"
                                value="{{ old('sale_price') }}">
                            <div class="invalid-feedback">{{ $errors->first('sale_price') }}</div>
                        </div>

                        <div class="form-group">
                            <label for="original_price">Original Price</label>
                            <input type="number" min="0"
                                class="form-control {{ $errors->has('original_price') ? 'is-invalid' : '' }}"
                                id="original_price" name="original_price" placeholder="Enter Original Price"
                                value="{{ old('original_price') }}">
                            <div class="invalid-feedback">{{ $errors->first('original_price') }}</div>
                        </div>

                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" min="0"
                                class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" id="quantity"
                                name="quantity" placeholder="Enter Quantity" value="{{ old('quantity') }}">
                            <div class="invalid-feedback">{{ $errors->first('quantity') }}</div>
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}"
                                id="image" name="image" value="{{ old('image') }}" style="height: 42px;">
                            <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                        </div>

                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select name="category_id" id="category_id"
                                class="form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}">
                                @if (count($categories) > 0)
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                            <div class="invalid-feedback">{{ $errors->first('category_id') }}</div>
                        </div>

                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection