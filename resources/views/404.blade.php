@extends('layout')

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-6 mr-auto ml-auto mt-5">
        <img class="d-block mr-auto ml-auto" src="/img/ethernet_big.png" width="100" alt="">

        <h3 class="text-center mt-3">
            {{$ip}}
        </h3>

        <h5 class="text-center mt-3">
            Not Found in database
        </h5>
    </div>
@endSection