<option value="{{ $item->id }}">{{str_repeat("　", $item->depth)}}{{ $item->title }}</option>
@foreach($item->children as $subItem)
    @include('backend.loops.category-option', ['item'=>$subItem])
@endforeach