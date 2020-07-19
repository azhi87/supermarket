@extends('layouts.master')

@section('content')
<br>


<div class="col-md-3 col-sm-3 col-xs-2"></div>
<div class="col-md-6 col-sm-6 col-xs-8 hidden-print">
@include('layouts.errorMessages')
       <div class="panel panel-info">
            <div class="panel-heading color-black text-center"><strong>زیادکردنی مەوادی تەلەفکراو</strong></div>
            <div class="panel-body">
				<form class='text-right form-horizontal' method="POST" action="/broken/store/{{$broken->id}}" id="addForm">
					{{csrf_field()}}
					

	<div class="form-group">

	<div class="col-md-12">
	    <div class="input-group has-warning">
		<input type="text" name="barcode" value="{{$broken->item_id}}" onblur="getItemPrice(this.value,this.id)" class="form-control" id="item0" >
		<span class="input-group-addon">:کۆد</span>
	</div>
	

	</div>
	</div>
<div class="form-group">

	<div class="col-md-12">
	    <div class="input-group has-warning">
	<input type="text" readonly="readonly" class="form-control" id="name0"  name="name" class="form-control" >
			<span class="input-group-addon">:ناو</span>   
	    </div>

	</div>
	</div>
<div class="form-group has-warning">
		<div class="col-md-12">
	    <div class="input-group">
			<input  name="quantity" value="{{$broken->quantity}}" class="form-control">
			<span class="input-group-addon">ژمارە</span>

		</div></div></div>
	
		<div class="form-group has-warning">
		<div class="col-md-12">
	    <div class="input-group">
			<input  name="singles" value="{{$broken->singles}}" class="form-control">
			<span class="input-group-addon">دانە</span>

		</div></div></div>
	

		<div class="form-group has-warning">
		<div class="col-md-12">
	    <div class="input-group">
			<input  value="{{$broken->exp}}" name="exp"  type="date" class="form-control">
			<span class="input-group-addon">بەرواری بەسەرچوون</span>

		</div></div></div>


<div class="form-group">
<div class="col-md-12">
		<button type="submit" class="btn-md btn-primary btn-block">تۆمارکردن </span></button>
</div>
</div>

					</form>
					</div>
	</div>

	
 

</div>
</div>
@endsection('content')
@section('afterFooter')
 <script type="text/javascript">
 	$(document).ready(function () {
  $("#menu-top li a").removeClass("menu-top-active");              
  $('#item').addClass('menu-top-active');
  });
 </script>

 @endsection