<?php

namespace App\Http\Controllers;

use App\Http\Requests\FindIPAddressFormRequest;
use App\Http\Requests\IPAddressFormRequest;
use App\IP;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class IPController extends Controller
{
    public function index(){
        return view('index');
    }

    public function addIPForm()
    {
        return view('add_ip');
    }

    /**
     * Add a new IP Address
     * @param IPAddressFormRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function addIP(IPAddressFormRequest $request){
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
    }

    /**
     * Redirect to IP logs route after validating IP Address
     * @param FindIPAddressFormRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function findIP(FindIPAddressFormRequest $request){
        return redirect('/ip/'.$request->ip_address);
    }

    /**
     * Display IP Address logs
     * @param $ip_address
     * @param null $month
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIPStats($ip_address, $month = null)
    {
        $curr_month = Carbon::parse($month)->startOfMonth();
        $ip = IP::where('ip', '=', $ip_address)->first();

        if($ip){
            return view('stats', compact([
                'ip', $ip,
                'curr_month' , $curr_month
            ]));
        }else{
            return view('404')
                        ->with('ip', $ip_address);
        }
    }

    /**
     * Get IP Address ISP info
     * @param $ip
     * @return mixed
     */
    private function getIPInfo($ip){
        $url = "https://ipinfo.io/$ip/json";
        $json = file_get_contents($url);
        return json_decode($json);
    }

}
