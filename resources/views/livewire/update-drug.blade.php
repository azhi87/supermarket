<div class="row border {{ $updated? 'border-success' : ''}}">
    @include('layouts.errorMessages')
    <div class="col">
        <span class="text-center text-muted">Barcode</span>
        <input type="text" class="form-control " id="horizontalFormEmail" wire:model.lazy='barcode'>
    </div>
    <div class="col">
        <span class="text-center text-muted">Name</span> <input type="text" class="form-control" wire:model.lazy='name'>
    </div>
    <div class="col">
        <span class="text-center text-muted">Scientific Name</span><input type="text" class="form-control"
            wire:model.lazy='name_en'>
    </div>
    <div class="col">
        <span class="text-center text-muted">Items Per box</span><input type="text" class="form-control"
            wire:model.lazy='items_per_box'>
    </div>
    <div class="col">
        <span class="text-center text-muted">Purchase Price $</span><input type="text" class="form-control"
            wire:model.lazy='purchase_price'>
    </div>
    <div class="col">
        <span class="text-center text-muted">Sale Price IQD</span><input type="text" class="form-control"
            wire:model.lazy='sale_price_id'>
    </div>

    <div class="col">
        <span class="text-center text-muted">Category</span>
        <select class="form-control" wire:model.lazy='category_id'>
            @foreach ($categories->sortby('category') as $cat)
            <option value="{{$cat->id}}">{{$cat->category}}</option>
            @endforeach
        </select>
    </div>
    <div class="col">
        <span class="text-center text-muted">Manufacturer</span>
        <select class="form-control" wire:model.lazy='manufacturer_id' required>
            <option></option>
            @foreach ($manufacturers->sortby('name') as $man)
            <option value="{{$man->id}}">{{$man->name}}</option>
            @endforeach
        </select>
    </div>
</div>