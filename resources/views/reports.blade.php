@extends('layout')

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mr-auto ml-auto">

        <h3 class="text-center mt-5">
            {{$month->format('M Y')}} Stats
        </h3>

        <div class="mt-3 mb-2">
            <select class="form-control col-xs-12 col-sm-12 col-md-6 col-lg-4 m-auto"
                    id="stat-month">
                @foreach($months as $log_month)
                    <option value="{{$log_month}}"
                            @if(Carbon\Carbon::parse($month)->format('M Y') === Carbon\Carbon::parse($log_month)->format('M Y')) selected @endif>
                        {{Carbon\Carbon::parse($log_month)->format('M Y')}}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="table-responsive">
            <table class="table table-striped mt-3 mb-5 text-center">
                <thead>
                <tr>
                    <th scope="col">IP</th>
                    <th scope="col">ISP</th>
                    <th scope="col">Downtime</th>
                    <th scope="col">Disconnects</th>
                    <th scope="col">Added</th>
                    <th scope="col">Logs</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ips as $ip)
                    @php
                        $show = false;
                        $logs = $ip->getMonthlyLogs($month->format('Y-m'));
                        if($logs->count()){
                            $logs = $logs->first();
                            if($logs->count()){
                                $show = true;
                            }
                        }

                    @endphp

                    @if($show)
                    <tr>
                        <td>
                            {{$ip->hiddenIP()}}
                        </td>
                        <td>
                            {{$ip->org}}
                        </td>

                        <td>
                            {{$ip->downtime($month)['minutes']}} mins
                            {{$ip->downtime($month)['hours']}} hours
                        </td>
                        <td>
                            {{$ip->disconnects($month->format('M Y'))->count()}}
                        </td>
                        <td>
                            {{$ip->created_at->format('M Y')}}
                        </td>
                        
                        <td>
                            <a target="_blank" href="/ip/{{$ip->id}}">view</a>
                        </td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
    </div>
@endSection