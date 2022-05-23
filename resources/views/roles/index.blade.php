@extends('layouts.dashboard')
@section('content')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    <div class="input-group input-group-outline">
                        <div class="card-tools">
                            <form action="{{ route('roles.index') }}" method="GET">
                                <div class="input-group input-group-lg" style="width: 250px;">
                                    <input type="text" name="name" class="form-control " placeholder="Name" value="{{ isset($_GET['name']) ? $_GET['name'] : '' }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        @if(session('messenger'))
            <div class="alert alert-success">
                {{session('messenger')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        @permission('role-create')
                        <a href="{{route('roles.create')}}"> <button type="button" class="btn btn-primary ">Create</button></a>
                        @endpermission
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Roles Management</h6>
                        </div>
                        <div class="pull-left">
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">id</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $key => $role)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $role->id }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $role->name }}</p>
                                        </td>
                                        <div>
                                            <td class="align-middle">
                                                <form action="{{ route('roles.destroy', $role->id)}}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    @permission('role-delete')
                                                    <button class="btn btn-link text-danger text-gradient px-3 mb-0" onclick=" return confirm('are you sure ?')"><i class="material-icons text-sm me-2">delete</i>Delete</button>
                                                    @endpermission
                                                    @permission('role-edit')
                                                    <a class="btn btn-link text-dark px-3 mb-0" href="{{ route('roles.edit',$role->id) }}"><i class="material-icons text-sm me-2">edit</i>Edit</a>
                                                    @endpermission
                                                </form>
                                            </td>
                                        </div>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{ $roles->links() }}
            </div>
        </div>
    </div>
</main>
@endsection
