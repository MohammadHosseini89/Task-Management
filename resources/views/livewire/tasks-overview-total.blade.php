<div wire:poll.240000ms>
    <style>
        .bg-custom {
            background:
                rgba(255, 255, 255, 0.92);
        }

        .nav-link {
            font-size: 12px;
            font-weight: bold;

        }
    </style>

    <div class="row col-md-12 ml-1 mr-3">

        <div class="col-md-3 mt-1"
            style="border-bottom: 1px solid rgb(21, 30, 208);
        border-right: 1px solid rgb(21, 30, 208);
        border-top: 1px solid rgb(21, 30, 208);
        border-left: 1px solid rgb(21, 30, 208);">
            {!! $chart_taskcount->container() !!}
            {!! $chart_taskcount->script() !!}
        </div>
        <div class="col-md-3 mt-1"
            style="border-bottom: 1px solid rgb(21, 30, 208);
        border-right: 1px solid rgb(21, 30, 208);
        border-top: 1px solid rgb(21, 30, 208);
        border-left: 1px solid rgb(21, 30, 208);">
            {!! $chart_taskcount_pie->container() !!}
            {!! $chart_taskcount_pie->script() !!}
        </div>
        <div class="col-md-3 mt-1"
            style="border-bottom: 1px solid rgb(21, 30, 208);
        border-right: 1px solid rgb(21, 30, 208);
        border-top: 1px solid rgb(21, 30, 208);
        border-left: 1px solid rgb(21, 30, 208);">
            {!! $chart_tasksprogress->container() !!}
            {!! $chart_tasksprogress->script() !!}
        </div>

        <div class="col-md-3 mt-1"
            style="border-bottom: 1px solid rgb(21, 30, 208);
        border-right: 1px solid rgb(21, 30, 208);
        border-top: 1px solid rgb(21, 30, 208);
        border-left: 1px solid rgb(21, 30, 208);">
            {!! $chart_tasksfailstatus->container() !!}
            {!! $chart_tasksfailstatus->script() !!}
        </div>

    </div>



    <div class="row col-md-12 ml-1 mr-3">

        <div class="col-md-3"
            style="border-bottom: 1px solid rgb(21, 30, 208);
        border-right: 1px solid rgb(21, 30, 208);
        border-top: 1px solid rgb(21, 30, 208);
        border-left: 1px solid rgb(21, 30, 208);">

            {!! $chart_subtaskcount->container() !!}
            {!! $chart_subtaskcount->script() !!}
        </div>
        <div class="col-md-3"
            style="border-bottom: 1px solid rgb(21, 30, 208);
        border-right: 1px solid rgb(21, 30, 208);
        border-top: 1px solid rgb(21, 30, 208);
        border-left: 1px solid rgb(21, 30, 208);">
            {!! $chart_subtaskcount_pie->container() !!}
            {!! $chart_subtaskcount_pie->script() !!}
        </div>
        <div class="col-md-3"
            style="border-bottom: 1px solid rgb(21, 30, 208);
        border-right: 1px solid rgb(21, 30, 208);
        border-top: 1px solid rgb(21, 30, 208);
        border-left: 1px solid rgb(21, 30, 208);">
            {!! $chart_subtasksprogress->container() !!}
            {!! $chart_subtasksprogress->script() !!}
        </div>

        <div class="col-md-3"
            style="border-bottom: 1px solid rgb(21, 30, 208);
        border-right: 1px solid rgb(21, 30, 208);
        border-top: 1px solid rgb(21, 30, 208);
        border-left: 1px solid rgb(21, 30, 208);">
            {!! $chart_subtasksfailstatus->container() !!}
            {!! $chart_subtasksfailstatus->script() !!}
        </div>

    </div>

    <div class="row col-md-12 ml-1 mr-3">
        <div class="col-md-6"
            style="border-bottom: 1px solid rgb(21, 30, 208);
        border-right: 1px solid rgb(21, 30, 208);
        border-top: 1px solid rgb(21, 30, 208);
        border-left: 1px solid rgb(21, 30, 208);">
            {!! $chart_taskcount_priority->container() !!}
            {!! $chart_taskcount_priority->script() !!}
        </div>

        <div class="col-md-6"
            style="border-bottom: 1px solid rgb(21, 30, 208);
        border-right: 1px solid rgb(21, 30, 208);
        border-top: 1px solid rgb(21, 30, 208);
        border-left: 1px solid rgb(21, 30, 208);">
            {!! $chart_taskcount_raisedby->container() !!}
            {!! $chart_taskcount_raisedby->script() !!}
        </div>


    </div>

    <div class="row col-md-12 ml-1 mr-3">
        {{-- <div class="col-md-6"
            style="border-bottom: 1px solid rgb(21, 30, 208);
        border-right: 1px solid rgb(21, 30, 208);
        border-top: 1px solid rgb(21, 30, 208);
        border-left: 1px solid rgb(21, 30, 208);">
            {!! $chart_taskcount_teams->container() !!}
            {!! $chart_taskcount_teams->script() !!}
        </div> --}}

        <div class="col-md-12"
            style="border-bottom: 1px solid rgb(21, 30, 208);
        border-right: 1px solid rgb(21, 30, 208);
        border-top: 1px solid rgb(21, 30, 208);
        border-left: 1px solid rgb(21, 30, 208);">
            {!! $chart_taskcount_impact->container() !!}
            {!! $chart_taskcount_impact->script() !!}
        </div>


    </div>

    <div class="row col-md-12 ml-1 mr-3">
        <div class="col-md-6"
            style="border-bottom: 1px solid rgb(21, 30, 208);
        border-right: 1px solid rgb(21, 30, 208);
        border-top: 1px solid rgb(21, 30, 208);
        border-left: 1px solid rgb(21, 30, 208);">
            {!! $chart_feedback_count->container() !!}
            {!! $chart_feedback_count->script() !!}
        </div>

        <div class="col-md-6"
            style="border-bottom: 1px solid rgb(21, 30, 208);
        border-right: 1px solid rgb(21, 30, 208);
        border-top: 1px solid rgb(21, 30, 208);
        border-left: 1px solid rgb(21, 30, 208);">
            {!! $chart_feedback_dates->container() !!}
            {!! $chart_feedback_dates->script() !!}

        </div>

    </div>

    <div class="row col-md-12 ml-1 mr-3">
        <div class="col-md-6 mb-1"
            style="border-bottom: 1px solid rgb(21, 30, 208);
        border-right: 1px solid rgb(21, 30, 208);
        border-top: 1px solid rgb(21, 30, 208);
        border-left: 1px solid rgb(21, 30, 208);">
            {!! $chart_tasksfailstatus_completed->container() !!}
            {!! $chart_tasksfailstatus_completed->script() !!}
        </div>

        <div class="col-md-6 mb-1"
            style="border-bottom: 1px solid rgb(21, 30, 208);
        border-right: 1px solid rgb(21, 30, 208);
        border-top: 1px solid rgb(21, 30, 208);
        border-left: 1px solid rgb(21, 30, 208);">
            {!! $chart_subtasksfailstatus_completed->container() !!}
            {!! $chart_subtasksfailstatus_completed->script() !!}
        </div>
    </div>

    <div class="row col-md-12 ml-1 mr-3">

        <div class="col-md-12"
            style="border-bottom: 1px solid rgb(21, 30, 208);
    border-right: 1px solid rgb(21, 30, 208);
    border-top: 1px solid rgb(21, 30, 208);
    border-left: 1px solid rgb(21, 30, 208);">

            <div style="text-align: center" class="bg-info rounded mt-1"> Last 1000 Feedback Details</div>
            <table class="table table-hover col-md-12 table-bordered table-mytask">

                <thead>
                    <tr style="text-align: center">
                        <th style="vertical-align: middle;">Owner</th>
                        <th style="vertical-align: middle;">Task ID</th>
                        <th style="vertical-align: middle;">Time</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($last_30 as $data)
                        <tr style="text-align: center">

                            <td> {{ $data->owner }} </td>
                            <td> {{ $data->uuid_sub_task }} </td>
                            <td> {{ $data->created_at }} </td>


                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>






</div>
