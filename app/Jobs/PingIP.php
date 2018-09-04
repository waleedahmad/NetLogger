<?php

namespace App\Jobs;

use App\IP;
use App\IPLog;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PingIP implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $last_record;
    private $ip;

    /**
     * Create a new job instance.
     *
     * @param $ip
     * @param $last_record
     */
    public function __construct(IP $ip, IPLog $last_record)
    {
        $this->ip = $ip;
        $this->last_record = $last_record;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->isReachable($this->ip->ip)){
            if(!$this->last_record->status){
                $this->ip->logs()->create([
                    'status' => true,
                ]);
            }
        }else{
            if($this->last_record->status){
                $this->ip->logs()->create([
                    'status' => false,
                ]);
            }
        }
    }

    private function isReachable($ip) {
        $pingresult = exec("/bin/ping -c 4 $ip", $outcome, $status);
        return $status === 0;
    }
}
