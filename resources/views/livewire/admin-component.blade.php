

<div wire:poll.30000ms>

    <style>
        .bg-custom {
            position: relative;
            /* make sure the container is positioned */
        }

        .bg-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('images/admin2.jpg') }}');
            background-size: cover;
            background-position: center;
            opacity: 0.85;
            z-index: 0;
        }

        th,
        td {
            /* Set the width of each column as a percentage of the table's overall width */
            width: 25%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-weight: bold;
            color: azure;
            font-family: "Arial", sans-serif;
        }

        .table-bordered {
            border: 1px solid burlywood;
        }

        .nav-link {
            font-size: 12px;
            font-weight: bold;

        }
    </style>

    @php
        $sort = ['FetchDataDashboard', 'FetchDataNLM', 'FetchDataMorning', 'FetchDataOSS_Sites', 'AnalyseDataOss', 'OptimizeTables'];
        $sortedJobs = $querydonejob->sortBy(function ($job) use ($sort) {
            return array_search($job->jobname, $sort);
        });
    @endphp

    <div class="row justify-content col-md-12">

        <div class="col-md-4 col-12 mt-2" style="height: 20%">
            <div class="container">
                <table class="table table-bordered table-hover text-nowrap p-0"
                    style=" height: 100%; width: 100%; text-align: center; font-size:12px; ">
                    <thead>
                        <tr style="background-color:rgba(65, 3, 3,0.3)">

                            <th>Tag</th>
                            <th>Count</th>

                        </tr>
                    </thead>
                    <tbody>

                        <tr style="font-weight: bold; ">
                            <td>Active Sessions</td>
                            <td>{{ $resultsadmincheck['active_sessions'] }}</td>
                        </tr>

                        <tr style="font-weight: bold; ">
                            <td>Last 24 Hours Logins</td>
                            <td>{{ $resultsadmincheck['lastonedaylogins'] }}</td>
                        </tr>

                        <tr style="font-weight: bold; ">
                            <td>Last 24 Hours Logouts</td>
                            <td>{{ $resultsadmincheck['lastonedaylogouts'] }}</td>
                        </tr>

                        <tr style="font-weight: bold; ">
                            <td>Last 24 Hours Unique Logins</td>
                            <td>{{ $resultsadmincheck['loginhistoriytotal_unique_user'] }}</td>
                        </tr>

                        <tr
                            @if ($resultsadmincheck['ua_route_request_last_2_days'] > 0) style="font-weight: bold; background-color:rgba(255, 0, 0, 0.3)" @else style="font-weight: bold;" @endif>
                            <td>UA Routes Attemp</td>
                            <td>{{ $resultsadmincheck['ua_route_request_last_2_days'] }}</td>
                        </tr>

                    </tbody>
                </table>

            </div>
        </div>
        <div class="col-md-4 col-12 mt-2" style="height: 20%">
            <div class="container">
                <table class="table table-bordered table-hover text-nowrap p-0"
                    style=" height: 100%; width: 100%; text-align: center; font-size:12px;">
                    <thead>
                        <tr style="background-color:rgba(65, 3, 3,0.3)">

                            <th>Since</th>
                            <th>Jobs Done</th>
                            <th>Latest Time</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sortedJobs as $mydata)
                            @php
                                $background = '';
                                if (in_array($mydata->jobname, ['FetchDataNLM', 'FetchDataDashboard', 'MakeTDS_Summary', 'UniqueTTsForTDSHistory'])) {
                                    $background =
                                        Carbon\Carbon::parse($mydata->latest_created_at)
                                            ->diff(now())
                                            ->format('%H:%I:%S') > '00:10:00'
                                            ? 'background-color:rgba(255, 0, 0, 0.3)'
                                            : 'background-color:rgba(21.5, 255, 0, 0.20)';
                                } elseif (in_array($mydata->jobname, ['FetchDataMorning', 'FetchDataOSS_Sites', 'AnalyseDataOss', 'ExportDataOSSDetails'])) {
                                    $background =
                                        Carbon\Carbon::parse($mydata->latest_created_at)
                                            ->diff(now())
                                            ->format('%H:%I:%S') > '24:30:00'
                                            ? 'background-color:rgba(255, 0, 0, 0.3)'
                                            : 'background-color:rgba(21.5, 255, 0, 0.20)';
                                } elseif ($mydata->jobname == 'OptimizeTables') {
                                    $diffInHours = Carbon\Carbon::parse($mydata->latest_created_at)->diffInHours(now());
                                    $background = $diffInHours > 168 ? 'background-color:rgba(255, 0, 0, 0.3)' : 'background-color:rgba(21.5, 255, 0, 0.20)';
                                } else {
                                    $diffInHours = Carbon\Carbon::parse($mydata->latest_created_at)->diffInHours(now());
                                    $background = $diffInHours > 1 ? 'background-color:rgba(255, 0, 0, 0.3)' : 'background-color:rgba(21.5, 255, 0, 0.20)';
                                }
                            @endphp
                            <tr style="{{ $background }}; font-weight: bold;">
                                <td>{{ Carbon\Carbon::parse($mydata->latest_created_at)->diff(now())->format('%H:%I:%S') }}
                                </td>
                                <td>{{ $mydata->jobname }}</td>
                                <td>{{ $mydata->latest_created_at }}</td>


                            </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>
        <div class="col-md-4 col-12 mt-2" style="height: 20%">
            <div class="container">
                <table class="table table-bordered table-hover text-nowrap p-0"
                    style=" height: 100%; width: 100%; text-align: center; font-size:12px;">
                    <thead>
                        <tr style="background-color:rgba(65, 3, 3,0.3)">

                            <th>Top 20 Recent 48 Hour</th>
                            <th>Download CSV</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($top_20_export_data as $item)
                            <tr style="font-weight: bold; ">
                                <td>{{ $item['email'] }}</td>
                                <td>{{ $item['Download_Number'] }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div class="row justify-content ml-1">



        <div class="col-md-6 col-12 mt-2" style="height: 20%">

            <table class="table table-bordered table-responsive table-hover -xl text-nowrap p-1"
                style=" height: 100%; width: 100%; text-align: center; font-size:12px; position: relative;">
                <thead>
                    <tr style="background-color:rgba(65, 3, 3,0.3)">
                        <th>Failed Job Name</th>
                        <th>Since </th>

                        {{-- <th>Exception</th> --}}
                        <th>Latest Time</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($queryfailedjob as $mydata)
                        <tr style="font-weight: bold;">
                            <td>{{ $mydata->connection }}</td>
                            <td>{{ Carbon\Carbon::parse($mydata->latest_created_at)->diff(now())->format('%H:%I:%S') }}
                            </td>

                            {{-- <td>{{ $mydata->exception }}</td> --}}
                            <td>{{ $mydata->latest_created_at }}</td>

                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div>

        <div class="col-md-6 col-12 mt-2" style="height: 20%">
            <div class="container">
                <table class="table table-bordered table-hover table-responsive -xl text-nowrap p-1"
                    style=" height: 100%; width: 100%; text-align: center; font-size:12px; position: relative;">
                    <thead>
                        <tr style="background-color:rgba(65, 3, 3,0.3)">

                            <th>User Name</th>
                            <th>Email</th>
                            <th>IP Address</th>
                            <th>UA Route</th>
                            <th>Time</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ua_route_request as $ua_route)
                            <tr style="font-weight: bold; ">
                                <td>{{ $ua_route->user_name }}</td>
                                <td>{{ $ua_route->email }}</td>
                                <td>{{ $ua_route->ip_address }}</td>
                                <td>{{ $ua_route->route_name }}</td>
                                <td>{{ $ua_route->created_at }}</td>


                            </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
