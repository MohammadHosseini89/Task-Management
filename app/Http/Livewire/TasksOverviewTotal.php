<?php

namespace App\Http\Livewire;

use DateTime;
use Carbon\Carbon;
use Livewire\Component;
use Akaunting\Apexcharts\Chart;
use Illuminate\Support\Facades\DB;

class TasksOverviewTotal extends Component
{

    public function render()
    {

        $Tasks_Data = DB::table('task_management_models')
            ->select('task_management_models.*')
            ->get();


        $SubTasks_Data = DB::table('sub_tasks')
            ->select('sub_tasks.*')
            ->get();


        $Actionlog_Data = DB::table('log_actions_task_management_models')
            ->select('log_actions_task_management_models.*')
            ->get();



        $actionlog = $Actionlog_Data->groupBy('action')->map(function ($item) {
            return [
                'action' => $item[0]->action,
                'count' => $item->count(),
            ];
        });

        $Tasks_Results = [
            'Completed' => $Tasks_Data->where('is_complete', 1)->count(),
            'Cancelled' => $Tasks_Data->where('is_cancel', 1)->count(),
            'Running' => $Tasks_Data->where('is_complete', 0)->where('is_cancel', 0)->count(),
        ];

        $SubTasks_Results = [
            'Completed' => $SubTasks_Data->where('is_complete', 1)->count(),
            'Cancelled' => $SubTasks_Data->where('is_cancel', 1)->count(),
            'Running' => $SubTasks_Data->where('is_complete', 0)->where('is_cancel', 0)->count(),
        ];

        $Tasks_Progress = [
            '00-10 %' => $Tasks_Data->where('is_complete', 0)->where('is_cancel', 0)->whereBetween('progress', [0, 10])->count(),
            '10-20 %' => $Tasks_Data->where('is_complete', 0)->where('is_cancel', 0)->whereBetween('progress', [10, 20])->count(),
            '20-30 %' => $Tasks_Data->where('is_complete', 0)->where('is_cancel', 0)->whereBetween('progress', [20, 30])->count(),
            '30-40 %' => $Tasks_Data->where('is_complete', 0)->where('is_cancel', 0)->whereBetween('progress', [30, 40])->count(),
            '40-50 %' => $Tasks_Data->where('is_complete', 0)->where('is_cancel', 0)->whereBetween('progress', [40, 50])->count(),
            '50-60 %' => $Tasks_Data->where('is_complete', 0)->where('is_cancel', 0)->whereBetween('progress', [50, 60])->count(),
            '60-70 %' => $Tasks_Data->where('is_complete', 0)->where('is_cancel', 0)->whereBetween('progress', [60, 70])->count(),
            '70-80 %' => $Tasks_Data->where('is_complete', 0)->where('is_cancel', 0)->whereBetween('progress', [70, 80])->count(),
            '80-90 %' => $Tasks_Data->where('is_complete', 0)->where('is_cancel', 0)->whereBetween('progress', [80, 90])->count(),
            '90-100 %' => $Tasks_Data->where('is_complete', 0)->where('is_cancel', 0)->whereBetween('progress', [90, 100])->count(),
        ];

        $SubTasks_Progress = [
            '00-10 %' => $SubTasks_Data->where('is_complete', 0)->where('is_cancel', 0)->whereBetween('progress', [0, 10])->count(),
            '10-20 %' => $SubTasks_Data->where('is_complete', 0)->where('is_cancel', 0)->whereBetween('progress', [10, 20])->count(),
            '20-30 %' => $SubTasks_Data->where('is_complete', 0)->where('is_cancel', 0)->whereBetween('progress', [20, 30])->count(),
            '30-40 %' => $SubTasks_Data->where('is_complete', 0)->where('is_cancel', 0)->whereBetween('progress', [30, 40])->count(),
            '40-50 %' => $SubTasks_Data->where('is_complete', 0)->where('is_cancel', 0)->whereBetween('progress', [40, 50])->count(),
            '50-60 %' => $SubTasks_Data->where('is_complete', 0)->where('is_cancel', 0)->whereBetween('progress', [50, 60])->count(),
            '60-70 %' => $SubTasks_Data->where('is_complete', 0)->where('is_cancel', 0)->whereBetween('progress', [60, 70])->count(),
            '70-80 %' => $SubTasks_Data->where('is_complete', 0)->where('is_cancel', 0)->whereBetween('progress', [70, 80])->count(),
            '80-90 %' => $SubTasks_Data->where('is_complete', 0)->where('is_cancel', 0)->whereBetween('progress', [80, 90])->count(),
            '90-100 %' => $SubTasks_Data->where('is_complete', 0)->where('is_cancel', 0)->whereBetween('progress', [90, 100])->count(),
        ];

        $Tasks_Fails_Status = [
            'Failed' => $Tasks_Failed_Already = $Tasks_Data->where('is_cancel', 0)->where('is_complete', 0)->where('due_date', '<', Carbon::now())->count(),
            '1 Day To Fail' => $Tasks_Failed_1_day = $Tasks_Data->where('is_cancel', 0)->where('is_complete', 0)->where('due_date', '<', Carbon::tomorrow())->count() - $Tasks_Failed_Already,
            '1-7 Days to Fail' => $Tasks_Failed_1_to_7day = $Tasks_Data->where('is_cancel', 0)->where('is_complete', 0)->where('due_date', '<', Carbon::now()->addDays(7))->count() - $Tasks_Failed_1_day,
            '7-14 Days to Fail' => $Tasks_Failed_7_to_14day = $Tasks_Data->where('is_cancel', 0)->where('is_complete', 0)->where('due_date', '<', Carbon::now()->addDays(14))->count() - $Tasks_Failed_1_to_7day,
            '14-21 Days to Fail' => $Tasks_Failed_14_to_21day = $Tasks_Data->where('is_cancel', 0)->where('is_complete', 0)->where('due_date', '<', Carbon::now()->addDays(21))->count() - $Tasks_Failed_7_to_14day,
            '21-30 Days to Fail' => $Tasks_Failed_21_to_30day = $Tasks_Data->where('is_cancel', 0)->where('is_complete', 0)->where('due_date', '<', Carbon::now()->addDays(30))->count() - $Tasks_Failed_14_to_21day,
            'Have More than 30 Days Time' => $Tasks_Data->where('is_cancel', 0)->where('is_complete', 0)->where('due_date', '>', Carbon::now()->addDays(30))->count(),
        ];

        $SubTasks_Fails_Status = [
            'Failed' => $SubTasks_Failed_Already = $SubTasks_Data->where('is_cancel', 0)->where('is_complete', 0)->where('due_date', '<', Carbon::now())->count(),
            '1 Day To Fail' => $SubTasks_Failed_1_day = $SubTasks_Data->where('is_cancel', 0)->where('is_complete', 0)->where('due_date', '<', Carbon::tomorrow())->count() - $SubTasks_Failed_Already,
            '1-7 Days to Fail' => $SubTasks_Failed_1_to_7day = $SubTasks_Data->where('is_cancel', 0)->where('is_complete', 0)->where('due_date', '<', Carbon::now()->addDays(7))->count() - $SubTasks_Failed_1_day,
            '7-14 Days to Fail' => $SubTasks_Failed_7_to_14day = $SubTasks_Data->where('is_cancel', 0)->where('is_complete', 0)->where('due_date', '<', Carbon::now()->addDays(14))->count() - $SubTasks_Failed_1_to_7day,
            '14-21 Days to Fail' => $SubTasks_Failed_14_to_21day = $SubTasks_Data->where('is_cancel', 0)->where('is_complete', 0)->where('due_date', '<', Carbon::now()->addDays(21))->count() - $SubTasks_Failed_7_to_14day,
            '21-30 Days to Fail' => $SubTasks_Failed_21_to_30day = $SubTasks_Data->where('is_cancel', 0)->where('is_complete', 0)->where('due_date', '<', Carbon::now()->addDays(30))->count() - $SubTasks_Failed_14_to_21day,
            'Have More than 30 Days Time' => $SubTasks_Data->where('is_cancel', 0)->where('is_complete', 0)->where('due_date', '>', Carbon::now()->addDays(30))->count(),
        ];

        $Completed_Tasks_Fails_Status = [
            'Failed' => $Tasks_Data->where('is_complete', 1)->where('is_fail', 1)->count(),
            'Successful' => $Tasks_Data->where('is_complete', 1)->where('is_success', 1)->count(),
        ];

        $Completed_SubTasks_Fails_Status = [
            'Failed' => $SubTasks_Data->where('is_complete', 1)->where('is_fail', 1)->count(),
            'Successful' => $SubTasks_Data->where('is_complete', 1)->where('is_success', 1)->count(),
        ];

        // dd($SubTasks_Fails_Status);


        // For Priority
        $Priority_Results_P1 = [
            'Running' => $Tasks_Data->where('priority', 'P1')->where('is_complete', 0)->where('is_cancel', 0)->count(),
            'Completed' => $Tasks_Data->where('priority', 'P1')->where('is_complete', 1)->count(),
            'Cancelled' => $Tasks_Data->where('priority', 'P1')->where('is_cancel', 1)->count(),
        ];

        $Priority_Results_P2 = [
            'Running' => $Tasks_Data->where('priority', 'P2')->where('is_complete', 0)->where('is_cancel', 0)->count(),
            'Completed' => $Tasks_Data->where('priority', 'P2')->where('is_complete', 1)->count(),
            'Cancelled' => $Tasks_Data->where('priority', 'P2')->where('is_cancel', 1)->count(),
        ];

        $Priority_Results_P3 = [
            'Running' => $Tasks_Data->where('priority', 'P3')->where('is_complete', 0)->where('is_cancel', 0)->count(),
            'Completed' => $Tasks_Data->where('priority', 'P3')->where('is_complete', 1)->count(),
            'Cancelled' => $Tasks_Data->where('priority', 'P3')->where('is_cancel', 1)->count(),
        ];

        $Priority_Results_P4 = [
            'Running' => $Tasks_Data->where('priority', 'P4')->where('is_complete', 0)->where('is_cancel', 0)->count(),
            'Completed' => $Tasks_Data->where('priority', 'P4')->where('is_complete', 1)->count(),
            'Cancelled' => $Tasks_Data->where('priority', 'P4')->where('is_cancel', 1)->count(),
        ];

        $Priority_Results_P5 = [
            'Running' => $Tasks_Data->where('priority', 'P5')->where('is_complete', 0)->where('is_cancel', 0)->count(),
            'Completed' => $Tasks_Data->where('priority', 'P5')->where('is_complete', 1)->count(),
            'Cancelled' => $Tasks_Data->where('priority', 'P5')->where('is_cancel', 1)->count(),
        ];



        // For Raisedby

        $Raisedby_FO = [
            'Running' => $Tasks_Data->where('raisedbyuser', 'FO')->where('is_complete', 0)->where('is_cancel', 0)->count(),
            'Completed' => $Tasks_Data->where('raisedbyuser', 'FO')->where('is_complete', 1)->count(),
            'Cancelled' => $Tasks_Data->where('raisedbyuser', 'FO')->where('is_cancel', 1)->count(),
        ];

        $Raisedby_BO = [
            'Running' => $Tasks_Data->where('raisedbyuser', 'BO')->where('is_complete', 0)->where('is_cancel', 0)->count(),
            'Completed' => $Tasks_Data->where('raisedbyuser', 'BO')->where('is_complete', 1)->count(),
            'Cancelled' => $Tasks_Data->where('raisedbyuser', 'BO')->where('is_cancel', 1)->count(),
        ];
        $Raisedby_OSS = [
            'Running' => $Tasks_Data->where('raisedbyuser', 'OSS')->where('is_complete', 0)->where('is_cancel', 0)->count(),
            'Completed' => $Tasks_Data->where('raisedbyuser', 'OSS')->where('is_complete', 1)->count(),
            'Cancelled' => $Tasks_Data->where('raisedbyuser', 'OSS')->where('is_cancel', 1)->count(),
        ];
        $Raisedby_Customer = [
            'Running' => $Tasks_Data->where('raisedbyuser', 'Customer')->where('is_complete', 0)->where('is_cancel', 0)->count(),
            'Completed' => $Tasks_Data->where('raisedbyuser', 'Customer')->where('is_complete', 1)->count(),
            'Cancelled' => $Tasks_Data->where('raisedbyuser', 'Customer')->where('is_cancel', 1)->count(),
        ];
        $Raisedby_FM = [
            'Running' => $Tasks_Data->where('raisedbyuser', 'FM')->where('is_complete', 0)->where('is_cancel', 0)->count(),
            'Completed' => $Tasks_Data->where('raisedbyuser', 'FM')->where('is_complete', 1)->count(),
            'Cancelled' => $Tasks_Data->where('raisedbyuser', 'FM')->where('is_cancel', 1)->count(),
        ];
        $Raisedby_EHS = [
            'Running' => $Tasks_Data->where('raisedbyuser', 'EHS')->where('is_complete', 0)->where('is_cancel', 0)->count(),
            'Completed' => $Tasks_Data->where('raisedbyuser', 'EHS')->where('is_complete', 1)->count(),
            'Cancelled' => $Tasks_Data->where('raisedbyuser', 'EHS')->where('is_cancel', 1)->count(),
        ];


        // Subtasks Pend Teams

        $SubTasks_teams_FO = [
            'Completed' => $SubTasks_Data->where('owner', '=', 'fo@default.com')->where('is_complete', 1)->count(),
            'Cancelled' => $SubTasks_Data->where('owner', '=', 'fo@default.com')->where('is_cancel', 1)->count(),
            'Running' => $SubTasks_Data->where('owner', '=', 'fo@default.com')->where('is_complete', 0)->where('is_cancel', 0)->count(),
        ];

        $SubTasks_teams_BO = [
            'Completed' => $SubTasks_Data->where('owner', '=', 'bo@default.com')->where('is_complete', 1)->count(),
            'Cancelled' => $SubTasks_Data->where('owner', '=', 'bo@default.com')->where('is_cancel', 1)->count(),
            'Running' => $SubTasks_Data->where('owner', '=', 'bo@default.com')->where('is_complete', 0)->where('is_cancel', 0)->count(),
        ];

        $SubTasks_teams_OSS = [
            'Completed' => $SubTasks_Data->where('owner', '=', 'oss@default.com')->where('is_complete', 1)->count(),
            'Cancelled' => $SubTasks_Data->where('owner', '=', 'oss@default.com')->where('is_cancel', 1)->count(),
            'Running' => $SubTasks_Data->where('owner', '=', 'oss@default.com')->where('is_complete', 0)->where('is_cancel', 0)->count(),
        ];

        $SubTasks_teams_Customer = [
            'Completed' => $SubTasks_Data->where('owner', '=', 'customer@default.com')->where('is_complete', 1)->count(),
            'Cancelled' => $SubTasks_Data->where('owner', '=', 'customer@default.com')->where('is_cancel', 1)->count(),
            'Running' => $SubTasks_Data->where('owner', '=', 'customer@default.com')->where('is_complete', 0)->where('is_cancel', 0)->count(),
        ];

        $SubTasks_teams_FM = [
            'Completed' => $SubTasks_Data->where('owner', '=', 'fm@default.com')->where('is_complete', 1)->count(),
            'Cancelled' => $SubTasks_Data->where('owner', '=', 'fm@default.com')->where('is_cancel', 1)->count(),
            'Running' => $SubTasks_Data->where('owner', '=', 'fm@default.com')->where('is_complete', 0)->where('is_cancel', 0)->count(),
        ];

        $SubTasks_teams_EHS = [
            'Completed' => $SubTasks_Data->where('owner', '=', 'ehs@default.com')->where('is_complete', 1)->count(),
            'Cancelled' => $SubTasks_Data->where('owner', '=', 'ehs@default.com')->where('is_cancel', 1)->count(),
            'Running' => $SubTasks_Data->where('owner', '=', 'ehs@default.com')->where('is_complete', 0)->where('is_cancel', 0)->count(),
        ];

        $SubTasks_teams_DeliveryTeam = [
            'Completed' => $SubTasks_Data->where('owner', '=', 'delivery@default.com')->where('is_complete', 1)->count(),
            'Cancelled' => $SubTasks_Data->where('owner', '=', 'delivery@default.com')->where('is_cancel', 1)->count(),
            'Running' => $SubTasks_Data->where('owner', '=', 'delivery@default.com')->where('is_complete', 0)->where('is_cancel', 0)->count(),
        ];


        // Running Impact Vs Solution 3


        $Impact_Blank = [
            'Ongoing' => $Tasks_Data->wherenull('impact')->where('solution3', 'Ongoing')->where('is_complete', 0)->where('is_cancel', 0)->count(),
            'New Requirement' => $Tasks_Data->wherenull('impact')->where('solution3', 'New Requirement')->where('is_complete', 0)->where('is_cancel', 0)->count(),
            'Currently Not Support' => $Tasks_Data->wherenull('impact')->where('solution3', 'Currently Not Support')->where('is_complete', 0)->where('is_cancel', 0)->count(),
            'Clarification Required' => $Tasks_Data->wherenull('impact')->where('solution3', 'Clarification Required')->where('is_complete', 0)->where('is_cancel', 0)->count(),
        ];

        $Impact_Alarming_Rules = [
            'Ongoing' => $Tasks_Data->where('impact', 'Alarm rules')->where('solution3', 'Ongoing')->where('is_complete', 0)->where('is_cancel', 0)->count(),
            'New Requirement' => $Tasks_Data->where('impact', 'Alarm rules')->where('solution3', 'New Requirement')->where('is_complete', 0)->where('is_cancel', 0)->count(),
            'Currently Not Support' => $Tasks_Data->where('impact', 'Alarm rules')->where('solution3', 'Currently Not Support')->where('is_complete', 0)->where('is_cancel', 0)->count(),
            'Clarification Required' => $Tasks_Data->where('impact', 'Alarm rules')->where('solution3', 'Clarification Required')->where('is_complete', 0)->where('is_cancel', 0)->count(),
        ];

        $Impact_Integration = [
            'Ongoing' => $Tasks_Data->where('impact', 'Integration')->where('solution3', 'Ongoing')->where('is_complete', 0)->where('is_cancel', 0)->count(),
            'New Requirement' => $Tasks_Data->where('impact', 'Integration')->where('solution3', 'New Requirement')->where('is_complete', 0)->where('is_cancel', 0)->count(),
            'Currently Not Support' => $Tasks_Data->where('impact', 'Integration')->where('solution3', 'Currently Not Support')->where('is_complete', 0)->where('is_cancel', 0)->count(),
            'Clarification Required' => $Tasks_Data->where('impact', 'Integration')->where('solution3', 'Clarification Required')->where('is_complete', 0)->where('is_cancel', 0)->count(),
        ];

        $Impact_Report = [
            'Ongoing' => $Tasks_Data->where('impact', 'Report')->where('solution3', 'Ongoing')->where('is_complete', 0)->where('is_cancel', 0)->count(),
            'New Requirement' => $Tasks_Data->where('impact', 'Report')->where('solution3', 'New Requirement')->where('is_complete', 0)->where('is_cancel', 0)->count(),
            'Currently Not Support' => $Tasks_Data->where('impact', 'Report')->where('solution3', 'Currently Not Support')->where('is_complete', 0)->where('is_cancel', 0)->count(),
            'Clarification Required' => $Tasks_Data->where('impact', 'Report')->where('solution3', 'Clarification Required')->where('is_complete', 0)->where('is_cancel', 0)->count(),
        ];

        $Impact_SDM_Process = [
            'Ongoing' => $Tasks_Data->where('impact', 'SDM Process')->where('solution3', 'Ongoing')->where('is_complete', 0)->where('is_cancel', 0)->count(),
            'New Requirement' => $Tasks_Data->where('impact', 'SDM Process')->where('solution3', 'New Requirement')->where('is_complete', 0)->where('is_cancel', 0)->count(),
            'Currently Not Support' => $Tasks_Data->where('impact', 'SDM Process')->where('solution3', 'Currently Not Support')->where('is_complete', 0)->where('is_cancel', 0)->count(),
            'Clarification Required' => $Tasks_Data->where('impact', 'SDM Process')->where('solution3', 'Clarification Required')->where('is_complete', 0)->where('is_cancel', 0)->count(),
        ];
        $Impact_WFM = [
            'Ongoing' => $Tasks_Data->where('impact', 'WFM')->where('solution3', 'Ongoing')->where('is_complete', 0)->where('is_cancel', 0)->count(),
            'New Requirement' => $Tasks_Data->where('impact', 'WFM')->where('solution3', 'New Requirement')->where('is_complete', 0)->where('is_cancel', 0)->count(),
            'Currently Not Support' => $Tasks_Data->where('impact', 'WFM')->where('solution3', 'Currently Not Support')->where('is_complete', 0)->where('is_cancel', 0)->count(),
            'Clarification Required' => $Tasks_Data->where('impact', 'WFM')->where('solution3', 'Clarification Required')->where('is_complete', 0)->where('is_cancel', 0)->count(),
        ];


        $Actionlog_Detail = DB::table('log_actions_task_management_models')
            ->orderBy('id', 'desc')
            ->where('action', '=', 'Owner Feedback')
            ->get();

        $labels_feedback =  ['OSS', 'Delivery Team', 'FO', 'BO', 'FM', 'Customer', 'EHS'];
        $feedback_counts = [
            $Actionlog_Detail->where('owner', '=', 'oss@default.com')->count(),
            $Actionlog_Detail->where('owner', '=', 'delivery@default.com')->count(),
            $Actionlog_Detail->where('owner', '=', 'fo@default.com')->count(),
            $Actionlog_Detail->where('owner', '=', 'bo@default.com')->count(),
            $Actionlog_Detail->where('owner', '=', 'fm@default.com')->count(),
            $Actionlog_Detail->where('owner', '=', 'customer@default.com')->count(),
            $Actionlog_Detail->where('owner', '=', 'ehs@default.com')->count(),
        ];

        $last_30 = $Actionlog_Detail->wherein('owner', [
            'oss@default.com', 'delivery@default.com',
            'fo@default.com', 'bo@default.com', 'fm@default.com', 'customer@default.com', 'ehs@default.com'
        ])->take(1000);
        $date_time_last_30_total = $last_30->pluck('created_at')->toarray();

        $date_time_last_30_oss = $last_30->where('owner', 'oss@default.com')->pluck('created_at')->toarray();
        $date_time_last_30_delivery = $last_30->where('owner', 'delivery@default.com')->pluck('created_at')->toarray();
        $date_time_last_30_fo = $last_30->where('owner', 'fo@default.com')->pluck('created_at')->toarray();
        $date_time_last_30_bo = $last_30->where('owner', 'bo@default.com')->pluck('created_at')->toarray();
        $date_time_last_30_fm = $last_30->where('owner', 'fm@default.com')->pluck('created_at')->toarray();
        $date_time_last_30_customer = $last_30->where('owner', 'customer@default.com')->pluck('created_at')->toarray();
        $date_time_last_30_ehs = $last_30->where('owner', 'ehs@default.com')->pluck('created_at')->toarray();


        $replacements = [
            'oss@default.com' => "OSS",
            'delivery@default.com' => "Delivery Team",
            'fo@default.com' => "FO",
            'bo@default.com' => "BO",
            'fm@default.com' => "FM",
            'customer@default.com' => "Customer",
            'ehs@default.com' => "EHS",
        ];


        $datesTotal = [];

        $datesOSS = [];
        $datesDelivery = [];
        $datesFO = [];
        $datesBO = [];
        $datesFM = [];
        $datesCustomer = [];
        $datesEHS = [];


        foreach ($date_time_last_30_total as $date) {
            $dateTime = new DateTime($date);
            $newDate = $dateTime->format('Ymd');
            $datesTotal[] = $newDate;
        }
        $datesTotal_unique = array_unique($datesTotal);

        // Start
        foreach ($date_time_last_30_oss as $date) {
            $dateTime = new DateTime($date);
            $newDate = $dateTime->format('Ymd');
            $datesOSS[] = $newDate;
        }

        foreach ($date_time_last_30_delivery as $date) {
            $dateTime = new DateTime($date);
            $newDate = $dateTime->format('Ymd');
            $datesDelivery[] = $newDate;
        }

        foreach ($date_time_last_30_fo as $date) {
            $dateTime = new DateTime($date);
            $newDate = $dateTime->format('Ymd');
            $datesFO[] = $newDate;
        }

        foreach ($date_time_last_30_bo as $date) {
            $dateTime = new DateTime($date);
            $newDate = $dateTime->format('Ymd');
            $datesBO[] = $newDate;
        }

        foreach ($date_time_last_30_fm as $date) {
            $dateTime = new DateTime($date);
            $newDate = $dateTime->format('Ymd');
            $datesFM[] = $newDate;
        }

        foreach ($date_time_last_30_customer as $date) {
            $dateTime = new DateTime($date);
            $newDate = $dateTime->format('Ymd');
            $datesCustomer[] = $newDate;
        }

        foreach ($date_time_last_30_ehs as $date) {
            $dateTime = new DateTime($date);
            $newDate = $dateTime->format('Ymd');
            $datesEHS[] = $newDate;
        }


        // Count occurrences of values from $datesTotal_unique in $datesOSS
        $count_date_oss = array_map(function ($value) use ($datesOSS) {
            return array_count_values($datesOSS)[$value] ?? 0;
        }, $datesTotal_unique);


        // $ = [];
        // $ = [];
        // $ = [];
        // $ = [];

        // Count occurrences of values from $datesTotal_unique in $datesDelivery
        $count_date_delivery = array_map(function ($value) use ($datesDelivery) {
            return array_count_values($datesDelivery)[$value] ?? 0;
        }, $datesTotal_unique);

        // Count occurrences of values from $datesTotal_unique in $datesFO
        $count_date_fo = array_map(function ($value) use ($datesFO) {
            return array_count_values($datesFO)[$value] ?? 0;
        }, $datesTotal_unique);

        // Count occurrences of values from $datesTotal_unique in $datesBO
        $count_date_bo = array_map(function ($value) use ($datesBO) {
            return array_count_values($datesBO)[$value] ?? 0;
        }, $datesTotal_unique);

        // Count occurrences of values from $datesTotal_unique in $datesFM
        $count_date_fm = array_map(function ($value) use ($datesFM) {
            return array_count_values($datesFM)[$value] ?? 0;
        }, $datesTotal_unique);

        // Count occurrences of values from $datesTotal_unique in $datesCustomer
        $count_date_customer = array_map(function ($value) use ($datesCustomer) {
            return array_count_values($datesCustomer)[$value] ?? 0;
        }, $datesTotal_unique);

        // Count occurrences of values from $datesTotal_unique in $datesEHS
        $count_date_ehs = array_map(function ($value) use ($datesEHS) {
            return array_count_values($datesEHS)[$value] ?? 0;
        }, $datesTotal_unique);


        $chart_feedback_dates = (new Chart)
            ->setType('line')
            ->setWidth('100%')
            ->setHeight(250)
            ->setLabels(array_reverse(array_values($datesTotal_unique)))
            // ->setDataLabelsStyle(['fontSize' => '10px','colors' => ['#000', '#001'],])->setSeries($my_2g_cat)
            ->setDataset('Delivery', 'line', array_reverse(array_values($count_date_delivery)))
            ->setDataset('FO', 'line', array_reverse(array_values($count_date_fo)))
            ->setDataset('BO', 'line', array_reverse(array_values($count_date_bo)))
            ->setDataset('FM', 'line', array_reverse(array_values($count_date_fm)))
            ->setDataset('Customer', 'line', array_reverse(array_values($count_date_customer)))
            ->setDataset('EHS', 'line', array_reverse(array_values($count_date_ehs)))

            ->setSubtitle('Last 1000 Feedback Dates')
            ->setLegendShow(true)
            ->setlegendPosition('bottom')
            ->setlegendHorizontalAlign('center')
            ->setlegendShowForZeroSeries(true)
            ->setdataLabelsEnabled(true)
            ->setSubtitleAlign('center')
            ->setSubtitleOffsetY(12)
            ->setSubtitleStyle([
                'color' => 'black',
            ])
            ->setOption([
                'yaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set y-axis label color to black
                        ],
                    ],
                ],
                'xaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set legend label color to black
                        ],
                    ],
                ],
            ])
            // ->setHorizontal(true)
            ;


        $chart_feedback_count = (new Chart)
            ->setType('bar')
            ->setWidth('100%')
            ->setHeight(250)
            ->setLabels(array_values($labels_feedback))
            // ->setDataLabelsStyle(['fontSize' => '10px','colors' => ['#000', '#001'],])->setSeries($my_2g_cat)
            ->setDataset('Feedback Count', 'bar', array_values($feedback_counts))
            ->setSubtitle('Feedback Received Count')
            ->setLegendShow(true)
            ->setlegendPosition('bottom')
            ->setlegendHorizontalAlign('center')
            ->setlegendShowForZeroSeries(true)
            ->setdataLabelsEnabled(true)
            ->setSubtitleAlign('center')
            ->setSubtitleOffsetY(12)
            ->setSubtitleStyle([
                'color' => 'black',
            ])
            ->setOption([
                'yaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set y-axis label color to black
                        ],
                    ],
                ],
                'xaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set legend label color to black
                        ],
                    ],
                ],
            ])
            // ->setHorizontal(true)
        ;


        $chart_taskcount_impact = (new Chart)
            ->setType('bar')
            ->setWidth('100%')
            ->setHeight(250)
            ->setLabels(array_keys($Impact_Blank))
            // ->setDataLabelsStyle(['fontSize' => '10px','colors' => ['#000', '#001'],])->setSeries($my_2g_cat)
            ->setDataset('Alarming Rules', 'bar', array_values($Impact_Alarming_Rules))
            ->setDataset('Integration', 'bar', array_values($Impact_Integration))
            ->setDataset('Report', 'bar', array_values($Impact_Report))
            ->setDataset('SDM Process', 'bar', array_values($Impact_SDM_Process))
            ->setDataset('WFM', 'bar', array_values($Impact_WFM))

            ->setDataset('Blank', 'bar', array_values($Impact_Blank))
            ->setSubtitle('Tasks Impact')
            ->setLegendShow(true)
            ->setlegendPosition('bottom')
            ->setlegendHorizontalAlign('center')
            ->setlegendShowForZeroSeries(true)
            ->setdataLabelsEnabled(true)
            ->setSubtitleAlign('center')
            ->setSubtitleOffsetY(12)
            ->setSubtitleStyle([
                'color' => 'black',
            ])
            ->setOption([
                'yaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set y-axis label color to black
                        ],
                    ],
                ],
                'xaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set legend label color to black
                        ],
                    ],
                ],
            ])
            // ->setHorizontal(true)
        ;


        $chart_taskcount_priority = (new Chart)
            ->setType('bar')
            ->setWidth('100%')
            ->setHeight(250)
            ->setLabels(array_keys($Priority_Results_P1))
            // ->setDataLabelsStyle(['fontSize' => '10px','colors' => ['#000', '#001'],])->setSeries($my_2g_cat)
            ->setDataset('P1', 'bar', array_values($Priority_Results_P1))
            ->setDataset('P2', 'bar', array_values($Priority_Results_P2))
            ->setDataset('P3', 'bar', array_values($Priority_Results_P3))
            ->setDataset('P4', 'bar', array_values($Priority_Results_P4))
            ->setDataset('P5', 'bar', array_values($Priority_Results_P5))
            ->setSubtitle('Tasks Priority')
            ->setLegendShow(true)
            ->setlegendPosition('bottom')
            ->setlegendHorizontalAlign('center')
            ->setlegendShowForZeroSeries(true)
            ->setdataLabelsEnabled(true)
            ->setSubtitleAlign('center')
            ->setSubtitleOffsetY(12)
            ->setSubtitleStyle([
                'color' => 'black',
            ])
            ->setOption([
                'yaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set y-axis label color to black
                        ],
                    ],
                ],
                'xaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set legend label color to black
                        ],
                    ],
                ],
            ])
            // ->setHorizontal(true)
        ;


        $chart_taskcount_raisedby = (new Chart)
            ->setType('bar')
            ->setWidth('100%')
            ->setHeight(250)
            ->setLabels(array_keys($Raisedby_FO))
            // ->setDataLabelsStyle(['fontSize' => '10px','colors' => ['#000', '#001'],])->setSeries($my_2g_cat)
            ->setDataset('FO', 'bar', array_values($Raisedby_FO))
            ->setDataset('BO', 'bar', array_values($Raisedby_BO))
            ->setDataset('OSS', 'bar', array_values($Raisedby_OSS))
            ->setDataset('Customer', 'bar', array_values($Raisedby_Customer))
            ->setDataset('FM', 'bar', array_values($Raisedby_FM))
            ->setDataset('EHS', 'bar', array_values($Raisedby_EHS))

            ->setSubtitle('Tasks Raisedby')
            ->setLegendShow(true)
            ->setlegendPosition('bottom')
            ->setlegendHorizontalAlign('center')
            ->setlegendShowForZeroSeries(true)
            ->setdataLabelsEnabled(true)
            ->setSubtitleAlign('center')
            ->setSubtitleOffsetY(12)
            ->setSubtitleStyle([
                'color' => 'black',
            ])
            ->setOption([
                'yaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set y-axis label color to black
                        ],
                    ],
                ],
                'xaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set legend label color to black
                        ],
                    ],
                ],
            ])
            // ->setHorizontal(true)
        ;


        $chart_taskcount_teams = (new Chart)
            ->setType('bar')
            ->setWidth('100%')
            ->setHeight(250)
            ->setLabels(array_keys($SubTasks_teams_FO))
            // ->setDataLabelsStyle(['fontSize' => '10px','colors' => ['#000', '#001'],])->setSeries($my_2g_cat)
            ->setDataset('FO', 'bar', array_values($SubTasks_teams_FO))
            ->setDataset('BO', 'bar', array_values($SubTasks_teams_BO))
            ->setDataset('OSS', 'bar', array_values($SubTasks_teams_OSS))
            ->setDataset('Customer', 'bar', array_values($SubTasks_teams_Customer))
            ->setDataset('FM', 'bar', array_values($SubTasks_teams_FM))
            ->setDataset('EHS', 'bar', array_values($SubTasks_teams_EHS))
            ->setDataset('Delivery Team', 'bar', array_values($SubTasks_teams_DeliveryTeam))

            ->setSubtitle('Team WOs')
            ->setLegendShow(true)
            ->setlegendPosition('bottom')
            ->setlegendHorizontalAlign('center')
            ->setlegendShowForZeroSeries(true)
            ->setdataLabelsEnabled(true)
            ->setSubtitleAlign('center')
            ->setSubtitleOffsetY(12)
            ->setSubtitleStyle([
                'color' => 'black',
            ])
            ->setOption([
                'yaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set y-axis label color to black
                        ],
                    ],
                ],
                'xaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set legend label color to black
                        ],
                    ],
                ],
            ])
            // ->setHorizontal(true)
        ;


        $chart_taskcount = (new Chart)
            ->setType('bar')
            ->setWidth('100%')
            ->setHeight(250)
            ->setLabels(array_keys($Tasks_Results))
            // ->setDataLabelsStyle(['fontSize' => '10px','colors' => ['#000', '#001'],])->setSeries($my_2g_cat)
            ->setDataset('Count', 'bar', array_values($Tasks_Results))
            ->setSubtitle('Dispatched')
            ->setLegendShow(true)
            ->setlegendPosition('bottom')
            ->setlegendHorizontalAlign('center')
            ->setlegendShowForZeroSeries(true)
            ->setdataLabelsEnabled(true)
            ->setSubtitleAlign('center')
            ->setSubtitleOffsetY(12)
            ->setSubtitleStyle([
                'color' => 'black',
            ])
            ->setOption([
                'yaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set y-axis label color to black
                        ],
                    ],
                ],
                'xaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set legend label color to black
                        ],
                    ],
                ],
            ])
            // ->setHorizontal(true)
        ;

        $chart_subtaskcount = (new Chart)
            ->setType('bar')
            ->setWidth('100%')
            ->setHeight(250)
            ->setLabels(array_keys($SubTasks_Results))
            // ->setDataLabelsStyle(['fontSize' => '10px','colors' => ['#000', '#001'],])->setSeries($my_2g_cat)
            ->setDataset('Count', 'bar', array_values($SubTasks_Results))
            ->setSubtitle('Assigned')
            ->setLegendShow(true)
            ->setlegendPosition('bottom')
            ->setlegendHorizontalAlign('center')
            ->setlegendShowForZeroSeries(true)
            ->setdataLabelsEnabled(true)
            ->setSubtitleAlign('center')
            ->setSubtitleOffsetY(12)
            ->setSubtitleStyle([
                'color' => 'black',
            ])
            ->setOption([
                'yaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set y-axis label color to black
                        ],
                    ],
                ],
                'xaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set legend label color to black
                        ],
                    ],
                ],
            ])
            // ->setHorizontal(true)
        ;

        $chart_logactioncount = (new Chart)
            ->setType('bar')
            ->setWidth('100%')
            ->setHeight(400)
            ->setLabels(array_keys($actionlog->toArray()))
            // ->setDataLabelsStyle(['fontSize' => '10px','colors' => ['#000', '#001'],])->setSeries($my_2g_cat)
            ->setDataset('Count', 'bar', array_values($actionlog->pluck('count')->toArray()))
            ->setSubtitle('Actions')
            ->setLegendShow(true)
            ->setlegendPosition('bottom')
            ->setlegendHorizontalAlign('center')
            ->setlegendShowForZeroSeries(true)
            ->setdataLabelsEnabled(true)
            ->setSubtitleAlign('center')
            ->setSubtitleOffsetY(12)
            ->setSubtitleStyle([
                'color' => 'black',
            ])
            ->setOption([
                'yaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set y-axis label color to black
                        ],
                    ],
                ],
                'xaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set legend label color to black
                        ],
                    ],
                ],
            ])
            ->setHorizontal(true);

        $chart_tasksprogress = (new Chart)
            ->setType('bar')
            ->setWidth('100%')
            ->setHeight(250)
            ->setLabels(array_keys($Tasks_Progress))
            // ->setDataLabelsStyle(['fontSize' => '10px','colors' => ['#000', '#001'],])->setSeries($my_2g_cat)
            ->setDataset('Count', 'bar', array_values($Tasks_Progress))
            ->setSubtitle('Running Tasks Progress')
            ->setLegendShow(true)
            ->setlegendPosition('bottom')
            ->setlegendHorizontalAlign('center')
            ->setlegendShowForZeroSeries(true)
            ->setdataLabelsEnabled(true)
            ->setSubtitleAlign('center')
            ->setSubtitleOffsetY(12)
            ->setSubtitleStyle([
                'color' => 'black',
            ])
            ->setOption([
                'yaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set y-axis label color to black
                        ],
                    ],
                ],
                'xaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set legend label color to black
                        ],
                    ],
                ],
            ])
            ->setHorizontal(true);



        $chart_subtasksprogress = (new Chart)
            ->setType('bar')
            ->setWidth('100%')
            ->setHeight(250)
            ->setLabels(array_keys($SubTasks_Progress))
            // ->setDataLabelsStyle(['fontSize' => '10px','colors' => ['#000', '#001'],])->setSeries($my_2g_cat)
            ->setDataset('Count', 'bar', array_values($SubTasks_Progress))
            ->setSubtitle('Running Assigns Progress')
            ->setLegendShow(true)
            ->setlegendPosition('bottom')
            ->setlegendHorizontalAlign('center')
            ->setlegendShowForZeroSeries(true)
            ->setdataLabelsEnabled(true)
            ->setSubtitleAlign('center')
            ->setSubtitleOffsetY(12)
            ->setSubtitleStyle([
                'color' => 'black',
            ])
            ->setOption([
                'yaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set y-axis label color to black
                        ],
                    ],
                ],
                'xaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set legend label color to black
                        ],
                    ],
                ],
            ])
            ->setHorizontal(true);

        $chart_subtaskcount_pie = (new Chart)
            ->setType('pie')
            ->setWidth('100%')
            ->setHeight(250)
            ->setLabels(array_keys($SubTasks_Results))
            ->setSubtitle('Assigned')
            ->setDataLabelsStyle(['fontSize' => '10px', 'colors' => ['#000', '#001'],])->setSeries(array_values($SubTasks_Results))
            //->setDataset('Count','pie', $my_2g_cat)
            ->setLegendShow(true)
            ->setlegendPosition('bottom')
            ->setlegendHorizontalAlign('center')
            ->setlegendShowForZeroSeries(true)
            ->setdataLabelsEnabled(true)
            ->setSubtitleAlign('center')
            ->setSubtitleOffsetY(10)
            ->setSubtitleStyle([
                'color' => 'black',
            ])
            ->setOption([
                'legend' => [
                    'labels' => [
                        'colors' => '#000000', // set legend label color to black
                    ],
                ],
                'dataLabels' => [
                    'background' => [
                        'enabled' => true,
                        'gradientToTransparent' => true,
                    ],
                ],
            ]);

        $chart_taskcount_pie = (new Chart)
            ->setType('pie')
            ->setWidth('100%')
            ->setHeight(250)
            ->setLabels(array_keys($Tasks_Results))
            ->setSubtitle('Dispatched')
            ->setDataLabelsStyle(['fontSize' => '10px', 'colors' => ['#000', '#001'],])->setSeries(array_values($Tasks_Results))
            //->setDataset('Count','pie', $my_2g_cat)
            ->setLegendShow(true)
            ->setlegendPosition('bottom')
            ->setlegendHorizontalAlign('center')
            ->setlegendShowForZeroSeries(true)
            ->setdataLabelsEnabled(true)
            ->setSubtitleAlign('center')
            ->setSubtitleOffsetY(10)
            ->setSubtitleStyle([
                'color' => 'black',
            ])
            ->setOption([
                'legend' => [
                    'labels' => [
                        'colors' => '#000000', // set legend label color to black
                    ],
                ],
                'dataLabels' => [
                    'background' => [
                        'enabled' => true,
                        'gradientToTransparent' => true,
                    ],
                ],
            ]);

        $chart_logaction_pie = (new Chart)
            ->setType('pie')
            ->setWidth('100%')
            ->setHeight(400)
            ->setLabels(array_keys($actionlog->toArray()))
            ->setSubtitle('Actions')
            ->setDataLabelsStyle(['fontSize' => '10px', 'colors' => ['#000', '#001'],])->setSeries(array_values($actionlog->pluck('count')->toArray()))
            //->setDataset('Count','pie', $my_2g_cat)
            ->setLegendShow(true)
            ->setlegendPosition('bottom')
            ->setlegendHorizontalAlign('center')
            ->setlegendShowForZeroSeries(true)
            ->setdataLabelsEnabled(true)
            ->setSubtitleAlign('center')
            ->setSubtitleOffsetY(10)
            ->setSubtitleStyle([
                'color' => 'black',
            ])
            ->setOption([
                'legend' => [
                    'labels' => [
                        'colors' => '#000000', // set legend label color to black
                    ],
                ],
                'dataLabels' => [
                    'background' => [
                        'enabled' => true,
                        'gradientToTransparent' => true,
                    ],
                ],
            ]);



        $chart_tasksfailstatus = (new Chart)
            ->setType('bar')
            ->setWidth('100%')
            ->setHeight(250)
            ->setLabels(array_keys($Tasks_Fails_Status))
            // ->setDataLabelsStyle(['fontSize' => '10px','colors' => ['#000', '#001'],])->setSeries($my_2g_cat)
            ->setDataset('Count', 'bar', array_values($Tasks_Fails_Status))
            ->setSubtitle('Running Tasks Status')
            ->setLegendShow(true)
            ->setlegendPosition('bottom')
            ->setlegendHorizontalAlign('center')
            ->setlegendShowForZeroSeries(true)
            ->setdataLabelsEnabled(true)
            ->setSubtitleAlign('center')
            ->setSubtitleOffsetY(12)
            ->setSubtitleStyle([
                'color' => 'black',
            ])
            ->setOption([
                'yaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set y-axis label color to black
                        ],
                    ],
                ],
                'xaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set legend label color to black
                        ],
                    ],
                ],
            ])
            ->setHorizontal(true);

        $chart_subtasksfailstatus = (new Chart)
            ->setType('bar')
            ->setWidth('100%')
            ->setHeight(250)
            ->setLabels(array_keys($SubTasks_Fails_Status))
            // ->setDataLabelsStyle(['fontSize' => '10px','colors' => ['#000', '#001'],])->setSeries($my_2g_cat)
            ->setDataset('Count', 'bar', array_values($SubTasks_Fails_Status))
            ->setSubtitle('Running Assigns Status')
            ->setLegendShow(true)
            ->setlegendPosition('bottom')
            ->setlegendHorizontalAlign('center')
            ->setlegendShowForZeroSeries(true)
            ->setdataLabelsEnabled(true)
            ->setSubtitleAlign('center')
            ->setSubtitleOffsetY(12)
            ->setSubtitleStyle([
                'color' => 'black',
            ])
            ->setOption([
                'yaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set y-axis label color to black
                        ],
                    ],
                ],
                'xaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set legend label color to black
                        ],
                    ],
                ],
            ])
            ->setHorizontal(true);

        $chart_tasksfailstatus_completed = (new Chart)
            ->setType('bar')
            ->setWidth('100%')
            ->setHeight(250)
            ->setLabels(array_keys($Completed_Tasks_Fails_Status))
            // ->setDataLabelsStyle(['fontSize' => '10px','colors' => ['#000', '#001'],])->setSeries($my_2g_cat)
            ->setDataset('Count', 'bar', array_values($Completed_Tasks_Fails_Status))
            ->setSubtitle('Completed Tasks Status')
            ->setLegendShow(true)
            ->setlegendPosition('bottom')
            ->setlegendHorizontalAlign('center')
            ->setlegendShowForZeroSeries(true)
            ->setdataLabelsEnabled(true)
            ->setSubtitleAlign('center')
            ->setSubtitleOffsetY(12)
            ->setSubtitleStyle([
                'color' => 'black',
            ])
            ->setOption([
                'yaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set y-axis label color to black
                        ],
                    ],
                ],
                'xaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set legend label color to black
                        ],
                    ],
                ],
            ])
            ->setHorizontal(true);

        $chart_subtasksfailstatus_completed = (new Chart)
            ->setType('bar')
            ->setWidth('100%')
            ->setHeight(250)
            ->setLabels(array_keys($Completed_SubTasks_Fails_Status))
            // ->setDataLabelsStyle(['fontSize' => '10px','colors' => ['#000', '#001'],])->setSeries($my_2g_cat)
            ->setDataset('Count', 'bar', array_values($Completed_SubTasks_Fails_Status))
            ->setSubtitle('Completed Assigns Status')
            ->setLegendShow(true)
            ->setlegendPosition('bottom')
            ->setlegendHorizontalAlign('center')
            ->setlegendShowForZeroSeries(true)
            ->setdataLabelsEnabled(true)
            ->setSubtitleAlign('center')
            ->setSubtitleOffsetY(12)
            ->setSubtitleStyle([
                'color' => 'black',
            ])
            ->setOption([
                'yaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set y-axis label color to black
                        ],
                    ],
                ],
                'xaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#000000', // set legend label color to black
                        ],
                    ],
                ],
            ])
            ->setHorizontal(true);

        return view('livewire.tasks-overview-total', [
            'chart_taskcount' => $chart_taskcount,
            'chart_subtaskcount' => $chart_subtaskcount,
            'chart_logactioncount' => $chart_logactioncount,
            'chart_taskcount_pie' => $chart_taskcount_pie,
            'chart_subtaskcount_pie' => $chart_subtaskcount_pie,
            'chart_logaction_pie' => $chart_logaction_pie,
            'chart_tasksprogress' => $chart_tasksprogress,
            'chart_subtasksprogress' => $chart_subtasksprogress,

            'chart_tasksfailstatus' => $chart_tasksfailstatus,
            'chart_subtasksfailstatus' => $chart_subtasksfailstatus,

            'chart_tasksfailstatus_completed' => $chart_tasksfailstatus_completed,
            'chart_subtasksfailstatus_completed' => $chart_subtasksfailstatus_completed,

            'chart_taskcount_priority' => $chart_taskcount_priority,
            'chart_taskcount_raisedby' => $chart_taskcount_raisedby,


            'chart_taskcount_teams' => $chart_taskcount_teams,
            'chart_taskcount_impact' => $chart_taskcount_impact,

            'chart_feedback_count' => $chart_feedback_count,
            'chart_feedback_dates' => $chart_feedback_dates,

            'last_30' => $last_30,
        ]);
    }
}
