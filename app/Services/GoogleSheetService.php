<?php 

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GoogleSheetService{

    protected $script_url = "https://script.google.com/macros/s/AKfycbxRASq0U64ioWartszay5WV1EPLkWFFNGaA7d5JSvmfuMdZ2DSFSsEzuTVeP5osbIV0/exec";

    public function getSheetNames(string $sheet_id)
    {
        $data = Http::get($this->script_url, [
            'sheet_id' => $sheet_id,
            'action' => 'getSheetNames',
        ]);

        return $data->json();
    }//get sheet names

    public function searchByUsername()
    {
        
    }//search by username

}//class