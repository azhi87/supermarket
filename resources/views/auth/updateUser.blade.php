@extends('layouts.master')
@section('content')
<div class="row">
	<div class="col-md-3"></div>
	<div class="col-md-6 col-sm-12">
		<div class="card card-topline-green">
			<div class="card-head">
				<header>Update User</header>
			</div>
			<div class="card-body bg-light " id="bar-parent1">
				@include('layouts.errorMessages')
				<form class="form-horizontal" role="form" method="POST" action="/users/update/{{$user->id}}">
					{{ csrf_field() }}
					<div class="row form-group{{ $errors->has('name') ? ' has-error' : '' }}">
						<label for="name" class="col-md-4 control-label">Full Name </label>
						<div class="col-md-8">
							<input id="name" type="text" class="form-control" name="name" class="form-control"
								value="{{ $user->name}}" required autofocus>
						</div>
					</div>

					<div class="row form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
						<label for="mobile" class="col-md-4 control-label">Mobile# </label>
						<div class="col-md-8">
							<input id="mobile" type="text" class="form-control" name="mobile" value="{{$user->mobile}}"
								required autofocus>
						</div>
					</div>

					<div class="row form-group{{ $errors->has('email') ? ' has-error' : '' }}">
						<label for="email" class="col-md-4 control-label">Email</label>
						<div class="col-md-8">
							<input id="email" type="email" class="form-control" name="email" value="{{$user->email}}"
								required>
						</div>
					</div>

					<div class="row form-group{{ $errors->has('type') ? ' has-error' : '' }}">
						<label for="email" class="col-md-4 control-label"> Role </label>
						<div class="col-md-8">
							<select type="type" class="form-control" name="type" required>
								<option selected="selected" value="{{$user->type}}">{{$user->typeText()}}</option>
								<option value="staff"> Staff</option>
								<option value="admin">Admin</option>
							</select>
						</div>
					</div>

					<div class="row form-group{{ $errors->has('password') ? ' has-error' : '' }}">
						<label for="password" class="col-md-4 control-label"> Password</label>
						<div class="col-md-8">
							<input id="password" type="password" class="form-control" name="password">
						</div>
					</div>

					<div class="row form-group">
						<label for="password-confirm" class="col-md-4 control-label">Confirm Password </label>
						<div class="col-md-8">
							<input id="password-confirm" type="password" class="form-control"
								name="password_confirmation">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-6 ">
							<button type="submit" class="btn btn3d btn-primary btn-block">
								<b> Save </b>
							</button>
						</div>
					</div>
				</form>
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