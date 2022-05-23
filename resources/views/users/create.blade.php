@extends('layouts.dashboard')
@section('content')
<div class="page-header ">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 ms-lg-auto me-lg-12">
                <div class="card card-plain">
                    <div class="card-header bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3" style="text-align: center;">
                        <h4 class="font-weight-bolder">Create User</h4>
                    </div>
                    <div class="card-body card my-4">
                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf
                            <div class="input-group input-group-outline mb-3">
                                <label class="form-label" for="name">Name:</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group input-group-outline mb-3">
                                <label class="form-label" for="email">Email address:</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group input-group-outline mb-3">
                                <label class="form-label" for="pwd">Password:</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @permission('')
                            <label for="pwd">Role:</label>
                            <select class="form-select form-group" name="role" style="text-align: left" aria-label="Default select example">
                                <option>--Select--</option>
                                @foreach($role as $rl)
                                <option value="{{$rl->id}}">{{$rl->name}}</option>
                                @endforeach
                            </select>
                            @endpermission
                            <div class="text-center">
                                <button type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Create</button>
                                <a href="{{ route('users.index') }}" class="btn btn-lg bg-gradient-info btn-lg w-100 mt-4 mb-0">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
