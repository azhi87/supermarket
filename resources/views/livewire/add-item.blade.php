<div class="row">
	<div class="col-md-5 col-sm-12">
		<div class="card card-topline-green">
			<div class="card-head">
				<header>Add Drug</header>
			</div>
			<div class="card-body bg-light " id="bar-parent1">
				@include('layouts.errorMessages')
				<form class="form-horizontal" method="POST" wire:submit.prevent='store'>
					<div class="form-group row">
						<label class="col-sm-3 control-label">Barcode</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="horizontalFormEmail" wire:model.lazy='barcode'>
						</div>
						@error('barcode')
						<p class="text-sm text-danger">{{ $message }}</p>
						@enderror
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label">Drug Name</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" wire:model.lazy='name'>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label">Scientific Name</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" wire:model.lazy='name_en'>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label">Items Per Packet</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" wire:model.lazy='items_per_box'>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label">Dosage Form</label>
						<div class="col-sm-9">
							<select class="form-control" wire:model.lazy='category_id'>
								<option></option>
								@foreach ($cats->sortby('category') as $cat)
								<option value="{{$cat->id}}">{{$cat->category}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label">Manufacturer</label>
						<div class="col-sm-9">
							<select class="form-control" wire:model.lazy='manufacturer_id' required>
								<option></option>
								@foreach ($mans->sortby('name') as $man)
								<option value="{{$man->id}}">{{$man->name}}</option>
								@endforeach
							</select>
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

			<div class="col-md-12">
				<div class="card card-topline-green">
					<div class="card-head">
						<header>Add Dosage</header>
					</div>
					<div class="card-body bg-light " id="bar-parent1">
						<form class="form-horizontal" method="POST" action="/cats/add">
							{{csrf_field()}}
							<div class="input-group has-warning">
								<input type="text" name="cat" class="form-control" placeholder="Add new Dosage Form">
								<span class="input-group-btn">
									<button class="btn btn-primary" type="submit"><b>Add</b></button>
								</span>
							</div>
							<div class="form-group">
								<div class="offset-md-3 col-md-9">
									<a type="button" href="/peripheralUpdates" class="btn btn-info btn-primary">
										<b>Update Dosage Form </b></a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			@livewire('add-manufacturer')
	</div>
            @livewire('show-item')
</div>

