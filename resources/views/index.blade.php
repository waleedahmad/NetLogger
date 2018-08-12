@extends('layout')

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-6 mr-auto ml-auto">
        <form class="mt-5 text-center" action="/ip" method="get">
            <img class="d-block mr-auto ml-auto" src="/img/wifi.svg" width="100" alt="">

            <h3 class="text-center mt-4">
                Search IP
            </h3>
            <input type="text"
                   name="ip_address"
                   class="form-control mt-3 @if($errors->has('ip_address')) is-invalid @endif"
                   placeholder="Your IP Address"
                   value="{{old('ip_address') ? old('ip_address') : ''}}"
                   required>

            @if($errors->has('ip_address'))
                <div class="alert alert-danger mt-">
                    {{$errors->first('ip_address')}}
                </div>
            @endif

            @if(session()->has('message'))
                <div class="alert alert-info mt-">
                    {{session()->get('message')}}
                </div>
            @endif

            <button type="submit" class="btn btn-primary mt-3">View Logs</button>
        </form>
    </div>
@endSection