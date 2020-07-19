@extends('layouts.master')
@section('content')
<?php $user = new \App\User();
$mandwbs = $user->Mandwbs();
$drivers = $user->drivers();
?>
<style>
	.input-group-addon {
		color: black;
		background-color: #F0FFFF;
		min-width: 120px;
		font-weight: bold
	}
</style>
@include('sales.header')

<div class="row ">
	<div class="col-sm-12 ">
		<div class="card card-topline-green ">
			<div class="card-body ">
				<div class="row">
					<div class="panel panel-primary col-sm-6 bg-light">
						<form action='/sale/search' method='post' role="form">
							{{csrf_field()}}

							<div class="form-group input-group ">
								<span class="input-group-addon">Invoice #</span>
								<input type="text" name='sale_id' class="form-control text-right">
							</div>

							@if(Auth::user()->type=='admin')
							<div class="form-group input-group">
								<span class="input-group-addon">Employee</span>
								<select class="form-control" name="user_id">
									<option value="-1" selected="selected">------</option>
									@foreach ($users as $user)
									<option value="{{$user->id}}"> {{$user->name}} </option>
									@endforeach
								</select>
							</div>
							@endif

							<div class="form-group input-group">
								<span class="input-group-addon">From</span>
								<input type="date" name='from' class="form-control text-right">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon">To</span>
								<input type="date" name='to' class="form-control text-right">
							</div>

							<div class="form-group text-center">
								<input type="submit" value="Search" class="btn-lg btn-info btn3d">
							</div>
						</form>
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
		$('#sale').addClass('menu-top-active');
	});
</script>

@endsection