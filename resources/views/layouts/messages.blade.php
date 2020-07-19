@if(Session::has('message'))
{{--  <div class="row">
 <div class="col-md-5"></div>
	<div class="alert alert-success alert-dismissable col-md-4" role="alert">
		 <button type="button" class="close hidden-print" data-dismiss="alert" aria-label="Close">
		     <span aria-hidden="true">&times;</span></button>
		<ul class="text-center">
			<li>{{session('message')}}</li>
		</ul>
	</div>
</div> --}}
<script type="text/javascript">
@if(Session::has('type') && Session('type')=='error')

swal({
              text:'{{session('message')}}',
              type:'error',
              title:'Something Went Wrong',
               confirmButtonClass: 'btn btn-danger btn-fill',
               buttonsStyling: false
            });

@else

swal({
              text:'{{session('message')}}',
              type:'success',
              title:'Success',
               confirmButtonClass: 'btn btn-success btn-fill',
               timer:1000,
               buttonsStyling: false
            });
@endif
</script>
@endif
