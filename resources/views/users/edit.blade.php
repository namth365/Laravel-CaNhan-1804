@extends('layouts.dashboard')
@section('content')
<div class="page-header ">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 ms-lg-auto me-lg-12">
                <div class="card card-plain">
                    <div class="card-header bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3" style="text-align: center;">
                        <h4 class="font-weight-bolder">Edit User</h4>
                    </div>
                    <div class="card-body card my-4">
                        <form action="{{ route('users.update',$users->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="input-group input-group-outline mb-3">
                                <label class="form-label" for="name">Name:</label>
                                <input type="text" name="name" class="form-control" value="{{$users->name}}" placeholder="Enter name">
                            </div>
                            <span class="text-danger">
                                @error('name')
                                {{$message}}
                                @enderror
                            </span>
                            <div class="form-group">
                                <label for="email">Email address:</label>
                                <input type="email" name="email" class="form-control" value="{{$users->email}}" disabled="">
                            </div>
                            <span class="text-danger">
                                @error('email')
                                {{$message}}
                                @enderror
                            </span>
                            <input type="checkbox" id="changePassword" name="changePassword">
                            <label>Change Password</label>
                            <div class="input-group input-group-outline mb-3">
                                <label class="form-label" for="pwd">Password:</label>
                                <input type="password" name="password" class="form-control password" disabled="" id="pwd">
                            </div>
                            <span class="text-danger">
                                @error('password')
                                {{$message}}
                                @enderror
                            </span>
                            <div class="input-group input-group-outline mb-3">
                                <label class="form-label" for="pwd">Password again:</label>
                                <input type="password" name="password_confirmation" class="form-control password" disabled="" id="pwd">
                            </div>
                            @permission('')
                            <label class="form-label" for="pwd">Role:</label>
                            <select class="form-select form-group" name="role" style="text-align: left" aria-label="Default select example">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ ($users->roles->contains('id', $role->id)) ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @endpermission
                            <div class="text-center">
                                <button type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Update</button>
                                <a href="{{ route('users.index') }}" class="btn btn-lg bg-gradient-info btn-lg w-100 mt-4 mb-0">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#changePassword').change(function() {
        if ($(this).is(":checked")) {
            $(".password").removeAttr('disabled');
        } else {
            $(".password").attr('disabled', '');
        }
    });
</script>
@endsection
