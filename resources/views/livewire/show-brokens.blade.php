<div class="col-md-7">
    <div class="card card-topline-green">
        <div class="card-head">
            <header>Expired | Lost Drugs</header>
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
                            <th>Quantity </th>
                            <th>Date</th>
                            <th>User</th>
                            <th>Delete</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($brokens as $broken)
                        <tr class="text-center">
                            <td>{{$broken->item->barcode}}</td>
                            <td>{{$broken->item->name}}</td>
                            <td>{{$broken->quantity}}</td>
                            <td>{{$broken->created_at->format('d-m-Y')}}</td>
                            <td>{{$broken->user->name}}</td>
                            <td>
                                <button class="btn btn-danger" wire:click.prevent='showDeleteButton'>Delete</button>
                                @if($showDeleteButton === true)
                                <button class="btn btn-warning" wire:click.prevent="delete({{ $broken->id }})">Confirm
                                    delete?</button>
                                @endif
                            </td>


                        </tr>
                        @endforeach
                    </tbody>

                </table>
                {{ $brokens->links() }}
            </div>
        </div>
    </div>
</div>