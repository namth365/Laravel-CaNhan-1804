@extends('layouts.dashboard')
@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    <form action="{{ route('users.index') }}" method="GET">
                        <div class="input-group input-group-outline">
                            <input type="text" name="name" class="form-control" placeholder="name" value="{{ isset($_GET['name']) ? $_GET['name'] : '' }}">
                            <input type="text" name="email" class="form-control" placeholder="email" value="{{ isset($_GET['email']) ? $_GET['email'] : '' }}">
                            <select class="form-control" name="role_name" style="text-align: left" aria-label="Default select example">
                                <option value="">All</option>
                                @foreach($roles as $role)
                                <option {{ (isset($_GET['role_name']) && ($_GET['role_name'] == $role->name)) ? 'selected' : '' }}>{{$role->name}}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary">search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
<div class="container-fluid py-6">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                @if(session('messenger'))
                    <div class="alert alert-success">
                        {{session('messenger')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <br>
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 col-12 d-flex align-items-center">
                        <h5 class="text-white text-capitalize ps-3" style="text-align: center;">Users Management</h5>
                        @permission('user-create')
                        <div class="col-10 text-end">
                            <a class="btn bg-gradient-dark mb-0" href="{{route('users.create')}}"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;User</a>
                        </div>
                        @endpermission
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10 ">Name</th>
                                    <th class="text-secondary text-uppercase  text-xxs font-weight-bolder opacity-10 ">Email</th>
                                    <th class="text-secondary text-uppercase  text-xxs font-weight-bolder opacity-10">Roles</th>
                                    <th width="20px" class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $key => $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold"> @foreach($user->roles as $role)
                                                <span style="padding: 3px; border-radius: 10px" class="bg-green">{{ $role->name }}</span>
                                            @endforeach</span>
                                    </td>
                                    <td>
                                        <div class="ms-auto text-end">
                                            <form action="{{ route('users.destroy', $user->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                @permission('user-delete')
                                                <button class="btn btn-link text-danger text-gradient px-3 mb-0" onclick=" return confirm('are you sure ?')"><i class="material-icons text-sm me-2">delete</i>Delete</button>
                                                @endpermission
                                                @permission('user-edit')
                                                <a class="btn btn-link text-dark px-3 mb-0" href="{{ route('users.edit',$user->id) }}"><i class="material-icons text-sm me-2">edit</i>Edit</a>
                                                @endpermission
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{$users->links()}}
        </div>
    </div>
</div>
    </main>
@endsection
