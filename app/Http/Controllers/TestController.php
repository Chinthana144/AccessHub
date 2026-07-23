<?php

namespace App\Http\Controllers;

use App\Models\Camps;
use App\Services\GoogleSheetService;
use App\Services\MikrotikService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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

    public function getUsers()
    {
        $sp3_camp_id = 3;

        $camp = Camps::find($sp3_camp_id);

        $host = $camp->mikrotikHost;
        $user = $camp->mikrotikUsername;
        $pwd = $camp->mikrotikPassword;
        $port = $camp->mikrotikPort;

        $mikrotikService = new MikrotikService($host, $user, $pwd, $port);

        $user_data = $mikrotikService->getUsers();

        return response()->json($user_data);
    }//get users
}//class
