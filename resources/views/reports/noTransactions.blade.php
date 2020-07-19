@extends('layouts.master')
@section('content')

<br>

<div class="row bordered-2">
    
<div class="col-md-12 col-sm-12 text-center">
</br>
    <strong><p style="font-size: 48px; "> ڕاپۆرتی ئەو کڕیارانەی کە مەوادیان نەکڕیوە </p> </strong>
    </br>
    </br>
</div>
</div>

<div class="row bordered-1" >

<br>
    

    <table class="table table-bordered table-text-center tseparate-1 tfs18boldc tfs24boldp  ">
    <tbody  >

      <tr  >
            <td class="col-print-11 bordered-0 hidden-print" > </td>
            <td class="col-print-2 ">{{$to}} </td>
            <td class="col-print-1 bg-info">: بۆ</td> 
            <td class="col-print-2 ">{{$from}} </td>
            <td class="col-print-1 bg-info">: لە</td> 
            <td class="col-print-11 bordered-0 hidden-print" > </td>
        </tr>

</tbody>
</table>

</div>

<div class="row bordered-1" >

        <table class="table table-bordered table-striped table-responsive table-text-center tfs16boldc tfs18boldp">
    <thead  >
        <tr class="bg-info">
           
            <th>دوا بەروار</th>
            <th>بڕی قەرز</th>
            <th>ناوی کڕیار</th>
            <th>کۆدی کڕیار</th>
        </tr>

    </thead>
@foreach ($customers as $customer)
    
    <tr >
        <td class="col-print-11">{{$customer->daysFromLastSale()}}</td>
        <td class="col-print-11">{{$customer->customerDebt()}}</td>
        <td class="col-print-4">{{$customer->name}}</td>
        <td class="col-print-1 bg-warning text-danger">{{$customer->id}}</td>
    </tr>
@endforeach


</table>
</div>

</div>


 @endsection

 @section('afterFooter')
 <script type="text/javascript">
    $(document).ready(function () {
  $("#menu-top li a").removeClass("menu-top-active");              
  $('#report').addClass('menu-top-active');
  });
 </script>

 @endsection
