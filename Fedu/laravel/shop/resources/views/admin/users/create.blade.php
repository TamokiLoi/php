@extends('admin.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <a href="{{ route('admin.user.index') }}" class="btn btn-primary">Back To List Users</a>
                </div>
                <br>
                <div class="card">
                    <div class="card-header">
                        <h3 style="margin: 0px;">Create New User</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.user.store' }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('put') }}
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                       id="name" name="name" placeholder="Enter name" value="{{ old('name') }}">
                                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                            </div>

                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                       id="email" name="email" placeholder="Enter email" value="{{ old('email') }}">
                                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password"
                                       class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                       id="password" name="password" placeholder="Password">
                                <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Re-Password</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                       name="password_confirmation" placeholder="Re-Password">
                            </div>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection