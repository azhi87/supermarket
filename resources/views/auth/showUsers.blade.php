@extends('layouts.master')
@section('content')

<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10">
		<div class="row">
			<div class="col-sm-12">
				<div class="card card-topline-green">
					<p class="text-center">
						<a type="button" href="/register" class="btn btn-primary btn-lg btn3d"><strong>Add New User </strong></span></a>
					</p>
					<div class="card-head">
						<header>List of Employees</header>
					</div>
					<div class="card-body ">
						<div class="table-scrollable">
							<table class="table text-center bg-light">
								<thead>
									<tr class="custom_centered bg-success">
										<th>ID</th>
										<th>Name </th>
										<th>Email</th>
										<th>Role</th>
										<th>Join Date</th>
										<th class="hidden-print">Edit</th>
										<th class="hidden-print">Deactivate</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($users as $user)
									<tr class="text-center">
										<td>{{$user->id}}</td>
										<td>{{$user->name}}</td>
										<td>{{$user->email}}</td>
										<td>{{$user->typeText()}}</td>

										<td>{{$user->created_at->format('d/m/Y')}}</td>
										<?php $user->status == "0" ? $btn = "btn-primary" : $btn = "btn-danger"; ?>
										<td class="hidden-print">
											<a href="/users/edit/{{$user->id}}" class="btn btn-lg"><i class="fa fa-edit fa-1a"></i>
											</a>
										</td>
										<td class="hidden-print">
											<a href="/users/toggle/{{$user->id}}" type="button" class="btn {{$btn}}  btn3d"><span class="fa fa-power-off fa-1x"></span></a></td>
									</tr>
									@endforeach
								</tbody>
							</table>
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
	$(document).ready(function() {
		$("#menu-top li a").removeClass("menu-top-active");
		$('#user').addClass('menu-top-active');
	});
</script>

@endsection