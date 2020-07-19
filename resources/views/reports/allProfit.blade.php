@extends('layouts.master')
@section('content')

<div class="row bordered-1">

<div class="col-md-12 col-sm-12">
<br>
        @if(isset($from) && isset($to))
                    <div class="col-md-6 text-center col-md-offset-3">
                        <label class="text-center text-danger"><span class="color-black">بۆ بەرواری : </span>  {{$to}} </label> 
                        <label class="text-center text-danger"><span class="color-black">لە بەرواری: </span> {{$from}} </label>         
                    </div>
        @endif
        <table class="table text-center tseparate table-bordered tfs16boldc tfs20boldp margin-1">
        <tbody >
        <tr  >

            <td class="col-print-1 bordered-0"> </td>
            <td class="col-print-1 "><i class="fa fa-dollar "></i> </td>
            <td class="col-print-3  text-danger bg-warning"> {{number_format($profits['purchase'],2)}}</td>
            <td class="col-print-3 bg-info"> : سەرجەمی کڕین  </td>
        </tr>
<tr ><td class="bordered-0"></td></tr>
         <tr  >

            <td class="bordered-0"> </td>
            <td ><i class="fa fa-dollar "></i></td>
            <td class="text-danger bg-warning"> {{number_format($profits['sale'],2)}}</td>
            <td class="bg-info"> :سەرجەمی فرۆشتن  </td>
        </tr>

<tr ><td class="bordered-0"></td></tr>
         <tr  >
            <td class=" bordered-0"> </td>
            <td ><i class="fa fa-dollar "></i></td>
            <td class="text-danger bg-warning"> {{number_format($profits['expense'],2)}}</td>
            <td class="bg-info"> :سەرجەمی مەسراف </td>
      </tr>

 <tr ><td class="bordered-0"></td> </tr>
         <tr  >
            <td class=" bordered-0"> </td>
            <td ><i class="fa fa-dollar "></i></td>
            <td class="text-danger bg-warning"> {{number_format($profits['itemProfit'],2)}}</td>
            <td class="bg-info"> : قازانج لە فرۆشتنی مەواد  </td>
 </tr>  

<tr ><td class="bordered-0"></td></tr>
         <tr  >
            <td class=" bordered-0"> </td>
            <td ><i class="fa fa-dollar "></i></td>
            <td class="text-danger bg-warning"> {{number_format($profits['totalProfit'],2)}}</td>
            <td class="bg-info"> :قازانجی گشتی  </td>
 </tr>  


 </tbody>
</table>
</div>
</div>

@endsection