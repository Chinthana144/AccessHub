<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Camps;
use App\Services\MikrotikService;
use Illuminate\Http\Request;

class CodeController extends Controller
{
    public function getIdentity(Request $request)
    {
        $camp_id = $request->input('camp_id');
        $camp = Camps::find($camp_id);

        $host = $camp->mikrotikHost;
        $user = $camp->mikrotikUsername;
        $pwd = $camp->mikrotikPassword;
        $port = $camp->mikrotikPort;

        $mikrotikService = new MikrotikService($host, $user, $pwd, $port);

        $response = $mikrotikService->getIdentity();

        return response()->json($response);

    }//get identity

}//class
