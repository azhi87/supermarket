<div>
<br/>

<div class="row">
    <div class="col-md-4">
		<div class="row">
			<div class="col-sm-12">
				<div class="card card-topline-green">
					<div class="card-body">
						<div class="table-scrollable">
							<table class="table text-center">
								<thead class="bg-info">
									<tr >
										<th> Type </th>
										<th> Quantity</th>
										<th> Price</th>
										<th> Currency </th>
                                    </tr>
                                   
                                </thead>
                                <tbody>
                                     <tr >
										<th> Sale </th>
										<td> {{ number_format(abs($transactions->where('type','sale')->sum('quantity')),2)}} </td>
										<td> 
                                             {{ number_format(abs($transactions->where('type','sale')->sum(function($transaction){
                                                    return $transaction->quantity * $transaction->ppi;
                                            })),0)}}
                                        </td>
                                        <td> ID </td>
                                    </tr>
                                     <tr >
										<th> Purchase </th>
										<td> {{ number_format(abs($transactions->where('type','purchase')->sum('quantity')),2)}} </td>
										<td> 
                                            {{ number_format(abs($transactions->where('type','purchase')->sum(function($transaction){
                                                    return $transaction->quantity * $transaction->ppi;
                                            })),2)}}
                                        </td>
                                        <td> $ </td>
                                    </tr>
                                     <tr >
										<th> Returned sale </th>
										<td> {{ number_format(abs($transactions->where('type','returned_sale')->sum('quantity')),2)}} </td>
										<td> 
                                            {{ number_format(abs($transactions->where('type','returned_sale')->sum(function($transaction){
                                                    return $transaction->quantity * $transaction->ppi;
                                            })),0)}}
                                        </td>
                                        <td> ID </td>
                                    </tr>
                                     <tr >
										<th> Returned Purchase </th>
										<td> {{ number_format(abs($transactions->where('type','returned_purchase')->sum('quantity')),2)}} </td>
										<td> 
                                            {{ number_format(abs($transactions->where('type','returned_purchase')->sum(function($transaction){
                                                    return $transaction->quantity * $transaction->ppi;
                                            })),2)}}
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
	<div class="col-md-8 mx-auto">
		<div class="row">
			<div class="col-sm-12">
				<div class="card card-topline-green">
					<div class="card-head bg-success text-white">
						<header>Drug transactions</header>
					</div>
					<div class="card-body">
						<div class="table-scrollable">
							<table class="table text-center">
								<thead class="bg-info">
									<tr >
										<th> # </th>
										<th> Name </th>
										<th> quantity </th>
										<th> Price </th>
										<th> Type </th>
										<th> Date </th>
										<th> Expirey date </th>
										<th> Description </th>
										<th> Details </th>
									</tr>
								</thead>
							
                        @foreach ($transactions as $transaction)
                        <tr style="line-height:12px;" class="{{ $transaction->type }}">
                            <td> {{ $loop->iteration }}</td>
                            <td> {{ $transaction->item->name }} </td>
                            <td> {{ abs( $transaction->quantity ) }} </td>
                            <td> {{ abs( $transaction->ppi * $transaction->quantity ) }} </td>
                            <td> {{ $transaction->type }} </td>
                            <td> {{ $transaction->created_at->format('d-m-Y') }} </td>
                            <td> {{ $transaction->exp }} </td>
                            <td> {{ $transaction->description }} </td>
                            <td>
                                <a 
                                    href="{{ substr($transaction->type,-4)==='sale' ? 
                                                        route('show-sales',$transaction->source_id):
                                                        route('show-purchases',$transaction->source_id) }}"
                                ><i class="fa fa-eye"></i></a>
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
    
    	
	</div>
						


</div>
