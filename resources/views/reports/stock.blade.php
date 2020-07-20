@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-topline-green">
                    <div class="card-head">
                        <header>Stock Report</header>
                    </div>
                    <div class="card-body ">
                        <div class="table-scrollable">
                            <table class="table text-center bg-light table-bordered">
                                <thead>
                                    <tr>
                                        <th>Barcode</th>
                                        <th>Name</th>
                                        <th>
                                            <table class="table table-bordered">
                                             	<tr class="text-center">
                                                <th>Expire</td>
                                                <th>Bought</td>
                                                <th>Sold</td>
                                                <th>Stock</td>
                                                </tr>
                                            </table>    
                                        </th>
                                    </tr>
                                </thead>
                                @foreach ($items->sortBy('category_id') as $item)

                                <tr class="text-center">

                                    <td>{{$item->barcode}}</td>
                                    <td width=""> {{$item->name}}</td>
                                    <td>
                                        @foreach ($item->expiryStock() as $exp)
                                        <table class="table table-bordered">
                                            <tr class="text-center">
                                                <td width="25%"><label class="label label-info label-mini">{{$exp->expp}}</label></td>
                                                <td width="25%"> <label class="text-primary"><strong>{{$exp->bought*$item->items_per_box}}</strong></td>
                                                <td width="25%"> <label class="text-success"><strong>{{$exp->sold*-1*$item->items_per_box}}<strong></td>
                                                <td width="25%"> <label class="text-danger"><strong>{{$exp->quantity*$item->items_per_box}}<strong></td>
                                            </tr>
                                        </table>
                                        @endforeach
                                    </td>
                                </tr>
                                @endforeach

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('afterFooter')
<script type="text/javascript">
    $(document).ready(function() {
        $("#menu-top li a").removeClass("menu-top-active");
        $('#report').addClass('menu-top-active');
    });
</script>
@endsection