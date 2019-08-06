@extends('admin.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div>
                <a href="{{ route('admin.category.index') }}" class="btn btn-primary">Back to List Categories</a>
            </div>
            <br>
            <div class="card">
                <div class="card-header">
                    <h3 style="margin: 0px; font-weight: bold;">Update Category</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.category.update', ['id' => $category->id]) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                id="name" name="name" placeholder="Enter Name" value="{{ $category->name }}">
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        </div>

                        <div class="form-group">
                            <label for="order">Priority</label>
                            <input type="order" class="form-control {{ $errors->has('order') ? 'is-invalid' : '' }}"
                                id="order" name="order" placeholder="Select Priority" value="{{ $category->order }}">
                            <div class="invalid-feedback">{{ $errors->first('order') }}</div>
                        </div>

                        <div class="form-group">
                            <label for="parent">Parent Category</label>
                            <select name="parent" id="parent"
                                class="form-control {{ $errors->has('parent') ? 'is-invalid' : '' }}">
                                <option value="0">empty</option>
                                @if (count($categories) > 0)
                                @foreach($categories as $sCategory)
                                <option value="{{ $sCategory->id }}"
                                    {{ $category->parent == $sCategory->id ? 'selected' : '' }}>{{ $sCategory->name }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                            <div class="invalid-feedback">{{ $errors->first('parent') }}</div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection