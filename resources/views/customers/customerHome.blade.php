@extends('layouts.master')
@section('content')

<div class="row hidden-print well">
 <div class=" col-md-12 col-sm-12 col-xs-12 text-center ">
 	<form method="post" action="/signature/print">
 			{{csrf_field()}}

		<div class="col-md-1 input-group-btn col-md-offset-1">    	
			<button type="submit" name="dailyReportSubmit" class="btn btn-primary btn3d"><b>ڕاپۆرتی قەرز</b></button>
		</div>
   	</form>	 

<form method="post" action="/customers/search" class=" form-inline text-center" >
{{csrf_field()}}

@if (Auth::user()->type!="mandwb")
<!--<a href="/debt/generalSearch" type="button" class="btn btn3d btn3d-pull btn-primary"><strong>گەڕانی گشتی </strong></a>-->
@endif
                           <div class="col-md-6 col-md-offset-3 well-sm bg-info">
						   <div class="col-md-12">
						                               
                        <select name="customer_id" class="select2" id="select2" onchange="getCustomerName();"
						  style="min-width: 500px;" >
                                <option value="0">هەڵبژاردنی ناوی کڕیار</option>
                                @foreach ($customers as $customer1)
<option value="{{$customer1->id}}">{{$customer1->name}}--{{$customer1->lab_name}}--{{$customer1->mobile}}</option>
                                @endforeach
                            </select>                     
                        </div>
                        <span class="input-group-btn">
						</div>
						<div class="col-md-1">
       <button class="btn btn-magick btn3d" type="submit">
		<strong>گەڕان </strong><span class="fa fa-search fa-12x"></span></button>
      </span>
	  </div>
</form>
</div>
</div>

 <div class="row">
	<div class="col-md-9 col-sm-12 col-xs-12 table-responsive">
	<table class="table table-bordered table-responsive ">
	<thead class="color-black bg-info">
		<tr class="custom_centered">
			<th class="hidden-print">گۆڕین</th>		
			<th>قەرز - ڕۆژ</th>
			<th>ژ. مۆبایل</th>
			<th>زۆن</th>
			<th>شار</th>
			<th>جۆر</th>
			<th>ناوی تاقیگە</th>
			<th>ناوی کڕیار</th>
			<th> ژمارە</th>

		</tr>
	</thead>
	<tbody>
	
		@foreach ($customers as $customer) 
		@if ($customer->status==="disabled")
			<tr class="text-center bg-danger">
		@else
		<tr class="text-center">
		@endif			
				<td class="hidden-print"><a href={{"/customers/edit/".$customer->id}}><span class="fa fa-edit fa-1x"></span></a></td>
				<td>{{$customer->daysToBlock}}</td>
				<td>{{$customer->mobile}}</td>	
				<td>{{$customer->garak->garak}}</td>
				<td>{{$customer->garak->city->city}}</td>
				@if($customer->ahli=='1')
				<td  class="success">ئەهلی</td>
				@else
				<td  class="danger">حوکمی</td>
				@endif
				<td>{{$customer->lab_name}}</td>

				<td>{{$customer->name}}</td>
				<td>{{$customer->id}}</td>
			</tr>
		@endforeach
	</tbody>
       
</table>

 {{ $customers->links('vendor.pagination.bootstrap-4') }}

 {{-- @if ($customer->has('links'))
 {{ $customers->links('vendor.pagination.bootstrap-4') }}
 @endif --}}
