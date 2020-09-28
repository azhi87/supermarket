@extends('layouts.master')
@section('content')
<div class="row">
	<div class="col-md-5">
		<div class="card card-topline-green">
			<div class="card-head">
				<header>List of Dosage Form</header>
			</div>
			<div class="card-body bg-light">
				<div class="table-scrollable">
					<table class="table table-bordered table-striped ">
						<thead class="bg-success">
							<tr class="text-center">
								<th>Name</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($cats->sortby('category') as $cat)
							<form action="/category/edit/{{$cat->id}}" method="POST">
							    @csrf
								<tr>
									<td><input class="text-center" name="category" type="text" value="{{$cat->category}}"></td>
									<td><button type="submit" class="btn btn-sm btn-primary"><b>Save</b></button></td>
								</tr>
							</form>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection