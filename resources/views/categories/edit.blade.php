@extends('layouts.dashboard')
@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4" >
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3" >
                            <h4 class="text-white text-capitalize ps-3">Edit Roles</h4>
                        </div>
                        <div class="pull-left">

                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">

                            <form action="{{ route('categories.update',$category->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>name</label>
                                        <input type="text" class="form-control" value="{{$category->name}}" name="name" placeholder="Enter  name">
                                    </div>
                                    <div class="form-group">
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Select parent category*</label>
                                                <select type="text" name="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
                                                    <option value="">None</option>
                                                    @if($categories)
                                                        @foreach($categories as $item)
                                                            <?php $dash=''; ?>
                                                            <option value="{{$item->id}}" @if($category->parent_id == $item->id ) selected @endif>{{$item->name}}</option>
                                                            @if(count($item->children))
                                                                @include('categories.sub_category_list_option_for_update',['subcategories' => $item->children])
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
                                    <button type="submit" class="btn btn-primary"> edit</button>
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
