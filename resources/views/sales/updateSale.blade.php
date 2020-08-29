@extends('layouts.master')
@section('content')
<style>
	.table td,
	.card .table td,
	.card .dataTable td {
		padding: 0px 8px;
		vertical-align: middle;
	}

	.table th,
	.card .table th,
	.card .dataTable th {
		padding: 5px 8px;
		vertical-align: middle;
	}

	.select2-results {
		max-height: 150px;
	}
</style>
@include('sales.header')
<div class="row">
	<div class="col-sm-12">
		<div class="card card-topline-green">
			<div class="card-body bg-light">
				<form action='{{ route('store-sale',$sale->id) }}' method='post' role="form">
					<div class="card-body" id="bar-parent">
						{{csrf_field()}}
						<div class="row">
							<div class="form-group col-md-3 has-success">
								<div class="input-group ">
									<span class="input-group-addon"><strong>Total</strong></span>
									<input type="double" min="0" id="total" name="total" readonly
										value="{{ abs($sale->total + $sale->discount) }}" class="form-control"
										onkeyup="getSaleTotalPrice();" onblur="getSaleTotalPrice();">
									<span class="input-group-addon">IQD</span>
								</div>
							</div>
							<div class="form-group col-md-3 has-success">
								<div class="input-group ">
									<span class="input-group-addon">Discount</span>
									<input type="number" step="250" min="0" value="{{ $sale->discount }}" id="discount"
										name="discount" class="form-control " onkeyup="getSaleTotalPrice();"
										onblur="getSaleTotalPrice();">
									<span class="input-group-addon">IQD</span>
								</div>
							</div>
							<div class="form-group col-md-4 has-warning">
								<div class="input-group ">
									<span class="input-group-addon">Gran Total</span>
									<input type="double" min="0" id="grandTotal" value="{{ abs($sale->total) }}"
										style="font-weight: bold;" class="form-control text-danger" readonly
										onkeyup="getSaleTotalPrice();" onblur="getSaleTotalPrice();">
									<span class="input-group-addon">IQD</span>
								</div>
							</div>
							<div class="form-group col-md-3 has-success hidden">
								<div class="input-group">
									<span class="input-group-addon">Note</span>
									<input id="description" name="description" value="{{$sale->description}}"
										class="form-control ">
									<input type="hidden" id="rate" name="rate" value="{{$rate->rate}}"
										class="form-control ">
								</div>
							</div>
							<div class="form-group col-md-2 has-success">
								<div class="input-group ">
									<span class="input-group-addon"><strong>Type</strong></span>
									<select required="required" name="type" class="form-control">
										<option value="{{$sale->type}}" selected>{{$sale->type}}</option>
										@if( $sale->type=='sale' )
										<option value="sale" selected>Sale</option>
										<option value="returned_sale">Return</option>
										@else
										<option value="sale">Purchase</option>
										<option value="returned_sale" selected>Return</option>
										@endif
									</select>
								</div>
							</div>



							@include('layouts.errorMessages')
							<div class="table-scrollable table-fixed">
								<table class="table table-bordered text-center table-scrollable" id="repeatedSale">
									<thead class="bg-info text-light">
										<tr>
											<th>No.</th>
											<th width="30%">Barcode</th>
											<th>Price IQD</th>
											<th>Packs</th>
											<th>Sheets</th>
											<th>Sheets Per Pack</th>
											<th>Subtotal</th>
											<th>Expire date</th>
											<th>Remove</th>
										</tr>
									</thead>

									<?php $i = 0; ?>
									@foreach ($sale->items as $item)
									<tr id="{{$i}}">
										<td>
											<span class="badge badge-danger">{{$i+1}}</span>
										</td>
										<td>
											<select id="barcode{{$i}}" type="text" name="item[barcode][{{$i}}]"
												onchange="getSaleItemPrice(this.value,this.id)"
												onblur="getSaleItemPrice(this.value,this.id)"
												class="form-control select3">

												<option value="{{$item->id}}" selected="selected">
													{{$item->name}}
												</option>

											</select>
										</td>
										<td>
											<input type="number" step="250" onkeyup="getSaleTotalPrice();"
												onblur="getSaleTotalPrice();" value={{$item->pivot->ppi}}
												name="item[ppi][{{$i}}]" id="ppi{{$i}}" class="form-control " required>
										</td>
										<td>
											<input type="number" step="1" onkeyup="getSaleTotalPrice();"
												onblur="getSaleTotalPrice();" id="quantity{{$i}}"
												value={{$item->pivot->quantity}} name="item[quantity][{{$i}}]"
												class="form-control" required>
										</td>
										<td>
											<input type="number" step="1" id="singles{{$i}}"
												value={{$item->pivot->singles}} name="item[singles][{{$i}}]"
												class="form-control " onkeyup="getSaleTotalPrice();"
												onblur="getSaleTotalPrice();" required>
										</td>
										<td>
											<span name="item[items_per_box][{{$i}}]" id="items_per_box{{$i}}"
												class="badge badge-primary">{{$item->items_per_box}}</span>
										</td>
										<td>
											<span class="badge badge-primary"
												id="subtotal{{$i}}">{{number_format((($item->pivot->singles / $item->items_per_box) + ($item->pivot->quantity))*$item->pivot->ppi,0)}}</span>
										</td>
										<td width="175px;">
											<select name="item[exp][{{$i}}]" id="exp{{$i}}" class="form-control"
												required>
												<option>{{$item->pivot->exp}}</option>
											</select>
											<input type="hidden" name="item[batch_no][{{ $i }}]"
												value="{{ $item->pivot->batch_no }}" id="batch_no{{ $i }}" /> </td>
										<td>
											<button class="btn btn-danger btn-circle" type="button"
												onclick="removeItem({{ $i }})">
												<i caption="delete" class="fa fa-minus-circle fa-1x"></i></button>
										</td>
									</tr>

									<?php $i++; ?>
									@endforeach

								</table>
							</div>
						</div>
					</div>

					<div class="no-print text-center">
						<input type="hidden" value="{{$i-1}}" id="howManyItems" name="howManyItems" />
						<button class="btn-lg btn-info btn-circle" type="button" onclick="addSaleItem()">
							<i caption="Add" class="fa fa-plus-circle fa-1x"></i></button>
					</div>
					<br>
					<div class="text-center no-print">
						<button name="save-print" class="btn-lg btn-info" type="submit">
							<i caption="Add" class="fa fa-print"></i>&nbsp;&nbsp;&nbsp;Print&nbsp;&nbsp;&nbsp;</button>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<button name="save" class="btn-lg btn-primary" type="submit">
							<i caption="Add"
								class="fa fa-save fa-1x">&nbsp;&nbsp;&nbsp;Save&nbsp;&nbsp;&nbsp;</i></button>

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