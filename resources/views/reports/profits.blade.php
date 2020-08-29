@extends('layouts.master')
@section('content')
<style>
    .bg-ivory {
        background: ivory
    }
</style>
<div class="row bordered-1">

    <div class="col-md-8 mx-auto col-sm-12">
        <br>
        <div class="col-md-6 text-center mx-auto h5">
            <label class="text-center "><span class="color-black">From : </span> {{$from}} </label>
            <label class="text-center"><span class="color-black">To : </span> {{ $to }} </label>
        </div>
        <table class="table text-center tseparate table-bordered">
            <tbody>
                <tr>
                    <td class="bg-info h4 text-white"> Purchases </td>
                    <td class="text-danger h4 bg-ivory"> {{number_format($purchases,2)}}</td>
                    <td class=""><i class="fa fa-dollar "></i> </td>
                    <td class="bordered-0"> </td>
                </tr>
                <tr>
                    <td class="bordered-0"></td>
                </tr>
                <tr>
                    <td class="bg-info h4 text-white"> Sales </td>
                    <td class="text-danger h4 bg-ivory"> {{number_format($sold + $saleDiscounts,2)}}</td>
                    <td><i class="fa fa-dollar "></i></td>
                    <td class="bordered-0"> </td>
                </tr>
                <tr>
                    <td class="bordered-0"></td>
                </tr>

                <tr>
                    <td class="bg-info h4 text-white"> Sale Discounts </td>
                    <td class="text-danger h4 bg-ivory"> {{number_format($saleDiscounts,2)}}</td>
                    <td><i class="fa fa-dollar "></i></td>
                    <td class="bordered-0 bg-danger"> </td>
                </tr>
                <tr>
                    <td class="bordered-0"></td>
                </tr>

                <tr>
                    <td class="bg-info h4 text-white">Paybacks </td>
                    <td class="text-danger h4 bg-ivory"> {{number_format($paybacks,2)}}</td>
                    <td><i class="fa fa-dollar "></i></td>
                    <td class="bordered-0 bg-default"> </td>
                </tr>
                <tr>
                    <td class="bordered-0"></td>
                </tr>

                <tr>
                    <td class="bg-info h4 text-white"> Payback discounts</td>
                    <td class="text-danger h4 bg-ivory"> {{number_format($paybackDiscounts,2)}}</td>
                    <td><i class="fa fa-dollar "></i></td>
                    <td class="bordered-0 bg-success"> </td>
                </tr>
                <tr>
                    <td class="bordered-0"></td>
                </tr>
                <tr>
                    <td class="bg-info h4 text-white"> Expenses </td>
                    <td class="text-danger h4 bg-ivory"> {{number_format($expenses,2)}}</td>
                    <td><i class="fa fa-dollar "></i></td>
                    <td class=" bordered-0 bg-danger"> </td>
                </tr>

                <tr>
                    <td class="bordered-0"></td>
                </tr>
                <tr>
                    <td class="bg-info h4 text-white"> Drug Sale Profit </td>
                    <td class="text-danger h4 bg-ivory"> {{number_format($itemProfit,2)}}</td>
                    <td><i class="fa fa-dollar "></i></td>
                    <td class=" bordered-0 bg-success"> </td>
                </tr>

                <tr>
                    <td class="bordered-0"></td>
                </tr>
                <tr>
                    <td class="bg-info h4 text-white"> Total Profit </td>
                    <td class="text-danger h4 bg-ivory">
                        {{ number_format($profit,2)}} </td>
                    <td><i class="fa fa-dollar "></i></td>
                    <td class=" bordered-0 {{ $profit>0? 'bg-success' : 'bg-danger' }}"> </td>
                </tr>


            </tbody>
        </table>
    </div>
</div>

@endsection