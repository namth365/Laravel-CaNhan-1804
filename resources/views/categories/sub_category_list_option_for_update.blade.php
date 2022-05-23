<?php /** @var TYPE_NAME $dash */
$dash.='-- '; ?>
@foreach($subcategories as $subcategory)
    @if($category->id != $subcategory->id )
        <option value="{{$subcategory->id}}" @if($category->parent_id == $subcategory->id ) selected @endif >
            {{$dash}}{{$subcategory->name}}
        </option>
    @endif
    @if(count($subcategory->children))
        @include('categories.sub_category_list_option_for_update',['subcategories' => $subcategory->children])
    @endif
@endforeach
