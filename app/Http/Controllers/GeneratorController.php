<?php

namespace App\Http\Controllers;

use App\Models\Camps;
use App\Services\MikrotikService;
use Illuminate\Http\Request;

class GeneratorController extends Controller
{
    public function index()
    {
        $camps = Camps::all();

        return view('admin.generator_view', compact('camps'));
    }//index

    public function fetchUserCodes(Request $request)
    {
        $camp_id = $request->input('camp_id');
        $first_charactor = $request->input('first_charactor');

        $camp = Camps::find($camp_id);

        $host = $camp->mikrotikHost;
        $user = $camp->mikrotikUsername;
        $pwd = $camp->mikrotikPassword;
        $port = $camp->mikrotikPort;

        $mikrotikService = new MikrotikService($host, $user, $pwd, $port);

        $all_users = $mikrotikService->getAllUsers();
        $selected_codes = [];

        foreach($all_users as $user)
        {
            $username = $user['username'];
            $first_no = substr($username, 0, 1);

            if($first_no == $first_charactor)
            {
                $selected_codes[] = $username;
            }
        }//foreach

        return response()->json($selected_codes);
    }//fetch codes

    public function generateCodes(Request $request)
    {
        $camp_id = $request->input('camp_id');
        $codes = $request->input('codes');
        $code_count = $request->input('code_count');
        $profile_name = $request->input('profile_name');
        $prefix = $request->input('first_charactor');

        $camp = Camps::find($camp_id);

        $host = $camp->mikrotikHost;
        $user = $camp->mikrotikUsername;
        $pwd = $camp->mikrotikPassword;
        $port = $camp->mikrotikPort;

        $mikrotikService = new MikrotikService($host, $user, $pwd, $port);

        $code_array = [];
        $new_users = [];

        if($codes != '')
        {
            $code_array = explode(',', $codes);
        }//has codes

        $user_create = "";
        $active_profile = "";

        for($i=0; $i<$code_count; $i++)
        {
            $username = "";
            $password = "";
            do {
                $username = $prefix . random_int(1000, 9999);
                $password = random_int(100, 999);
            } while (in_array($username, $code_array));

            //adding created code
            $code_array[] = $username;

            $new_users[] = [
                    'username' => $username,
                    'password' => $password,
                ];

            $user_create = $mikrotikService->createUser($username, $password);
            if(empty($user_create))
            {
                return response()->json([
                    'success' => false,
                    'message' => "user create failed!"
                ]);
            }

            $active_profile = $mikrotikService->activateProfile($username, $profile_name);
            
            // if(empty($active_profile))
            // {
            //     return response()->json([
            //         'success' => false,
            //         'message' => "profile activate failed!"
            //     ]);
            // }

        }//for loop

        return response()->json([
            'users' => $new_users,
            'last_user' => $new_users,
            'profile' => $active_profile
        ]);

    }//generate codes

    //code remover
    public function removeCodes(Request $request)
    {
        $camp_id = $request->input('camp_id');
        $txt_codes = $request->input('txt_codes');

        $camp = Camps::find($camp_id);

        $host = $camp->mikrotikHost;
        $user = $camp->mikrotikUsername;
        $pwd = $camp->mikrotikPassword;
        $port = $camp->mikrotikPort;

        $mikrotikService = new MikrotikService($host, $user, $pwd, $port);
        
        if(!empty($txt_codes))
        {
            $code_array = explode(",", $txt_codes);

            //fetch all users
            $all_users = $mikrotikService->getAllUsers();
            $removed_users = [];

            foreach($all_users as $user)
            {
                $username = $user['username'];
                $user_id = $user['.id'];

                if(in_array($username, $code_array))
                {
                    $mikrotikService->deleteUser($user_id);

                    $removed_users[] = $username;
                }
            }//foreach user

            return response()->json([
                'success' => true,
                'message' => 'users removed successfully!',
                'users' => $removed_users,
            ]);

        }//has codes
        else{
            return response()->json([
                'success' => false,
                'message' => 'Invalid input'
            ]);
        }

    }//remove codes

}//class
