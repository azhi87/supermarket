@extends('layouts.master')
@section('links')
<style>@media print {
  a[href]:after {
    content: none !important;
  }
}</style>
@endsection
@section('content')


<div class="row bordered-2 ">
	
<div class="col-md-12 col-sm-12 text-center">
<br/>
	<strong><p style="font-size: 36px; ">ڕاپۆرتی قەرز  </p> </strong>
<br>
  <span class="text-center">{{Carbon\Carbon::now()}}</span>

</div>

</div>


<div class="row bordered-1">

		<table class="table table-bordered table-text-center table-responsive tfs14boldc tfs12boldp" >
    <thead   >
        <tr class="bg-info">
            <th>کۆتا کڕین</th>
           <th class="hidden-print">  توانایی قەرز - ڕۆژ</th>
           <th> دوا بەرواری قەرز</th>
            <th>ژمارەی مۆبایل</th>
            <th>کۆی قەرز / دۆلار</th>
            <th>جۆری کڕیار</th>
            <th>ناوی تاقیگە</th>
            <th>ناوی کڕیار</th>
        </tr>

    </thead>
    <tbody>
@foreach ($customers->where('deleted','active') as $customer)
	@if ($customer->status==="disabled")
			<tr class="text-center bg-danger">
		@else
		<tr class="text-center">
		@endif
<td>{{$customer->daysFromLastSale()}}</td>
<td class="hidden-print">{{$customer->daysToBlock}}</td>
<td class="{{$customer->bgChange()}}">{{$customer->daysFromLastDebtPayment()}}</td>
<td >{{$customer->mobile}}</td>
<td >{{$customer->customerDebt()}}</td>
@if($customer->ahli=='1')
				<td  class="success">ئەهلی</td>
				@else
				<td  class="danger">حوکمی</td>
				@endif
<td >{{$customer->lab_name}}</td>
<td >{{$customer->name}}</td>
</tr>
@endforeach
</tbody>
</table>

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