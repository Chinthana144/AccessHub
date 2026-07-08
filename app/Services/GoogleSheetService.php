<?php 

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GoogleSheetService{

    protected $script_url = "https://script.google.com/macros/s/AKfycbwo0AA1Ejz0_-YiR2PIXeb1nmk-w3BgvpRhGT3MDqJBuJExHSUtlNCOZ5_hSi_4gZ-K/exec";

    public function getSheetNames(string $sheet_id)
    {
        $data = Http::get($this->script_url, [
            'sheet_id' => $sheet_id,
            'action' => 'getSheetNames',
        ]);

        return $data->json();
    }//get sheet names

    public function getCodes(string $sheet_id, string $sheet_name)
    {
        $data = Http::get($this->script_url, [
            'sheet_id' => $sheet_id,
            'sheet_name' => $sheet_name,
            'action' => 'view',
        ]);

        return $data->json();
    }//search by username

    public function getCodesByDate(string $sheet_id, string $sheet_name, string $sheet_date)
    {
       $data = Http::get($this->script_url, [
            'sheet_id' => $sheet_id,
            'sheet_name' => $sheet_name,
            'sheet_date' => $sheet_date,
            'action' => 'getCodeByDate',
        ]);

        return $data->json(); 
    }

}//class