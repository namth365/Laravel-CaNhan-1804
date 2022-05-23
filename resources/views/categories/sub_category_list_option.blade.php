<?php $dash.='-- '; ?>
@foreach($subcategories as $subcategory)
    <option value="{{$subcategory->id}}">{{$dash}}{{$subcategory->name}}</option>
    @if(count($subcategory->children))
        @include('categories.sub_category_list_option',['subcategories' => $subcategory->children])
    @endif
@endforeach
