<div id="formModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Product</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <span id="form_result"></span>
                <form method="POST" id="formSave" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="col-md-8" style="max-width: 100%">
                            <input type="hidden" name="id" id="id" class="form-control @error('id') is-invalid @enderror"/>
                        </div>
                        @error('id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" >Name : </label>
                        <div class="col-md-8" style="max-width: 100%">
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"/>
                        </div>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" >Price : </label>
                        <div class="col-md-8" style="max-width: 100%">
                            <input type="text" name="price" id="price" class="form-control @error('price') is-invalid @enderror"/>
                        </div>
                        @error('price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Description : </label>
                        <div class="col-md-8" style="max-width: 100%">
                            <input type="text" name="description" id="description"
                                   class="form-control @error('description') is-invalid @enderror"/>
                        </div>
                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-select form-group" name="parent_id">
                            @foreach($parent as $c)
                                <option value="{{$c->id}}">{{$c->name}}</option>
                                @if($c->children)
                                    @foreach($c->children as $cc)
                                        <option value="{{$cc->id}}">--{{$cc->name}}</option>
                                    @endforeach
                                @endif
                            @endforeach
                        </select>
                        @error('parent_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Select Image : </label>
                        <div class="col-md-8">
                            <input type="file" name="image" id="image" class="@error('image') is-invalid @enderror"/>
                            <span id="store_image"></span>
                        </div>
                        @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <br />
                    <div class="form-group" align="center">
                        <input type="hidden" name="action" id="action" />
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add"/>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
