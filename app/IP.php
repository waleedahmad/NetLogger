<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class IP extends Model
{
    protected $table = 'ip';

    public function logs(){
        return $this->hasMany(IPLog::class, 'ip_id', 'id');
    }

    public function disconnects($month = null){
        return $this->hasMany(IPLog::class, 'ip_id', 'id')
                    ->where('created_at', '>=', Carbon::parse($month)->startOfMonth()->format('Y-m-d'))
                    ->where('created_at', '<=', Carbon::parse($month)->endOfMonth()->format('Y-m-d'))
                    ->where('status', '=', 0);
    }

    public function downtime($month = null){
        $secs = 0;

        $logs = $this->getMonthlyLogs($month, 'ASC');

        if($logs->count()){
            $logs = $logs->first();
            $month_last_log  = $logs[$logs->count() - 1];
            $month_first_log = $logs->first();

            if($month_first_log->status){
                $prev_log = $this->logs()->orderBy('created_at', 'DESC')
                                        ->where('id', '<', $month_first_log->id);

                if($prev_log->count()){
                    $prev_log = $prev_log->first();
                    if($month_first_log->created_at->format('Y M') != $prev_log->created_at->format('Y M')){
                        $start_of_month = $month_first_log->created_at->startOfMonth();
                        $secs += $month_first_log->created_at->diffInSeconds($start_of_month);
                    }
                }
            }

            if(!$month_last_log->status){
                $next_log = $this->logs()->orderBy('created_at', 'DESC')
                                        ->where('id', '>', $month_last_log->id);

                if($next_log->count()){
                    $next_log = $next_log->first();
                    if($month_last_log->created_at->format('Y M') != $next_log->created_at->format('Y M')){
                        $end_of_month = $month_last_log->created_at->endOfMonth();
                        $secs += $month_last_log->created_at->diffInSeconds($end_of_month);
                    }
                }else{
                    $now = Carbon::now();
                    $secs += $month_last_log->created_at->diffInSeconds($now);
                }
            }

            $down = null;
            foreach($logs as $log) {
                if(!$log->status){
                    $down = $log->created_at;
                }else if($log->status){
                    $up = $log->created_at;
                    if($down){
                        $secs += $up->diffInSeconds($down);
                        $down = null;
                    }
                }
            }
        }

        return [
            'hours' => round($secs / 60 / 60, 1),
            'minutes' => round($secs / 60, 1)
        ];
    }
    
    public function hiddenIP(){
        $ip = explode(".",$this->ip);
        $ip[3] = '***';
        return implode('.', $ip);
    }

    public function getMonthlyLogs($month = null, $orderBy = 'DESC'){
        $logs = $this->logs();
        $logs = $month ? $logs->whereRaw(
                    'date(created_at) >= ?',
                    Carbon::parse($month)->startOfMonth()->format('Y-m-d')
                )->whereRaw(
                    'date(created_at) <= ?',
                    Carbon::parse($month)->endOfMonth()->format('Y-m-d')
                ) : $logs;

        return $logs->orderBy('created_at', $orderBy)
                    ->get()
                    ->groupBy(function($date) use ($month){
                        return Carbon::parse($month ? $month : $date->created_at)->format('Y-m');
                    });
    }
}
