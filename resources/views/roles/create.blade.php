@extends('layouts.dashboard')
@section('content')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Create Roles </h6>
                        </div>
                        <div class="pull-left">
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <form action="{{ route('roles.store') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-lable">Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Enter role name"value="{{ isset($_GET['name']) ? $_GET['name'] : '' }}">
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <label>Permission</label>
                                    <div class="row">
                                        @foreach($permissions as $permission)
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="{{$permission->id}}" name="permission[]">
                                                    <label class="form-check-label">{{$permission->name}}</label>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer" style="text-align: center">
                                    <a action="{{ route('roles.store') }}"> <button type="submit" class="btn btn-primary"> Create</button></a>
                                    <button type="reset" class="btn btn-danger">reset </button>
                                    <a href="{{route('roles.index')}}"><button type="button" class="btn btn-info ">Back</button></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
</main>
@endsection