</div>
<div class="col-md-3 col-sm-6 col-xs-10 col-md-offset-0 col-sm-offset-6 col-xs-offset-0 hidden-print">
@if(Auth::user()->type!='mandwb')
@include('layouts.errorMessages')
       <div class="panel panel-info">
                <div class="panel-heading text-center">
                 <span class="h3 color-black"><b>زیادکردنی کڕیار</b></span>
                </div>
         <div class="panel-body">
		
			<form class='text-right' method="POST" action="/customers/store" enctype="multipart/form-data" id="addForm">
			{{csrf_field()}}
			<fieldset class="form-group hidden">
					<label for="id">کۆدی کڕیار</label>
			<input type="text" class="form-control" name="id" >
				</fieldset>

				<fieldset class="form-group">
					<label for="name">ناوی کڕیار</label>
				<input type="text" class="form-control" name="name" required>
				</fieldset>


				<fieldset class="form-group">
					<label for="name">ناوی تاقیگە</label>
				<input type="text" class="form-control" name="lab_name" required>
				</fieldset>

				<fieldset class="form-group">
					<label for="formGroupExampleInput2">ژمارەی مۆبایل</label>
					<input type="text" name="mobile"  class="form-control" id="formGroupExampleInput2" required>
				</fieldset>

 				<fieldset class="form-group">
				<label for="formGroupExampleInput2">جۆر</label>
				<select class="form-control" name="ahli">

						<option value="0">‌حوکمی</option>
				
						<option value="1">ئەهلی</option>
				</select>
				</fieldset>

 				<fieldset class="form-group">
				<label for="formGroupExampleInput2">زۆن</label>
				<select class="form-control" name="garak_id">
					@foreach ($garaks as $garak)
						<option value={{$garak->id}}>{{$garak->city->city}}---{{$garak->garak}}</option>
					@endforeach
				
				</select>
				</fieldset>

				<fieldset class="form-group">
					<label for="formGroupExampleInput2">ناونیشان</label>
					<input type="text" name="address"  class="form-control" id="formGroupExampleInput2" required>
				</fieldset>

				<fieldset class="form-group">
					<label for="formGroupExampleInput2">زۆرترین ڕۆژی گێڕانەوەی قەرز</label>
					<input type="text" name="daysToBlock" value="30" class="form-control" id="formGroupExampleInput2">
				</fieldset>

				<button type="submit" class="btn btn-primary btn-lg btn3d btn-block"><b>تۆمارکردن</b></button>
			</form>
	</div>
	</div>
	
		 	      <div class="panel panel-info">
		                <div class="panel-heading text-center color-black">
		                 
		                    <span class="h3 color-black"><b>زیادکردنی گەڕەک</b></span>
		                </div>
		         <div class="panel-body">
					<form class='text-right' method="POST" action="/customers/addGarak" id="addForm">
					{{csrf_field()}}
		 				<fieldset class="form-group">
						<label for="formGroupExampleInput2">زیادکردنی گەڕەک بۆ شاری</label>
						<select class="form-control" name="city_id" required>
							@foreach ($cities as $city)
								<option value={{$city->id}}>{{$city->city}}</option>
							@endforeach
						</select>
						</fieldset>
						<fieldset class="form-group">
							<label for="formGroupExampleInput2">گەڕەک</label>
							<input type="text" name="garak"  class="form-control" id="formGroupExampleInput2">
						</fieldset>

						<button type="submit" class="btn btn-primary btn-lg btn3d btn-block"><b>تۆمارکردن</b></button>
					</form>
				</div>
				</div>
				 <div class="panel panel-info">
		                <div class="panel-heading text-center">
		                                 <span class="h3 color-black"><b>زیادکردنی شار</b></span>

		                </div>

		         	<div class="panel-body">
						<form class='text-right' method="POST" action="/customers/addCity" id="addForm">
						{{csrf_field()}}
							<fieldset class="form-group">
								<label for="formGroupExampleInput2">ناوی شار</label>
								<input type="text" name="city"  class="form-control" id="formGroupExampleInput2">
							</fieldset>
							<button type="submit" class="btn btn-primary btn-lg btn3d btn-block"><b>تۆمارکردن</b></button>
						</form>
					</div>
				</div>
	</div>
	</div>
@endif
</div>
</div>
@endsection('content')
@section('afterFooter')
 <script type="text/javascript">
 	$(document).ready(function () {
  $("#menu-top li a").removeClass("menu-top-active");              
  $('#customer').addClass('menu-top-active');
  });
 </script>

<script type="text/javascript">
  $(document).ready(function() {
    $('.select2').select2();
});
  
 </script>

 @endsection