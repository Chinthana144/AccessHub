<?php

namespace App\Http\Controllers;

use App\Models\Camps;
use App\Services\MikrotikService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CodeResetController extends Controller
{
    public function index()
    {
        $active_camp_id = Session::get('active_camp_id');
        $camps = Camps::where('status', 1)->get();

        return view('codes.code_reset', compact('camps', 'active_camp_id'));
    }

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

    public function getUserManagerUsers(Request $request)
    {
        $camp_id = $request->input('camp_id');
        $camp = Camps::find($camp_id);

        $host = $camp->mikrotikHost;
        $user = $camp->mikrotikUsername;
        $pwd = $camp->mikrotikPassword;
        $port = $camp->mikrotikPort;

        $mikrotikService = new MikrotikService($host, $user, $pwd, $port);

        $response = $mikrotikService->getUserManagerUsers();

        return response()->json($response); 
    }//get user manager users

    public function getOneUser(Request $request)
    {
        $camp_id = $request->input('camp_id');
        $camp = Camps::find($camp_id);

        $username = $request->input('username');

        $host = $camp->mikrotikHost;
        $user = $camp->mikrotikUsername;
        $pwd = $camp->mikrotikPassword;
        $port = $camp->mikrotikPort;

        $mikrotikService = new MikrotikService($host, $user, $pwd, $port);

        $response = $mikrotikService->getOneUser($username);

        return response()->json($response);
    }

}//class
