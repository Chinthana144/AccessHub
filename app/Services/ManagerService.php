<?php 

namespace App\Services;

use RouterOS\Client;
use RouterOS\Query;

class ManagerService{

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
    }//constructor

    public function generalCLI(string $txtCli)
    {
        if (!$this->isConnected) {
            return [];
        }

        return $this->client
            ->query($txtCli)
            ->read();
    }//general CLI

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

    public function getAllUsers()
    {
       if (!$this->isConnected) {
            return [];
        }

        $query = new Query('/tool/user-manager/user/print');

        return $this->client
            ->query($query)
            ->read();  
    }//get all users

    public function testing(string $parameter)
    {
        if (!$this->isConnected) {
            return [];
        }

        $query = (new Query('/tool/user-manager/user/print'))
            ->where('username', '34395');

        return $this->client
            ->query($query)
            ->read();
    }//get one user

}//class