<?php

namespace App\Console\Commands;

use App\Models\Camps;
use App\Models\CodeUsage;
use App\Services\MikrotikService;
use Carbon\Carbon;
use DateTime;
use Illuminate\Console\Command;

class DetectCodeActivationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'codes:detect-activation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check user caller-id, detect activation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Start codes checking...');

        $camps = Camps::where('status', 1)->get();
        $dubai_time = Carbon::now('Asia/Dubai');        
        $binded_users = 0;

        foreach($camps as $camp)
        {
            $host = $camp->mikrotikHost;
            $user = $camp->mikrotikUsername;
            $pwd = $camp->mikrotikPassword;
            $port = $camp->mikrotikPort;

            $mikrotikService = new MikrotikService($host, $user, $pwd, $port);

            $user_data = $mikrotikService->getAllUsers();

            $this->info("scanning camp: " . $camp->name);

            foreach($user_data as $user)
            { 
                if(isset($user['caller-id']) && strlen($user['caller-id']) > 4)
                {
                    $today = new DateTime($dubai_time);
                    $new_user = CodeUsage::where('camp_id', $camp->id)
                        ->where('username', $user['username'])
                        ->first();

                    if($new_user['status'] > 1)
                    {
                        $binded_users += 1;

                        $code_expire_date = new DateTime($new_user['expire_at']);

                        if($today > $code_expire_date)
                        {
                            $new_user->status = 3;
                            $new_user->save();
                        }//expired user

                        continue;
                    }
                    $this->info('user: '. $user['username'] .' | mac: '. $user['caller-id']);
                    $profile = $user['actual-profile'] ?? 'Unlimited 30 Days';
                    $days = $this->getProfileDays($profile);

                    $expire_day = $today->modify('+'.$days.' days');
                    $expire_time = $expire_day->modify('-15 minutes');

                    $new_user->first_login_at = $dubai_time->format('Y-m-d H:i:s');
                    $new_user->expire_at = $expire_time;
                    $new_user->status = 2;

                    $new_user->save();
                }//has mac address

            }//foreach user
        }//foreach camp
        
        $this->info('binded users: ' . $binded_users);
        $this->info('Codes updated successfully...');

        return self::SUCCESS;

    }//handle

    protected function getProfileDays(string $profile)
    {
        $remove_unlimited = str_replace("Unlimited", "", $profile);
        $remove_days = str_replace('Days', '', $remove_unlimited);
        $remove_space = str_replace(" ", '', $remove_days);

        return intval($remove_space);
    }//get profile days

}//class
