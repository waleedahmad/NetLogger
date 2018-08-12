<?php

namespace App\Console\Commands;

use App\IP;
use Illuminate\Console\Command;

class LogIPs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:ip';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Log all ips';

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

            $last_record = $ip->log()->orderBy('created_at', '=', 'desc')->first();

            if($this->isReachable($ip->ip)){
                if(!$last_record->status){
                    $ip->log()->create([
                        'status' => true,
                    ]);
                }
            }else{
                if($last_record->status){
                    $ip->log()->create([
                        'status' => false,
                    ]);
                }
            }
        }
    }

    private function isReachable($ip) {
        $pingresult = exec("/bin/ping -c 4 $ip", $outcome, $status);
        return $status === 0;
    }
}
