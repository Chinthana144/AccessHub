<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sheets extends Model
{
    protected $fillable = [
        'camp_id',
        'name',
        'start_date',
        'end_date',
        'last_synced_at',
        'has_data',
        'status',
    ];

    public function camp()
    {
        return $this->belongsTo(Camps::class, 'camp_id');
    }
}
