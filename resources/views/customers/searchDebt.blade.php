@extends('layouts.master')
@section('content')
<?php $user=new \App\User();$mandwbs=$user->Mandwbs();?>
<style>
	.input-group-addon{color:black;background-color:#F0FFFF;min-width:110px;font-weight: bold}
</style>


<br/>
 <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-1"></div>
                <div class="col-md-6 col-sm-6 col-xs-10">
                    <!-- Form Elements -->
                   <div class="panel panel-primary">
                        <div class="panel-heading text-center" >
                        <span class='h3'><b>گەڕانی قەرز</b></span>
                        </div>
                    <div class="panel-body text-right">
                            
                                   
                        <form action='/debt/generalSearch' method='post' role="form">
                        			{{csrf_field()}}
                        				<div class="form-group input-group ">
                                            <input type="text" name='customer_id' class="form-control text-right" >
                                            <span class="input-group-addon">کۆدی کڕیار</span>
                                        </div>
                                        <div class="form-group input-group ">
                                            <input type="text" name='customer_name' class="form-control text-right" >
                                            <span class="input-group-addon">ناوی کڕیار</span>
                                        </div>
                                       
                                        <div class="form-group input-group ">
                                            
                                            <input type="text" name='tel' class="form-control text-right" >
                                            <span class="input-group-addon">ژمارەی تەلەفۆن</span>
                                        </div>
                                        <div class="form-group input-group ">
                                            <input type="text" name='debt_id' class="form-control text-right" >
                                           
                                            <span class="input-group-addon">ژ. وەصلی قەرز</span>
                                        </div>

                                        <div class="form-group input-group ">
                                             <select  class="form-control" name="status" selected >
											<option value="-1">------</option>
											<option value="0">NO</option>
											<option value="1">OK</option>
											</select>
                                            <span class="input-group-addon">ئەدمین</span>
                                        </div>

                                        <div class="form-group input-group ">
                                            <select  class="form-control" name="user_id" >
                                            <option value="-1" selected="selected">------</option>
											@foreach ($mandwbs as $mandwb)
											<option value="{{$mandwb->id}}"> {{$mandwb->name}} </option>
											@endforeach
											</select>
                                            <span class="input-group-addon">مەندوب</span>
                                        </div>

                                        <div class="form-group input-group ">
                                            <input type="date" name='from' class="form-control text-right" >
                                            <span class="input-group-addon">لە</span>
                                        </div>
                                       <div class="form-group input-group ">
                                            <input type="date" name='to' class="form-control text-right" >
                                            <span class="input-group-addon">بۆ</span>
                                        </div>
                                        
                                         <div class="form-group text-center">
                                            <input type="submit" value="گەڕان" class="btn-lg btn-info btn3d">
                                        </div>
                                        </div>
                                    </form>
                        </div>                                  
                                </div>
                            </div>
@endsection

@section('afterFooter')
 <script type="text/javascript">
    $(document).ready(function () {
  $("#menu-top li a").removeClass("menu-top-active");              
  $('#sale').addClass('menu-top-active');
  });
 </script>

 @endsection