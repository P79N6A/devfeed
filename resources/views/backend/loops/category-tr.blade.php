<tr>
    <td><input id="cb-{{$item->id}}" type="checkbox" value="{{ $item->id }}"></td>
    <td>{{ str_repeat("--", $item->depth) }} {{ $item->title }}</td>
    <td>{{ $item->description }}</td>
    <td>{{ $item->slug }}</td>
    <td>{{ $item->count }}</td>
</tr>
@foreach($item->children as $subItem)
    @include('backend.loops.category-tr', ['item'=>$subItem])
@endforeach