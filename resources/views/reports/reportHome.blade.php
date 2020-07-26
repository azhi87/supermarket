@extends('layouts.master')
@section('content')
<div class="row">

	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="card card-topline-green">
			<div class="card-head bg-light">
				<header>Income</header>
			</div>
			<div class="card-body " id="bar-parent">
				<form method="POST" action="/reports/income" id="contact_form">
					{{csrf_field()}}
					<fieldset class="form-group">
						<label for="id">From</label>
						<input type="date" class="form-control" name="from">
					</fieldset>
					<fieldset class="form-group">
						<label for="formGroupExampleInput2">To</label>
						<input type="date" name="to" class="form-control" required>
					</fieldset>
					<div class="form-group">
						<div class="col-md-12">
							<button type="submit" class="btn btn-primary btn3d btn-block"><strong>Search</strong></button>
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
	<div class="col-md-3 col-sm-6 col-xs-12 hidden">
		<div class="card card-topline-green">
			<div class="card-head bg-light">
				<header>Money By Date</header>
				@include('layouts.errorMessages')
			</div>
			<div class="card-body " id="bar-parent">
				<form method="POST" action="/reports/profit" id="contact_form">
					{{csrf_field()}}
					<fieldset class="form-group">
						<label for="id">From</label>
						<input type="date" class="form-control" name="from">
					</fieldset>
					<fieldset class="form-group">
						<label for="formGroupExampleInput2">To</label>
						<input type="date" name="to" class="form-control" required>
					</fieldset>
					<div class="form-group">
						<div class="col-md-12">
							<button type="submit" class="btn btn-primary btn3d btn-block"><strong>Search</strong></button>
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
	
		<div class="col-md-3 col-sm-6 col-xs-12 ">
		<div class="card card-topline-green">
			<div class="card-head bg-light">
				<header>Search Stock</header>
				@include('layouts.errorMessages')
			</div>
			<div class="card-body " id="bar-parent">
				<form method="POST" action="{{ route('show-item-stock') }}" id="contact_form">
					{{csrf_field()}}
					<fieldset class="form-group" id="stock">
						<label for="formGroupExampleInput2">Barcode</label>
						<select name="barcode" id="" class="select3"></select>
					</fieldset>

					<div class="form-group">
						<div class="col-md-12">
							<button type="submit" class="btn btn-primary btn3d btn-block"><strong>Search</strong></button>
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>

	<div class="col-md-3 col-sm-6 col-xs-12  ">
		<div class="card card-topline-green">
			<div class="card-head bg-light">
				<header>Drug Transactions</header>
			</div>
			<div class="card-body " id="transaction">
				<fieldset class="form-group">
					<label for="formGroupExampleInput2">Barcode</label>
					<select name="id" class="select3"></select>
				</fieldset>
			</div>
		</div>
	</div>

	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="card card-topline-green">
			<div class="card-head bg-light">
				<header>Expirey Report</header>
				@include('layouts.errorMessages')
			</div>
			<div class="card-body " id="bar-parent">
				<form method="POST" action="/stock/expiry" id="contact_form">
					{{csrf_field()}}

					<fieldset class="form-group">
						<label for="formGroupExampleInput2">To</label>
						<input type="date" name="date" class="form-control" required>
					</fieldset>
					<div class="form-group">
						<div class="col-md-12">
							<button type="submit" class="btn btn-primary btn-block"><strong>Search</strong></button>
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>


	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="card card-topline-green">
			<div class="card-head bg-light">
				<header>Stock By Manufacturer</header>
				@include('layouts.errorMessages')
			</div>
			<div class="card-body " id="bar-parent">
				<form method="POST" action=" {{route('show-stock-byManufacturer')}}" id="contact_form">
					{{csrf_field()}}

					<fieldset class="form-group">
						<label for="formGroupExampleInput2">Manufacturer</label>
						<select class="form-control" name="manufacturer_id" required>
							@foreach($mans as $man)
							<option value="{{ $man->id }}"> {{ $man->name }} </option>
							@endforeach
						</select>
					</fieldset>
					<div class="form-group">
						<div class="col-md-12">
							<button type="submit" class="btn btn-primary btn-block"><strong>Search</strong></button>
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>


	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="card card-topline-green">
			<div class="card-head bg-light">
				<header>Item Popularity Report</header>
			</div>
			<div class="card-body " id="bar-parent">
				<a href="{{ route('show-popular-items') }}" class="btn btn-primary  btn3d btn-block"> Search </a>
			</div>
		</div>
	</div>

	<div class="col-md-3 col-sm-6 col-xs-12 ">
		<div class="card card-topline-green">
			<div class="card-head bg-light">
				<header>Debt Report</header>
				@include('layouts.errorMessages')
			</div>
			<div class="card-body " id="bar-parent">
				<form method="POST" action="{{ route('supplier-debt-report') }}" id="contact_form">
					{{csrf_field()}}
					<fieldset class="form-group">
						<label for="formGroupExampleInput2">Supplier</label>
						<select class="form-control" name="supplier_id">
							<option value="-1">All Suppliers</option>
							@foreach($suppliers as $supplier)
							<option value="{{ $supplier->id }}"> {{ $supplier->name }} </option>
							@endforeach
						</select>
					</fieldset>

					<div class="form-group">
						<div class="col-md-12">
							<button type="submit" class="btn btn-primary btn3d btn-block"><strong>Search</strong></button>
						</div>
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
			maximumSelectionLength: 1,
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
	$('#transaction .select3').on("select2:select", function(e) {
		window.open('/item/transactions/' + e.params.data.id);
	});
</script>
@endsection