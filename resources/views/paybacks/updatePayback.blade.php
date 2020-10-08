@extends('layouts.master')
@section('content')

<div class="row">
	<div class="col-md-3 col-sm-12"></div>
	<div class="col-md-6 col-sm-12">
		<div class="card card-topline-green">
			<div class="card-head">
				<header>Update Payback</header>
			</div>
			<div class="card-body bg-light" id="bar-parent1">
				@include('layouts.errorMessages')
				<form class="form-horizontal" method="POST" action="/paybacks/store/{{$payback->id}}">
					{{csrf_field()}}
					<input type="hidden" value="{{ $payback->supplier->id }}" name="supplier_id">
					<div class="form-group">
						<label for="name">Amount $ </label>
						<div class="input-group">
							<input type="text" name="paid" value="{{$payback->paid}}" class="form-control" required />
						</div>
					</div>
					<div class="form-group">
						<label for="name">Discount $ </label>
						<div class="input-group">
							<input type="text" name="discount" value="{{$payback->discount}}" class="form-control"
								required />
						</div>
					</div>
					<div class="form-group">
						<label for="name">Note</label>
						<textarea class="form-control" name="description" alue="{{$payback->description}}">{{$payback->description}}</textarea>
					</div>
					<div class="form-group text-center">
						<button type="submit" class="btn btn-primary btn-lg btn-block">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
@section('afterFooter')
<script type="text/javascript">
	$(document).ready(function() {
		$("#menu-top li a").removeClass("menu-top-active");
		$('#exchange').addClass('menu-top-active');
	});
</script>
@endsection