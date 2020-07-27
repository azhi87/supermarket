@extends('layouts.master')
@section('content')

<div class="row">
        <div class="col-md-12 col-sm-12">
    	<div class="card card-topline-green">
    		<div class="card-body bg-light">
    				<div class="row h5">
    				<label class="col-md-3 control-label text-primary">Supplier Name: <strong> {{ $supplier->name }}</strong></label>
    				<label class="col-md-2 control-label text-info" >
    							<a href=" {{ route('show-supplier-purchases',$supplier->id) }}" style="text-decoration: underline;">Purchases:</a>
    						<strong>	{{ number_format($supplier->purchases->sum('total'),2) }}</strong>
    				</label>
    				<label class="col-md-2 control-label text-success">Paybacks:<strong>{{ number_format($supplier->paybacks->sum('paid'),2) }}</strong></label>
    				<label class="col-md-2 control-label text-info">Discounts: <strong>{{ number_format($supplier->paybacks->sum('discount'),2) }}</strong></label>
    				<label class="col-md-2 control-label text-danger">Current Debt:<strong>  {{ number_format($supplier->debt(),2) }}</strong></label>
    				</div>
    		</div>
    	</div>
    </div>

	<div class="col-md-4 col-sm-12">
		<div class="card card-topline-green">
			<div class="card-head">
				<header>Payback Form</header>
			</div>
			<div class="card-body bg-light " id="bar-parent1">
				@include('layouts.errorMessages')
				<form class="form-horizontal" method="POST" action="/paybacks/store">
					{{csrf_field()}}
				    <input type='hidden' value = "{{ $supplier->id }}" name = "supplier_id"/>
					<div class="row form-group">
						<label class="col-sm-3 control-label">Amount</label>
						<div class="col-sm-9">
							<input type="text" name="paid" class="form-control" required />
						</div>
					</div>
					<div class="row form-group">
						<label class="col-sm-3 control-label">Discount</label>
						<div class="col-sm-9">
							<input type="text" name="discount" class="form-control" value="0" required />
						</div>
					</div>
					<div class="row form-group">
						<label class="col-sm-3 control-label">Note</label>
						<div class="col-sm-9">
					    	<textarea class="form-control" name="description"></textarea>
	                    </div>				
					</div>
					<div class="form-group text-center">
						<button type="submit" class="btn btn-primary btn-lg btn-block"><b>Save</b></button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="col-md-8 col-sm-12">
		<div class="card card-topline-green">
			<div class="card-body">
				<div class="table-scrollable">
					<div class="table-responsive">
						<table class="table table-bordered text-center table-striped">
							<thead class="bg-info text-light">
								<tr class="text-center">
									<th>User Name</th>
									<th>Date</th>
									<th>Amount </th>
									<th>Discount </th>
									<th>Note</th>
									<th class="hidden-print">Edit</th>
								</tr>
							</thead>
							<tbody>
								@foreach($supplier->paybacks->sortbydesc('created_at') as $payback)
								<tr class="text-center">
									<td>{{$payback->user->name}}</td>
									<td>{{$payback->created_at}}</td>
									<td>{{number_format($payback->paid,2)}}</td>
									<td>{{number_format($payback->discount,2)}}</td>
									<td>{{$payback->description}}</td>
									<td class="hidden-print"><a href="/payback/edit/{{$payback->id}}">
									    <span class="fa fa-edit fa-1x"></span></a>
									</td>
								</tr>
								@endforeach
							</tbody>
							<tfoot class="hidden">
							    <tr class="bg-info h5 text-light">
							        <th>Total</th>
							        <th colspan="2">{{number_format($supplier->paybacks->sum('paid'),2)}}</th>
							    </tr>
							</tfoot>
						</table>
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
		$('#debtHeader').addClass('menu-top-active');
	});
</script>
@endsection