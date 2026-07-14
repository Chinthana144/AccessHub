<?php 

namespace App\Services;

use RouterOS\Client;
use RouterOS\Query;

class MikrotikService{

    protected $client;
    public $isConnected = false;

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

    //======================= User Manager =========================//
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

    public function getOneUser(string $username)
    {
        if (!$this->isConnected) {
            return [];
        }

        $query = (new Query('/tool/user-manager/user/print'))->where('username', $username);

        return $this->client
            ->query($query)
            ->read();
    }//get one user

    public function resetMac(string $id)
    {
        if (!$this->isConnected) {
            return [];
        }

        $query = (new Query('/tool/user-manager/user/set'))
            ->equal('.id', $id)
            ->equal('caller-id', 'bind');

        return $this->client
            ->query($query)
            ->read();
    }//reset mac address

    public function disableUser(string $id)
    {
        if (!$this->isConnected) {
            return [];
        }

        $query = (new Query('/tool/user-manager/user/set'))
            ->equal('.id', $id)
            ->equal('caller-id', 'bind')
            ->equal('disabled', 'true');

        return $this->client
            ->query($query)
            ->read();
    }//disable user

    public function enableUser(string $id)
    {
        if (!$this->isConnected) {
            return [];
        }

        $query = (new Query('/tool/user-manager/user/set'))
            ->equal('.id', $id)
            ->equal('disabled', 'false');

        return $this->client
            ->query($query)
            ->read();
    }//enable user

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

}//class