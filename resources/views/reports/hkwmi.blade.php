@extends('layouts.master')
@section('content')

<div class="row bordered-2">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<br>
	<strong><p style="font-size: 36px; "> ڕاپۆرتی مەواد - حوکمی </p> </strong>
    <br>
</div>
</div>
   
<div class="row bordered-1" >
		<table class="table table-bordered table-striped table-responsive table-text-center tfs14boldc tfs12boldp " >
    <thead >
        <tr  class="bg-info">
        <th> تێبینی</th>
          <th class="bg-danger">ژمارەی وەصل</th>
           <th>بەروار</th>
            <th >ناوی مەواد</th>
            <th>ناوی تاقیگه</th>
        </tr>
    </thead>
<tbody>
      @foreach ($sales as $sale)
         @foreach ($sale->items as $item)
  <tr>
  <td > {{$sale->description}}</td>
<td  ><a href="/sale/seeSales/{{$sale->id}}">{{$sale->id}}</a>
<td>{{$sale->created_at->format('d-m-Y')}}
<td > {{$item->name}}</td>
<td>{{$sale->customer->lab_name}}</td>
  </tr>
 @endforeach
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
  $('#report').addClass('menu-top-active');
  });
 </script>

 @endsection