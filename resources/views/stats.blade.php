@extends('layout')

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-6 mr-auto ml-auto mt-5">
        <img class="d-block mr-auto ml-auto" src="/img/wifi.svg" width="100" alt="">

        <h3 class="text-center mt-3">
            {{$ip->ip}}
        </h3>

        <h5 class="text-center mt-4">
            Network Stats
        </h5>

        <table class="table table-striped mt-5">
            <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Status</th>
                <th scope="col">Date & Time</th>
            </tr>
            </thead>
            <tbody>
                @foreach($stats->get() as $stat)
                    <tr>
                        <td>
                            <img src="{{$stat->status ? '/img/internet_up.png' : '/img/internet_down.png'}}"
                                 alt="" width="35">
                        </td>
                        <td>{{$stat->status ? 'UP' : 'DOWN'}}</td>
                        <td>{{$stat->created_at}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endSection