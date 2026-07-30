<?php

namespace App\Console\Commands;

use App\Models\Camps;
use App\Models\CodeUsage;
use App\Services\MikrotikService;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

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
                    $old_code = CodeUsage::where('camp_id', $camp->id)
                        ->where('username', $user['username'])
                        ->first();
                    $code_expire = new DateTime($old_code->expire_at);

                    $dubai_time = new DateTime(Carbon::now('Asia/Dubai'));

                    $interval = $dubai_time->diff($code_expire);

                    if( intval($interval->days) > 30)
                    {
                        $this->info($user['username'] . " expired 30 days ago.");
                        $old_code->delete();
                    }//expired months ago
                    // $this->info($dubai_time->format('Y-m-d H:i:s') . " - " . $code_expire->format("Y-m-d H:i:s") . " = " . $interval->days);

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
