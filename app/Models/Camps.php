<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Camps extends Model
{
    protected $fillable = [
        'name',
        'address',
        'contactPerson',
        'contactNo',
        'mikrotikHost',
        'mikrotikPort',
        'mikrotikUsername',
        'mikrotikPassword',
        'sheetID',
        'status',
    ];
}
