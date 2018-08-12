<?php

namespace App\Console\Commands;

use App\IP;
use Illuminate\Console\Command;

class updateIPDetails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ip:details';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update IP details';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $ips = IP::all();

        foreach($ips as $ip){
            $ip_info = $this->getIPInfo($ip->ip);
            $ip->city = $ip_info->city;
            $ip->region = $ip_info->region;
            $ip->country = $ip_info->country;
            $ip->loc = $ip_info->loc;
            $ip->postal = $ip_info->postal;
            $ip->org = $ip_info->org;
            $ip->save();
        }
    }

    private function getIPInfo($ip){
        $url = "https://ipinfo.io/$ip/json";
        $json = file_get_contents($url);
        return json_decode($json);
    }
}
