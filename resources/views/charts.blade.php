@extends('layout')

@section('stats')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mr-auto ml-auto mt-5">

        <h3 class="text-center mt-3">
            {{$ip->hiddenIP()}}
        </h3>

        <h5 class="text-center mt-4">
            Network Stats <a href="/ip/{{$ip->id}}"><i class="fa fa-list text-primary" aria-hidden="true"></i></a>
        </h5>

        <div id="chart"
             data-stats="{{json_encode($stats)}}"
             style="width: 100%"></div>

        @if($ip->id === 1)
            <div id="losses"
                 data-losses="{{json_encode($losses)}}"
                 data-total-loss="{{number_format($total_loss)}}"
                 style="width: 100%"></div>
        @endif
    </div>
@endSection