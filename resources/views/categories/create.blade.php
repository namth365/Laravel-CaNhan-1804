@extends('layouts.dashboard')
@section('content')

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">

                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Roles Management</h6>
                        </div>
                        <div class="pull-left">

                        </div>

                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">

                            <form action="{{ route('categories.store') }}" method="POST">
                                @csrf
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Category name*</label>
                                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Category name" value="{{old('name')}}" required />
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Select parent category*</label>
                                                <select type="text" name="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
                                                    <option value="">None</option>
                                                    @if($categories)
                                                        @foreach($categories as $category)
                                                            <?php $dash=''; ?>
                                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                                                @if(count($category->children))
                                                                    @include('categories.sub_category_list_option',['subcategories' => $category->children])
                                                                @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('parent_id')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer" style="text-align: center">
                                    <button type="submit" class="btn btn-primary"> Create</button>
                                    <button type="reset" class="btn btn-danger">reset </button>
                                    <a href="{{route('categories.index')}}"><button type="button" class="btn btn-info ">Back</button></a>
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
