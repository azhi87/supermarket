@extends('layouts.master')
@section('content')

<br/>

<div class="row bordered-2">
	
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
</br>
	<strong><p style="font-size: 48px; "> ڕاپۆرتی مەواد بەپێی کڕیار </p> </strong>
    </br>
    </br>
</div>
</div>

<div class="row bordered-1" >

<br>
    <table class="table table-bordered tseparate-1 table-text-center tfs16boldc tfs16boldp " >
    <tbody>

        <tr  >
            <td class="col-print-11 bordered-0" ></td>
            <td class="col-print-4 " > {{$name}}</td>
            <td class="col-print-2 bg-info">: ناوی کڕیار</td> 
            <td class="col-print-11 bordered-0" ></td>
             
        </tr>  
</tbody>
</table>


</div>

<div class="row bordered-1" >
<div class="col-md-5">
        <table class="table table-bordered table-striped table-responsive table-text-center">
    <thead >
        <tr class="bg-danger"><td colspan="3"><strong>مەوادی نەکڕراو<strong></td></tr>
        <tr  class="bg-info">
            <th class="col-print-6">ناوی مەواد</th>
            <th class="col-print-2">کۆدی مەواد</th>
            <th>#</th>
        </tr>
    </thead>

    <tbody>
    <?php $i=1;?>
       @foreach ($zeroItems as $item)
        <tr>
            <td>{{$item->name}}</td>
            <td class="bg-warning color-brown"">{{$item->id}}</td>
            <td>{{$i++}}</td>
        </tr>
        @endforeach
 </tbody>
</table>
 </div>
<div class="col-md-7">
		<table class="table table-bordered table-striped table-responsive table-text-center">
    <thead >
         <tr class="bg-primary"><td colspan="4"><strong>مەوادی کڕراو</strong></td></tr>
        <tr  class="bg-info">
           
            <th class="col-print-2">سەرجەمی کارتۆن</th>
            <th class="col-print-6">ناوی مەواد</th>
            <th class="col-print-2">کۆدی مەواد</th>
            <th>#</th>
        
        </tr>
          
    </thead>

<tbody>
      <?php $i=1;?>
      @foreach ($items as $item)
        <tr>
            <td class="bg-warning color-brown">{{number_format($item->tqty,0)}}</td>
            <td> {{$item->name}}</td>
            <td class="bg-warning color-brown"">{{$item->id}}</td>
            <td>{{$i++}}</td>
        </tr>
 @endforeach
 </tbody>
</table>
 </div>

 
</div>


<br/>
<br/>

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