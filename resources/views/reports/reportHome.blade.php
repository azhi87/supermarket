
@extends('layouts.master')

<?php $drivers = new App\User();  
		 $mandwbs = $drivers->mandwbs();
        $drivers = $drivers->drivers();
        $suppliers=\App\Supplier::all();

?>

@section('content')
<br>
<div class="row">
						<div class="col-md-4 col-sm-6 col-xs-10">
							<div class="card card-topline-green">
								<div class="card-head bg-light">
									<header>Income</header>
									@include('layouts.errorMessages')
								</div>
								<div class="card-body " id="bar-parent">
									<form method="POST" action="/reports/income" id="contact_form">
										{{csrf_field()}}
													<fieldset class="form-group">
														<label for="id">From</label>
														<input type="date" class="form-control" name="from" >
													</fieldset>
													<fieldset class="form-group">
														<label for="formGroupExampleInput2">To</label>
														<input type="date" name="to"  class="form-control" required>
													</fieldset>
											<div class="form-group">
											<div class="col-md-12">
															<button type="submit" class="btn btn-primary btn3d btn-block"><strong>Search</strong></button>
											</div>
											</div>
									</form>
										
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-6 col-xs-10 hidden">
							<div class="card card-topline-green">
								<div class="card-head bg-light">
									<header>Money By Date</header>
									@include('layouts.errorMessages')
								</div>
								<div class="card-body " id="bar-parent">
									<form method="POST" action="/reports/profit" id="contact_form">
										{{csrf_field()}}
													<fieldset class="form-group">
														<label for="id">From</label>
														<input type="date" class="form-control" name="from" >
													</fieldset>
													<fieldset class="form-group">
														<label for="formGroupExampleInput2">To</label>
														<input type="date" name="to"  class="form-control" required>
													</fieldset>
											<div class="form-group">
											<div class="col-md-12">
															<button type="submit" class="btn btn-primary btn3d btn-block"><strong>Search</strong></button>
											</div>
											</div>
									</form>
										
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-6 col-xs-10">
							<div class="card card-topline-green">
								<div class="card-head bg-light">
									<header>Expirey Report</header>
									@include('layouts.errorMessages')
								</div>
								<div class="card-body " id="bar-parent">
									<form method="POST" action="/stock/expiry" id="contact_form">
										{{csrf_field()}}
													
													<fieldset class="form-group">
														<label for="formGroupExampleInput2">To</label>
														<input type="date" name="date"  class="form-control" required>
													</fieldset>
											<div class="form-group">
											<div class="col-md-12">
															<button type="submit" class="btn btn-primary btn3d btn-block"><strong>Search</strong></button>
											</div>
											</div>
									</form>
										
								</div>
							</div>
						</div>
</div>



{{-- <div class="row bg-success">
    @if(Auth::user()->type=='admin')
<div class="col-md-3 col-sm-6 col-xs-10">
@include('layouts.errorMessages')
       <div class="panel panel-info">
                <div class="panel-heading text-center">
                 <span class='h3 color-black'> ڕاپۆرتی مەوادی مەخزەن </span>
                </div>
                <div class="panel-body text-right">

<a type="button" href='/reports/stockValuation' class=" btn btn-primary btn-block btn3d"><strong>Search</strong></a>
		</div>
</div>
</div>
@endif
</div> --}}


 


 @endsection
@section('afterFooter')
 <script type="text/javascript">
 	$(document).ready(function () {
  $("#menu-top li a").removeClass("menu-top-active");              
  $('#report').addClass('menu-top-active');
  });
 </script>

 @endsection

 @section('afterFooter')
 <script type="text/javascript">
    $(document).ready(function () {
  $("#menu-top li a").removeClass("menu-top-active");              
  $('#report').addClass('menu-top-active');
  });
 </script>

 @endsection


