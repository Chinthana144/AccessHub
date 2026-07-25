<?php

namespace App\Console\Commands;

use App\Models\Camps;
use App\Models\CodeUsage;
use App\Services\MikrotikService;
use Illuminate\Console\Command;

class SyncCodeUsageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'codes:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize MikroTik users into code_usages table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Synchronization started...');

        //get all active camps
        $camps = Camps::where('status', 1)->get();

        foreach($camps as $camp)
        {
            $host = $camp->mikrotikHost;
            $user = $camp->mikrotikUsername;
            $pwd = $camp->mikrotikPassword;
            $port = $camp->mikrotikPort;

            $mikrotikService = new MikrotikService($host, $user, $pwd, $port);

            $user_data = $mikrotikService->getAllUsers();

            foreach($user_data as $user)
            {
                //check user
                $user_exists = CodeUsage::where('username', $user['username'])
                    ->where('camp_id', $camp->id)
                    ->exists();
                if($user_exists)
                {
                    continue;
                }//user exist
                else
                {
                    CodeUsage::create([
                        'camp_id' => $camp->id,
                        'username' => $user['username'],
                        'password' => $user['password'],
                        'profile' => $user['actual-profile'] ?? 'Unlimited 30 Days',
                        'mac_address' => $user['caller-id'] ?? '',
                        'first_login_at' => null,
                        'expire_at' => null,
                        'status' => 1,
                    ]);
                }//no user
            }//foreach user
        }//foreach camp

        $this->info('Synchronization finished...');

        return self::SUCCESS;
    }//handle
}
