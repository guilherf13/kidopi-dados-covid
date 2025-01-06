<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiCovidAccessLog extends Model
{
    protected $table = 'api_covid_access_logs';
    protected $fillable = ['country', 'api_acess_at'];
    public $timestamps = false;
}
