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
@include('sales.header')
<div class="row">
	<div class="col-sm-12">
		<div class="card card-topline-green">
			<div class="card-body bg-light">
				<form action='/sale/create' method='post' role="form" id="saleForm">
						{{csrf_field()}}
					<div class="card-body" id="bar-parent">
						<div class="row">
							<div class="form-group has-success">
								<div class="input-group ">
									<span class="input-group-addon"><strong>Total</strong></span>
									<input type="double" min="0" id="total" name="total" class="form-control ">
									<span class="input-group-addon">IQD</span>
								</div>
							</div>
							<div class="form-group has-success">
								<div class="input-group ">
									<span class="input-group-addon"><strong>Discount</strong></span>
									<input type="number" step="0.01" min="0" value="0" id="discout" name="discount" class="form-control ">
									<span class="input-group-addon">IQD</span>
								</div>
							</div>
							<div class="form-group col-md-3 has-success">
								<div class="input-group">
									<span class="input-group-addon"><strong>Note</strong></span>
									<input type="text" id="description" name="description" class="form-control ">
									<input type="hidden" id="rate" name="rate" value="{{$rate->rate}}" class="form-control ">
								</div>
							</div>

							<div class="form-group col-md-2 has-success">
								<div class="input-group ">
									<span class="input-group-addon"><strong>Type</strong></span>
									<select required="required" name="type" class="form-control">
										<option value="sale" selected>Sale</option>
										<option value="returned_sale" >Return</option>
									</select>
								</div>
							</div>

							@include('layouts.errorMessages')
							<div class="table-scrollable table-fixed">
								<table class="table table-bordered text-center table-scrollable " id="repeatedSale">
									<thead class="bg-success">
										<tr class="custom_centered">
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
									<tr>
										<td>
											<span class="badge badge-danger">1</span>
										</td>
										<td>
											<select id="barcode0" type="text" name="barcode0" onchange="getSaleItemPrice(this.value,this.id)" onblur="getSaleItemPrice(this.value,this.id)" class="form-control select2 select3">
												<option></option>
											</select>
										</td>
										<td>
											<input type="number" step="250" onkeyup="getSaleTotalPrice();" onblur="getSaleTotalPrice();" name="ppi0" id="ppi0" class="form-control " required>
										</td>
										<td>
											<input type="number" step="1" value="1" onkeyup="getSaleTotalPrice();" onblur="getSaleTotalPrice();" id="quantity0" name="quantity0" class="form-control" required>
										</td>
										<td>
											<input type="number" step="1" id="singles0" name="singles0" value="0" class="form-control " onkeyup="getSaleTotalPrice();" onblur="getSaleTotalPrice();" required>
										</td>
										<td>
											<span name="items_per_box0" id="items_per_box0" class="badge badge-primary"></span>
										</td>
										<td>
											<span class="badge badge-primary" id="subtotal0"></span>
										</td>
										<td>
											<select name="exp0" id="exp0" class="form-control " style="min-width: 150px;" required></select>
										</td>
										<td>
											<button class="btn btn-danger btn-circle" type="button">
												<i caption="delete" class="fa fa-minus-circle fa-1x"></i></button>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>

					<div class="no-print text-center">
						<input type="hidden" value="0" id="howManyItems" name="howManyItems" />
						<button class="btn-lg btn-success btn-circle" type="button" onclick="addSaleItem()">
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