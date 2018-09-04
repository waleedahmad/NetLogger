<?php

namespace App\Console\Commands;

use App\IP;
use App\Jobs\PingIP;
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
            $last_record = $ip->logs()->orderBy('created_at', '=', 'desc')->first();
            PingIP::dispatch($ip, $last_record);
        }
    }
}
