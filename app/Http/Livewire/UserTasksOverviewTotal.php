<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Http\Request;
use Akaunting\Apexcharts\Chart;
use Illuminate\Support\Facades\DB;

class UserTasksOverviewTotal extends Component
{
    public $checked_userid;
    public $checked_email;

    // Mount
    public function mount(Request $request)
    {

        $this->checked_userid = auth()->user()->id;
        $this->checked_email = auth()->user()->email;
    }

    public function render()
    {

        $Tasks_Data = DB::table('task_management_models')
            ->where('user_id', $this->checked_userid)
            ->select('task_management_models.*')
            ->get();


        $SubTasks_Data = DB::table('sub_tasks')
            ->where('owner', '=', $this->checked_email)
            ->select('sub_tasks.*')
            ->get();


        $Actionlog_Data = DB::table('log_actions_task_management_models')
            ->where('user_id', $this->checked_userid)
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
            'Have More than 30 Days Time' => $Tasks_Data->where('is_cancel', 0)->where('is_complete', 0)->where('due_date', '>', Carbon::now()->addDays(30))->count() - $Tasks_Failed_21_to_30day ,
        ];

        $SubTasks_Fails_Status = [
            'Failed' => $SubTasks_Failed_Already = $SubTasks_Data->where('is_cancel', 0)->where('is_complete', 0)->where('due_date', '<', Carbon::now())->count(),
            '1 Day To Fail' => $SubTasks_Failed_1_day = $SubTasks_Data->where('is_cancel', 0)->where('is_complete', 0)->where('due_date', '<', Carbon::tomorrow())->count() - $SubTasks_Failed_Already,
            '1-7 Days to Fail' => $SubTasks_Failed_1_to_7day = $SubTasks_Data->where('is_cancel', 0)->where('is_complete', 0)->where('due_date', '<', Carbon::now()->addDays(7))->count() - $SubTasks_Failed_1_day,
            '7-14 Days to Fail' => $SubTasks_Failed_7_to_14day = $SubTasks_Data->where('is_cancel', 0)->where('is_complete', 0)->where('due_date', '<', Carbon::now()->addDays(14))->count() - $SubTasks_Failed_1_to_7day,
            '14-21 Days to Fail' => $SubTasks_Failed_14_to_21day = $SubTasks_Data->where('is_cancel', 0)->where('is_complete', 0)->where('due_date', '<', Carbon::now()->addDays(21))->count() - $SubTasks_Failed_7_to_14day,
            '21-30 Days to Fail' => $SubTasks_Failed_21_to_30day = $SubTasks_Data->where('is_cancel', 0)->where('is_complete', 0)->where('due_date', '<', Carbon::now()->addDays(30))->count() - $SubTasks_Failed_14_to_21day,
            'Have More than 30 Days Time' => $SubTasks_Data->where('is_cancel', 0)->where('is_complete', 0)->where('due_date', '>', Carbon::now()->addDays(30))->count() - $SubTasks_Failed_21_to_30day ,
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


        // $diff = $Tasks_Data->where('due_date', '<', Carbon::now())->count();


        $chart_taskcount = (new Chart)
            ->setType('bar')
            ->setWidth('100%')
            ->setHeight(250)
            ->setLabels(array_keys($Tasks_Results))
            // ->setDataLabelsStyle(['fontSize' => '10px','colors' => ['#000', '#001'],])->setSeries($my_2g_cat)
            ->setDataset('Count', 'bar', array_values($Tasks_Results))
            ->setSubtitle('Dispatched by Me')
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
            ->setSubtitle('Assigned To Me')
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
            ->setSubtitle('Assigned To Me')
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
            ->setSubtitle('Dispatched By Me')
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

        return view('livewire.user-tasks-overview-total', [
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


        ]);
    }
}
