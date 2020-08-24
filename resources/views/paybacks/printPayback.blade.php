@extends('layouts.master')
@section('content')


<div style="page-break-after: always;">
	<div class="for-watermark-div visible-print">{{ config('APP_NAME') }}</div>
	<h1>{{ env('APP_NAME') }}</h1>

	<br>
	<hr class="bg-primary">


	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12 table-responsive ">
			<table class="table table-bordered table-striped table-responsive tfs16boldc tfs16boldp">

				<thead>

					<tr class="custom_centered bg-info">

						<th>Currency</th>
						<th>Amount</th>
						<th>Discount</th>
						<th>User</th>
					</tr>
				</thead>

				<tbody>

					<tr class="text-center">
						<td>{{$payback->currency}}</td>
						<td>{{number_format($payback->paid)}}</td>
						<td>{{$payback->discount}}</td>
						<td>{{$payback->created_at->format('d/m/Y')}}</td>
					</tr>
				</tbody>
			</table>
		</div>


		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 table-responsive ">
				<table class="table table-bordered table-striped table-responsive tfs18boldc tfs16boldp">

					<thead class="bg-success">

						<tr class="text-right">
							<td class="text-right"> : {{$payback->description}}</td>
						</tr>
					</thead>


				</table>
			</div>
		</div>



		<div class="row  bordered-2 bgivory">
			<div class="col-md-12 col-sm-12 col-xs-12 ">

				<br>
				<table class="table table-bordered tfs16boldc tfs16boldp margin-1 bgivory">
					<tbody>

						<tr>


							<td class="col-print-5"
								style="text-align: right; vertical-align: middle; line-height: 80px; ">
								{{ $payback->user->name }}
							</td>
						</tr>

					</tbody>


				</table>
				<br>
			</div>
		</div>


		<div class="row bordered-1 ">

			<table class="table table-text-center tfs16boldc tfs14boldp" style="margin-bottom: 1px !important;">
				<tbody>

					<tr class=" bg-ivory">
						<td> </td>
					</tr>

				</tbody>
			</table>

		</div>
	</div>


	@endsection
	@section('afterFooter')
	<script type="text/javascript">
		$(document).ready(function () {
  $("#menu-top li a").removeClass("menu-top-active");              
  $('#debtHeader').addClass('menu-top-active');
  });
	</script>

	@endsection