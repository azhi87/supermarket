@extends('layouts.master')
@section('content')
<br/>
<div class="row">

 <div class="col-md-7 col-sm-7 col-xs-12 table-responsive text-center">
<table class="table table-bordered table-text-center table-responsive">

	<thead >
 		<tr><td colspan="3">خشتەی کارەکانی : {{Auth::user()->name}}</td></tr>
		<tr class="bg-success">
		    <th class='hidden-print'>سڕینەوە</th>
			<th>کار</th>
			<th>ژمارە</th>
		</tr>
	</thead>
	<tbody>
@foreach ($events as $event)

	<tr>
	    <td><i class="fa fa-trash bg-danger" onclick="delete_event({{$event->id}});"></i></td>
		<td >{{$event->title}}</td>
		<td>{{$loop->iteration}}</td>
	</tr>
@endforeach
<tr class="bg-danger"><td>{{Auth::user()->dayEvent($day)}}</td><td></td><td>*</td></tr>



	</tbody>
       
</table>
<br/>
<br/>
</form>
</div>
	<div class="col-md-4 col-sm-4 col-xs-10 hidden-print">
@include('layouts.errorMessages')
       <div class="panel panel-info">
                <div class="panel-heading text-center "><span class="h3 color-black"><b>زیادکردنی تێبینی</b></span></div>
                <div class="panel-body">
					<form class='text-right' method="POST" action="/event/store" id="addForm">
					{{csrf_field()}}
					<fieldset class="form-group">
					<label for="name">بەروار</label>
					    <input type="date" name="start_date" class="form-control" value="{{$day}}"/>
					</fieldset>
					

						<fieldset class="form-group">
							<label for="name">تێبینی</label>
							<textarea class="form-control" name="title" required=""></textarea>
						</fieldset>
						<div class="form-group text-center">
						<button type="submit" class="btn btn-primary btn-block btn3d "><b>تۆمارکردن</b></button>
						</div>
					</form>
					</div>

</div>
</div>

<!--delete confirmation modal-->
<div class="modal fade" id="delete_event">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">سڕینەوەی ئیڤێنت</h4>
      </div>
      <div class="modal-body">
        ئایا دڵنیایی لە سڕینەوەی ئەم ئیفێنتە؟
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">داخستن</button>
        <a id="delete" href="" type="button" class="btn btn-danger"> سڕینەوە</a>
      </div>
    </div>
  </div>
</div>
@endsection
@section('afterFooter')
<script type="text/javascript">
function delete_event(id)
{
    $("#delete").attr('href', "/event/delete/"+id);
      $('#delete_event').modal('show');
}
</script>
@endsection