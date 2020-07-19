@extends('layouts.master')
@section('content')

<div class="row text-right">
<h1 class="text-center color-red">گۆڕانکاری هێدەری وەصلی فرۆشتن</h1>
<form method="post" action='/invoice_headers/update'>
	{{csrf_field()}}
	<div class="form-group">
		<label for="exampleInputName2">دێڕی یەکەم</label>
		<input type="text" name="line1" class="form-control" value="{{$invoice_headers->line1}}">
	</div>
	<div class="form-group">
		<label for="exampleInputEmail2">دێڕی دووەم</label>
		<input type="text" name="line2" class="form-control" value="{{$invoice_headers->line2}}">
	</div>
	<div class="form-group">
		<label for="exampleInputEmail2">سێیەم دووەم</label>
		<input type="text" name="line3" class="form-control" value="{{$invoice_headers->line3}}">
	</div>
	<div class="form-group">
		<label for="exampleInputEmail2">ناونیشان</label>
		<input type="text" name="address" class="form-control" value="{{$invoice_headers->address}}">
	</div>
	<div class="form-group">
		<label for="exampleInputEmail2">ژمارەی مۆبایل</label>
		<input type="text" name="mobiles" class="form-control" value="{{$invoice_headers->mobiles}}">
	</div>
	<div class="form-group">
		<label for="exampleInputEmail2">ژ.محاسب</label>
		<input type="text" name="mobiles2" class="form-control" value="{{$invoice_headers->mobiles2}}">
	</div>
	<button type="submit" class="btn btn-primary">تۆمارکردن</button>
</form>
@endSection