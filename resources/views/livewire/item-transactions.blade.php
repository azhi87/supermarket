<div>
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-6">
					<div class="card card-topline-green">
						<div class="card-body">
							<div class="table-scrollable">
								<table class="table text-center">
									<thead class="bg-info text-light">
										<tr>
											<th> Type </th>
											<th> Quantity</th>
											<th> Total Price</th>
											<th> Currency </th>
										</tr>

									</thead>
									<tbody>
										<tr>
											<th> Sale </th>
											<td> {{ number_format(abs($transactions->where('type','sale')->sum('quantity')),0)}} </td>
											<td>
												{{ number_format(abs($transactions->where('type','sale')->sum('ppi')),0)}}
											</td>
											<td> IQD </td>
										</tr>
										<tr>
											<th> Returned sale </th>
											<td> {{ number_format(abs($transactions->where('type','returned_sale')->sum('quantity')),0) }} </td>
											<td>
												{{ number_format(abs($transactions->where('type','returned_sale')->sum('ppi')),0) }}
											</td>
											<td> IQD </td>
										</tr>
									</tbody>
								</table>
							</div>
							{{-- {{ $transactions->links()}} --}}
						</div>
					</div>
				</div>

				<div class="col-sm-6">
					<div class="card card-topline-green">
						<div class="card-body">
							<div class="table-scrollable">
								<table class="table text-center">
									<thead class="bg-info text-light">
										<tr>
											<th> Type </th>
											<th> Quantity</th>
											<th> Total Price</th>
											<th> Currency </th>
										</tr>

									</thead>
									<tbody>
										<tr>
											<th> Purchase </th>
											<td> {{ number_format(abs($transactions->where('type','purchase')->sum('quantity')),0)}} </td>
											<td>
												{{ number_format(abs($transactions->where('type','purchase')->sum('ppi')),0)}}
											</td>
											<td> $ </td>
										</tr>
										<tr>
											<th> Returned Purchase </th>
											<td> {{ number_format(abs($transactions->where('type','returned_purchase')->sum('quantity')),0)}} </td>
											<td>
												{{ number_format(abs($transactions->where('type','returned_purchase')->sum('ppi')),0)}}
											</td>
											<td> $ </td>
										</tr>
									</tbody>

								</table>
							</div>
							{{-- {{ $transactions->links()}} --}}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="card card-topline-green">
				<div class="card-head bg-info text-light">
					<header>Drug transactions</header>
				</div>
				<div class="card-body">
					<div class="table-scrollable">
						<table class="table text-center">
							<thead class="bg-info text-light">
								<tr>
									<th> # </th>
									<th> Type </th>
									<th> Quantity </th>
									<th> Bonus </th>
									<th> Price </th>
									<th> Date </th>
									<th> Expirey date </th>
									<th> Description </th>
									<th> Details </th>
								</tr>
							</thead>

							@foreach ($transactions as $transaction)
							<tr style="line-height:12px;" class="{{ $transaction->type }}">
								<td> {{ $loop->iteration }}</td>
								<td> {{ $transaction->type }} </td>
								<td> {{ abs( $transaction->quantity - $transaction->bonus ) }} </td>
								<td> {{ abs( $transaction->bonus ) }} </td>
								<td> {{ abs( number_format($transaction->ppi,2) ) }} </td>
								
								<td> {{ $transaction->created_at->format('d-m-Y') }} </td>
								<td> {{ $transaction->exp }} </td>
								<td> {{ $transaction->description }} </td>
								<td>
									<a href="{{ substr($transaction->type,-4)==='sale' ? 
                                                        route('show-sales',$transaction->source_id):
                                                        route('show-purchases',$transaction->source_id) }}"><i class="fa fa-eye"></i></a>
								</td>
							</tr>
							@endforeach
						</table>
					</div>
					{{-- {{ $transactions->links()}} --}}
				</div>
			</div>
		</div>
	</div>
</div>
