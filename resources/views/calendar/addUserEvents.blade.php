@extends('layouts.master')
@section('links')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
<style type="text/css">.duplicate{color:border:1px solid red; color:red;}</style>
<style type="text/css">.fc-fri { background-color:#a29b9b;color: white; }.fc-state-highlight , .fc-today{background-color:#9ad49d !important;}</style>

@endsection
@section('content')
<br/>

<div class="row hidden-print">
@include('layouts.errorMessages')
<div class="col-md-4 col-sm-4"></div>
<div class="col-md-4 col-sm-4 col-xs-6" >

<form method="post"  action="/user-events/selectUser">
 {{csrf_field()}}
	<div class="input-group has-warning">
					
					<span class="input-group-btn"><button class="btn btn-secondary btn-danger"  type="submit"> گەڕان</button></span>

					<select class="form-control"  name="user_id" placeholder="ناوی کارمەند">
					<option value="-1"></option>
						@foreach ($users->where('status','1') as $user)
							<option value="{{$user->id}}">{{$user->name}}</option>
						@endforeach
					</select>
	</div>
</form>
 </div>
</div>
<br><br>
@if(!empty($selectedUser))
	
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 hidden-print">

            <div class="panel panel-primary">
                <div class="panel-heading text-center"><span class="h2">کالێندەر  : {{$selectedUser->name}}</span></div>

                <div class="panel-body" style="font-size:14px;">
                    {!! $calendar->calendar() !!}
                </div>
            </div>
       
</div>
 <div class="col-md-6 col-sm-6 col-xs-12 table-responsive text-center">
 
<table class="table table-bordered table-text-center table-responsive">

	<thead class="bg-success">
		<tr><td colspan="2">خشتەی کارەکانی : {{$selectedUser->name}}</td></tr>
		<tr>
			<th class="hidden-print">کار</th>
			<th>ڕۆژ</th>
		</tr>
	</thead>
	<tbody>
<form method="post" id="eventForm" action='/user-events/store/{{$selectedUser->id}}'>
	<input type="hidden" name="user_id" value="{{$selectedUser->id}}"/>
@foreach ($selectedUser->uevents as $event)
	@if($event->sequence==$selectedUser->todaySequence())
		<tr class="bg-danger">
	@else
		<tr>
	@endif
		<td ><input name="description{{$event->sequence}}" type="text" class="text-center" value="{{$event->description}}"></td>
		<td><input name="sequence{{$event->sequence}}"  type="text" class="text-center sequence" value="{{$event->sequence}}"></td>
	</tr>
@endforeach
@for($i=$selectedUser->uevents->count('sequence')+1; $i<31; $i++)
<tr>
		<td ><input name="description{{$i}}" type="text" class="text-center" ></td>
		<td><input name="sequence{{$i}}" type="text" class="text-center sequence" value="{{$i}}"></td>
	</tr>
@endfor


	</tbody>
       
</table>
<button type="submit" class="btn btn-primary btn-block">تۆمارکردن</button>
<br/>
<br/>
</form>

@include('layouts.errorMessages')
       <div class="panel panel-info">
                <div class="panel-heading text-center">
                  <span class="h3 color-black"><b>زیادکردنی ڕۆژی پشوو</b></span>
                </div>
                <div class="panel-body">
			
			<label class="label label-danger"><b>نابێت پێش ڕۆژی پشووەکە ئەنجام بدرێت</b></label>
			<form class='text-right' method="POST" action="/events/holiday" enctype="multipart/form-data" id="addForm">
			{{csrf_field()}}



			<fieldset class="form-group">
				<label for="formGroupExampleInput2">کارمەند</label>
				<select class="form-control" name="user_id" required="">
					<option></option>
					<option value="-1">هەموو كارمەندان</option>
					@foreach ($users->where('status','1') as $user)
						<option value={{$user->id}}>{{$user->name}}</option>
					@endforeach
				
				</select>
			</fieldset>
			<fieldset class="form-group">
					<label for="id">ژمارەی ڕۆژەکانی پشوو</label>
			<input type="text" class="form-control" name="days" >
				</fieldset>
			<fieldset class="form-group">
				<label for="formGroupExampleInput2">کارمەند</label>
				<select class="form-control" name="category" required="">
					<option value="make">زیادکردن </option>
					<option value="cancel" style="color:red;">سڕینەوەی </option>
				</select>
			</fieldset>

				<button type="submit" class="btn btn-primary btn3d btn-block"><b>تۆمارکردن</b></button>
			</form>
	</div>

	
		</div>
	
 



@endif
<div id="fullCalModal" class="modal fade text-center">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                <h4 id="modalTitle" class="modal-title">پشاندانی ئیڤێنت</h4>
            </div>
            <div id="modalBody" class="modal-body h3"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('afterFooter')

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
@if(!empty($selectedUser))
{!! $calendar->script() !!}
@endif
<script type="text/javascript">

	$(document).ready(function() {
  $('#eventForm').on('submit', function(e){
    if(checkDuplicates()) {
        	e.preventDefault();
        	alert('تکایە ژمارەی دووبارە نابێت هەبێت');
    }
    else
    {
    	$(this).submit();
    }
  });
});
    function checkDuplicates()
    {
        var arr = [];
        var hasDuplicates=false;
		$(".sequence").each(function(){
		    var value = $(this).val();
		    if (arr.indexOf(value) == -1)
		    {
		        arr.push(value);
		    }
		    else
		    {
		    	hasDuplicates=true;
		        $(this).addClass("duplicate");
		    }

		});
		return hasDuplicates;
    }

</script>
@endsection