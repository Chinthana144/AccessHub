<?php

namespace App\Http\Controllers;

use App\Models\Camps;
use App\Services\ManagerService;
use Illuminate\Http\Request;

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
}//class
