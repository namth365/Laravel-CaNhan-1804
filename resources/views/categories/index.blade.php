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
                            <form action="{{ route('categories.index') }}" method="GET">
                                <div class="input-group input-group-outline" style="width: 250px;">
                                    <input type="text" name="name" class="form-control float-right" placeholder="Name" value="{{ isset($_GET['name']) ? $_GET['name'] : '' }}">
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
                        @permission('category-create')
                        <a href="{{route('categories.create')}}"> <button type="button" class="btn btn-primary ">
                                Create
                            </button></a>
                        @endpermission
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Categories Management</h6>
                        </div>
                        <div class="pull-left">

                        </div>

                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Category Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Parent Category</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                        @if(isset($categories))
                                            <?php $_SESSION['i'] = 0; ?>
                                            @foreach($categories as $category)
                                                <?php $_SESSION['i']=$_SESSION['i']+1; ?>
                                                <tr>
<!--                                                    --><?php //$dash=''; ?><!-- -->
                                                    <td>{{ $category->id  }}</td>
                                                    <td>{{ $category->name }}</td>
                                                    <td>
                                                        @if(isset($category->parent_id))
                                                            {{$category->parent->name}}
                                                        @else
                                                            None
                                                        @endif
                                                    </td>
                                                        <td>
                                                                <form action="{{ route('categories.destroy', $category->id)}}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    @permission('category-delete')
                                                                    <button class="btn btn-link text-danger text-gradient px-3 mb-0" onclick=" return confirm('are you sure ?')"><i class="material-icons text-sm me-2">delete</i>Delete</button>
                                                                    @endpermission
                                                                    @permission('category-edit')
                                                                    <a class="btn btn-link text-dark px-3 mb-0" href="{{ route('categories.edit',$category->id) }}"><i class="material-icons text-sm me-2">edit</i>Edit</a>
                                                                    @endpermission
                                                                </form>
                                                        </td>
                                    </tr>
                                    @endforeach
                                            <?php unset($_SESSION['i']); ?>
                                        @endif
                                </tbody>
                            </table>

                        </div>

                    </div>

                </div>
                {{ $categories->links() }}
            </div>
        </div>
        </div>
</main>
@endsection
