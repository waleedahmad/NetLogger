@extends('layout')

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-6 mr-auto ml-auto mt-5">

        <h3 class="text-center mt-3">
            {{$ip->ip}}
        </h3>

        <h5 class="text-center mt-4">
            Network Stats
        </h5>

        <div>
            <table class="table table-striped mt-5 text-center">
                <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Status</th>
                    <th scope="col">Time</th>
                    <th scope="col">Date</th>
                </tr>
                </thead>
                <tbody>
                @foreach($stats as $stat)
                    <tr>
                        <td>
                            <img src="{{$stat->status ? '/img/internet_up.png' : '/img/internet_down.png'}}" alt="" width="35">
                        </td>
                        <td>
                            <b>{{$stat->status ? 'Up' : 'Down'}}</b>
                        </td>
                        <td>
                            {{$stat->created_at->format('h:i:s A')}}

                        </td>
                        <td>
                            {{$stat->created_at->toDateString()}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-center">
            {{ $stats->links() }}
        </div>
    </div>
@endSection