@extends('layouts.master')
@section('content')
<style>
	.table td,
	.card .table td,
	.card .dataTable td{
		padding: 5px 8px;
		vertical-align: middle;
	}
</style>
@include('purchases.header')
<div class="row">
	<div class="col-sm-12">
		<div class="card card-topline-green">
			<div class="card-body bg-light">
			    <div class="row">
				<div class="col-md-12 col-sm-12">
					<form method="POST" action="{{route('search-purchase')}}">
						{{csrf_field()}}
						<div class="form-group input-group input-group-sm">
							<span class="input-group-addon"><strong>from</strong></span>
							<input type="date" name="start_date" class="form-control" />
							<span class="input-group-addon"><strong>to</strong></span>
							<input type="date" name="end_date" class="form-control" />
							<span class="input-group-addon"><strong>invoice #</strong></span>
							<input type="text" name="purchase_id" class="form-control" />
							<span class="input-group-addon"><strong>Supplier</strong></span>
							<select required="required" name="supplier_id" class="form-control">
										@foreach ($suppliers as $supplier)
										<option value="{{$supplier->id}}">{{$supplier->name}}</option>
										@endforeach
							</select>

							<span class="input-group-btn">
								<button type="submit" class="btn-primary btn-flat">Search!</button>
							</span>
						</div>
					</form>
				</div>

			
				</div>
				<div class="row">
					<div class="card-body col-md-12">
						<div class="table-scrollable">
							<table class="table text-center table-striped table-hover">
								<thead class="bg-info text-light">
									<tr class="custom_centered">
										<th>ID No.</th>
										<th>Invoice No.</th>
										<th>Supplier Name</th>
										<th>Total</th>
										<th>Date</th>
										<th>User</th>
										<th>Edit</th>
										<th>Delete</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($purchases->sortbydesc('created_at') as $purchase)
									<tr>
										<td>{{$purchase->id}}</td>
										<td><strong>{{$purchase->invoice_no}}</strong></td>
										<td>{{$purchase->supplier->name}}</td>
										<td> $ {{number_format($purchase->total,2)}}</td>
										<td><strong>{{$purchase->created_at}}</strong></td>
										<td>{{$purchase->user->name}}</td>			

                                        <td>
                                        <a class="btn btn-md btn-circle btn-primary" href="/purchase/edit/{{$purchase->id}}"><span class="fa fa-edit "></span></a>
                                        </td>
                                        <td>
                                        <a class="btn btn-md btn-circle btn-danger" onclick='confirmDelete("{{$purchase->id}}")'><span class="fa fa-trash-o "></span></a>
                                        </td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
				
				{{ $purchases->links('vendor.pagination.bootstrap-4') }}
			
			</div>
		</div>
	</div>
</div>

@endsection