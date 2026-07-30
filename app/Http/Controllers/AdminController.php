<?php

namespace App\Http\Controllers;

use App\Models\Camps;
use App\Services\ManagerService;
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

    public function createTokenTable()
    {   
        DB::statement("
            CREATE TABLE personal_access_tokens (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                tokenable_type VARCHAR(255) NOT NULL,
                tokenable_id BIGINT UNSIGNED NOT NULL,
                name VARCHAR(255) NOT NULL,
                token VARCHAR(64) NOT NULL UNIQUE,
                abilities TEXT NULL,
                last_used_at TIMESTAMP NULL,
                expires_at TIMESTAMP NULL,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL,
                INDEX tokenable_type_tokenable_id_index (tokenable_type, tokenable_id)
            );
        ");

        // dd('table created successfully');
        return redirect()->route('admin.index')->with('success', 'table created successfully!');
    }//create token table
}//class
