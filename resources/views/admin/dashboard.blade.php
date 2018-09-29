@extends('layout')

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mr-auto ml-auto">

        <h3 class="text-center mt-5">
            IP Addresses
        </h3>

        <div class="table-responsive">
            <table class="table table-striped mt-5 mb-5 text-center">
                <thead>
                <tr>
                    <th scope="col">IP</th>
                    <th scope="col">ISP</th>
                    <th scope="col">City</th>
                    <th scope="col">Region</th>
                    <th scope="col">Country</th>
                    <th scope="col">Added on</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ips as $ip)
                    <tr>
                        <td>
                            {{$ip->ip}}
                        </td>
                        <td>
                            {{$ip->org}}
                        </td>
                        <td>
                            {{$ip->city}}
                        </td>
                        <td>
                            {{$ip->region}}
                        </td>
                        <td>
                            {{$ip->country}}
                        </td>
                        <td>
                            {{$ip->created_at}}
                        </td>
                        <td>
                            <a target="_blank" href="/ip/{{$ip->id}}">view</a>
                        </td>

                        <td></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
    </div>
@endSection