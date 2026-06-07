<?php

namespace App\Jobs;

use Exception;
use App\Models\User;
use League\Csv\Reader;
use App\Models\DoneJob;
use App\Models\FailedJobData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\Facades\Hash;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class InitializeUsersJob implements ShouldQueue
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
        // Path to the CSV file
        $filePath = storage_path('users_initial.csv');

        // Load the CSV file using League\Csv\Reader
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $headers = $csv->getHeader();

        // Loop through each row and insert the data into the User model
        foreach ($csv as $row) {
            try {
                $user = new User;
                $user->name = $row['name'];
                $user->email = $row['email'];
                $user->phone = $row['phone'];
                $user->status = $row['status'];
                $user->jobid = $row['jobid'];
                $user->is_superuser = $row['is_superuser'];
                $user->route1 = $row['route1'];
                $user->route2 = $row['route2'];
                $user->route3 = $row['route3'];
                $user->route4 = $row['route4'];
                $user->route5 = $row['route5'];
                $user->route6 = $row['route6'];
                $user->route7 = $row['route7'];
                $user->route8 = $row['route8'];
                $user->route9 = $row['route9'];
                $user->route10 = $row['route10'];
                $user->route11 = $row['route11'];
                $user->route12 = $row['route12'];
                $user->route13 = $row['route13'];
                $user->route14 = $row['route14'];
                $user->route15 = $row['route15'];
                $user->route16 = $row['route16'];
                $user->route17 = $row['route17'];
                $user->route18 = $row['route18'];
                $user->is_reserve1 = $row['is_reserve1'];
                $user->is_reserve2 = $row['is_reserve2'];
                $user->is_reserve3 = $row['is_reserve3'];
                $user->is_reserve4 = $row['is_reserve4'];
                $user->is_reserve5 = $row['is_reserve5'];
                $user->is_reserve6 = $row['is_reserve6'];
                $user->is_reserve7 = $row['is_reserve7'];
                $user->is_reserve8 = $row['is_reserve8'];
                $user->is_reserve9 = $row['is_reserve9'];
                $user->is_reserve10 = $row['is_reserve10'];
                $user->string_reserve1 = $row['string_reserve1'];
                $user->string_reserve2 = $row['string_reserve2'];
                $user->string_reserve3 = $row['string_reserve3'];
                $user->string_reserve4 = $row['string_reserve4'];
                $user->string_reserve5 = $row['string_reserve5'];
                $user->email_verified_at = $row['email_verified_at'] === 'NULL' ? null : $row['email_verified_at'];
                $user->password = Hash::make('2wsx@WSX');
                $user->remember_token = $row['remember_token'];
                $user->created_at = now();
                $user->updated_at = now();
                $user->save();
            } catch (\Throwable $th) {
                app()[ExceptionHandler::class]->report($th);
            }
        }

        DoneJob::create([
            'jobname' => 'InitializeUsersJob',
            'status' => 'Done',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function failed1(Exception $exception)
    {
        FailedJobData::create([
            'connection' => "InitializeUsersJob",
            'queue' => null,
            'payload' =>  null,
            'exception' => $exception->getMessage(),
            'failed_at' => now(),
        ]);
    }
}
