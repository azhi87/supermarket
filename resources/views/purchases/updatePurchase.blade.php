@extends('layouts.master')
@section('content')
<style>
	.table td,
	.card .table td,
	.card .dataTable td{
		padding: 0px 8px;
		vertical-align: middle;
	}

	.table th,
	.card .table th,
	.card .dataTable th{
		padding: 5px 8px;
		vertical-align: middle;
	}
	.select2-results {
		max-height: 150px;
	}
</style>
@include('purchases.header')
<div class="row">
	<div class="col-sm-12">
		<div class="card card-topline-green">
			<div class="card-body bg-light">
			<form action='{{ route('store-purchase', $purchase->id )}}' method='post' role="form">
					<div class="card-body" id="bar-parent">
						{{csrf_field()}}
						<div class="row">
							<div class="form-group col-md-3 col-sm-3 has-success ">
								<div class="input-group ">
									<span class="input-group-addon"><strong>Invoice No.</strong></span>
									<input required="required" value="{{$purchase->invoice_no}}" type="text" name="invoice_no" class="form-control">
								</div>
							</div>
							<div class="form-group col-md-3 col-sm-3 has-success ">
								<div class="input-group has-success">
									<span class="input-group-addon"><strong>Total Price</strong></span>
									<input required="required" value="{{$purchase->total}}" type="text" id="total" name="total" class="form-control" readonly>
									<span class="input-group-addon">$</span>
								</div>
							</div>
							<div class="form-group col-md-3 col-sm-3 has-success">
								<div class="input-group">
									<span class="input-group-addon"><strong>Supplier</strong></span>
									<select required="required" type="text" name="supplier_id" class="form-control">
										<option value='{{$purchase->supplier_id}}'>{{$purchase->supplier->name}}</option>
										@foreach ($suppliers as $supplier)
										<option value='{{$supplier->id}}'>{{$supplier->name}}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="form-group col-md-3 has-warning">
								<div class="input-group">
									<span class="input-group-addon"><strong>Type</strong></span>
									<select required="required" name="type" class="form-control">
											<option value="{{$purchase->type}}" selected>{{$purchase->type}}</option>
										<!--@if( $purchase->type=='purchase')-->
										<!--	<option value="purchase" selected>Purchase</option>-->
										<!--	<option value="returned_purchase" >Return</option>-->
										<!--@else-->
										<!--	<option value="purchase">Purchase</option>-->
										<!--	<option value="returned_purchase" selected>Return</option>-->
										<!--@endif-->
									</select>
								</div>
							</div>

						    <div class="form-group col-md-12 col-sm-12 has-success ">
								<div class="input-group ">
									<span class="input-group-addon"><strong>Note</strong></span>
									<input  type="text" name="note" value="{{$purchase->note}}" class="form-control ">
								</div>
							</div>
								
						</div>
					</div>

					<select id="allItems" class="hidden">
						<option value="0"></option>
						@foreach ($drugs as $item)
						<option value="{{$item->id}}">{{$item->name}}</option>
						@endforeach
					</select>

					@include('layouts.errorMessages')
					<div class="table-scrollable table-fixed">
						<table class="table table-bordered text-center" id="repeatedSale">
							<thead class="bg-info text-light">
								<tr class="text-center">
									<th>No.</th>
									<th width="25%">Barcode (Name)</th>
									<th>Purchase Price ($)</th>
									<th>Sale Price(PerPack IQD)</th>
									<th>Packs</th>
									<th>Bonus (packs)</th>
									<th>Subtotal</th>
									<th>Expire date</th>
									<th>Remove</th>
								</tr>
							</thead>

							<?php $i = 0; ?>
							@foreach ($purchase->items as $item)
							<tr id="{{$i}}">

								<td>
									<span class="badge badge-danger">{{$i+1}}</span>
								</td>
								<td>
									<select id="barcode{{$i}}" type="text" name="barcode{{$i}}" onchange="getPurchaseItemPrice(this.value,this.id)" onblur="getPurchaseItemPrice(this.value,this.id)" class="form-control select2">
										<option value="0"></option>
										@foreach ($drugs as $drug)
										@if($drug->id==$item->id)
										<option value="{{$drug->id}}" selected="selected">{{$drug->name}}</option>
										@else
										<option value="{{$drug->id}}">{{$drug->name}}</option>
										@endif
										@endforeach
									</select>
								</td>
								<td>
									<input type="number" step="0.01" value="{{$item->pivot->ppi}}" name="ppi{{$i}}" id="ppi{{$i}}" onkeyup="getPurchaseTotalPrice();" onblur="getPurchaseTotalPrice();" class="form-control" required>
								</td>
								<td>
									<input type="number" step="250" value="{{$item->sale_price_id}}" name="sppi{{$i}}" id="sppi{{$i}}" onkeyup="getPurchaseTotalPrice();" onblur="getPurchaseTotalPrice();" class="form-control" required>
								</td>
								<td>
									<input type="number" step="1" value="{{$item->pivot->quantity}}" id="quantity{{$i}}" name="quantity{{$i}}" class="form-control" onkeyup="getPurchaseTotalPrice();" onblur="getPurchaseTotalPrice();" required>
								</td>
								<td>
									<input type="number" step="1" value="{{$item->pivot->bonus}}" id="bonus{{$i}}" name="bonus{{$i}}" class="form-control" onkeyup="getPurchaseTotalPrice();" onblur="getPurchaseTotalPrice();" required>
								</td>
								<td>
									<span class="badge badge-primary" id="subtotal{{$i}}">{{number_format((($item->pivot->singles / $item->items_per_box) + ($item->pivot->quantity))*$item->pivot->ppi,0)}}</span>
								</td>
								<td>
									<input type="date" value="{{$item->pivot->exp}}" name="exp{{$i}}" id="exp{{$i}}" class="form-control text-right">
								</td>
								<td>
									<button class="btn btn-danger btn-circle" type="button" onclick="removeItem({{$i}})">
										<i caption="delete" class="fa fa-minus-circle fa-1x"></i></button>
								</td>
							</tr>
							<?php $i++; ?>
							@endforeach
						</table>
					</div>
					<div class="no-print text-center">
						<input type="hidden" value="{{$i}}" id="howManyItems" name="howManyItems" />
						<button class="btn-lg btn-info btn-circle" type="button" onclick="addItem()">
							<i caption="Add" class="fa fa-plus-circle fa-1x"></i></button>
					</div>
					<br>
					<div class="text-center no-print">
						<input type="submit" name="submit" value="Save" class="btn-primary text-center btn-lg btn-block" />
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
@section('afterFooter')

<script>
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$(document).ready(function() {
		$('.select3').select2({
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

	});
</script>
@endsection