<div class="col-md-7">
	<div class="card card-topline-green">
		<div class="card-head">
			<header>List of Drugs</header>
		</div>
		<div class="row mt-2 ml-2">
			<div class="col-md-12">
				<input type="text" placeholder="Search by name,barcode" wire:model="query">
			</div>
		</div>

		<div class="card-body bg-light">
			<div class="table-scrollable">
				<table class="table table-bordered table-striped ">
					<thead class="text-light bg-info">
						<tr class="text-center">
							<th>Barcode</th>
							<th>Drug Name</th>
							<th>Scientific Name</th>
							<th class="hidden-print">Edit</th>
						</tr>
					</thead>

					<tbody>
						@foreach ($items as $item)
						<tr class="text-center">
							<td>{{$item->barcode}}</td>
							<td>{{$item->name}}</td>
							<td>{{$item->name_en}}</td>
							<td class="hidden-print"><a href={{ route('edit-item', $item->id)}}><span
										class="fa fa-edit fa-1x"></span></a>
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