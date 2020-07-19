@extends('layouts.master')

@section('content')

    <style type="text/css">.input-group-addon{font-weight:bold; padding:4px;}</style>

<div class="well">
@include('sales.header')
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