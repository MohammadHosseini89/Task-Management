<?php

namespace App\Jobs;

use Exception;
use Carbon\Carbon;
use App\Models\DoneJob;
use App\Models\LoginHistory;
use App\Models\FailedJobData;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProtectUserLogoutLogs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $loginHistories = LoginHistory::whereNull('logout_time')->get();

        foreach ($loginHistories as $logHistory) {
            $loginTime = Carbon::parse($logHistory->login_time);
            $now = Carbon::now();

            if ($now->diffInHours($loginTime) > 12) {
                $logHistory->logout_time = Carbon::now();
                $logHistory->save();
            }
        }

        DoneJob::create([
            'jobname' => 'ProtectUserLogout',
            'status' => 'Done',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    public function failed2(Exception $exception)
    {
        FailedJobData::create([
            'connection' => "ProtectUserLogout",
            'queue' => null,
            'payload' =>  null,
            'exception' => $exception->getMessage(),
            'failed_at' => now(),
        ]);
    }
}
