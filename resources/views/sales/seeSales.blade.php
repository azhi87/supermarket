@extends('layouts.master')
@section('content')
@include('sales.header')

<div class="row ">
	<div class="col-sm-12 ">
		<div class="card card-topline-green ">
			<div class="card-body ">
				<div class="row">
					<div class="panel panel-primary col-md-12 bg-light">
						<form method="POST" class="form-inline pull-right" action="/sale/searchId">
							<div class="input-group input-group-sm">
								@csrf
								<input type="text" name="sale_id" class="form-control" placeholder="Search by Invoice ID">
								<span class="input-group-btn">
									<button type="submit" class="btn btn-primary btn-flat">Search!</button>
								</span>
							</div>
						</form>
					<div class="col-md-4 col-md-offset-4 col-sm-6">
					    <form method="POST" action="{{route('search-sale-byItem')}}">
						{{csrf_field()}}
						<div class="form-group input-group input-group-sm">
							<span class="input-group-addon">Barcode</span>
							<input type="text" name="barcode" class="form-control" />
							<span class="input-group-btn">
								<button type="submit" class="btn-primary btn-flat">Search!</button>
							</span>
						</div>	
				        </form>
				    </div>

					@foreach ($sales as $sale)
					<div class="panel-body border border-secondary">
						<div class="table-scrollable table-fixed">
							<table class="table table-striped table-bordered text-center" id="dataTables-example">
								<tbody>
									<tr class="info h5">
										<td><span>&nbsp;Invoice No. :</span><strong>{{$sale->id}}</strong></td>
										<td><span>&nbsp;Total  : </span> {{number_format($sale->total,0)}}</td>
										<td><span>&nbsp;Date:</span>{{$sale->created_at->format('d/m/yy')}}</td>
										<td><span>&nbsp; User : </span>{{$sale->user->name}}</td>
								</tbody>
							</table>
						</div>

						<div class="table-scrollable table-fixed">
							<table class="table table-striped table-bordered text-center" id="dataTables-example">
								<tbody class="bg-info text-light">
									<tr class="text-center">
										<th class="text-center">#</th>
										<th class="text-center">Barcode</th>
										<th class="text-center">Name</th>
										<th class="text-center">Packs</th>
										<th class="text-center"> Sheets</th>
										<th class="text-center">Price</th>
										<th class="text-center">Subtotal</th>
										<th class="text-center"> Expiry</th>
									</tr>
								</tbody>
								<tbody>
									<?php $i = 1; ?>
									@foreach ($sale->items as $item)
									<tr class="text-center h5">
										<td><span class="badge bg-danger">{{$i}}</span></td>
										<td>{{ $item->barcode }}</td>
										<td>{{ $item->name }}</td>
										<td>{{ $item->pivot->quantity }}</td>
										<td>{{ $item->pivot->singles }}</td>
										<td>{{ number_format($item->pivot->ppi,0) }}</td>
										<td>{{ number_format((($item->pivot->singles / $item->items_per_box) + ($item->pivot->quantity)) * $item->pivot->ppi,0) }}</td>
										<td>{{ $item->pivot->exp }}</td>
									</tr>
									<?php $i++; ?>
									@endforeach

								</tbody>
							</table>
						</div>

						@if(Auth::user()->type=="admin")
							<div class="text-center hidden-print">
								<a class="btn btn-circle btn-success btn-lg" onclick="printExternal('/sale/print/{{ $sale->id }}')"><span class="fa fa-print fa-2x"></span></a>
								<a class="btn btn-circle btn-danger btn-lg" onclick='confirmDelete("{{$sale->id}}")'><span class="fa fa-trash-o fa-2x"></span></a>
								<a class="btn btn-circle btn-primary btn-lg" href="/sale/edit/{{$sale->id}}"><span class="fa fa-edit fa-2x"></span></a>
							</div>
						@endif
					</div>

					<br />
					@endforeach
					{{ $sales->links('vendor.pagination.bootstrap-4') }}
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">سڕینەوەی کڕین</h4>
			</div>
			<div class="modal-body text-center">
				<h3>دڵنیایت لە سڕینەوەی ئەم کڕینە؟</h3>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">نەخێر</button>
				<a id="delete" href="" type="button" class="btn btn-danger">بەڵێ</a>
			</div>
		</div>
	</div>
</div>


@endsection


@section('afterFooter')
<script type="text/javascript">
	function confirmDelete(id) {
		$("#delete").attr('href', "/sale/delete/" + id);
		$('#myModal').modal('show');
	}
</script>
@endsection