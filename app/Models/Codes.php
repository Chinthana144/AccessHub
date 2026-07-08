<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Codes extends Model
{
    protected $fillable = [
        'camp_id',
        'sheet_id',
        'issue_date',
        'submit_datetime',
        'username',
        'password',
        'customer_name',
        'room_no',
        'amount',
        'note',
        'status',
        'user_id',
    ];

    public function camp()
    {
        return $this->belongsTo(Camps::class, 'camp_id');
    }

    public function sheet()
    {
        return $this->belongsTo(Sheets::class, 'sheet_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}//class
