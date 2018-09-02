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
            <span class="text-primary">{{$ip->disconnects($curr_month->format('M Y'))->count()}}</span>
            disconnect(s) in {{$curr_month->format('M Y')}}
        </h5>


        <h5 class="text-center mt-3">
            Remained down for
            <span class="text-primary">{{$downtime['hours']}}</span>
            Hours or
            <span class="text-primary">
                {{$downtime['minutes']}}
            </span>
            Minutes
        </h5>


        @if($ip->getMonthlyLogs()->count() > 1)
            <div class="mt-3 mb-3">
                <select class="form-control col-xs-12 col-sm-12 col-md-6 col-lg-4 m-auto"
                        id="current-month"
                        data-ip="{{$ip->ip}}">
                    @foreach($ip->getMonthlyLogs() as $date => $month)
                        <option value="{{$date}}"
                                @if(Carbon\Carbon::parse($curr_month)->format('M Y') === Carbon\Carbon::parse($date)->format('M Y')) selected @endif>
                            {{Carbon\Carbon::parse($date)->format('M Y')}}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif


        <div class="accordion mt-5 mb-5" id="accordionExample">
            @foreach($ip->getMonthlyLogs($curr_month->format('Y-m')) as $m_index => $month)
                @php
                    $days = $month->groupBy(function($date){
                        return Carbon\Carbon::parse($date->created_at)->format('d');
                    });
                @endphp

                @foreach($days as $d_index => $day)
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <div class="row text-center"
                                 data-toggle="collapse"
                                 data-target="#collapse{{$loop->iteration}}"
                                 aria-expanded="true"
                                 aria-controls="collapse{{$loop->iteration}}">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <b>{{\Carbon\Carbon::parse($m_index . '-' . $d_index)->toFormattedDateString()}}</b>

                                    <img src="{{!$day->where('status', '=', 0)->count() ? '/img/internet_up.png' : '/img/internet_down.png'}}" alt="" width="25">
                                    <b>{{$day->where('status', '=', 0)->count()}}</b>
                                </div>
                            </div>
                        </div>

                        <div id="collapse{{$loop->iteration}}" class="collapse @if($loop->iteration === 1) show @endif " aria-labelledby="heading{{$loop->iteration}}" data-parent="#accordionExample">
                            <div class="card-text">
                                @if($day->count())
                                    <table class="table table-striped text-center m-0">
                                        <thead>
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Time</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($day as $stat)
                                            <tr>
                                                <td>
                                                    <img src="{{$stat->status ? '/img/internet_up.png' : '/img/internet_down.png'}}" alt="" width="35">
                                                </td>

                                                <td>
                                                    {{$stat->status ? 'Connected' : 'Disconnected'}}
                                                </td>

                                                <td>
                                                    {{$stat->created_at->format('h:i:s A')}}

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
            @endforeach
        </div>
    </div>
@endSection