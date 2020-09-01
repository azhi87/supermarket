@extends('layouts.master')
@section('content')
<div class="row h3 mx-auto bg-primary">
    Updaing drugs in this section are auto saved
</div>
<div class="row">
    <div class="col-md-6">@livewire('add-manufacturer')</div>
    <div class="col-md-6"></div>
</div>

@foreach ($items as $item)
@livewire('update-drug',['item' => $item], key($item->id))
@endforeach
{{ $items->links() }}
@endsection