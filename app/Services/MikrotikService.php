<?php 

namespace App\Services;

use RouterOS\Client;
use RouterOS\Query;

class MikrotikService{

    protected $client;
    public $isConnected = false;
    public $version = 0;

    public function __construct($host, $user, $pwd, $port)
    {
        try{
            $this->client = new Client([
                'host' => $host,
                'user' => $user,
                'pass' => $pwd,
                'port' => (int)$port,
                'timeout' => 3, // seconds
            ]);
            $this->isConnected = true; // success

            $this->version = $this->detectRouterOSVersion();
        
        } catch (\Exception $e) {
            // Handle connection error
            // echo "Connection failed: " . $e->getMessage();
            $this->isConnected = false; // failed
        }
    } //constructor

    public function getIdentity(){

        $response = [];

        if($this->isConnected){
            $query = new Query('/system/identity/print');
            $response = $this->client->query($query)->read();

            return $response;
        }
        else{
            return $response;
        }
    }//get identity

     public function detectRouterOSVersion()
    {
        if (!$this->isConnected) {
            return [];
        }

        $query = (new Query('/system/resource/print'));

        $resource = $this->client
            ->query($query)
            ->read();

        $version = $resource[0]['version'];

        $result = explode(' ', $version);

        return intval($result[0][0]);
    }//get router OS version


    public function getOneUser(string $username)
    {
        if (!$this->isConnected) {
            return [];
        }

        $query = "";
        $encode_data = [];

        if($this->version == 6)
        {
            $query = (new Query('/tool/user-manager/user/print'))->where('username', $username);

            $user_data = $this->client->query($query)->read();
            $encode_data = json_encode([
                'id' => $user_data[0]['.id'],
                'profile' => $user_data[0]['actual-profile'],
                'mac' => $user_data[0]['caller-id'],
                'disabled' => $user_data[0]['disabled'],
                'username' => $user_data[0]['username'],
                'password' => $user_data[0]['password'],
            ]);
        }
        else{
            $query = (new Query('/user-manager/user/print'))->where('name', $username);

            $user_data = $this->client->query($query)->read();
            
            if(!empty($user_data))
            {
                $encode_data = json_encode([
                    'id' => $user_data[0]['.id'],
                    'mac' => $user_data[0]['caller-id'],
                    'disabled' => $user_data[0]['disabled'],
                    'username' => $user_data[0]['name'],
                    'password' => $user_data[0]['password'],
                ]);
            }  
        }//else OS 7

        return $encode_data;
    }//get one user

    public function getAddress(string $mac)
    {
        if (!$this->isConnected) {
            return [];
        }

        $query = (new Query('/ip/dhcp-server/lease/print'))
            ->where('mac-address', $mac);

        return $this->client
            ->query($query)
            ->read();   
    }//get address

    public function resetMac(string $id)
    {
        if (!$this->isConnected) {
            return [];
        }

        $query = "";

        if($this->version == 6)
        {
            $query = (new Query('/tool/user-manager/user/set'))
                ->equal('.id', $id)
                ->equal('caller-id', 'bind')
                ->equal('caller-id-bind-on-first-use', 'yes')
                ->equal('disabled', 'false');
        }
        else{
            $query = (new Query('/user-manager/user/set'))
            ->equal('.id', $id)
            ->equal('caller-id', 'bind');
            // ->equal('caller-id-bind-on-first-use', 'yes');
            // ->equal('disabled', 'false');
        }

        return $this->client
            ->query($query)
            ->read();
    }//reset mac address

    public function disableUser(string $id)
    {
        if (!$this->isConnected) {
            return [];
        }

        if($this->version == 6)
        {
            $query = (new Query('/tool/user-manager/user/set'))
            ->equal('caller-id', 'bind')
            ->equal('disabled', 'true')
            ->equal('.id', $id);
        }
        else{
            $query = (new Query('/user-manager/user/set'))
            ->equal('.id', $id)
            ->equal('caller-id', 'bind')
            ->equal('disabled', 'true');
        }

        return $this->client
            ->query($query)
            ->read();
    }//disable user

    public function enableUser(string $id)
    {
        if (!$this->isConnected) {
            return [];
        }

        if($this->version == 6)
        {
            $query = (new Query('/tool/user-manager/user/set'))
                ->equal('caller-id', 'bind')
                ->equal('disabled', 'false')
                ->equal('.id', $id);
        }
        else{
            $query = (new Query('/tool/user-manager/user/set'))
                ->equal('.id', $id)
                ->equal('caller-id', 'bind')
                ->equal('disabled', 'false');
        }
        
        return $this->client
            ->query($query)
            ->read();
    }//enable user

    //======================= User Manager =========================//
    public function createUser(string $username, string $password)
    {
        if (!$this->isConnected) {
            return [];
        }

        $query = (new Query('/tool/user-manager/user/add'))
            ->equal('username', $username)
            ->equal('password', $password)
            ->equal('caller-id', 'bind')
            ->equal('customer', 'admin')
            ->equal('shared-users', '1');

        return $this->client
            ->query($query)
            ->read();
    }//create user

    public function deleteUser(string $user_id)
    {
        if (!$this->isConnected) {
            return [];
        }

        $query = (new Query('/tool/user-manager/user/remove'))
            ->equal('.id', $user_id);
        
        return $this->client
            ->query($query)
            ->read();
    }//delete user

    public function activateProfile(string $username, string $profile)
    {
        if (!$this->isConnected) {
            return [];
        }

        $query = (new Query('/tool/user-manager/user/create-and-activate-profile'))
            ->equal('customer', 'admin')
            ->equal('profile', $profile)
            ->equal('numbers', $username);
            
        return $this->client
            ->query($query)
            ->read();
    }//activate profile

    public function getUserManagerUsers()
    {
        if (!$this->isConnected) {
            return [];
        }

        $query = new Query('/tool/user-manager/user/print');

        return $this->client
            ->query($query)
            ->read();
    }//get user manager users



    public function getSessionByUsername(string $username)
    {
        if (!$this->isConnected) {
            return [];
        }

        // $query = (new Query('/tool/user-manager/session/print'))->where('user', $username);
        // $query = (new Query('/ppp/active/print'))->where('name', $username);

        $query = new Query('/tool/user-manager/session/print');

        return $this->client
            ->query($query)
            ->read();
    }//get sessions by user name

    //get users
    public function getUsers()
    {
        if (!$this->isConnected) {
            return [];
        }

        $query = (new Query('/tool/user-manager/user/print'))
            ->where('caller-id', 'bind');

        return $this->client
            ->query($query)
            ->read();   
    }//get users

    public function getAllUsers()
    {
       if (!$this->isConnected) {
            return [];
        }

        $query = new Query('/user-manager/user/print');

        return $this->client
            ->query($query)
            ->read();  
    }//get all users

    //get sesiion
    public function getSession(string $username)
    {
        if (!$this->isConnected) {
            return [];
        }

        $query = (new Query('/ip/hotspot/active/print'))
            ->where('user', $username);

        return $this->client
            ->query($query)
            ->read(); 
    }//get session

    public function removeSession(string $session_id)
    {
        if (!$this->isConnected) {
            return [];
        }

        $query = (new Query('/ip/hotspot/active/remove'))
            ->equal('.id', $session_id);

        return $this->client
            ->query($query)
            ->read(); 
    }//remove session

   


}//class