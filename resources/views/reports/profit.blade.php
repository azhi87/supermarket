@extends('layouts.master')

@section('content')

<br/>
<div class="row bordered-2" >
   
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
</br>
   <strong><p style="font-size: 48px; "> ڕاپۆرتی قازانجی گشتی کۆمپانیا </p> </strong>
    </br>
    </br>
</div>
</div>


<div class="row bordered-1">

<div class="col-md-12 col-sm-12 col-xs-12">
<br>
        

        <table class="table text-center table-bordered tfs16boldc tfs24boldp margin-1" >
        <tbody >
        <tr  >

            <td class="col-md-2 col-sm-1  bordered-0"> </td>
            <td class="col-md-1 col-sm-1 col-xs-1"><i class="fa fa-dollar "></i> </td>
            <td class="col-md-4 col-sm-5 col-xs-6 text-danger bg-warning"> Value4</td>
            <td class="col-md-3 col-sm-4 col-xs-5 bg-info"> : سەرجەمی کڕین  </td>
            <td class="col-md-2 col-sm-1  bordered-0"> </td>

        </tr>
<tr ><td class="bordered-0"></td></tr>
         <tr  >

            <td class="bordered-0"> </td>
            <td ><i class="fa fa-dollar "></i></td>
            <td class="text-danger bg-warning"> Value2</td>
            <td class="bg-info"> :سەرجەمی فرۆشتن  </td>
              <td class="bordered-0"> </td>
            </tr>
<tr ><td class="bordered-0"></td></tr>
         <tr  >
            <td class=" bordered-0"> </td>
            <td ><i class="fa fa-dollar "></i></td>
            <td class="text-danger bg-warning"> Value1</td>
            <td class="bg-info"> :سەرجەمی خەسم</td>
               <td class="bordered-0"> </td>
           </tr>

<tr ><td class="bordered-0"></td></tr>
         <tr  >
            <td class=" bordered-0"> </td>
            <td ><i class="fa fa-dollar "></i></td>
            <td class="text-danger bg-warning"> Value1</td>
            <td class="bg-info"> :سەرجەمی مەسراف </td>
     <td class="bordered-0"> </td>
      </tr>

<tr ><td class="bordered-0"></td></tr>
         <tr  >
            <td class=" bordered-0"> </td>
            <td ><i class="fa fa-dollar "></i></td>
            <td class="text-danger bg-warning"> Value1</td>
            <td class="bg-info"> :سەرجەمی مەسراف </td>
       <td class="bordered-0"> </td>
      </tr>

 <tr ><td class="bordered-0"></td></tr>
         <tr  >
            <td class=" bordered-0"> </td>
            <td ><i class="fa fa-dollar "></i></td>
            <td class="text-danger bg-warning"> Value1</td>
            <td class="bg-info"> :سەرجەمی مەوادی تەلەفکراو </td>
              <td class="bordered-0"> </td>

 </tr>      

 <tr ><td class="bordered-0"></td></tr>
         <tr  >
            <td class=" bordered-0"> </td>
            <td ><i class="fa fa-dollar "></i></td>
            <td class="text-danger bg-warning"> Value1</td>
            <td class="bg-info"> :سەرجەمی گۆڕینەوەی دۆلار  </td>
     <td class="bordered-0"> </td>
 </tr>      

 <tr ><td class="bordered-0"></td> </tr>
         <tr  >
            <td class=" bordered-0"> </td>
            <td ><i class="fa fa-dollar "></i></td>
            <td class="text-danger bg-warning"> Value1</td>
            <td class="bg-info"> : قازانج لە فرۆشتنی مەواد  </td>
     <td class="bordered-0"> </td>
      </tr>  

<tr ><td class="bordered-0"></td></tr>
         <tr  >
            <td class=" bordered-0"> </td>
            <td ><i class="fa fa-dollar "></i></td>
            <td class="text-danger bg-warning"> Value1</td>
            <td class="bg-info"> :قازانجی گشتی  </td>
                             <td class="bordered-0"> </td>
 </tr>  

 <tr ><td class="bordered-0"></td></tr>
         <tr  >
            <td class=" bordered-0"> </td>
            <td ><i class="fa fa-dollar "></i></td>
            <td class="text-danger bg-warning"> Value1</td>
            <td class="bg-info"> :سەرجەمی قەرزی کریار  </td>
                            <td class="bordered-0"> </td>
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