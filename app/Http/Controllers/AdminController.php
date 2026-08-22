<?php

namespace App\Http\Controllers;

use App\Models\Camps;
use App\Services\ManagerService;
use App\Services\MikrotikService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $camps = Camps::all();

        return view('admin.admin_view', compact('camps'));
    }//index

    public function generalCli(Request $request)
    {   
        $camp_id = $request->input('camp_id');
        $txt_cli = $request->input('txt_cli');

        $camp = Camps::find($camp_id);

        $host = $camp->mikrotikHost;
        $user = $camp->mikrotikUsername;
        $pwd = $camp->mikrotikPassword;
        $port = $camp->mikrotikPort;

        $managerService = new ManagerService($host, $user, $pwd, $port);

        $data = $managerService->generalCLI($txt_cli);

        return response()->json($data);
    }//general CLI

    public function testing(Request $request)
    {
        $camp_id = $request->input('camp_id');
        $parameter = $request->input('parameter');
        $camp = Camps::find($camp_id);

        $host = $camp->mikrotikHost;
        $user = $camp->mikrotikUsername;
        $pwd = $camp->mikrotikPassword;
        $port = $camp->mikrotikPort;

        $managerService = new ManagerService($host, $user, $pwd, $port);

        $data = $managerService->testing($parameter);

        return response()->json($data);
    }

    //================================= Sessions Section =================================//
    public function viewSession()
    {
        $camps = Camps::all();

        return view('admin.session_view', compact('camps'));
    }//view session page

    public function fetchSession(Request $request)
    {
        $camp_id = $request->input('camp_id');
        $username = $request->input('username');

        $camp = Camps::find($camp_id);

        $host = $camp->mikrotikHost;
        $user = $camp->mikrotikUsername;
        $pwd = $camp->mikrotikPassword;
        $port = $camp->mikrotikPort;

        $mikrotikService = new MikrotikService($host, $user, $pwd, $port);

        $data = $mikrotikService->getSession($username);

        return response()->json($data);
    }//fetch session

    //==================================== Code Check =====================================//
    public function codeCheck(Request $request)
    {
        $camp_id = $request->input('camp_id');
        $txt_codes = $request->input('txt_codes');

        $camp = Camps::find($camp_id);

        $host = $camp->mikrotikHost;
        $user = $camp->mikrotikUsername;
        $pwd = $camp->mikrotikPassword;
        $port = $camp->mikrotikPort;

        $mikrotikService = new MikrotikService($host, $user, $pwd, $port);

        $code_array = explode(',', $txt_codes);

        $all_users = $mikrotikService->getAllUsers();

        $users_array = []; 

        foreach($all_users as $user)
        {
            $username = $user['username'];

            if(!in_array($username, $code_array))
            {
                $mac = $user['caller-id'] ?? "00";
                $profile = $user['actual-profile'] ?? "NoProfile";
                $users_array[] = $user['username'] . " " . $user['password'] ." ".$mac . " " . $profile;
            }//in array

        }//foreach

        return response()->json($users_array);
    }//code check

    //================================ generator ===============================//
    public function generatorView()
    {
        $camps = Camps::all();

        return view('admin.generator_view', compact('camps'));
    }//generator view
}//class
