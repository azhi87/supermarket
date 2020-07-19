@extends('layouts.master')
@section('content')

  <div class="row bordered-2" >  
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<br/>
    <strong><p style="font-size: 34px;  ">مەوادی مەخزەن</p> </strong>
<br/>
{{--    <div class="hidden-print bg-info"><a href="/reports/unconfirmedItems">ڕاپۆرتی مەواد - وەسڵی چێك نەکراو</a></div>--}}
</div>
</div>

<div class="row bordered-1" >
    <table class="table table-bordered table-responsive table-striped table-text-center tfs14boldc tfs12boldp" >
    <thead >
        <tr class="bg-info">
           
            <th>   ژ.مەخزەن  </th>
            <th>  بەرواری بەسەرچوون  </th>
            <th>  ناوی مەواد  </th>
             <th>  کۆد  </th>
        </tr>

    </thead>
   @foreach ($items as $item)
    
<tr>
              <td>{{$item->quantity}}</td>
              <td>{{$item->exp}}</td>
     
<td>@php echo (\App\Item::find($item->id)->name) @endphp</td>
<td class="bg-warning color-brown">{{$item->id}}</td>

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