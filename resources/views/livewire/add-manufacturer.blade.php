	<div class="col-md-12">
		<div class="card card-topline-green">
			<div class="card-head">
				<header>Add Manufacturer</header>
			</div>
			<div class="card-body bg-light " id="bar-parent1">
				@include('layouts.errorMessages')
				@include('layouts.messages')
				<form class="form-horizontal" method="POST" wire:submit.prevent='store'>
					<div class="form-group row">
						<label class="col-sm-3 control-label">Name</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="horizontalFormEmail" wire:model.lazy = 'name'>
						</div>
					
					</div>
				
					<div class="form-group">
						<div class="offset-md-3 col-md-9">
							<button type="submit" class="btn btn-primary btn3d btn-block"><b>Save</b></button>
						</div>
					</div>
				</form>
				
			</div>
		</div>
	</div>
