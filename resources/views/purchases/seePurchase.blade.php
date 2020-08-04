@extends('layouts.master')
@section('content')
@include('purchases.header')
<div class="row ">
	<div class="col-sm-12 ">
		<div class="card card-topline-green ">
			<div class="card-body ">
				<div class="row">
				    
				    <div class="col-md-4 col-md-offset-4 col-sm-6">
					    <form method="POST" action="{{route('search-purchase-byItem')}}">
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
				    
					<div class="panel panel-primary col-md-12 bg-light">
						@foreach ($purchases as $purchase)
						<div class="panel-body border border-secondary">
							<div class="table-scrollable table-fixed">
								<table class="table table-striped table-bordered text-center" id="dataTables-example">
									<tbody>
										<tr class="info h5">
											<td><span >&nbsp;Invoice No.: </span><strong>{{$purchase->invoice_no}}</strong></td>
											<td><span>&nbsp;Total : </span> {{ number_format(abs($purchase->total),2)}} $</td>
											<td><span >&nbsp; Date : </span>{{ $purchase->created_at }}</td>
											<td><span>&nbsp; User : </span>{{$purchase->user->name}}</td>
											<td><span>&nbsp; Supplier : </span><strong>{{$purchase->supplier->name}}</strong></td>
											<td class="{{ $purchase->type === 'purchase' ? 'bg-success' : 'bg-danger' }}">{{ ucfirst($purchase->type) }}</td>
										</tr>
										<tr class="h5">
											<td><span>&nbsp;Note: </span><strong>{{$purchase->note}}</strong></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="table-scrollable table-fixed">
								<table class="table table-bordered text-center table-striped table-scrollable h6" id="repeatedSale">
									<thead class="bg-info text-light">
										<tr class="text-center">
											<th>#</th>
											<th>Barcode</th>
											<th>Name</th>
											<th>Packs</th>
											<th>Bonus</th>
											<th>Purchase Price $</th>
											<th>Subtotal</th>
											<th> Expiry</th>
										</tr>
									</thead>
									<tbody>
										<?php $i = 1; ?>
										@foreach ($purchase->items as $item)
										<tr class="text-center h6">
											<td><span class="badge bg-danger">{{$i}}</span></td>
											<td>{{$item->barcode}}</td>
											<td>{{$item->name}}</td>
											<td>{{$item->pivot->quantity}}</td>
											<td>{{$item->pivot->bonus}}</td>
											<td>{{$item->pivot->ppi}}</td>
											<td>{{$item->pivot->quantity*$item->pivot->ppi}}</td>
											<td>{{$item->pivot->exp}}</td>
										</tr>
										<?php $i++; ?>
										@endforeach
									</tbody>
								</table>
							</div>

							@if(Auth::user()->type=="admin")
							<div class="text-center hidden-print">
								<a class="btn btn-lg btn-circle btn-danger" onclick='confirmDelete("{{$purchase->id}}")'><span class="fa fa-trash-o "></span></a>
								<a class="btn btn-lg btn-circle btn-primary" href="/purchase/edit/{{$purchase->id}}"><span class="fa fa-edit "></span></a>
							</div>
							@endif
						</div>
						<br />
						@endforeach
						{{ $purchases->links('vendor.pagination.bootstrap-4') }}
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
		$("#delete").attr('href', "/purchase/delete/" + id);
		$('#myModal').modal('show');
	}
</script>
@endsection