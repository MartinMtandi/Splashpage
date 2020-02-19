<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    protected $fillable = [
        'user_id', 'ap_ip', 'ap_port', 'user_mac', 'ap_id', 'ap_group', 'user_url', 'vendor', 'version'
    ];
}
