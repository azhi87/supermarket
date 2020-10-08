
@extends('layouts.master')
@section('content')
	<div class="page-content" style="dir=rtl;">
					<div class="page-bar">
						<div class="page-title-breadcrumb">
							<div class=" pull-left">
								<div class="page-title">Invoice</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="white-box">
								<h1 class="text-center"><strong style="font-weight: bold !important; font-size: 46px !important;">  دەرمانخانەی خانی </strong></h1>
								<h1 class="text-center">KHEZAN PHARMACY</h1>
								<hr>
								<div class="row">
									<div class="col-md-12">
										<div class="pull-left">  
											<address>
												<img src="img/invoice_logo.png" alt="logo" class="logo-default" hidden/>
												<p class="text-muted m-l-5">
												   سلێمانی - سەرەتای شەقامی توویمەلیك، , <br>
													خوار نەخۆشخانەی ڕۆیال    <br>
												</p>
											</address>
										</div>
										<div class="pull-right">
											<address>
<!--												<p class="addr-font-h4"> <b> مۆبایل :</b> 07700202023</p>
-->												<p class="addr-font-h4"> <b> بەکارهێنەر :</b >  {{$sale->user->name}}  </p>
												<p class="m-t-30">
													<b> بەروار :</b> <i class="fa fa-calendar"></i> {{$sale->created_at}}
												</p>
												
											</address>
										</div>
									</div>
									<div class="col-md-12">
										<div class="table-responsive m-t-40">
											<table class="table table-hover">
												<thead>
													<tr>
														<th class="text-center">#</th>
														<th>Name  </th>
														<th class="text-right">Pack</th>
														<th class="text-right">Sheet</th>
														<th class="text-right">Price</th>
														<th class="text-right">Total</th>
													</tr>
												</thead>
												<tbody>
													@foreach($sale->items as $item)
													<tr>
														<td class="text-center">{{$loop->iteration}}</td>
														<td>{{$item->name}}</td>
														<td class="text-right">{{$item->pivot->quantity}}</td>
														<td class="text-right">{{$item->pivot->singles}}</td>
														<td class="text-right">{{$item->pivot->ppi}}</td>
														<td class="text-right">{{number_format((($item->pivot->quantity)+($item->pivot->singles/$item->items_per_box))*$item->pivot->ppi,0)}}</td>
													</tr>
													@endforeach
													
												</tbody>
											</table>
										</div>
									</div>
									<div class="col-md-12">
										<div class="pull-right m-t-30 text-right">
											<p class="h3"><strong>Total Amount: {{number_format($sale->total,0)}}</strong></p>
										</div>
										<div class="clearfix"></div>
										<hr>
										<div class="text-right hidden-print">
											<button onclick="javascript:window.print();" class="btn btn-default btn-outline" type="button"> <span><i
													 class="fa fa-print"></i> Print</span> </button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

@endsection
@section('afterFooter')
 <script type="text/javascript">
    $(document).ready(function () {
  $("#menu-top li a").removeClass("menu-top-active");              
  $('#sale').addClass('menu-top-active');
  });
 </script>

 @endsection