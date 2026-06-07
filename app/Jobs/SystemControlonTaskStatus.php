<?php

namespace App\Jobs;

use App\Models\subTask;
use App\Models\TaskManagementModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SystemControlonTaskStatus implements ShouldQueue
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
        $DataTasktocheck = TaskManagementModel::where('is_complete', '1')->where('fail_label_for_system', 0)
            ->where('success_label_for_system', 0)->get();

        foreach ($DataTasktocheck as $data) {

            if ($data->complete_date < $data->due_date) {
                $data->success_label_for_system = 1;
                $data->save();
            } else {
                $data->fail_label_for_system = 1;
                $data->save();
            }
        }


        $DataSubTasktocheck = subTask::where('is_complete', '1')->where('fail_label_for_system', 0)
        ->where('success_label_for_system', 0)->get();

        foreach ($DataSubTasktocheck as $data) {

            if ($data->complete_date < $data->due_date) {
                $data->success_label_for_system = 1;
                $data->save();
            } else {
                $data->fail_label_for_system = 1;
                $data->save();
            }
        }

    }
}
