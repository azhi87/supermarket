<div class="col-md-7">
	<div class="card card-topline-green">
		<div class="card-head">
			<header>List of Drugs</header>
		</div>

		<div class="form-group row mt-2 ml-5">
			<label class="col-sm-3 control-label">Search Items by name, barcode</label>
			<div class="col-sm-9">
				<input type="text" wire:model="query">
			</div>
		</div>

		<div class="card-body bg-light">
			<div class="table-scrollable">
					<table class="table table-bordered table-striped ">
						<thead class="bg-success">
							<tr class="text-center">
								<th>Barcode</th>
								<th>Drug Name</th>
								<th>Scientific Name</th>
								@if(Auth::user()->type=='admin')
								<th class="hidden-print">Edit</th>
								@endif
							</tr>
						</thead>

						<tbody>
							@foreach ($items as $item)
							<tr class="text-center">
								<td>{{$item->barcode}}</td>
								<td>{{$item->name}}</td>
								<td>{{$item->name_en}}</td>
								<td class="hidden-print"><a href={{"/items/edit/".$item->id}}><span class="fa fa-edit fa-1x"></span></a>
								</td>
							</tr>
							@endforeach
						</tbody>

					</table>
				{{ $items->links() }}
			</div>
		</div>
	</div>
</div>
</div>