@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4 col-sm-6">
        <form method="POST" action="{{route('search-supplier')}}">
            {{csrf_field()}}
            <div class="form-group input-group input-group-sm">
                <span class="input-group-addon">ناوی فرۆشیار</span>
                <select name="id" class="form-control select2">
                    @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
                <span class="input-group-btn">
                    <button type="submit" class="btn-primary btn-flat">گەڕان!</button>
                </span>
            </div>
        </form>
    </div>
</div>
<div class="row">

    <div class="col-md-4 col-sm-12 hidden-print">
        <div class="card card-topline-green">
            <div class="card-head text-center h3">
                <header>زیادکردنی فرۆشیار</header>
            </div>
            <div class="card-body ">
                @include('layouts.errorMessages')
                <div class="panel panel-success">
                    <form method="POST" action="/suppliers/store" enctype="multipart/form-data" id="addForm">
                        {{csrf_field()}}
                        <div class="form-group hidden">
                            <label for="formGroupExampleInput2">کۆد </label>
                            <input type="text" name="id" class="form-control" id="formGroupExampleInput2">
                        </div>

                        <div class="form-group text-right px-3">
                            <label for="name"> ناوی فرۆشیار </label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group text-right px-3">
                            <label for="name"> جۆری دراو </label>
                            <select class="form-control" name="isDollar" required>
                                <option value="1">دۆلار</option>
                                <option value="0">دینار</option>
                            </select>
                        </div>
                        <div class="form-group text-right px-3">
                            <label for="formGroupExampleInput2"> مۆبایل#</label>
                            <input type="text" name="mobile" class="form-control" id="formGroupExampleInput2">
                        </div>

                        <div class="form-group text-right px-3">
                            <label for="formGroupExampleInput2">ناونیشان</label>
                            <input type="text" name="address" class="form-control" id="formGroupExampleInput2" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block"> <b>تۆمارکردن</b></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-sm-12">
        <div class="card card-topline-green ">
            <div class="card-head text-center">
                <header class="text-center">لیستی فرۆشیارەکان</header>
            </div>
            <div class="card-body">
                <div class="table-scrollable">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped ">
                            <thead class="bg-info text-light">
                                <tr class="text-center">
                                    <th> ناوی فرۆشیار </th>
                                    <th> قەرزی ئێستا</th>
                                    <th>مۆبایل</th>
                                    <th>ناونیشان</th>
                                    <th class="hidden-print">گۆڕانکاری</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($suppliers as $supplier)
                                <tr class="text-center">
                                    <td>{{$supplier->name}}</td>
                                    <td><a href=" {{ route('payback',$supplier->id) }}"
                                            style="text-decoration: underline;"><strong>
                                                {{ number_format($supplier->debt(),0) }} </strong>
                                        </a><small class="text-sm"> {{  $supplier->isDollar ? 'دۆلار':'دینار' }}</small>
                                    </td>
                                    <td>{{$supplier->mobile}}</td>
                                    <td>{{$supplier->address}}</td>
                                    <td class="hidden-print"><a href="{{ route('edit-supplier',$supplier->id) }}"><span
                                                class="fa fa-edit fa-1x "></span></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $suppliers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection('content')
@section('afterFooter')
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
        $("#menu-top li a").removeClass("menu-top-active");
        $('#supplier').addClass('menu-top-active');
    });
</script>

@endsection