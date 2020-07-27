
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
								<h1 class="text-center">دەرمانخانەی خێزان</h1>
								<hr>
								<div class="row">
									<div class="col-md-12">
										<div class="pull-left">  
											<address>
												<img src="img/invoice_logo.png" alt="logo" class="logo-default" />
												<p class="text-muted m-l-5">
												کۆتای شەقامی ابراهیم پاشا, تەنیشت فولکەی گۆزەکان , <br>
													تەلاری پزیشکی خێزانی تەندروست <br>
												</p>
											</address>
										</div>
										<div class="pull-right text-right">
											<address>
												<p class="addr-font-h4"> <b> مۆبایل :</b> 07700202023</p>
												<p class="addr-font-h4"> <b> کاشێر :</b >  {{$sale->user->name}}  </p>
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
														<th class="text-right">کۆ</th>
														<th class="text-right">نرخ</th>
														<th class="text-right">دانە</th>
														<th class="text-right">پاکەت</th>
														<th>ناوی دەرمان </th>
														<th class="text-center">ژ</th>
													</tr>
												</thead>
												<tbody>
													@foreach($sale->items as $item)
													<tr>
														<td class="text-right">{{number_format((($item->pivot->quantity)+($item->pivot->singles/$item->items_per_box))*$item->pivot->ppi,0)}}</td>
														<td class="text-right">{{$item->pivot->ppi}}</td>
														<td class="text-right">{{$item->pivot->singles}}</td>
														<td class="text-right">{{$item->pivot->quantity}}</td>
														<td>{{$item->name}}</td>
														<td class="text-center">{{$loop->iteration}}</td>
													</tr>
													@endforeach
													
												</tbody>
											</table>
										</div>
									</div>
									<div class="col-md-12">
										<div class="pull-right m-t-30 text-right">
											<p>Total amount: {{number_format($sale->total,0)}}</p>
										</div>
										<div class="clearfix"></div>
										<hr>
										<div class="text-right">
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