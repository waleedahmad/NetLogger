<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class IP extends Model
{
    protected $table = 'ip';

    public function log(){
        return $this->hasMany(IPLog::class, 'ip_id', 'id');
    }

    public function disconnects(){
        return $this->hasMany(IPLog::class, 'ip_id', 'id')
                    ->where('created_at', '>=', Carbon::now()->subMonths(1)->format('Y-m-d'))
                    ->where('status', '=', 0);
    }

    public function downtime(){
        $start = $end = null;
        $secs = 0;

        $disconnects = $this->hasMany(IPLog::class, 'ip_id', 'id')
                            ->where(
                                'created_at',
                                '>=',
                                Carbon::now()->subMonths(1)->format('Y-m-d')
                            )->get();

        foreach($disconnects as $disconnect){
            if(!$disconnect->status){
                $start = $disconnect->created_at;
            }else{
                $end = $disconnect->created_at;
                if($start){
                    $secs += $end->diffInSeconds($start);
                }
                $start = $end = null;
            }
        }
        return [
            round($secs / 60 / 60, 1),
            round($secs / 60, 1)
        ];
    }

    public function hiddenIP(){
        $ip = explode(".",$this->ip);
        $ip[3] = '***';
        return implode('.', $ip);
    }
}
