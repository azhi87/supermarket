@extends('layouts.master')

@section('content')
<br>

<div class="row">
<div class="col-md-12 col-sm-12">
<div class="panel panel-success">
<div class="panel panel-heading text-center"> <strong class="h2">لیستی مەوادەکان </strong></div>
<table class="table table-responsive table-bordered table-text-center bg-success">

	<thead>
		<tr class="h4">
			<th>   نرخی  تایبەت</th>
			<th>    کەنترین نرخی فرۆشتن</th>
			<th>   نرخی فرۆشتن</th>
			<th>  ناوی مەواد</th>
			<th> کۆدی مەواد</th>
		</tr>
	</thead>
	<tbody >

	<form action="/customerItems" method="POST">
		{{csrf_field()}}
		<div class="row" style="padding-bottom: 10px;">
			<div class="col-md-1"></div>
<div class="col-md-3">
		<a type="button" class="btn-lg btn-primary" href="/customers">گەڕانەوە</a>
</div>

<div class="col-md-6" > 
		<input class="text-center" type="text" name="customer_id" value="{{$customer_id}}" readonly="readonly"> کۆدی کڕیار	
</div>
</div>
	@foreach ($items as $item)
		<tr class="h4">
			<td ><input class="text-center" name="sale_price[]" onBlur="checkMinPrice(this.id,{{$item->min}})" id="sale_price{{$item->id}}"  type="text"  value="{{$item->specialPrice($customer_id)}}"></td>
			<td>{{$item->min}}</td>
			<td>{{$item->sale_price}}</td>
			<td>{{$item->name}}</td>
			<td ><input class="text-center" name="item_id[]"  type="text"  value="{{$item->id}}" readonly="readonly"></td>
		</tr>
	@endforeach
<tr><td></td></tr>
<tr>
	<td colspan="4"><button type="submit" class="btn btn-lg btn-primary"><b>تۆمارکردن</b></button>
		</td>
</tr>
		</form>

	</tbody>
</table>

</div>
</div>





</div>
@endsection
@section('afterFooter')
<script type="text/javascript">
	function checkMinPrice(id,min)
	{
		price=$("#"+id).val();
		if(price<min)
		{
			$("#"+id).val(min);
			$("#"+id).css('border-color','red');

		}
		else
		{
			$("#"+id).css('border-color','green');
		}
	}
</script>
@endsection