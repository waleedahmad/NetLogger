<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IPLog extends Model
{
    protected $table = 'ip_log';

    protected $fillable = [
        'status'
    ];
}
