<!DOCTYPE html>
<html lang="en">
<!-- BEGIN HEAD -->

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta content="width=device-width, initial-scale=1" name="viewport" />
  <title></title>
  <!-- google font -->
  <link href="https://fonts.googleapis.com/css?family=Merriweather:600&display=swap" rel="stylesheet">
  <!-- icons -->
  <link href="{{asset('public/css/simple-line-icons.min.css')}}" rel="stylesheet" />
  
  <link href="{{asset('public/css/font-awesome.min.css')}}" rel="stylesheet" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <!--bootstrap -->

  <link href="{{asset('public/css/bootstrap.min.css')}}" rel="stylesheet" />
  <link href="{{asset('public/css/datepicker.css')}}" rel="stylesheet" />
  <!-- Material Design Lite CSS -->
  <link href="{{asset('public/css/material.min.css')}}" rel="stylesheet" />
  <link href="{{asset('public/css/material_style.css')}}" rel="stylesheet" />
  <link href="{{asset('public/css/select2.css')}}" rel="stylesheet" />
  <link href="{{asset('public/css/select2-bootstrap.min.css')}}" rel="stylesheet" />
  <!-- Theme Styles -->
  <link href="{{asset('public/css/theme_style1.css')}}" rel="stylesheet" />
  <link href="{{asset('public/css/style.css')}}" rel="stylesheet" />
  <link href="{{asset('public/css/plugins.min.css')}}" rel="stylesheet" />
  <link href="{{asset('public/css/formlayout.css')}}" rel="stylesheet" />
  <link href="{{asset('public/css/responsive.css')}}" rel="stylesheet" />
  <link href="{{asset('public/css/theme-color.css')}}" rel="stylesheet" />
  <link href="{{asset('public/css/sweetalert.min.css')}}" rel="stylesheet" />
 @livewireStyles
  <!-- favicon -->
  <link rel="shortcut icon" href="img/favicon.ico" />
   @yield('links')
</head>
<!-- END HEAD -->

<body style="font-family: 'Merriweather', serif;" class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md page-full-width header-white white-sidebar-color logo-indigo">

  <div class="page-wrapper" style="font-family: 'Merriweather', serif;">
    <!-- start header -->
    <div class="page-header navbar navbar-fixed-top" style="font-family: 'Merriweather', serif;">
      @include('layouts.navbar')
    </div>
    <!-- end header -->
    <div class="clearfix"> </div>
    <!-- start page container -->
    <div class="page-container" style="font-family: 'Merriweather', serif;">
      <!-- start sidebar menu-->
      <div class="sidebar-container" style="font-family: 'Merriweather', serif;">
        <div class="sidemenu-container navbar-collapse collapse" style="font-family: 'Merriweather', serif;">
          
        </div>
      </div>
      <!-- end sidebar menu -->
      <!-- start page content -->
      <div class="page-content-wrapper" style="font-family: 'Merriweather', serif;">
        <div class="page-content" style="font-family: 'Merriweather', serif;">
            
          @yield('content')
        </div>
      </div>
      <!-- end page content -->
      <!-- start chat sidebar -->
      <div class="chat-sidebar-container" data-close-on-body-click="false">
        <div class="chat-sidebar">
         
        </div>
      </div>
      <!-- end chat sidebar -->
    </div>
    <!-- end page container -->

  </div>

  @include('layouts.footer')
  @livewireScripts
  @yield('afterFooter')
  @include('layouts.messages')
  
    <!--ajax delete confirmation-->
    <div class="modal fade" id="deleteTreatmentOrTest" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                Delete Confirmation
            </div>
            <div class="modal-body">
                Are you sure you want to delete this <span class="text-danger descriptor"></span>?
                This operation is irreversible..
            </div>
            <div class="modal-footer">
                <button id="no" type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button id="yes"  class="btn btn-danger btn-ok" data-dismiss="modal">Delete</button>
            </div>
        </div>
    </div>
</div>

</body>