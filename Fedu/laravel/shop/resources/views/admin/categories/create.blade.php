@extends('admin.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <a href="{{ route('admin.category.index') }}" class="btn btn-primary">Back To List Categories</a>
                </div>
                <br>
                <div class="card">
                    <div class="card-header">
                        <h3 style="margin: 0px;">Create New Category</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.category.store') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                       id="name" name="name" placeholder="Enter name Category" value="{{ old('name') }}">
                                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                            </div>

                            <div class="form-group">
                                <label for="order">Priority</label>
                                <input type="order" class="form-control {{ $errors->has('order') ? 'is-invalid' : '' }}"
                                       id="order" name="order" placeholder="Enter Priority" value="{{ old('order') }}">
                                <div class="invalid-feedback">{{ $errors->first('order') }}</div>
                            </div>

                            <div class="form-group">
                                <label for="parent">Parent Category</label>
                                <select name="parent" id="parent" class="form-control {{ $errors->has('order') ? 'is-invalid' : '' }}">
                                    <option value="0">temp</option>
                                    @if (count($categories) > 0)
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('parent') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="invalid-feedback">{{ $errors->first('parent') }}</div>
                            </div>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection