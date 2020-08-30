<div class="col-md-5 col-sm-12">
    <div class="card card-topline-green">
        <div class="card-head">
            <header>Add an expired item</header>
        </div>
        <div class="card-body bg-light " id="bar-parent1">
            @include('layouts.errorMessages')
            <form class="form-horizontal" wire:submit.prevent='store'>
                <div class="form-group row">
                    <label class="col-sm-4 control-label">Barcode || Name</label>
                    <div class="col-sm-8" wire:ignore>
                        <select name="id" class="select3" wire:model="item_id"></select>
                    </div>
                    @error('barcode')
                    <p class="text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 control-label">Quantity</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" wire:model.lazy='quantity'>
                    </div>

                </div>
                <div class="form-group row">
                    <label class="col-sm-4 control-label">Expiry Date</label>
                    <div class="col-sm-8">
                        <input type="date" readonly class="form-control" wire:model.lazy='exp'>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 control-label">Batch_no</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" wire:model.lazy='batch_no'>
                    </div>
                </div>

                <div class="form-group">
                    <div class="offset-md-3 col-md-9">
                        <button type="submit" class="btn btn-primary btn3d btn-block"><b>Save</b></button>
                    </div>
                </div>
            </form>
        </div>
    </div>



</div>



@section('afterFooter')
<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function() {
    $('.select3').select2({
    width: '100%',
    ajax: {
    url: "/drugs/searchAjax",
    type: "post",
    dataType: 'json',
    data: function(params) {
    return {
    _token: CSRF_TOKEN,
    search: params.term // search term
    };
    },
    processResults: function(response) {
    return {
    results: response
    };
    },
    cache: true
    }
    
    });
    $('.select3').on('change', function (e) {
    @this.set('barcode', e.target.value);
    });
    });

</script>
@endsection