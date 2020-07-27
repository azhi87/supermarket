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
@include('sales.header')
<div class="row">
	<div class="col-sm-12">
		<div class="card card-topline-green">
			<div class="card-body bg-light">
				<form action='/sale/create' method='post' role="form" id="saleForm">
						{{csrf_field()}}
					<div class="card-body" id="bar-parent">
						<div class="row">
							<div class="form-group col-md-3 has-success">
								<div class="input-group ">
									<span class="input-group-addon"><strong>Total</strong></span>
									<input type="double" min="0" id="total" name="total" class="form-control" 
									 onkeyup="getSaleTotalPrice();" onblur="getSaleTotalPrice();" readonly>
								</div>
							</div>
							<div class="form-group col-md-3 has-success">
								<div class="input-group ">
									<span class="input-group-addon"><strong>Discount</strong></span>
									<input type="number" step="250" min="0" value="0" id="discount" name="discount"
									class="form-control" onkeyup="getSaleTotalPrice();" onblur="getSaleTotalPrice();">
								</div>
							</div>
							<div class="form-group col-md-4 has-success">
								<div class="input-group ">
									<span class="input-group-addon"><strong>Grand total</strong></span>
									<input type="double" min="0" id="grandTotal" name="grandTotal" class="form-control "
									onkeyup="getSaleTotalPrice();" onblur="getSaleTotalPrice();"  readonly>
								</div>
							</div>
							<div class="form-group col-md-3 has-success hidden">
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
									<tr>
										<td>
											<span class="badge badge-danger">1</span>
										</td>
										<td>
											<select id="barcode0" type="text" name="barcode0" onchange="getSaleItemPrice(this.value,this.id)" onblur="getSaleItemPrice(this.value,this.id)" class="form-control select3">
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
						<button class="btn-lg btn-info btn-circle" type="button" onclick="addSaleItem()">
							<i caption="Add" class="fa fa-plus-circle fa-1x"></i></button>
					</div>
					<br>
					<div class="text-center no-print">
                        <button name="save-print" class="btn-lg btn-info" type="submit" >
							<i caption="Add" class="fa fa-print"></i>&nbsp;&nbsp;&nbsp;Print&nbsp;&nbsp;&nbsp;</button>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <button  name="save" class="btn-lg btn-primary" type="submit" >
							<i caption="Add" class="fa fa-save fa-1x">&nbsp;&nbsp;&nbsp;Save&nbsp;&nbsp;&nbsp;</i></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection

@section('afterFooter')
@if(Session::has('sale-id'))
	<script>
		$(document).ready(function(){
			printExternal('{{ route('print-sale', session('sale-id')) }}');
	});
		
	</script>
@endif
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
				data: function(params) {
					return {
						_token: CSRF_TOKEN,
						search: params.term // search term
					};
				},
				processResults: function(response) {
					if (response.length == 1) {
						$("#barcode0").append($("<option />")
							.attr("value", response[0].id)
							.html(response[0].text)
						).val(response[0].id).trigger("change").select2("close");
					}
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