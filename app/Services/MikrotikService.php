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


}//class