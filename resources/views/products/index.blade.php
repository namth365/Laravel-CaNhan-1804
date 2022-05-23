@extends('layouts.dashboard')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List Product</h3>
            <div align="right">
                @permission('product-create')
                <button type="button" name="create_product" id="create_product" data-route-store="{{ route('products.store') }}" class="btn btn-primary create_product">Create Product</button>
                @endpermission
            </div>
        </div>
        <!-- /.card-header -->
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
            <div class="container-fluid py-1 px-3">
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        <form action="{{ route('products.index') }}" method="GET" id="list-products">
                            <div class="input-group input-group-outline">
                                <input type="text" name="name" class="form-control" placeholder="name" value="{{ isset($_GET['name']) ? $_GET['name'] : '' }}">
                                <input type="text" name="price" class="form-control" placeholder="price"value="{{ isset($_GET['price']) ? $_GET['price'] : 0 }}">
                                <select class="form-control" name="category_name" style="text-align: left" aria-label="Default select example">
                                    <option value="">All</option>
                                    @foreach($categories as $category)
                                        <option  value="{{ $category->name }}" {{ (isset($_GET['category_name']) && ($_GET['category_name'] == $category->name)) ? 'selected' : '' }}>{{$category->name}}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary">search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive p-0">
                <table id="user_table" class="table align-items-center mb-0">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)
                        <tr id="product_id_{{ $product->id }}">
                            <td>{{ $product->id }}</td>
                            <td><img src="{{ '/thumbnail/' . $product->image }}" class="img-thumbnail" width="150" alt=""></td>
                            <td>{{ $product->name }}</td>
                            <td>{{$product->price}}/đ</td>
                            <td>{{ $product->description }}</td>
                            <td>
                                @foreach($product->categories as $category)
                                    <span style="padding: 3px; border-radius: 10px" class="bg-green">{{ $category->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @permission('product-edit')
                                <a href="javascript:void(0)" data-id="{{ $product->id }}" data-route-edit="{{ route('products.edit', $product->id) }}" data-route-update="{{ route('products.update', $product->id) }}" id="edit-product" class="btn btn-block btn-warning edit-product" style="margin-bottom: 11px">Edit</a>
                                @endpermission
                                @permission('product-delete')
                                <div method="POST" >
                                    @csrf
                                    @method('DELETE')
                                    <a href="javascript:void(0)" data-id="{{ $product->id }}" data-route-destroy="{{ route('products.destroy', $product->id) }}" id="delete-product" class="btn btn-block btn-danger delete-product" style="margin-bottom: 11px" onclick=" return confirm('are you sure ?')">Delete</a>
                                </div>
                                @endpermission
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $products->withQueryString()->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
    </div>
    @include('products.modal')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="{{ asset('/js/Product/demoproduct.js') }}"></script>
    <script src="{{ asset('/js/Product/script.js') }}"></script>
@endsection

