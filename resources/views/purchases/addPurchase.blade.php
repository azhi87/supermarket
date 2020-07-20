@extends('layouts.master')
@section('content')
<style>
	.table td,
	.table th,
	.card .table td,
	.card .table th,
	.card .dataTable td,
	.card .dataTable th {
		padding: 0px 8px;
		vertical-align: middle;
	}

	.select2-results {
		max-height: 50px;
	}
</style>
@include('purchases.header')
<div class="row">
	<div class="col-sm-12">
		<div class="card card-topline-green">
			<div class="card-body bg-light">
				<form action='/purchase/create' method='post' role="form">
					<div class="card-body" id="bar-parent">
						{{csrf_field()}}
						<div class="row">
							<div class="form-group col-md-3 col-sm-3 has-success ">
								<div class="input-group ">
									<span class="input-group-addon"><strong>Invoice No.</strong></span>
									<input required="required" type="text" name="invoice_no" class="form-control ">
								</div>
							</div>
							<div class="form-group col-md-3 col-sm-3 has-success ">
								<div class="input-group has-success">
									<span class="input-group-addon"><strong>Total Price</strong></span>
									<input required="required" type="text" id="total" name="total" class="form-control" readonly="readonly">
									<span class="input-group-addon">$</span>
								</div>
							</div>
							
							<div class="form-group col-md-3 has-success">
								<div class="input-group ">
									<span class="input-group-addon"><strong>Supplier</strong></span>
									<select required="required" name="supplier_id" class="form-control">
										@foreach ($suppliers as $supplier)
										<option value="{{$supplier->id}}">{{$supplier->name}}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="form-group col-md-3 has-success">
								<div class="input-group ">
									<span class="input-group-addon"><strong>Type</strong></span>
									<select required="required" name="type" class="form-control">
										<option value="purchase" selected>Purchase</option>
										<option value="returned_purchase" >Return</option>
									</select>
								</div>
							</div>
							
						</div>
					</div>

					<select id="allItems" class="hidden">
						<option></option>
						@foreach ($drugs as $item)
						<option value="{{$item->id}}">{{$item->name}}</option>
						@endforeach
					</select>

					@include('layouts.errorMessages')
					<div class="table-scrollable table-fixed">
						<table class="table table-bordered text-center" id="repeatedSale">
							<thead class="bg-info">
								<tr class="custom_centered sm">
									<th>No.</th>
									<th width="30%">Barcode (Name)</th>
									<th>Purchase Price ($)</th>
									<th>Sale Price (Per Packet IQD)</th>
									<th>Packs</th>
									<th>Bonus (packs)</th>
									<th>Expire date</th>
									<th>Remove</th>
								</tr>
							</thead>
							<tr>
								<td>
									<span class="badge badge-danger">1</span>
								</td>
								<td>
									<select id="barcode0" type="text" name="barcode0" onchange="getPurchaseItemPrice(this.value,this.id)" onblur="getPurchaseItemPrice(this.value,this.id)" class="form-control select3">
										<option></option>
									</select>
								</td>
								<td>
									<input type="number" step="0.001" min="0" onkeyup="getPurchaseTotalPrice();" onblur="getPurchaseTotalPrice();" name="ppi0" id="ppi0" class="form-control " required>
								</td>
								<td>
									<input type="number" step="250" onkeyup="getPurchaseTotalPrice();" onblur="getPurchaseTotalPrice();" name="sppi0" id="sppi0" class="form-control ">
								</td>
								<td>
									<input type="number" step="0.1" value="1" onkeyup="getPurchaseTotalPrice();" onblur="getPurchaseTotalPrice();" id="quantity0" name="quantity0" class="form-control" required>
								</td>
								<td>
									<input type="number" step="1" id="bonus0" name="bonus0" value="0" class="form-control" onkeyup="getPurchaseTotalPrice();" onblur="getPurchaseTotalPrice();" required>
								</td>
								<td>
									<input type="date" name="exp0" id="exp0" class="form-control " required>
								</td>
								<td>
									<button class="btn btn-danger btn-circle" type="button">
										<i caption="delete" class="fa fa-minus-circle fa-1x"></i></button>
								</td>
							</tr>
						</table>
						<input type="hidden" id="singles0" />
						<span class="hidden" id="items_per_box0">0</span>
					</div>

					<div class="no-print text-center">
						<input type="hidden" value="0" id="howManyItems" name="howManyItems" />
						<button class="btn-lg btn-success btn-circle" type="button" onclick="addItem()">
							<i caption="Add" class="fa fa-plus-circle fa-2x"></i></button>
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
				delay: 250,
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