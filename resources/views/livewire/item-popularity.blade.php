<div>
<div class="row">
    <div class="mx-auto"
    <h4>Showing data for the past <input type="number" wire:model="days" style="width:70px;text-align:center;" /> days</h4>
    </div>
</div>

<div class="row">

	<div class="col-md-6">
		<div class="row">
			<div class="col-sm-12">
				<div class="card card-topline-green">
					<div class="card-head bg-success text-white">
						<header>Most Popular Items</header>
					</div>
					<div class="card-body">
						<div class="table-scrollable">
							<table class="table text-center table-striped">
								<thead>
									<tr class="bg-info">
										<th> # </th>
										<th> Name </th>
										<th> Packs sold </th>
									</tr>
								</thead>
							
                        @foreach ($populars as $item)
                        <tr style="line-height:12px;">
                            <td> {{ $loop->iteration }}</td>
                            <td> {{ $item->item->name }}</td>
                        <td class="text-danger"><strong>{{ number_format(-1 * $item->quantity, 2) }}</strong></td>
                        </tr>
                        @endforeach
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
    
    	<div class="col-md-6">
		<div class="row">
			<div class="col-sm-12">
				<div class="card card-topline-red">
					<div class="card-head bg-danger">
						<header>Least Popular Items</header>
					</div>
					<div class="card-body">
						<div class="table-scrollable">
							<table class="table text-center table-striped">
								<thead>
									<tr class="bg-info">
										<th> # </th>
										<th> Name </th>
										<th> Packs sold </th>
									</tr>
								</thead>
							
                        @foreach ($leastPopulars as $item)
                        <tr style="line-height:12px;">
                            <td> {{ $loop->iteration }}</td>
                            <td> {{ $item->item->name }}</td>
                        <td class="text-danger"><strong>{{ number_format(-1 * $item->quantity, 2) }}</strong></td>
                        </tr>
                        @endforeach
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
						


</div>
</div>