<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IP extends Model
{
    protected $table = 'ip';

    public function log(){
        return $this->hasMany(IPLog::class, 'ip_id', 'id');
    }
}
