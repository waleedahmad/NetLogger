@extends('layout')

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-6 mr-auto ml-auto">
        <form class="mt-5" action="/ip" method="post">
            <h3 class="text-center mb-5">
                Monitor Downtime
            </h3>
            <div>
                <label>Your IP Address</label>

                <input type="text"
                       name="ip_address"
                       class="form-control @if($errors->has('ip_address')) is-invalid @endif"
                       placeholder="Your IP Address"
                       value="{{old('ip_address') ? old('ip_address') : ''}}"
                       required>

                @if($errors->has('ip_address'))
                    <div class="alert alert-danger mt-2">
                        {{$errors->first('ip_address')}}
                    </div>
                @endif

                <small id="emailHelp" class="form-text text-muted">
                    Don't forget to enable
                    <a href="https://searchnetworking.techtarget.com/definition/ICMP" target="_blank">
                        Respond ICMP Echo (ping)
                    </a>
                    Request from WAN in your router's console settings
                </small>
            </div>

            <div class="form-group mt-3">
                <label>Email address (Optional)</label>
                <input type="email"
                       name="email"
                       class="form-control @if($errors->has('email')) is-invalid @endif"
                       value="{{old('email') ? old('email') : ''}}"
                       placeholder="Your Email Adress">

                @if($errors->has('email'))
                    <div class="alert alert-danger mt-2">
                        {{$errors->first('email')}}
                    </div>
                @endif

                <small id="emailHelp" class="form-text text-muted">
                    Receive alerts by email when you internet goes down.
                    We'll never share your email with anyone else
                </small>
            </div>

            @if(session()->has('message'))
                <div class="alert alert-info mt-2">
                    {{session()->get('message')}}
                </div>
            @endif

            {{csrf_field()}}
            <div class="text-center">
                <button type="submit" class="btn btn-primary mr-auto ml-auto">Save my IP</button>
            </div>
        </form>
    </div>
@endSection