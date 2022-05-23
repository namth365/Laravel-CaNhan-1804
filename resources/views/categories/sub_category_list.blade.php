<?php $dash.='-- '; ?>
@foreach($subcategories as $subcategory)
    <?php $_SESSION['i']=$_SESSION['i']+1; ?>
    <tr>
        <td>{{$_SESSION['i']}}</td>
        <td>{{$dash}}{{$subcategory->name}}</td>
        <td>{{$subcategory->parent->name}}</td>
        <td>
            <a href="{{ route('categories.show', $subcategory->id) }}" class="btn btn-block btn-info" style="display: inline-block; width: 100px">Detail</a>
            <a href="{{ route('categories.edit', $subcategory->id) }}" class="btn btn-block btn-warning" style="margin-bottom: 9px; display: inline-block; width: 100px">Edit</a>
            <form action="{{ route('categories.destroy', $subcategory->id) }}" method="POST" style="display: inline-block; width: 100px">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-block btn-danger">Delete</button>
            </form>
        </td>
    </tr>
    @if(count($subcategory->children))
        @include('categories.sub_category_list',['subcategories' => $subcategory->children])
    @endif
@endforeach
