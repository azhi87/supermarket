
@extends('layouts.master')
@section('content')
	<div class="page-content">
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
								<h3><b>INVOICE</b> <span class="pull-right">#{{$sale->id}}</span></h3>
								<hr>
								<div class="row">
									<div class="col-md-12 hidden">
										<div class="pull-left">s
											<address>
												<img src="img/invoice_logo.png" alt="logo" class="logo-default" />
												<p class="text-muted m-l-5">
													D 103, RedStar Hospital, <br> Opp. Town Hall, <br>
													Sardar Patel Road, <br> Ahmedabad - 380015
												</p>
											</address>
										</div>
										<div class="pull-right text-right">
											<address>
												<p class="addr-font-h3">To,</p>
												<p class="font-bold addr-font-h4">Jayesh Patel</p>
												<p class="text-muted m-l-30">
													207, Prem Sagar Appt., <br> Near Income Tax Office, <br>
													Ashram Road, <br> Ahmedabad - 380057
												</p>
												<p class="m-t-30">
													<b>Invoice Date :</b> <i class="fa fa-calendar"></i> {{$sale->created_at->format('d/m/Y')}}
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
														<th>Drug Name</th>
														<th class="text-right">Packs</th>
														<th class="text-right">Sheets</th>
														<th class="text-right">Price</th>
														<th class="text-right">Subtotal</th>
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