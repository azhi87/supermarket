@extends('layouts.master')
@section('content')

<div class="row">
	<div class="col-md-3 col-sm-12"></div>
	<div class="col-md-6 col-sm-12">
		<div class="card card-topline-green">
			<div class="card-head">
				<header>گۆڕانکاری فرۆشیار</header>
			</div>
			<div class="card-body bg-light " id="bar-parent1">
				@include('layouts.messages')
				@include('layouts.errorMessages')
				<form method="POST" action="/suppliers/store/{{$supplier->id}}" enctype="multipart/form-data"
					id="addForm">
					{{csrf_field()}}


					<div class="form-group">
						<label for="name"> ناوی فرۆشیار </label>
						<input type="text" class="form-control" value="{{$supplier->name}}" name="name" required>
					</div>

					<div class="form-group {{ $supplier->debt() == '0' ? '' : 'hidden' }}">
						<label for="name"> جۆری دراو </label>
						<select class="form-control" name="isDollar" required>
							<option value="1" {{ $supplier->isDollar ? 'selected' : ''}}>دۆلار</option>
							<option value="0">دینار</option>
						</select>
					</div>

					<div class="form-group">
						<label>مۆبایل </label>
						<input type="text" name="mobile" value="{{$supplier->mobile}}" class="form-control">
					</div>

					<div class="form-group">
						<label>ناونیشان</label>
						<input type="text" name="address" value="{{$supplier->address}}" class="form-control" required>
					</div>

					<button type="submit" class="btn btn-primary btn-lg btn-block">تۆمارکردن</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection('content')
@section('afterFooter')
<script type="text/javascript">
	$(document).ready(function() {
		$("#menu-top li a").removeClass("menu-top-active");
		$('#supplier').addClass('menu-top-active');
	});
</script>

@endsection