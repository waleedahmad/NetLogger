<?php

namespace App\Http\Controllers;

use App\IP;
use App\Rules\IPAccessible;
use App\Rules\IPAddress;
use Illuminate\Http\Request;

class IPController extends Controller
{
    public function index(){
        return view('index');
    }

    public function addIPForm()
    {
        return view('add_ip');
    }

    public function addIP(Request $request){
        $messages = [
            'unique' => ':attribute already exists in database.',
        ];

        $validator = \Validator::make($request->all(), [
            'ip_address' => [
                'required',
                new IPAddress(),
                new IPAccessible(),
                'unique:ip,ip'
            ],
            'email' => strlen($request->email) ? 'email' : ''
        ], $messages);

        if($validator->passes()){
            $ip = new IP();
            $ip->ip = $request->ip_address;
            $ip->email = $request->email;
            if($ip->save()){
                $ip->log()->create([
                    'status' => true
                ]);
                $request->session()->flash('message', 'Your IP has been added successfully');
                return redirect('/add/ip');
            }
        }else{
            return redirect('/add/ip')->withErrors($validator)->withInput();
        }
    }

    public function findIP(Request $request){
        $messages = [
            'exists' => ':attribute does not exist in database.',
        ];

        $validator = \Validator::make($request->all(), [
            'ip_address' => [
                'required',
                new IPAddress(),
                'exists:ip,ip'
            ]
        ], $messages);

        if($validator->passes()){
            return redirect('/ip/'.$request->ip_address);
        }else{
            return redirect('/')->withErrors($validator)->withInput();
        }
    }

    public function getIPStats($ip_address)
    {
        $ip = IP::where('ip', '=', $ip_address)->first();
        if($ip){
            $stats = $ip->log()->orderBy('created_at', 'DESC');
            return view('stats')
                ->with('ip', $ip)
                ->with('stats', $stats);
        }else{
            return view('404')
                        ->with('ip', $ip_address);
        }
    }
}
