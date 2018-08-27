@extends('layout')

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-10 mr-auto ml-auto mt-5">

        <h3 class="text-center mt-3">
            {{$ip->hiddenIP()}}
        </h3>

        <h5 class="text-center mt-4">
            Network Stats
        </h5>

        <h5 class="text-center mt-3">
            <span class="text-primary">{{$ip->disconnects->count()}}</span>
            disconnects since
            <span class="text-primary">
                {{$curr_month->format('M jS Y')}}
            </span>
        </h5>

        <h5 class="text-center mt-3">
            Remained down for
            <span class="text-primary">{{$ip->downtime()[0]}}</span>
            Hours or
            <span class="text-primary">
                {{$ip->downtime()[1]}}
            </span>
            Minutes
        </h5>

        <div class="accordion mt-5 mb-5" id="accordionExample">
            @foreach($stats as $index => $stat)
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <div class="row text-center"
                             data-toggle="collapse"
                             data-target="#collapse{{$loop->iteration}}"
                             aria-expanded="true"
                             aria-controls="collapse{{$loop->iteration}}">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <b>{{$stat['formatted_date']}} - </b>

                                <img src="{{!$stat['disconnects'] ? '/img/internet_up.png' : '/img/internet_down.png'}}" alt="" width="25">
                                <b>{{$stat['disconnects']}}</b>
                            </div>
                        </div>
                    </div>

                    <div id="collapse{{$loop->iteration}}" class="collapse @if($loop->iteration === 1) show @endif " aria-labelledby="heading{{$loop->iteration}}" data-parent="#accordionExample">
                        <div class="card-text">
                            @if($stat['logs']->count())
                                <table class="table table-striped text-center m-0">
                                    <thead>
                                    <tr>
                                        <th scope="col">Status</th>
                                        <th scope="col">Time</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($stat['logs'] as $stat)
                                        <tr>
                                            <td>
                                                <img src="{{$stat->status ? '/img/internet_up.png' : '/img/internet_down.png'}}" alt="" width="35">
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
                            @else
                                <div class="text-center p-3">
                                    No disconnects
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


        {{--<div class="text-center">
            {{ $stats->links() }}
        </div>--}}
    </div>
@endSection