<?php

namespace App\Http\Controllers;

use App\Services\GoogleSheetService;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        return view('test.test');
    }

    public function getSheetNames()
    {
        $service = new GoogleSheetService;

        $sheet_id = "1SjJIhgsCy4_nvzEpuVUjyKlnDt1ZPEFRqshiPXp7JAA";
        // $sheet_id = "1F1g2i_rUb7ozSSgfXbG0iNB1edNLd3TVVJoZhU9F3ok";
        $sheets = $service->getSheetNames($sheet_id);

        // dd($sheets);

        return view('test.test', compact('sheets'));
    }//get sheet names
}   
