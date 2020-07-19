@extends('layouts.master')

@section('content')

<div class=" row row-print bordered-2 text-center " >
<br/>
<p class="h2"><strong>ڕاپۆرتی پارەی هاتوو - قەرز - وەسڵ </strong></p> 
    <br>
</div>

    <div class="row bordered-1">
<div class="col-md-12 col-sm-12">

        <table class="table text-center tseparate table-bordered tfs16boldc tfs214boldp margin-1">
        <tbody >
        <tr  >

            <td class="col-print-1 bordered-0"> </td>
            <td class="col-print-3  text-danger bg-warning">{{number_format($oldSales-$oldDebts,2)}}</td>
            <td class="col-print-3 bg-info"> :کۆی قەرزی دوێنێ  </td>
        </tr>
<tr ><td class="bordered-0"></td></tr>

         <tr>
            <td class="bordered-0"> </td>
            <td class="text-danger bg-warning">{{number_format($todayDebts,2)}}</td>
            <td class="bg-info"> :سەرجەمی پارەی هاتووی ئەمڕۆ   </td>
        </tr>
<tr ><td class="bordered-0"></td></tr>
         <tr>
            <td class=" bordered-0"> </td>
            <td class="text-danger bg-warning">{{number_format($todaySales,2)}}</td>
            <td class="bg-info"> :سەرجەمی وەسڵی فرۆشتنی ئەمڕۆ</td>
      </tr>
      
      <tr ><td class="bordered-0"></td></tr>

         <tr>
            <td class="bordered-0"> </td>
            <td class="text-danger bg-warning">{{number_format($allincomeSales,2)}}</td>
            <td class="bg-info"> :سەرجەمی پارەی هاتوو لە وەسڵدا   </td>
        </tr>
<tr ><td class="bordered-0"></td></tr>

<tr>
            <td class="bordered-0"> </td>
            <td class="text-danger bg-warning">{{number_format($allincomeDebts,2)}}</td>
            <td class="bg-info"> :سەرجەمی پارەی هاتوو لە قەرزدا   </td>
        </tr>

      <tr ><td class="bordered-0"></td></tr>
         <tr>
            <td class=" bordered-0"> </td>
            <td class="text-danger bg-warning">{{number_format(($oldSales-$oldDebts)+$todaySales-$todayDebts,2)}}</td>
            <td class="bg-info"> :کۆی قەرزی ئێستا</td>
      </tr>
      <tr ><td class="bordered-0"></td></tr>

<tr>
<td class="bordered-0"> </td>
<td class="text-danger bg-warning">{{number_format((($oldSales-$oldDebts)+$todaySales-$todayDebts)-($allincomeDebts+$allincomeSales),2)}}</td>
<td class="bg-info"> :سەرجەمی پارە لە قاسەدا    </td>
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