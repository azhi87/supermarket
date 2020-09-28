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
									<input required="required" type="text" id="total" name="total" class="form-control"
										readonly="readonly">
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

							<div class="form-group col-md-3 has-warning">
								<div class="input-group ">
									<span class="input-group-addon"><strong>Type</strong></span>
									<select required="required" name="type" class="form-control">
										<option value="purchase" selected>Purchase</option>
										<option value="returned_purchase">Return</option>
									</select>
								</div>
							</div>

							<div class="form-group col-md-12 col-sm-12 has-success ">
								<div class="input-group ">
									<span class="input-group-addon"><strong>Note</strong></span>
									<input type="text" name="note" class="form-control ">
								</div>
							</div>

						</div>
					</div>

					@include('layouts.errorMessages')
					<div class="table-scrollable table-fixed">
						<table class="table table-bordered text-center" id="repeatedSale">
							<thead class="bg-info text-light">
								<tr class="text-center">
									<th>No.</th>
									<th width="25%">Barcode (Name)</th>
									<th>Price ($)</th>
									<th>Sale Price(PerPack IQD)</th>
									<th>Packs</th>
									<th>Bonus (packs)</th>
									<th>Subtotal</th>
									<th>Expire date</th>
									<th>batch_no</th>
									<th>Remove</th>
								</tr>
							</thead>
							<tr>
								<td>
									<span class="badge badge-danger">1</span>
								</td>
								<td>
									<select id="barcode0" type="text" name="item[barcode][]"
										onchange="getPurchaseItemPrice(this.value,this.id)"
										onblur="getPurchaseItemPrice(this.value,this.id)" class="form-control select3">
									</select>
								</td>
								<td>
									<input type="number" step="0.01" min="0" onkeyup="getPurchaseTotalPrice();"
										onblur="getPurchaseTotalPrice();" name="item[ppi][]" id="ppi0"
										class="form-control " required>
								</td>
								<td>
									<input type="number" step="250" onkeyup="getPurchaseTotalPrice();"
										onblur="getPurchaseTotalPrice();" name="item[sppi][]" id="sppi0"
										class="form-control ">
								</td>
								<td>
									<input type="number" step="0.1" value="1" onkeyup="getPurchaseTotalPrice();"
										onblur="getPurchaseTotalPrice();" id="quantity0" name="item[quantity][]"
										class="form-control" required>
								</td>
								<td>
									<input type="number" step="1" id="bonus0" name="item[bonus][]" value="0"
										class="form-control" onkeyup="getPurchaseTotalPrice();"
										onblur="getPurchaseTotalPrice();" required>
								</td>
								<td>
									<span class="badge badge-primary" id="subtotal0"></span>
								</td>
								<td>
									<input type="date" name="item[exp][]" id="exp0" class="form-control " required>
								</td>
								<td>
									<input type="text" name="item[batch_no][]" id="batch_no0" class="form-control ">
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
						<button class="btn-lg btn-info btn-circle" type="button" onclick="addItem()">
							<i caption="Add" class="fa fa-plus-circle fa-2x"></i></button>
					</div>
					<br>
					<div class="text-center no-print">
						<input type="submit" name="submit" value="Save"
							class="btn-primary text-center btn-lg btn-block" />
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
			width: '100%',
			multiple: true,
			maximumSelectionLength : 1,
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