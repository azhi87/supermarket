@extends('layouts.master')
@section('content')

<div class="row">
	<div class="col-md-3 col-sm-12"></div>
	<div class="col-md-6 col-sm-12">
		<div class="card card-topline-green">
			<div class="card-head">
				<header>Update Drug</header>
			</div>
			<div class="card-body bg-light " id="bar-parent1">
				@include('layouts.errorMessages')
				<form class="form-horizontal" method="POST" action="/items/update/{{$item->id}}" enctype="multipart/form-data" id="addForm">
					{{csrf_field()}}
					<div class="row form-group">
						<label class="col-sm-3 control-label">Barcode</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="barcode" value="{{$item->barcode}}">
						</div>
					</div>

					<div class="row form-group">
						<label class="col-sm-3 control-label">Drug Name</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="name" value="{{$item->name}}">
						</div>
					</div>

					<div class="row form-group">
						<label class="col-sm-3 control-label"> Scietific Name </label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="name_en" value="{{$item->name_en}}">
						</div>
					</div>

					<div class="row form-group">
						<label class="col-sm-3 control-label">Purchase Price</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="purchase_price" value="{{$item->purchase_price}}">
						</div>
					</div>

					<div class="row form-group hidden">
						<label class="col-sm-3 control-label"> Sale Price</label>
						<div class="col-sm-9">
							<input type="text" name="sale_price" value="{{$item->sale_price}}" class="form-control">
						</div>
					</div>

					<div class="row form-group">
						<label class="col-sm-3 control-label"> Sale Price IQD </label>
						<div class="col-sm-9">
							<input type="text" name="sale_price_id" value="{{$item->sale_price_id}}" class="form-control">
						</div>
					</div>

					<div class="row form-group">
						<label class="col-sm-3 control-label">Items Per Packet </label>
						<div class="col-sm-9">
							<input type="text" name="items_per_box" value="{{$item->items_per_box}}" class="form-control">
						</div>
					</div>

					<div class="row form-group">
						<label class="col-sm-3 control-label">Dosage Form </label>
						<div class="col-sm-9">
							<select class="form-control" name="category_id">
								@foreach ($cats as $cat)
								@if($cat->id==$item->category_id)
								<option selected="selected" value={{$cat->id}}>{{$cat->category}}</option>
								@else
								<option value="{{$cat->id}}">{{$cat->category}}</option>
								@endif
								@endforeach
							</select>
						</div>
					</div>

					<div class="row form-group hidden">
						<label class="col-sm-3 control-label">Supplier</label>
						<div class="col-sm-9">
							<select class="form-control" name="supplier_id">
								@foreach ($suppliers as $supplier)
								@if($supplier->id==$item->supplier_id)
								<option selected="selected" value="{{$supplier->id}}">{{$supplier->name}}</option>
								@else
								<option value="{{$supplier->id}}">{{$supplier->name}}</option>
								@endif
								@endforeach
							</select>
						</div>
					</div>
					@if(Auth::user()->type=='admin')
					<div class="row form-group">
						<label class="col-sm-3 control-label"> Disable Drug</label>
						<div class="col-sm-9">
							<select class="form-control" name='status'>
								<option value="1">No</option>
								<option style="color:red;font-size:20px;" value="0">Yes</option>
							</select>
						</div>
					</div>
					@endif
					<div class="form-group">
						<label class="col-sm-3 control-label">Note</label>
						<textarea cols="50" rows="4" class="form-control" name="description">{{$item->description}}</textarea>
					</div>
					<button type="submit" class="btn btn-primary btn-lg btn-block">Save</button>
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
		$('#item').addClass('menu-top-active');
	});
</script>

@endsection