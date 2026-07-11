<?php

namespace App\Http\Controllers;

use App\Models\Camps;
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

        if(count($user_data) > 0) 
        {
            $code_id = $user_data[0]['.id'];
            $active = $user_data[0]['active'];
            $profile = $user_data[0]['actual-profile'] ?? "N/A";
            $mac = $user_data[0]['caller-id'] ?? "N/A";
            $disabled = $user_data[0]['disabled'];
            $username = $user_data[0]['username'];
            $password = $user_data[0]['password'];

            $start_time = $user_data[0]['comment'] ?? "N/A";
            if($user_data[0]['comment'] != "")
            {
                $date_time = new DateTime($user_data[0]['comment']);
                // $date_time->format("Y-m-d H:i:s");
                $start_time = $date_time->format("Y-m-d H:i:s");
            }
            else
            {
                $start_time = "N/A";   
            }

            $lease_data = $mikrotikService->getAddress($mac);

            $ip_address = $lease_data[0]['active-address'] ?? "N/A";
            $device_name = $lease_data[0]['host-name'] ?? "N/A";

            //get mac type
            $mac_data = $this->getMacType($mac);

            //get days
            $days = $this->getProfileDays($profile);
            try {
                $date = new DateTime($start_time);
                $date->modify('+'.$days." days");
                $date = $date->format("Y-m-d H:i:s");
            } catch (\Throwable $th) {
                $date = "";
            }

            $data = [
                'code_id' => $code_id,
                'active' => $active,
                'profile' => $profile,
                'mac' => $mac,
                'mac_type' => $mac_data['type'],
                'start_time' => $start_time,
                'days' => $days,
                'end_time' => $date,
                'disabled' => $disabled,
                'username' => $username,
                'password' => $password,
                'ip_address' => $ip_address,
                'device_name' => $device_name,
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
        $mac = $user_data[0]['caller-id'];

        $response = $mikrotikService->getAddress($mac);

        return response()->json($response);
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
