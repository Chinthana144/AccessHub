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

    public function getOneUser(Request $request)
    {
        $camp_id = $request->input('camp_id');
        $username = $request->input('username');

        $camp = Camps::find($camp_id);

        $host = $camp->mikrotikHost;
        $user = $camp->mikrotikUsername;
        $pwd = $camp->mikrotikPassword;
        $port = $camp->mikrotikPort;

        $mikrotikService = new MikrotikService($host, $user, $pwd, $port);

        $user = $mikrotikService->getOneUser($username);

        return response()->json($user);
    }//get one user

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

    //================================ Restart ===============================//
    public function codeRestartView()
    {
        $camps = Camps::all();

        return view('admin.restart_view', compact('camps'));
    }//code restart

    public function codeRestart(Request $request)
    {
        $camp_id = $request->input('camp_id');
        $code = $request->input('code');
        /*
        * get user
        * get sessions
        * remove all sessions
        * delete user
        * create user
        * create and activate profile
        * return username, password
        */
        
        $camp = Camps::find($camp_id);

        $host = $camp->mikrotikHost;
        $user = $camp->mikrotikUsername;
        $pwd = $camp->mikrotikPassword;
        $port = $camp->mikrotikPort;

        $mikrotikService = new MikrotikService($host, $user, $pwd, $port); 

        $user = $mikrotikService->getOneUser($code);

        if(!empty($user))
        {
            $user_id = $user[0]['.id'];
            $username = $user[0]['username'];
            $password = $user[0]['password'];
            $profile = $user[0]['actual-profile'];

            $sessions = $mikrotikService->getSession($code);
            if(!empty($sessions))
            {
                foreach($sessions as $session)
                {
                    $session_id = $session['.id'];
                    $mikrotikService->removeSession($session_id);
                }//foreach session
            }//has session

            //remove curret user
            $delete_user = $mikrotikService->deleteUser($user_id);

            if(!empty($delete_user))
            {
                //create same user again
                $new_user = $mikrotikService->createUser($username, $password);
                if(!empty($new_user))
                {
                    //create and activate profile
                    $active_profile = $mikrotikService->activateProfile($username, $profile);

                    if(!empty($active_profile))
                    {
                        return response()->json([
                            'success' => true,
                            'message' => 'Code restarted successfully!', 
                        ]);
                    }//profile
                    else{
                        return response()->json([
                            'success' => false,
                            'message' => 'Profile activation failed!', 
                        ]);
                    }
                }//new user
                else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Username create failed!', 
                    ]);
                }//user create failed
            }//delete user
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Username delete failed!', 
                ]);
            }
        }//has user
        else{
            return response()->json([
                'success' => false,
                'message' => 'Username not found!', 
            ]);
        }
    }//codeRestart
}//class
