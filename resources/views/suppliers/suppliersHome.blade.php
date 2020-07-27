@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-md-4 col-sm-12 hidden-print">
        <div class="card card-topline-green">
            <div class="card-head text-center h3">
                <header>Add Supplier</header>
            </div>
            <div class="card-body ">
                @include('layouts.errorMessages')
                <div class="panel panel-success">
                        <form method="POST" action="/suppliers/store" enctype="multipart/form-data" id="addForm">
                            {{csrf_field()}}
                            <div class="form-group hidden">
                                <label for="formGroupExampleInput2">Code </label>
                                <input type="text" name="id" class="form-control" id="formGroupExampleInput2">
                            </div>

                            <div class="form-group">
                                <label for="name">Supplier Name </label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="formGroupExampleInput2"> Mobile#</label>
                                <input type="text" name="mobile" class="form-control" id="formGroupExampleInput2">
                            </div>

                            <div class="form-group">
                                <label for="formGroupExampleInput2">Address</label>
                                <input type="text" name="address" class="form-control" id="formGroupExampleInput2" required>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg btn-block"> <b>Save</b></button>
                        </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-sm-12">
        <div class="card card-topline-green ">
            <div class="card-head">
                <header>Suppliers</header>
            </div>
            <div class="card-body">
                <div class="table-scrollable">
                    <div class="table-responsive">    
                    <table class="table table-bordered table-striped ">
                        <thead class="bg-info text-light">
                            <tr class="text-center">
                                <th> Supplier Name</th>
                                <th>Current Debt</th>
                                <th>Mobile#</th>
                                <th>Address</th>
                                <th class="hidden-print">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                            @foreach ($suppliers as $supplier)
                            <tr class="text-center">
                                <td>{{$supplier->name}}</td>
                                <td><a href=" {{ route('payback',$supplier->id) }}" style="text-decoration: underline;"><strong> {{ number_format($supplier->debt(),2) }} </strong></a></td>
                                <td>{{$supplier->mobile}}</td>
                                <td>{{$supplier->address}}</td>
                                <td class="hidden-print"><a href={{"/suppliers/edit/".$supplier->id}}><span class="fa fa-edit fa-1x "></span></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection('content')
@section('afterFooter')
<script type="text/javascript">
    $(document).ready(function() {
        $("#menu-top li a").removeClass("menu-top-active");
        $('#supplier').addClass('menu-top-active');
    });
</script>

@endsection