@extends('layouts.master')
@section('links')
<link href="{{asset('css/steps.css')}}" rel="stylesheet">
@endsection
@section('content')
  <div class="page-content-wrapper">
        <div class="page-content">
          <div class="page-bar">
            <div class="page-title-breadcrumb">
              <div class=" pull-left">
                <div class="page-title">Wizard</div>
              </div>
              <ol class="breadcrumb page-breadcrumb pull-right">
                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                </li>
                <li class="active">Wizard</li>
              </ol>
            </div>
          </div>
   
          <!-- Verticle Steps Wizard -->
          <div class="row">
            <div class="col-sm-12">
              <div class="card-box">
                <div class="card-head">
                  <header>Verticle Steps</header>
                </div>
                <div id="example-vertical">
                  <h3>Keyboard</h3>
                  <section>
                    <p>Try the keyboard navigation by clicking arrow left or right!</p>
                  </section>
                  <h3>Effects</h3>
                  <section>
                    <p>Wonderful transition effects.</p>
                  </section>
                  <h3>Pager</h3>
                  <section>
                    <p>The next and previous buttons help you to navigate through your content.</p>
                  </section>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
{{-- <div class="row">
            <div class="col-sm-12">
              <div class="card-box">
                <div class="card-head">
                  <header>Verticle Steps</header>
                </div>
                <div id="example-vertical">
                  <h3>Keyboard</h3>
                  <section>
                    <p>Try the keyboard navigation by clicking arrow left or right!</p>
                  </section>
                  <h3>Effects</h3>
                  <section>
                    <p>Wonderful transition effects.</p>
                  </section>
                  <h3>Pager</h3>
                  <section>
                    <p>The next and previous buttons help you to navigate through your content.</p>
                  </section>
                </div>
              </div>
            </div>
          </div> --}}
@endsection

@section('afterFooter')
  <script src="{{asset('js/jquery.steps.js')}}"></script>
  <script src="{{asset('js/steps-data.js')}}"></script>
@endsection

