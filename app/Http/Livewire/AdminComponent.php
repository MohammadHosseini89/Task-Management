<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\DoneJob;
use Livewire\Component;
use App\Models\LoginHistory;
use App\Models\FailedJobData;
use App\Models\ExportLogModel;
use Illuminate\Support\Facades\DB;
use App\Models\UserUnauthorizedHistory;

class AdminComponent extends Component
{
    public function render()
    {
        $querydonejob = DoneJob::select('jobname', DB::raw('MAX(created_at) as latest_created_at'))
            ->groupBy('jobname')
            ->get();

        $twoDaysAgo = Carbon::now()->subDays(2)->toDateTimeString();
        $oneDayAgo = Carbon::now()->subDays(1)->toDateTimeString();

        $queryfailedjob = FailedJobData::select('connection', 'exception', DB::raw('MAX(created_at) as latest_created_at'))
            ->where('created_at', '>=', $twoDaysAgo)
            ->groupBy('connection', 'exception')
            ->get();

        $loginhistoriy_active = LoginHistory::whereNull('logout_time')->where('created_at', '>=', $oneDayAgo)->get();
        $loginhistoriy_total = LoginHistory::where('created_at', '>=', $oneDayAgo)->get();
        $loginhistoriy_total_unique_user = LoginHistory::select('user_id')->distinct();
        $ua_route_request = UserUnauthorizedHistory::where('created_at', '>=', $twoDaysAgo)->get();
        $resultsadmincheck = [
            'active_sessions' => $loginhistoriy_active->count('session_id'),
            'lastonedaylogins' => $loginhistoriy_total->count('login_time'),
            'lastonedaylogouts' => $loginhistoriy_total->count('logout_time'),
            'loginhistoriytotal_unique_user' => $loginhistoriy_total_unique_user->count('user_id'),
            'ua_route_request_last_2_days' => $ua_route_request->count(),
        ];

        $export_data = ExportLogModel::where('created_at', '>=', $twoDaysAgo)
            ->selectRaw('email, file_name_export')
            ->get();
        $group_export_data = $export_data->groupBy('email')->map(function ($item) {
            return [
                'email' => $item[0]->email,
                'Download_Number' => $item->count(),
            ];
        });

        $top_20_export_data = $group_export_data->sortByDesc('Download_Number')->take(20);

        return view('livewire.admin-component', [
            'querydonejob' =>  $querydonejob,
            'queryfailedjob' => $queryfailedjob,
            'resultsadmincheck' => $resultsadmincheck,
            'ua_route_request' => $ua_route_request,

            'top_20_export_data' => $top_20_export_data,

        ]);
    }
}
