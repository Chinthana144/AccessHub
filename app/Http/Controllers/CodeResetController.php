<?php

namespace App\Http\Controllers;

use App\Models\Camps;
use App\Models\CodeUsage;
use App\Services\MikrotikService;
use DateTime;
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

        $user_data = $mikrotikService->getOneUser($username);

        // dd($user_data);

        if(!empty($user_data))
        {
            $decode_data = json_decode($user_data);

            $code_id = $decode_data->id;
            $profile = $decode_data->profile ?? "N/A";
            $mac = $decode_data->mac ?? "N/A";
            $disabled = $decode_data->disabled;
            $username = $decode_data->username;
            $password = $decode_data->password;

            $code_data = CodeUsage::where('camp_id', $camp_id)
                ->where('username', $username)
                ->first();

            $code_login_at = $code_data['first_login_at'] ?? '';
            $code_expire_at = $code_data['expire_at'] ?? '';
            $code_status = $code_data['status'] ?? 0;

            //Router OS 7
            $code_expire_at = $decode_data->end_time ?? $code_expire_at;
            $code_status = $decode_data->state ?? $code_status;

            //state OS 7
            if(!empty($decode_data->state))
            {
                switch ($decode_data->state) {
                    case 'waiting':
                        $code_status = 1;
                        break;
                    case 'running-active':
                        $code_status = 2;
                        break;
                    case 'used':
                        $code_status = 3;
                        break;
                    default:
                        $code_status = 0;
                        break;
                }//switch
            }//has state
                        
            $lease_data = $mikrotikService->getAddress($mac);

            $ip_address = $lease_data[0]['active-address'] ?? "N/A";
            $device_name = $lease_data[0]['host-name'] ?? "N/A";

            //get mac type
            $mac_data = $this->getMacType($mac);

            $data = [
                'code_id' => $code_id,
                'code_status' => $code_status,
                'profile' => $profile,
                'mac' => $mac,
                'mac_type' => $mac_data['type'],
                'start_time' => $code_login_at,
                'end_time' => $code_expire_at,
                'disabled' => $disabled,
                'username' => $username,
                'password' => $password,
                'ip_address' => $ip_address,
                'device_name' => $device_name,
                'state' => $code_status,
            ];
            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        }//has code
        else{
            return response()->json([
                'success' => false,
                'message' => "Username Not Found!",
            ]);
        }//no code
    }//get one user

    public function resetCode(Request $request)
    {
        $username = $request->input('username');
        $camp_id = $request->input('camp_id');
        $camp = Camps::find($camp_id);
        
        $host = $camp->mikrotikHost;
        $user = $camp->mikrotikUsername;
        $pwd = $camp->mikrotikPassword;
        $port = $camp->mikrotikPort;

        $mikrotikService = new MikrotikService($host, $user, $pwd, $port);

        $user_data = $mikrotikService->getOneUser($username);

        if(!empty($user_data))
        {
            $decode_data = json_decode($user_data);

            $code_id = $decode_data->id;

            //remove session
            $session_data = $mikrotikService->getSession($username);
            // dd($session_data);
            if(!empty($session_data)){
                //remove all sessions for the user
                foreach($session_data as $session)
                {
                    $session_id = $session['.id'];
                    $mikrotikService->removeSession($session_id);
                }//session
            }//has session
            
            $mikrotikService->resetMac($code_id);

            $data = [
                'code_id' => $decode_data->id,
                'username'=> $decode_data->username,
                'password' => $decode_data->password,
                'sessions' => count($session_data),
            ];

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);

        }//has user
        else{
            return response()->json([
                'success'=> false,
                'message'=>'User not found!'
            ]);
        }//no user
    }//reset user

    public function disableUser(Request $request)
    {
        $username = $request->input('username');
        $camp_id = $request->input('camp_id');
        $camp = Camps::find($camp_id);
        
        $host = $camp->mikrotikHost;
        $user = $camp->mikrotikUsername;
        $pwd = $camp->mikrotikPassword;
        $port = $camp->mikrotikPort;

        $mikrotikService = new MikrotikService($host, $user, $pwd, $port);

        $user_data = $mikrotikService->getOneUser($username);
        
        if(!empty($user_data))
        {
            $decode_data = json_decode($user_data);
            $code_id = $decode_data->id;

            //remove session
            $session_data = $mikrotikService->getSession($username);
            if(!empty($session_data))
            {
                $session_id = $session_data[0]['.id'];

                $mikrotikService->removeSession($session_id);
            }//has session 

            $mikrotikService->disableUser($code_id);

            $data = [
                'code_id' => $decode_data->id,
                'username'=> $decode_data->username,
                'password' => $decode_data->password,
            ];

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        }//has user
        else{
            return response()->json([
                'success'=> false,
                'message'=>'User not found!'
            ]);
        }//no user
    }//disable user

    public function enableUser(Request $request)
    {
        $username = $request->input('username');
        $camp_id = $request->input('camp_id');
        $camp = Camps::find($camp_id);
        
        $host = $camp->mikrotikHost;
        $user = $camp->mikrotikUsername;
        $pwd = $camp->mikrotikPassword;
        $port = $camp->mikrotikPort;

        $mikrotikService = new MikrotikService($host, $user, $pwd, $port);

        $user_data = $mikrotikService->getOneUser($username);

        if(!empty($user_data))
        {
            $decode_data = json_decode($user_data);
            $code_id = $decode_data->id;

            $mikrotikService->enableUser($code_id);

            $data = [
                'code_id' => $decode_data->id,
                'username'=> $decode_data->username,
                'password' => $decode_data->password,
            ];

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        }//has user
        else{
            return response()->json([
                'success'=> false,
                'message'=>'User not found!'
            ]);
        }//no user
    }//enable user

    public function getSessionByUsername(Request $request)
    {
        $camp_id = $request->input('camp_id');
        $camp = Camps::find($camp_id);

        $username = $request->input('username');

        $host = $camp->mikrotikHost;
        $user = $camp->mikrotikUsername;
        $pwd = $camp->mikrotikPassword;
        $port = $camp->mikrotikPort;

        $mikrotikService = new MikrotikService($host, $user, $pwd, $port);

        //fetch user
        $user_data = $mikrotikService->getOneUser($username);
        // $mac = $user_data[0]['caller-id'];

        // $response = $mikrotikService->getAddress($mac);

        return response()->json($user_data);
    }//get session

    //========================= Other methods ==========================//
    public function getMacType(string $mac)
    {
        // Remove separators
        $mac = strtoupper(str_replace([':', '-'], '', $mac));

        // Basic validation
        if (strlen($mac) !== 12) {
            return [
                'valid' => false,
                'type' => 'Unknown'
            ];
        }

        // First byte
        $firstByte = hexdec(substr($mac, 0, 2));

        // Check the Locally Administered bit
        $isRandomized = ($firstByte & 0x02) !== 0;

        return [
            'valid' => true,
            'type' => $isRandomized ? 'Randomized' : 'Device',
            'is_randomized' => $isRandomized
        ];
    }

    protected function getProfileDays(string $profile)
    {
        $replace_1 = str_replace("Days", "", $profile);

        $replace_2  = str_replace("days", "", $replace_1);

        $replace_3  = str_replace("Unlimited", "", $replace_2);

        $days = str_replace(" ", "", $replace_3);

        return $days;
    }

}//class
