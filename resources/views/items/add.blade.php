@extends('layouts.master')
@section('content')
<br>
<div class="row hidden-print well">

		<div class="col-sm-7 hidden-print">
    <form method="post" action="/items/search" class="form-inline text-center">
    {{csrf_field()}}

            <div class="input-group">                            
                <select name="id" class="select2" id="select2" style="min-width:500px;">
                    <option value="0">Search for item</option>
                @foreach ($items_all as $item1)
                    <option value="{{$item1->id}}">{{$item1->name}}--{{$item1->category->category}}</option>
                @endforeach
            </select>
                <button class="btn btn-group-addon" type="submit"> Search<span class="fa fa-search fa-1x"></span></button>
            </div>
            
    <div class="col-sm-3 input-group-btn">
      
    </div>
    </form>
</div>
@if(Auth::user()->type=='admin')
<div class="col-sm-4">

<form method="POST" action="/cats/add">
{{csrf_field()}}
<div class="input-group has-warning input-group-sm">
      <input type="text" name="cat" class="form-control" placeholder="Add drug category">
      <span class="input-group-btn">
        <button class="btn btn-secondary btn-danger" type="submit"><b>Add</b></button>
      </span>
      </div>
</form>
    
    </div>
    @endif


 </div>
<div class="row">
						<div class="col-md-12">
<div class="row">
<div class="col-sm-9">
<div class="card card-topline-green">
		<div class="card-head">
			<header>List of Drugs</header>
			
		</div>
<div class="card-body">
	<div class="table-scrollable">
		<table class="table">
	<thead class="bg-success">
		<tr class="custom_centered">
	
			<th>Barcode</th>
			<th>Name</th>
			<th>Scientific Name</th>
			<th>Category</th>
			<th>Purchase Price</th>
			<th>Sale Price $</th>
			<th>Sale Price ID</th>
			<th>Sale Min Price</th>

		                    	@if(Auth::user()->type=='admin')
			<th class="hidden-print">Edit</th>
			                    @endif
		</tr>
	</thead>

	<tbody>
	<?php if (isset($searchItems))
		{ 	
			$items=$searchItems;
			$update=1;
		}
		else {
			$update=0;
			}
		?>

		@foreach ($items as $item) 
			<tr class="text-center">
				<td>{{$item->barcode}}</td>
				<td>{{$item->name}}</td>
				<td>{{$item->name_en}}</td>
				<td>{{$item->category->category}}</td>
				<td>{{$item->purchase_price}}</td>
				<td>{{$item->sale_price}}</td>
				<td>{{$item->sale_price_id}}</td>
				<td>{{$item->min}}</td>

				<td class="hidden-print"><a href={{"/items/edit/".$item->id}}><span class="fa fa-edit fa-1x"></span></a></td>

			</tr>
		@endforeach
	</tbody>
       
</table>
</div>
</div>
</div>
</div>
 @if ($update==0)
 {{ $items->links('vendor.pagination.bootstrap-4') }}
 @endif
 
<div class="col-sm-3 hidden-print">
<div class="card card-topline-green">
	<div class="card-head text-center h3">
		<header>Add Drug</header>
		
	</div>
	<div class="card-body ">
@include('layouts.errorMessages')
                
                <div class="panel-body">
		
		
			<form class='text-right' method="POST" action="/items/store" id="addForm">
			{{csrf_field()}}
			<fieldset class="form-group">
					<label for="id">Barcode</label>
			<input type="text" class="form-control" name="barcode" required>
				</fieldset>

				<fieldset class="form-group">
					<label for="name">Drug Name</label>
			<input type="text" class="form-control" name="name" required>
				</fieldset>

				<fieldset class="form-group">
					<label for="name">Scientific Name</label>
			<input type="text" class="form-control" name="name_en">
				</fieldset>

			
				
				<fieldset class="form-group">
					<label for="formGroupExampleInput2">Items Per Packet</label>
					<input type="text" name="items_per_box" class="form-control" id="formGroupExampleInput2" required>
				</fieldset>

				


 				<fieldset class="form-group">
				<label for="formGroupExampleInput2">Dosage From</label>
				<select class="form-control" name="category_id">
					@foreach ($cats as $cat)
						<option value={{$cat->id}}>{{$cat->category}}</option>
					@endforeach
				</select>
				</fieldset>

	
				<fieldset class="form-group hidden">
					<label for="formGroupExampleInput2">Stock Alert</label>
					<input type="text" name="maxzan" value="100" class="form-control" id="formGroupExampleInput2">
				</fieldset>

				<fieldset class="form-group">
							<label for="name">Description</label>
							<textarea cols="50" rows="4" class="form-control" name="description"></textarea>
						</fieldset>
				<button type="submit" class="btn btn-primary btn3d btn-block"><b>Save</b></button>
			</form>
	</div>

	
</div>
</div>
</div>
</div>
</div>

@endsection('content')
@section('afterFooter')
<script type="text/javascript">
 $(document).ready(function () {
    $('.select2').select2();
  $("#menu-top li a").removeClass("menu-top-active");              
  $('#items/add').addClass('menu-top-active');
  });
 </script>
 @endsection