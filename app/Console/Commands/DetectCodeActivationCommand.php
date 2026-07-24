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

        foreach($camps as $camp)
        {
            $dubai_time = Carbon::now('Asia/Dubai');

            $host = $camp->mikrotikHost;
            $user = $camp->mikrotikUsername;
            $pwd = $camp->mikrotikPassword;
            $port = $camp->mikrotikPort;

            $mikrotikService = new MikrotikService($host, $user, $pwd, $port);

            $user_data = $mikrotikService->getAllUsers();

            foreach($user_data as $user)
            {
                if($user['caller-id'] == "bind" || $user['caller-id'] == "")
                {
                    continue;
                }//not connected
                else
                {
                    //check user login status
                    $new_user = CodeUsage::where('camp_id', $camp->id)
                        ->where('username', $user['username'])
                        ->first();

                    if($new_user['status'] > 1)
                    {
                        continue;
                    }
                    else
                    {
                        $profile = $user['actual-profile'];
                        $days = $this->getProfileDays($profile);

                        $today = new DateTime($dubai_time);
                        $expire_day = $dubai_time->modify('+'.$days.' days');
                        $expire_time = $expire_day->modify('-15 minutes');

                        $new_user->first_login_at = $dubai_time->format('Y-m-d H:i:s');
                        $new_user->expire_at = $expire_time;
                        $new_user->status = 2;

                        $new_user->save();
                    }//generated user
                }//has mac address
            }//foreach user
        }//foreach camp
    }

    protected function getProfileDays(string $profile)
    {
        $remove_unlimited = str_replace("Unlimited", "", $profile);
        $remove_days = str_replace('Days', '', $remove_unlimited);
        $remove_space = str_replace(" ", '', $remove_days);

        return intval($remove_space);
    }

}//class
