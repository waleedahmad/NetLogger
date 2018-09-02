@extends('layout')

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mr-auto ml-auto">

        <h3 class="text-center mt-5">
            IP Addresses
        </h3>

        <h5 class="text-center mt-3">
            {{$month->format('M Y')}} Stats
        </h5>

        <div class="table-responsive">
            <table class="table table-striped mt-3 text-center">
                <thead>
                <tr>
                    <th scope="col">IP</th>
                    <th scope="col">ISP</th>
                    <th scope="col">Downtime</th>
                    <th scope="col">Disconnects</th>
                    <th scope="col">Added</th>
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
                            {{$ip->downtime($month)['minutes']}} mins or
                            {{$ip->downtime($month)['hours']}} hours
                        </td>
                        <td>
                            {{$ip->disconnects($month->format('M Y'))->count()}}
                        </td>
                        <td>
                            {{$ip->created_at->format('Y-m-d g:i:s A')}}
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