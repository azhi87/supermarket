@extends('layouts.master')
@section('content')
<br>
<div class="col-md-3 col-sm-3 col-xs-1 hidden-print">
</div>
<div class="col-md-6 col-sm-6 col-xs-10 hidden-print">
@include('layouts.errorMessages')


       <div class="panel panel-info">
                <div class="panel-heading text-center">
                  <span class="h3 color-black"><b>گؤرانکاری کڕیار</b></span>
                </div>
         <div class="panel-body">
		
			<form class='text-right' method="POST" action="/customers/store/{{$customer->id}}" enctype="multipart/form-data" id="addForm">
			{{csrf_field()}}
			@if(Auth::user()->type=='mandwb')
			<div class="hidden">
			
			@else
			<div>
			@endif
			<fieldset class="form-group">
					<label for="id">کۆدی کڕیار</label>
			<input type="text" value="{{$customer->id}}" class="form-control" name="id" >
				</fieldset>

				<fieldset class="form-group">
					<label for="name">ناوی کڕیار</label>
			<input type="text" value="{{$customer->name}}" class="form-control" name="name" required>
				</fieldset>
				
				<fieldset class="form-group">
					<label for="name">ناوی تاقیگە</label>
			<input type="text" value="{{$customer->lab_name}}" class="form-control" name="lab_name" required>
				</fieldset>

 				<fieldset class="form-group">
				<label for="formGroupExampleInput2">زۆن</label>
				<select class="form-control" name="garak_id">
				<option value={{$customer->garak_id}}>{{$customer->garak->city->city}}---
				{{$customer->garak->garak}}</option>
					@foreach ($garaks as $garak)
						<option value={{$garak->id}}>{{$garak->city->city}}---{{$garak->garak}}</option>
					@endforeach
				</select>
				</fieldset>

				<fieldset class="form-group">
				<label for="formGroupExampleInput2">حاڵەت</label>
				<select class="form-control" name="status">
				<option selected="selected" value={{$customer->status}}>{{$customer->status}}</option>
				<option value="active">active</option>
				<option value="disabled">disabled</option>
				</select>
				</fieldset>
				</div>
				
				<fieldset class="form-group">
					<label for="formGroupExampleInput2">ژمارەی مۆبایل</label>
					<input type="text" value="{{$customer->mobile}}" name="mobile"  class="form-control" id="formGroupExampleInput2" required>
				</fieldset>
				
				<fieldset class="form-group">
					<label for="formGroupExampleInput2">ناونیشان</label>
					<input type="text" value="{{$customer->address}}" name="address"  class="form-control" id="formGroupExampleInput2">
				</fieldset>
				@if(Auth::user()->type=='mandwb')
			        <div class="hidden">
			    @else
			        <div>
			    @endif
				<fieldset class="form-group">
					<label for="formGroupExampleInput2">زۆرترین ڕۆژی گێڕانەوەی قەرز</label>
					<input type="text" name="daysToBlock" value="{{$customer->daysToBlock}}" class="form-control" id="formGroupExampleInput2">
				</fieldset>


				@if(Auth::user()->type=='admin')
				<fieldset class="form-group">
					<label for="formGroupExampleInput2">سرینەوەی کڕیار</label>
					<select class="form-control" name='deleted'>
						<option value="active">نەخێر</option>
						<option style="color:red;font-size:20px;" value="disabled">بەڵێ</option>
					</select>
				</fieldset>
				@endif
				</div>
				<button type="submit" class="btn btn-primary btn-lg btn-block">تۆمارکردن</button>
			</form>
	</div>
	</div>
	</div>
@endsection

@section('afterFooter')
 <script type="text/javascript">
 	$(document).ready(function () {
  $("#menu-top li a").removeClass("menu-top-active");              
  $('#customer').addClass('menu-top-active');
  });
 </script>

 @endsection