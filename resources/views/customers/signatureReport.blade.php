@extends('layouts.master')

@section('content')
<br/>   
<div class="row bordered-2" >
<div class="col-md-12 col-sm-12 text-center">
<br/>
    <strong><p style="font-size: 36px; ">ڕاپۆرتی مارکێتی گەڕەکەکان </p> </strong>
</div>
<br/>
<div class="col-md-12 col-sm-12 text-right">
    <h2> <span class="label label-default">   گەڕەك : {{$garak}} </span></h2>
</div>
</div>


<div class="row bordered-1" >

        <table class="table table-bordered table-striped table-text-center tfs16boldc tfs24boldp " >
    <thead>
        <tr class="bg-info">
           
            <th>   ناوی سیانی  --   ئیمزا</th>
            <th>کۆی قەرز / دۆلار</th>
            <th>ناوی کڕیار</th>
            <th>کۆد </th>
        </tr>

    </thead>
    <tbody>
        <?php $totalDebt=0;?>
    @foreach ($customers->where('deleted','active') as $customer)
    <?php $totalDebt+=$customer->customerDebt();?>
    <tr height="60">
<td class="col-print-4" ></td>
<td class="col-print-2 text-danger">{{$customer->customerDebt()}}</td>
<td class="col-print-3"> {{$customer->name}}</td>
<td class="col-print-1 bg-warning text-danger">{{$customer->id}}</td>

    </tr>
@endforeach

 </table>
</div>
<br/>


 <div class="row ">
<div class="text-center">
     <p>{{$totalDebt}}: کۆی قەرز  </p>
      <p>{{$customers->count()}}: ژمارەی کڕیارەکان </p>
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