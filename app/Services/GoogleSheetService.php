<?php 

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GoogleSheetService{

    protected $script_url = "https://script.google.com/macros/s/AKfycbxI94FOcXwsYQNY4kzragwiSVpBaZXyz03VBQtOldA8QEP7ubnGGAEPoUh5dadQ2S7j/exec";

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
            'action' => 'filterByDate',
        ]);

        return $data->json(); 
    }

}//class