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
            {!! $chart_logaction_pie->container() !!}
            {!! $chart_logaction_pie->script() !!}
        </div>

        <div class="col-md-6"
            style="border-bottom: 1px solid rgb(21, 30, 208);
        border-right: 1px solid rgb(21, 30, 208);
        border-top: 1px solid rgb(21, 30, 208);
        border-left: 1px solid rgb(21, 30, 208);">
            {!! $chart_logactioncount->container() !!}
            {!! $chart_logactioncount->script() !!}
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



</div>
