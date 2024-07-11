<div class="d-flex align-items-center">
    <div class="d-flex flex-column">
        <a href="{{route('products.show', $row->id)}}" class="mb-1 text-decoration-none">{{$row->name}}</a>
        <span>Code : {{$row->code}}</span>
    </div>
</div>
