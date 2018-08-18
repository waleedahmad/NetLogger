<?php

namespace App\Http\Controllers;

use App\IP;
use App\Rules\IPAccessible;
use App\Rules\IPAddress;
use App\Rules\IPBelongToUser;
use Carbon\Carbon;
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
                new IPBelongToUser(),
                'unique:ip,ip'
            ],
            'email' => strlen($request->email) ? 'email' : ''
        ], $messages);

        if($validator->passes()){
            $ip_info = $this->getIPInfo($request->ip_address);
            $ip = new IP();
            $ip->ip = $request->ip_address;
            $ip->email = $request->email;
            $ip->city = isset($ip_info->city) ? $ip_info->city : NULL;
            $ip->region = isset($ip_info->region) ? $ip_info->region : NULL;
            $ip->country = isset($ip_info->country) ? $ip_info->country : NULL;
            $ip->loc = isset($ip_info->loc) ? $ip_info->loc : NULL;
            $ip->postal = isset($ip_info->postal) ? $ip_info->postal : NULL;
            $ip->org = isset($ip_info->org) ? $ip_info->org : NULL;

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
        $curr_month = Carbon::now()->startOfMonth();
        $ip = IP::where('ip', '=', $ip_address)->first();
        if($ip){
            $stats = $ip->log()
                        ->whereRaw(
                            'date(created_at) >= ?',
                            $curr_month->format('Y-m-d')
                        )
                        ->whereRaw(
                            'date(created_at) <= ?',
                            Carbon::now()->endOfMonth()->format('Y-m-d')
                        )
                        ->orderBy('created_at', 'DESC')
                        ->paginate(20);
            return view('stats', compact([
                'ip', $ip,
                'stats', $stats,
                'curr_month' , $curr_month
            ]));
        }else{
            return view('404')
                        ->with('ip', $ip_address);
        }
    }

    private function getIPInfo($ip){
        $url = "https://ipinfo.io/$ip/json";
        $json = file_get_contents($url);
        return json_decode($json);
    }
}
