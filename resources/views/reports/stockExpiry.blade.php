@extends('layouts.master')
@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-12">
				<div class="card card-topline-green">
					<div class="card-head">
						<header>Stock Expiry Report</header>
					</div>
					<div class="card-body ">
						<div class="table-scrollable">
							<table class="table text-center bg-light table-bordered table-striped">
								<thead>
									<tr>
										<th>Barcode</th>
										<th>Drug Name</th>
										<th>Expiry Date</td>
										<th>Stock</td>
									</tr>
								</thead>

								@foreach ($items as $item)
								<tr class="text-center">
									<td>@php echo (\App\Item::find($item->id)->barcode) @endphp</td>
									<td>@php echo (\App\Item::find($item->id)->name) @endphp</td>
									<td>{{$item->exp}}</td>
									<td>{{$item->quantity}}</td>
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