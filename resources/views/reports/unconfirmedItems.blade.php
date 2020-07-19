@extends('layouts.master')
@section('content')

<br>

<div class="row bordered-2">
    
<div class="col-md-12 col-sm-12 text-center">
</br>
    <strong><p style="font-size: 48px; "> ڕاپۆرتی مەوادە - وەسڵی چێك نەکراو  </p> </strong>
    </br>
    </br>
</div>
</div>



<div class="row bordered-1" >

        <table class="table table-bordered table-striped table-responsive table-text-center tfs16boldc tfs18boldp">
    <thead  >
        <tr class="bg-info">
             <th>کۆی کێش</th>
            <th>کۆی پارە</th>
            <th>ژ.فرۆشراو</th>
            <th>ناوی مەواد</th>
            <th>کۆدی مەواد</th>
        </tr>

    </thead>
@foreach ($items as $item)

<tr >
<td class="col-print-11">{{number_format($item->weight,2)}}</td>
<td class="col-print-11">{{number_format($item->tppi,2)}}</td>
<td class="col-print-11">{{number_format($item->tqty,2)}}</td>
<td class="col-print-4">{{$item->name}}</td>
<td class="col-print-1 bg-warning text-danger">{{$item->item_id}}</td>

</tr>
@endforeach 
</table>
</div>


<div class="row bordered-1" >
<br>
        <table class="table  table-bordered tseparate-1 tfs16boldc tfs18boldp">
        <tbody  class="text-center">

        <tr>
            <td class="col-print-1 bordered-0" ></td>
            <td class="col-print-4 bg-warning text-danger"> {{$items->sum('tqty')}}</td>
            <td class="col-print-3 bg-info"> : سەرجەمی ژمارەی فرۆشراو</td>
            <td class="col-print-1 bordered-0" ></td>
        </tr>

        <tr>
            <td class="bordered-0"></td>
            <td class="bg-warning text-danger"> 
            {{number_format($items->sum('tppi'),2)}}
             </td>
            <td class="bg-info"> : سەرجەمی پارەی فرۆشراو</td>
            <td class="bordered-0"></td>
        </tr>

        <tr>
            <td class="bordered-0"></td>
            <td class="bg-warning text-danger"> 
            {{number_format($items->sum('weight'),2)}}
             </td>
            <td class="bg-info"> : کێشی گشتی</td>
            <td class="bordered-0"></td>
        </tr>
    

</tbody>
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
