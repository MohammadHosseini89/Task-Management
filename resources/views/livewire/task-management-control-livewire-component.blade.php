<div wire:poll.10000ms>
    <style>
        .bg-custom {
            background:
                rgba(255, 255, 255, 0.92);
        }


        .modal-body {
            background: linear-gradient(to bottom,
                    rgba(255, 255, 255, 0.92),
                    rgba(250, 250, 250, 0.99));
        }

        .form-group {
            color: black;
            font-size: 10px;
        }

        .card {
            background: rgba(255, 255, 255, 0.92);
        }

        .table-modal-search-owner {
            border: 1px solid burlywood;


        }

        .nav-link {
            font-size: 12px;
            font-weight: bold;

        }

        .table-modal-search-owner td,
        .table-modal-search-owner th {
            padding: 1;
            margin: 0;
            text-align: center;
            line-height: 1.5;
            font-size: 12px;
            color: rgb(5, 2, 56);
            font-family: "Arial", sans-serif;

        }

        .table-dispatch {
            border: 1px solid burlywood;
            vertical-align: middle;

        }

        .table-dispatch td,
        .table-dispatch th {
            text-align: center;
            color: rgb(0, 0, 0);
            font-family: "Arial", sans-serif;
            font-size: smaller;
            vertical-align: middle;


        }

        .table-modal-dispatch {
            vertical-align: middle;
            text-align: center;
        }

        .table-modal-dispatch td,
        .table-modal-dispatch th {
            padding: 0;
            margin: 0;
            text-align: center;
            line-height: 1.5;
            font-size: 12px;
            font-weight: bolder;
            color: rgb(234, 216, 216);
            vertical-align: middle;


        }


        .form-control {
            font-size: 12px;

        }

        .my-table-log td,
        .my-table-log th {
            padding: 0;
            margin: 0;
            text-align: center;
            line-height: 1.5;
            font-family: "Arial", sans-serif;
            font-size: smaller;

        }

        .my-table-assign-control td,
        .my-table-assign-control th {
            padding: 0;
            margin: 0;
            text-align: center;
            line-height: 1.5;
            font-family: "Arial", sans-serif;
            vertical-align: middle;
        }

        .table-modal-search-owner {
            border: 1px solid burlywood;


        }
    </style>


    <div class="row">

        <div class="card col-md-12">

            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link" href="{{ route('tasks') }}" id="createTasksTab">Create New
                            Task</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('dispatchedbyme') }}">Dispatched
                            by Me</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('mytasks') }}">My Tasks</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('support') }}">I'm Support</a></li>

                    <li class="nav-item"><a class="nav-link active" href="{{ route('controltask') }}">Task Control</a>
                    </li>


                    <li class="nav-item"><a class="nav-link" href="{{ route('cancelled') }}">Cancelled
                            Tasks</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('completed') }}">Completed
                            Tasks</a></li>
                </ul>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('message'))
                <div class="alert alert-success text-center">{{ session('message') }}</div>
            @endif

            <div class="row ml-2 mr-2 justify-content-left"
                style="text-align: center;  border-bottom: 1px solid rgb(97, 96, 96);
                                        border-right: 1px solid rgb(97, 96, 96);
                                        border-top: 1px solid rgb(97, 96, 96);
                                        border-left: 1px solid rgb(97, 96, 96);">


                <div class="col-md-1 mt-1">
                    <div class="form-group">
                        <label class="form-control" style="background-color: rgb(218, 209, 209)">
                            <i style="color:rgb(19, 177, 209)" class="fa fa-search mr-2"></i>Search</label>

                    </div>
                </div>

                <div class="col-md-1 mt-1">
                    <div class="form-group">
                        {{-- <label style="color:rgb(8, 59, 59)" for="issue_livesearch">Issue</label> --}}
                        <input type="search" class="form-control" placeholder="Issue" id="issue_livesearch"
                            name="issue_livesearch" wire:model="issue_livesearch">
                    </div>
                </div>

                <div class="col-md-1 mt-1">
                    <div class="form-group">
                        {{-- <label style="color:rgb(8, 59, 59)" for="uuid_livesearch">Task ID</label> --}}
                        <input type="search" class="form-control" placeholder="Task ID" id="uuid_livesearch"
                            name="uuid_livesearch" wire:model="uuid_livesearch">
                    </div>
                </div>

                <div class="col-md-1 mt-1">
                    <div class="form-group">
                        {{-- <label style="color:rgb(8, 59, 59)" for="description_livesearch">Description</label> --}}
                        <input type="search" class="form-control" placeholder="Description" id="description_livesearch"
                            name="description_livesearch" wire:model="description_livesearch">
                    </div>
                </div>



                <div class="col-md-1 mt-1">
                    <div class="form-group">
                        {{-- <label style="color:rgb(8, 59, 59)" for="raisedbyuser_livesearch">Raised By</label> --}}
                        <input type="search" class="form-control" placeholder="Raised By" id="raisedbyuser_livesearch"
                            name="raisedbyuser_livesearch" wire:model="raisedbyuser_livesearch">
                    </div>
                </div>

                <div class="col-md-1 mt-1">
                    <div class="form-group">
                        {{-- <label style="color:rgb(8, 59, 59)" for="priority_livesearch">Priority</label> --}}
                        <input type="search" class="form-control" placeholder="Priority" id="priority_livesearch"
                            name="priority_livesearch" wire:model="priority_livesearch">
                    </div>
                </div>

                <div class="col-md-1 mt-1">
                    <div class="form-group">
                        {{-- <label style="color:rgb(8, 59, 59)" for="owner_livesearch">Owner</label> --}}
                        <input type="search" class="form-control" placeholder="Owner" id="owner_livesearch"
                            name="owner_livesearch" wire:model="owner_livesearch">
                    </div>
                </div>

            </div>

            <div class="card-body">
                <div class="tab-content">


                    {{-- Dispatchedbyme --}}
                    <div class="tab-pane active" id="Dispatchedbyme">

                        @if (count($viewDetailsDispatchedByMe) == 0)
                            <table class="table table-bordered table-dispatch">
                            @else
                                <table class="table table-hover col-md-12 table-bordered table-dispatch">
                        @endif
                        <thead>
                            <tr>
                                <th style="vertical-align: middle;" colspan="1">Task Action</th>

                                <th style="vertical-align: middle;" colspan="1">Task ID</th>
                                <th style="vertical-align: middle;" colspan="1">Issue</th>
                                <th style="vertical-align: middle;" colspan="1">Raised By</th>

                                {{-- <th style="vertical-align: middle;" colspan="2">Cancel Assigns</th> --}}
                                <th style="vertical-align: middle;" colspan="5">Control on Assigns</th>
                                {{-- <th style="vertical-align: middle;" colspan="2">Assigns</th>

                                <th style="vertical-align: middle;" colspan="1">Progress</th>
                                <th style="vertical-align: middle;" colspan="1">Details</th> --}}


                                <th style="vertical-align: middle;" colspan="1">Progress Total</th>
                                <th style="vertical-align: middle;" colspan="2">Created At</th>
                                <th style="vertical-align: middle;" colspan="2">Latest Update</th>
                                <th style="vertical-align: middle;" colspan="1">Time To Fail</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($viewDetailsDispatchedByMe as $datadispatch)
                                <tr>
                                    <td colspan="1">
                                        @if ($datadispatch->is_cancel === 1)
                                            <button class="btn btn-block btn-warning btn-xs"
                                                style="cursor: default;">Cancelled</button>
                                        @elseif($datadispatch->is_complete === 1)
                                            <button class="btn btn-block btn-secondary btn-xs"
                                                style="cursor: default;">Completed</button>
                                        @else
                                            <button class="btn btn-block btn-danger btn-xs"
                                                wire:click="cancelConfirm('{{ $datadispatch->id }}')">Cancel</button>
                                            <button class="btn btn-block btn-primary btn-xs"
                                                wire:click="editTaskManagementDataDispatch({{ $datadispatch->id }})">Edit</button>

                                            <button class="btn btn-block btn-xs"
                                                style="background-color: rgba(185, 12, 176, 0.7); color:azure"
                                                wire:click="editAssignDataDispatch({{ $datadispatch->id }})">Assign</button>
                                            <button class="btn btn-block btn-xs"
                                                style="background-color: rgb(33, 1, 1); color:azure"
                                                wire:click="CompleteDataDispatch({{ $datadispatch->id }})">Complete</button>
                                        @endif
                                    </td>



                                    <td colspan="1"
                                        wire:click="viewDetailsDispatchedByMe('{{ $datadispatch->id }}')"
                                        style="text-decoration: underline;cursor: pointer; color: rgb(39, 3, 199);">
                                        {{ $datadispatch->uuid }} </td>

                                    <td colspan="1" style=" color: black;">
                                        {{ $datadispatch->issue }} </td>

                                    <td colspan="1" style=" color: black;">
                                        {{ $datadispatch->raisedbyuser }} </td>

                                    @php
                                        $myassignedtasks = \App\Models\subTask::where(
                                            'task_management_model_id',
                                            $datadispatch->id,
                                        )->get();
                                    @endphp

                                    <td colspan="5">
                                        @foreach ($myassignedtasks as $subtasks)
                                            <span wire:click='viewDetailsMytasks({{ $subtasks->id }})'
                                                style="text-decoration: underline;cursor: pointer; color: rgb(39, 3, 199);">
                                                {{ App\Models\User::where('email', '=', $subtasks->owner)->first()->name }}
                                            </span>
                                            <br>

                                            @if ($subtasks->is_cancel === 1)
                                                <button class="btn btn-block btn-xs mt-1 mb-1"
                                                    style="cursor: default;background-color: rgb(25, 24, 23); color:azure">Cancelled</button>
                                            @elseif($subtasks->is_complete === 1)
                                                <button class="btn btn-block btn-secondary btn-xs mt-1 mb-1"
                                                    style="cursor: default;">Completed</button>
                                            @else
                                                <button class="btn btn-xs"
                                                    style="background-color: rgb(58, 23, 3); color:azure"
                                                    wire:click="cancelSubTask('{{ $subtasks->id }}')">Cancel</button>

                                                <button class="btn btn-xs mt-1 mb-1"
                                                    style="background-color: rgb(43, 5, 100); color:azure"
                                                    wire:click="CompleteSubTask({{ $subtasks->id }})">Complete</button>
                                            @endif

                                            @if ($subtasks->label_for_system2 === 'Rejected')
                                                <button class="btn btn-xs mt-1 mb-1"
                                                    wire:click="rejectedAssignBack('{{ $subtasks->id }}')"
                                                    style="background-color: rgba(59, 2, 14, 0.7); color:azure">Rejected
                                                    Assign Back
                                                </button>
                                            @endif
                                            <br>

                                            <div class="mt-1"
                                                style="border-bottom: 1px solid rgb(22, 4, 92);
                                            border-right: 1px solid rgb(22, 4, 92);
                                            border-top: 1px solid rgb(22, 4, 92);
                                            border-left: 1px solid rgb(22, 4, 92);">
                                                Progress:{{ $subtasks->progress }}%

                                                @php
                                                    $countfeedback = \App\Models\LogActionsTaskManagementModel::where(
                                                        'uuid_sub_task',
                                                        $subtasks->uuid_sub_task,
                                                    )
                                                        ->where('action', 'Owner Feedback')
                                                        ->count();
                                                    $countreject = \App\Models\LogActionsTaskManagementModel::where(
                                                        'uuid_sub_task',
                                                        $subtasks->uuid_sub_task,
                                                    )
                                                        ->where('action', 'Reject Task')
                                                        ->count();

                                                @endphp
                                                <br>
                                                Feedback:{{ $countfeedback }}
                                                <br>
                                                Reject:{{ $countreject }}
                                            </div>

                                            @if ($loop->iteration > count($myassignedtasks) - 1)
                                            @break
                                        @endif
                                        <div class="line"></div>
                                    @endforeach
                                </td>




                                {{-- <td colspan="2" style="font-size: 10px">
                                    @foreach ($myassignedtasks as $subtasks)
                                        <span wire:click='viewDetailsMytasks({{ $subtasks->id }})'
                                            style="text-decoration: underline;cursor: pointer; color: burlywood;">
                                            {{ App\Models\User::where('email', '=', $subtasks->owner)->first()->name }}
                                        </span>
                                        @if ($loop->iteration > count($myassignedtasks) - 1)
                                        @break
                                    @endif
                                    <div class="line"></div>
                                @endforeach
                            </td> --}}
                                {{--
                            <td colspan="1">

                                @foreach ($myassignedtasks as $subtasks)
                                    {{ $subtasks->progress }}%
                                    @if ($loop->iteration > count($myassignedtasks) - 1)
                                    @break
                                @endif
                                <div class="line"></div>
                            @endforeach

                        </td> --}}



                                {{-- <td colspan="1" style="font-size: 10px">
                                    @foreach ($myassignedtasks as $subtasks)
                                        @php
                                            $countfeedback = \App\Models\LogActionsTaskManagementModel::where('uuid_sub_task', $subtasks->uuid_sub_task)
                                                ->where('action', 'Owner Feedback')
                                                ->count();
                                            $countreject = \App\Models\LogActionsTaskManagementModel::where('uuid_sub_task', $subtasks->uuid_sub_task)
                                                ->where('action', 'Reject Task')
                                                ->count();

                                        @endphp

                                        Feedback:{{ $countfeedback }}
                                        <br>
                                        Reject:{{ $countreject }}

                                        @if ($loop->iteration > count($myassignedtasks) - 1)
                                        @break
                                    @endif
                                    <div class="line"></div>
                                @endforeach
                            </td> --}}

                                <td colspan="1">
                                    <div class="progress progress-xs">
                                        <div class="progress-bar progress-bar-danger"
                                            style="width: {{ $datadispatch->progress }}%"></div>
                                    </div>
                                </td>

                                <td colspan="2"> {{ $datadispatch->created_at }} </td>
                                <td colspan="2"> {{ $datadispatch->latest_update }} </td>
                                <td colspan="1">
                                    @php
                                        $diff = \Carbon\Carbon::parse($datadispatch->due_date)
                                            ->diff(\Carbon\Carbon::now())
                                            ->format('%d days %H:%I:%S');
                                        $parts = explode(' ', $diff);

                                        $days = (int) $parts[0];
                                        $time_parts = explode(':', $parts[2]);

                                        $hours = (int) $time_parts[0];
                                        $minutes = (int) $time_parts[1];
                                        $seconds = (int) $time_parts[2];
                                    @endphp
                                    {{ sprintf('%02d:%02d:%02d', $days * 24 + $hours, $minutes, $seconds) }} </td>



                            </tr>
                        @endforeach
                    </tbody>
                    </table>
                    {{ $viewDetailsDispatchedByMe->links('custom-pagination') }}
                </div>



            </div>

        </div>
    </div>

    <!-- Modal Dispatched BY me -->
    <div wire:ignore.self class="modal fade" id="viewDispatchedByMeModal" tabindex="-1" data-backdrop="static"
        data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content modal-content-bg bg-light">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Task Number:
                        @if (empty($modalDispatchedByMe->uuid))
                            ''
                        @else
                            {{ $modalDispatchedByMe->uuid }}
                        @endif
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click="closeModalDispatchedByMeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <table class="table table-bordered col-md-12 table-modal-dispatch">

                        @if (empty($modalDispatchedByMe->uuid))
                            ''
                        @else
                            <tr>

                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Issue:
                                </th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Impact:
                                </th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">RC:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">
                                    Solution:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">
                                    Solution2:</th>

                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">
                                    Status:</th>
                            </tr>

                            <tr>

                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $modalDispatchedByMe->issue }}</td>

                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $modalDispatchedByMe->impact }}</td>

                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $modalDispatchedByMe->rc }}</td>

                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $modalDispatchedByMe->solution }}</td>

                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $modalDispatchedByMe->solution2 }}</td>

                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $modalDispatchedByMe->solution3 }}</td>
                            </tr>

                            <tr>

                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Created
                                    At:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Latest
                                    Update:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Due
                                    Date:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Raised
                                    By:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Created
                                    By Team:</th>

                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Creator:
                                </th>

                            </tr>

                            <tr>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $modalDispatchedByMe->created_at }}</td>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $modalDispatchedByMe->latest_update }}</td>

                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $modalDispatchedByMe->due_date }}</td>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $modalDispatchedByMe->raisedbyuser }}</td>

                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $modalDispatchedByMe->createdbyteam }}</td>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $modalDispatchedByMe->creator }}</td>
                            </tr>


                            <tr>


                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">
                                    Progress:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Owner:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Processor:
                                </th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">
                                    Support:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">
                                    Priority:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">
                                    Status:</th>

                            </tr>

                            <tr>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $modalDispatchedByMe->progress }}%</td>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    @foreach (array_filter(explode(';', $modalDispatchedByMe->owner)) as $owner)
                                        {{ $owner }}<br>
                                    @endforeach
                                </td>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    @foreach (array_filter(explode(';', $modalDispatchedByMe->current_processor)) as $processor)
                                        {{ $processor }}<br>
                                    @endforeach
                                </td>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    @foreach (array_filter(explode(';', $modalDispatchedByMe->support)) as $supporter)
                                        {{ $supporter }}<br>
                                    @endforeach
                                </td>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $modalDispatchedByMe->priority }}</td>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ ucfirst($modalDispatchedByMe->current_status) }}</td>

                            </tr>

                            <tr>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="6">
                                    Description:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="6">
                                    Feedback:</th>
                            </tr>
                            <tr>

                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="6" rowspan="4">
                                    {{ $modalDispatchedByMe->description }}</td>


                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="6" rowspan="4">
                                    {{ $modalDispatchedByMe->feedback }}</td>

                            </tr>
                        @endif
                    </table>

                </div>

                {{-- Show Attachments --}}

                <div style="background-color:rgba(0, 0, 0, 0.7)">
                    <h6 style="text-align: center; color:blanchedalmond"> Attachments: </h6>
                </div>
                <div class="row justify-content-center">
                    <table class="table table-hover table-bordered table-hover p-0 my-table-log mt-1"
                        style="text-align: center; font-size: 12.5px; width:90%">

                        @if (!empty($dispatchedbymeattach))

                            <tr>
                                @foreach ($dispatchedbymeattach as $attach)
                                    @if ($loop->iteration % 3 == 1)
                            </tr>
                            <tr>
                        @endif
                        <td>
                            <button type="button" class="btn btn-sm btn-info" data-dismiss="modal"
                                wire:click="downloadattach('{{ $attach->id }}')">{{ $attach->filename }}</button>
                        </td>
                        @endforeach
                        </tr>

                        @endif

                    </table>
                </div>

                {{-- Show Log Table --}}
                <div style="background-color:rgba(0, 0, 0, 0.7)">
                    <h6 style="text-align: center; color:blanchedalmond"> Logs: </h6>
                </div>
                <div class="row justify-content-center">

                    <table class="table table-hover table-bordered table-hover p-0 my-table-log mt-1"
                        style="text-align: center; font-size: 12.5px; width:90%">

                        @if (!empty($dispatchedbymetasklog))
                            @foreach ($dispatchedbymetasklog as $log)
                                {{-- @if ($loop->iteration % 3 == 1)
                        </tr>
                        <tr> --}}
                                {{-- @endif --}}
                                <tr>
                                    <td wire:click="viewDetailsLog('{{ $log->id }}')"
                                        style="cursor: pointer; color: azure; background-color:rgb(2, 52, 15);">
                                        {{ $log->action }}</td>

                                    <td style="background-color:rgb(6, 5, 56); color:azure; font-size:10px">
                                        {{ $log->created_at }} by
                                        {{ App\Models\User::find($log->user_id)->name }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif



                    </table>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click="closeModalDispatchedByMeModal">Close</button>
                </div>
            </div>
        </div>

    </div>

    {{-- Cancel Task Modal --}}
    <div wire:ignore.self class="modal fade" id="CancelTaskModal" tabindex="-1" data-backdrop="static"
        data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cancel Confirmation
                        @if (empty($modalDispatchedByMe->uuid))
                            ''
                        @else
                            {{ $modalDispatchedByMe->uuid }}
                        @endif
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click="CloseModalCancel">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-4 pb-4">
                    <h6>Are you sure? You want to cancel this Task data!</h6>

                    <form wire:submit.prevent="CancelTask">
                        <div class="form-group col-md-12">
                            <label for="task_cancel_description" style="color: rgb(204, 198, 213)"> Please Mention
                                Cancel
                                Reason</label>
                            <textarea class="form-control" wire:model="task_cancel_description" id="task_cancel_description"
                                name="task_cancel_description" rows="3"></textarea>
                            @error('task_cancel_description')
                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                            @enderror
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"
                        wire:click="CloseModalCancel">Close</button>
                    <button class="btn btn-sm btn-danger" wire:click="CancelTask">Yes! Cancel</button>
                </div>
            </div>
        </div>
    </div>


    {{-- Complete Task Modal --}}
    <div wire:ignore.self class="modal fade" id="viewCompleteConfirmationModal" tabindex="-1"
        data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Complete Confirmation
                        @if (empty($modalDispatchedByMe->uuid))
                            ''
                        @else
                            {{ $modalDispatchedByMe->uuid }}
                        @endif
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click="CloseModalComplete">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-4 pb-4">
                    <h6>Are you sure? You want to Complete this Task data!</h6>

                    <form wire:submit.prevent="CompleteTask">
                        <div class="form-group col-md-12">
                            <label for="task_complete_description" style="color: rgb(204, 198, 213)"> Please
                                Mention
                                Complete
                                Description</label>
                            <textarea class="form-control" wire:model="task_complete_description" id="task_complete_description"
                                name="task_cancel_description" rows="3"></textarea>
                            @error('task_complete_description')
                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="task_fail"
                                    wire:model="task_fail">
                                <label class="form-check-label" for="task_fail" style="color: rgb(84, 8, 198)">
                                    Check to Fail Task and Complete it
                                </label>
                            </div>
                            {{-- <div class="form-check">
                                <input class="form-check-input" type="checkbox" value=""
                                    id="task_success" wire:model="task_success">
                                <label class="form-check-label" for="task_success" style="color: rgb(204, 198, 213)">
                                    Check to Successful Task and Complete it
                                </label>
                            </div> --}}
                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"
                        wire:click="CloseModalComplete">Close</button>
                    <button class="btn btn-sm btn-primary" wire:click="CompleteTask">Yes!
                        Complete</button>
                </div>
            </div>
        </div>
    </div>


    {{-- Modal Edit --}}

    <div wire:ignore.self class="modal fade" id="editTaskModal" tabindex="-1" data-backdrop="static"
        data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Task Number:
                        @if (empty($modalDispatchedByMe->uuid))
                            ''
                        @else
                            {{ $modalDispatchedByMe->uuid }}
                        @endif
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click="closeEditTaskManagementModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form wire:submit.prevent="editTaskData">

                        <div class="row justify-content-center col-md-12 mr-1 ml-2">
                            <div class="col-md-3 col-12 ml-1 mr-1 mt-1" style="height: 20%; width: 30%">


                                <div class="form-group">
                                    <label for="edit_raisedbyuser">Raised By</label>
                                    <input type="text" class="form-control" wire:model="edit_raisedbyuser"
                                        id="edit_raisedbyuser" name="edit_raisedbyuser"
                                        placeholder={{ $edit_raisedbyuser }}>
                                    @error('edit_raisedbyuser')
                                        <span class="text-danger"
                                            style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="edit_issue">Issue</label>
                                    <input type="text" class="form-control" wire:model="edit_issue"
                                        id="edit_issue" name="edit_issue" placeholder="Enter issue 1">
                                    @error('edit_issue')
                                        <span class="text-danger"
                                            style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="edit_impact">Impact</label>
                                    <input type="text" class="form-control" wire:model="edit_impact"
                                        id="edit_impact" name="edit_impact" placeholder="Enter impact">
                                    @error('edit_impact')
                                        <span class="text-danger"
                                            style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="edit_rc">RC</label>
                                    <input type="text" class="form-control" wire:model="edit_rc"
                                        id="edit_rc" name="edit_rc" placeholder="Enter RC">
                                    @error('edit_rc')
                                        <span class="text-danger"
                                            style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror

                                </div>


                                <div class="form-group">
                                    <label for="edit_priority">Priority</label>
                                    <select wire:model="edit_priority" name="edit_priority" id="edit_priority"
                                        class="form-control">
                                        <option value="">Select Priority</option>
                                        <option value="P1">P1</option>
                                        <option value="P2">P2</option>
                                        <option value="P3">P3</option>
                                        <option value="P4">P4</option>
                                        <option value="P5">P5</option>
                                    </select>
                                    @error('edit_priority')
                                        <span class="text-danger"
                                            style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror

                                </div>


                            </div>
                            <div class="col-md-3 col-12 ml-1 mr-1 mt-1" style="height: 20%; width: 30%">


                                <div class="form-group">
                                    <label for="edit_solution">Solution</label>
                                    <input type="text" class="form-control" wire:model="edit_solution"
                                        id="edit_solution" name="edit_solution" placeholder="Enter solution">
                                    @error('edit_solution')
                                        <span class="text-danger"
                                            style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror

                                </div>

                                <div class="form-group">
                                    <label for="edit_solution2">Solution 2</label>
                                    <input type="text" class="form-control" wire:model="edit_solution2"
                                        id="edit_solution2" name="edit_solution2" placeholder="Enter Solution 2">
                                    @error('edit_solution2')
                                        <span class="text-danger"
                                            style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="edit_solution3">Status</label>
                                    <select wire:model="edit_solution3" name="edit_solution3" id="edit_solution3"
                                        class="form-control" style="font-size: 12px">
                                        <option value="">Select Status</option>
                                        <option value="Ongoing">Ongoing</option>
                                        <option value="New Requirement">New Requirement</option>
                                        <option value="Currently Not Support">Currently Not Support</option>
                                        <option value="Clarification Required">Clarification Required</option>
                                    </select>
                                    @error('edit_solution3')
                                        <span class="text-danger"
                                            style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="edit_due_date">Due Date</label>
                                    <input type="datetime-local" class="form-control" wire:model="edit_due_date"
                                        id="edit_due_date" name="edit_due_date">
                                    @error('edit_due_date')
                                        <span class="text-danger"
                                            style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="edit_latest_update">Latest Update</label>
                                    <input type="text" class="form-control" wire:model="edit_latest_update"
                                        id="edit_latest_update" name="edit_latest_update"
                                        placeholder="Enter latest update" readonly value="{{ now() }}">
                                    @error('edit_latest_update')
                                        <span class="text-danger"
                                            style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-md-4 col-12 ml-1 mr-1 mt-1" style="height: 20%; width: 30%">
                                <div class="form-group">
                                    <label for="edit_progress">Progress</label>
                                    <input type="text" class="form-control" wire:model="edit_progress"
                                        id="edit_progress" name="edit_progress" placeholder="Enter progress">
                                    @error('edit_progress')
                                        <span class="text-danger"
                                            style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{--
                                <div class="form-group">
                                    <label for="searchmodalownereditopen">Owner</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i style="color: black"
                                                    class="fa fa-search"></i></span>
                                        </div>
                                        @if (!empty($stringowner_edit))
                                            <input type="search" name="searchmodalownereditopen"
                                                id="searchmodalownereditopen" class="form-control"
                                                placeholder="{{ $stringowner_edit }}"
                                                wire:click="searchmodalownereditopen">
                                        @else
                                            <input type="search" name="searchmodalownereditopen"
                                                id="searchmodalownereditopen" class="form-control"
                                                placeholder="{{ $edit_owner }}"
                                                wire:click="searchmodalownereditopen">
                                        @endif
                                    </div>


                                    @error('owner')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div> --}}

                                <div class="form-group">
                                    <label for="searchmodalsupporteditopen">Support</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i style="color: black"
                                                    class="fa fa-search"></i></span>
                                        </div>
                                        @if (!empty($stringsupport_edit))
                                            <input type="search" name="searchmodalsupporteditopen"
                                                id="searchmodalsupporteditopen" class="form-control"
                                                placeholder="{{ $stringsupport_edit }}"
                                                wire:click="searchmodalsupporteditopen">
                                        @else
                                            <input type="search" name="searchmodalsupporteditopen"
                                                id="searchmodalsupporteditopen" class="form-control"
                                                placeholder="{{ $edit_support }}"
                                                wire:click="searchmodalsupporteditopen">
                                        @endif
                                    </div>


                                    @error('support')
                                        <span class="text-danger"
                                            style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror


                                </div>

                                <div class="form-group">
                                    <label for="edit_description">Description</label>
                                    <textarea class="form-control" wire:model="edit_description" id="edit_description" name="edit_description"
                                        rows="3"></textarea>
                                    @error('edit_description')
                                        <span class="text-danger"
                                            style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>





                            </div>
                        </div>

                        <div class="row justify-content-center col-md-12 mr-1 ml-2">
                            <div class="form-group">
                                <label for="file">Attachment:</label>
                                <input type="file" name="file" wire:model="file" class="form-control-file"
                                    id="file">

                                @error('file')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row justify-content float-right mr-5">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary ml-1" data-dismiss="modal"
                                wire:click="closeEditTaskManagementModal">Close</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <!-- Modal Task Log -->
    <div wire:ignore.self class="modal fade" id="viewLogModal" tabindex="-1" data-backdrop="static"
        data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content modal-content-bg bg-light">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Log:
                        @if (empty($tasklogmodal->uuid))
                            ''
                        @else
                            @if (Str::contains($tasklogmodal->label_for_system, 'Parent'))
                                {{ $tasklogmodal->action }} {{ $tasklogmodal->created_at }} by
                                {{ App\Models\User::find($log->user_id)->name }} {{ $tasklogmodal->uuid }}
                            @else
                                {{ $tasklogmodal->action }} {{ $tasklogmodal->created_at }} by
                                {{ App\Models\User::find($log->user_id)->name }}
                                {{ $tasklogmodal->uuid_sub_task }}
                            @endif
                        @endif
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click="closeLogModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <table class="table table-bordered col-md-12 table-modal-dispatch">

                        @if (empty($tasklogmodal->uuid))
                            ''
                        @else
                            <tr>

                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Issue:
                                </th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Impact:
                                </th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">RC:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">
                                    Solution:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">
                                    Solution2:</th>

                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">
                                    Status:</th>
                            </tr>

                            <tr>

                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $tasklogmodal->issue }}</td>

                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $tasklogmodal->impact }}</td>

                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $tasklogmodal->rc }}</td>

                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $tasklogmodal->solution }}</td>

                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $tasklogmodal->solution2 }}</td>

                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $tasklogmodal->solution3 }}</td>
                            </tr>

                            <tr>

                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Created
                                    At:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Latest
                                    Update:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Due
                                    Date:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Raised
                                    By:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Created
                                    By Team:</th>

                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Creator:
                                </th>

                            </tr>

                            <tr>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $tasklogmodal->task_created_at }}</td>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $tasklogmodal->latest_update }}</td>

                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $tasklogmodal->due_date }}</td>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $tasklogmodal->raisedbyuser }}</td>

                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $tasklogmodal->createdbyteam }}</td>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $tasklogmodal->creator }}</td>
                            </tr>


                            <tr>


                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">
                                    Progress:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Owner:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Processor:
                                </th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">
                                    Support:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">
                                    Priority:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">
                                    Status:</th>

                            </tr>

                            <tr>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $tasklogmodal->progress }}%</td>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    @foreach (array_filter(explode(';', $tasklogmodal->owner)) as $owner)
                                        {{ $owner }}<br>
                                    @endforeach
                                </td>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    @foreach (array_filter(explode(';', $tasklogmodal->current_processor)) as $processor)
                                        {{ $processor }}<br>
                                    @endforeach
                                </td>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    @foreach (array_filter(explode(';', $tasklogmodal->support)) as $supporter)
                                        {{ $supporter }}<br>
                                    @endforeach
                                </td>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $tasklogmodal->priority }}</td>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ ucfirst($tasklogmodal->current_status) }}</td>

                            </tr>

                            <tr>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="6">
                                    Description:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="6">
                                    Feedback:</th>
                            </tr>
                            <tr>

                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="6" rowspan="4">
                                    {{ $tasklogmodal->description }}</td>


                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="6" rowspan="4">
                                    {{ $tasklogmodal->feedback }}</td>

                            </tr>
                        @endif
                    </table>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click="closeLogModal">Close</button>
                </div>
            </div>
        </div>

    </div>


    {{-- UA Modal --}}
    <div wire:ignore.self class="modal fade" id="viewUAInfoModal" tabindex="-1" data-backdrop="static"
        data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>UA Info </h5>
                </div>
                <div class="modal-body pt-4 pb-4">
                    <h6 style="color:red">Your Action Logged as UA!</h6>
                </div>

            </div>
        </div>
    </div>

    {{-- Control Assign Modal --}}

    <div wire:ignore.self class="modal fade" id="viewControlAssignModal" tabindex="-1" data-backdrop="static"
        data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title">Assign Control
                        @if (empty($modalDispatchedByMe->uuid))
                            ''
                        @else
                            {{ $modalDispatchedByMe->uuid }}
                        @endif

                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click="CloseControlAssignModal">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session()->has('message'))
                        <div class="alert alert-success text-center">{{ session('message') }}</div>
                    @endif

                    <div style="background-color:rgba(0, 0, 0, 0.7)">
                        <h6 style="text-align: center; color:blanchedalmond">Add Assigns: </h6>
                    </div>
                    <div class="row justify-content-center">
                        <form wire:submit.prevent="addAssigntoTask">
                            <div class="form-group">
                                <label for="searchmodalownereditopen"></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i style="color: black"
                                                class="fa fa-search"></i></span>
                                    </div>
                                    @if (!empty($stringowner_edit))
                                        <input type="search" name="searchmodalownereditopen"
                                            id="searchmodalownereditopen" class="form-control"
                                            placeholder="{{ $stringowner_edit }}"
                                            wire:click="searchmodalownereditopen">
                                    @else
                                        <input type="search" name="searchmodalownereditopen"
                                            id="searchmodalownereditopen" class="form-control"
                                            placeholder="{{ $edit_owner }}"
                                            wire:click="searchmodalownereditopen">
                                    @endif

                                    <button type="submit" class="btn btn-primary">Add Assign</button>

                                </div>
                        </form>
                    </div>

                </div>


                <div style="background-color:rgba(0, 0, 0, 0.7)">
                    <h6 style="text-align: center; color:blanchedalmond">Running Assigns: </h6>
                </div>
                <div class="row justify-content-center">

                    <table class="table table-hover table-bordered table-hover p-0 my-table-assign-control mt-1"
                        style="text-align: center; font-size: 12.5px; width:90%">

                        <thead>
                            <tr style="background-color: rgba(101, 77, 77, 0.9); color:azure">
                                <th>Action</th>
                                <th>Runing Assign</th>
                                <th>Assign ID</th>

                            </tr>
                        </thead>
                        <tbody>

                            @if (!empty($Assigned_SubTasks))
                                @foreach ($Assigned_SubTasks as $subtasks)
                                    @if (!empty($subtasks->current_processor))
                                        <tr>

                                            <td style="color: azure; background-color:rgb(241, 221, 175);">

                                                <button class="btn btn-xs mr-2"
                                                    wire:click="cancelSubTask('{{ $subtasks->id }}')"
                                                    style="background-color: rgba(185, 12, 58, 0.7); color:azure">Cancel
                                                    Assign
                                                </button>

                                                <button class="btn btn-xs mr-2"
                                                    style="background-color: rgb(33, 1, 1); color:azure; vertical-align: middle;"
                                                    wire:click="CompleteSubTask({{ $subtasks->id }})">Complete
                                                    Assign</button>
                                                </button>

                                                @if ($subtasks->label_for_system2 === 'Rejected')
                                                    <button class="btn btn-xs"
                                                        wire:click="rejectedAssignBack('{{ $subtasks->id }}')"
                                                        style="background-color: rgba(95, 35, 0, 0.7); color:azure">Rejected
                                                        By Owner Assign Back
                                                    </button>
                                                @endif

                                            </td>


                                            <td style="color: azure; background-color:rgb(35, 161, 69);">

                                                {{ App\Models\User::where('email', '=', $subtasks->owner)->first()->name }}

                                            </td>

                                            <td
                                                style="background-color:rgb(57, 54, 202); color:azure; font-size:10px">
                                                {{ $subtasks->uuid_sub_task }}

                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary ml-1" data-dismiss="modal"
                    wire:click="CloseControlAssignModal">Close</button>
            </div>
        </div>
    </div>
</div>


{{-- Owner Edit Search Modal --}}
<div wire:ignore.self class="modal fade" id="viewOwnerEditSearchModal" tabindex="-1" data-backdrop="static"
    data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-l" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Owner
                </h5>

            </div>
            <div class="modal-body">

                <div class="row justify-content-center">
                    <input type="search" name="searchTermFirstOwnerEdit" id="searchTermFirstOwnerEdit"
                        class="form-control" placeholder="search" wire:model="searchTermFirstOwnerEdit">


                    <div class="col-md-9 mt-1">


                        <table class="table table-bordered table-hover table-modal-search-owner">
                            <thead>
                                <tr>
                                    <th>Select</th>
                                    <th>Name</th>
                                    <th>Job ID</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($users_owner_edit))
                                    @foreach ($users_owner_edit as $result)
                                        <tr>
                                            <td> <input class="form-check-input-sm" type="checkbox"
                                                    name={{ $result->email }} value="{{ $result->email }}"
                                                    wire:model="selectedItems_edit">

                                            </td>
                                            <td> {{ $result->name }} </td>
                                            <td> {{ $result->jobid }} </td>

                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="bg-secondary">Search at Least 3
                                            Character To
                                            Show Result</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary" wire:click="getSelectedOwnersEdit">Select
                    Confirm</button>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"
                    wire:click="searchmodalownereditclose">Close</button>
            </div>
        </div>
    </div>
</div>


{{-- Support Edit Search Modal --}}
<div wire:ignore.self class="modal fade" id="viewSupportEditSearchModal" tabindex="-1" data-backdrop="static"
    data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-l" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Support
                </h5>

            </div>
            <div class="modal-body">

                <div class="row justify-content-center">
                    <input type="search" name="SupportEditsearchTermFirst" id="SupportEditsearchTermFirst"
                        class="form-control" placeholder="search" wire:model="SupportEditsearchTermFirst">


                    <div class="col-md-9 mt-1">


                        <table class="table table-bordered table-hover table-modal-search-owner">
                            <thead>
                                <tr>
                                    <th>Select</th>
                                    <th>Name</th>
                                    <th>Job ID</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($users_support_edit))
                                    @foreach ($users_support_edit as $result)
                                        <tr>
                                            <td> <input class="form-check-input-sm" type="checkbox"
                                                    name={{ $result->email }} value="{{ $result->email }}"
                                                    wire:model="supportselectedItems_edit">
                                            </td>
                                            <td> {{ $result->name }} </td>
                                            <td> {{ $result->jobid }} </td>

                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" bg-info>Search at Lest 3 Character To Show
                                            Result
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary" wire:click="getSelectedSupportsEdit">Select
                    Confirm</button>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"
                    wire:click="searchmodalsupporteditclose">Close</button>
            </div>
        </div>
    </div>
</div>



{{-- Cancel SubTask Modal --}}
<div wire:ignore.self class="modal fade" id="viewSubtaskCancelModal" tabindex="-1" data-backdrop="static"
    data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cancel Assign Confirmation
                    @if (empty($request_subtask_cancel->uuid_sub_task))
                        ''
                    @else
                        {{ $request_subtask_cancel->uuid_sub_task }}
                    @endif
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    wire:click="CloseSubtaskCancelModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-4 pb-4">
                <h6>Are you sure? You want to cancel this Assign</h6>
                <form wire:submit.prevent="CancelSubTaskConfirmed">

                    <div class="form-group col-md-12">
                        <label for="subtask_cancel_description" style="color: rgb(204, 198, 213)"> Please Mention
                            Cancel
                            Description</label>
                        <textarea class="form-control" wire:model="subtask_cancel_description" id="subtask_cancel_description"
                            name="task_cancel_description" rows="3"></textarea>
                        @error('subtask_cancel_description')
                            <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                        @enderror
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"
                    wire:click="CloseSubtaskCancelModal">Close</button>
                <button class="btn btn-sm btn-danger" wire:click="CancelSubTaskConfirmed">Yes!
                    Cancel</button>
            </div>
        </div>
    </div>
</div>

{{-- Complete SubTask Modal --}}
<div wire:ignore.self class="modal fade" id="viewSubtaskCompleteModal" tabindex="-1" data-backdrop="static"
    data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Complete Assign Confirmation
                    @if (empty($complete_request_subtask->uuid_sub_task))
                        ''
                    @else
                        {{ $complete_request_subtask->uuid_sub_task }}
                    @endif
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    wire:click="CloseSubtaskCompleteModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-4 pb-4">
                <h6>Are you sure? You want to Complete this Assign</h6>
                <form wire:submit.prevent="CompleteSubTaskConfirmed">

                    <div class="form-group col-md-12">
                        <label for="subtask_complete_description" style="color: rgb(204, 198, 213)"> Please
                            Mention Complete
                            Description</label>
                        <textarea class="form-control" wire:model="subtask_complete_description" id="subtask_complete_description"
                            name="task_cancel_description" rows="3"></textarea>
                        @error('subtask_complete_description')
                            <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="row">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="subtask_fail"
                                wire:model="subtask_fail">
                            <label class="form-check-label" for="subtask_fail" style="color: rgb(84, 8, 198)">
                                Check to Complete Assign and Fail Task
                            </label>
                        </div>
                        {{-- <div class="form-check">
                            <input class="form-check-input" type="checkbox" value=""
                                id="subtask_success" wire:model="subtask_success">
                            <label class="form-check-label" for="subtask_success" style="color: rgb(204, 198, 213)">
                                Check to Complete Assign and Successful Task
                            </label>
                        </div> --}}
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"
                    wire:click="CloseSubtaskCompleteModal">Close</button>
                <button class="btn btn-sm btn-info" wire:click="CompleteSubTaskConfirmed">Yes!
                    Complete</button>
            </div>
        </div>
    </div>
</div>

{{-- Assign Back Modal --}}
<div wire:ignore.self class="modal fade" id="AssignBackModal" tabindex="-1" data-backdrop="static"
    data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Back Confirmation
                    @if (empty($assignback_request_subtask->uuid_sub_task))
                        ''
                    @else
                        {{ $assignback_request_subtask->uuid_sub_task }}
                    @endif
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    wire:click="closeAssignBackModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-4 pb-4">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h6>Are you sure? You want to Assign Back this Task?</h6>

                <form wire:submit.prevent="AssignBack">
                    <div class="form-group col-md-12">
                        <label for="feedback" style="color: rgb(204, 198, 213)"> Please Mention Assign Back
                            Reason</label>
                        <textarea class="form-control" wire:model="assignbackfeedback" id="assignbackfeedback" name="assignbackfeedback"
                            rows="3">
                            </textarea>
                        @error('assignbackfeedback')
                            <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                        @enderror
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"
                    wire:click="closeAssignBackModal">Close</button>
                <button class="btn btn-sm btn-danger" wire:click="AssignBackSubTask">Yes! Assign Back</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Sub Tasks -->
<div wire:ignore.self class="modal fade" id="viewMytasks_Modal" tabindex="-1" data-backdrop="static"
    data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modal-content-bg bg-light">
            <div class="modal-header">
                <h5 class="modal-title text-primary">Task Number:
                    @if (empty($modalMytasks->uuid))
                        ''
                    @else
                        {{ $modalMytasks->uuid_sub_task }}
                    @endif
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    wire:click="closemodalMytasksModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table col-md-12 table table-bordered table-modal-dispatch">

                    @if (empty($modalMytasks->uuid))
                        ''
                    @else
                        <tr>

                            <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                colspan="2">Issue:
                            </th>
                            <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                colspan="2">Impact:
                            </th>
                            <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                colspan="2">RC:</th>
                            <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                colspan="2">
                                Solution:</th>
                            <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                colspan="2">
                                Solution2:</th>

                            <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                colspan="2">
                                Status:</th>
                        </tr>

                        <tr>

                            <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                colspan="2">
                                {{ $modalMytasks->issue }}</td>

                            <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                colspan="2">
                                {{ $modalMytasks->impact }}</td>

                            <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                colspan="2">
                                {{ $modalMytasks->rc }}</td>

                            <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                colspan="2">
                                {{ $modalMytasks->solution }}</td>

                            <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                colspan="2">
                                {{ $modalMytasks->solution2 }}</td>

                            <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                colspan="2">
                                {{ $modalMytasks->solution3 }}</td>
                        </tr>

                        <tr>

                            <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                colspan="2">Created
                                At:</th>
                            <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                colspan="2">Latest
                                Update:</th>
                            <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                colspan="2">Due
                                Date:</th>
                            <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                colspan="2">Raised
                                By:</th>
                            <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                colspan="2">Created
                                By Team:</th>

                            <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                colspan="2">Creator:
                            </th>

                        </tr>

                        <tr>
                            <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                colspan="2">
                                {{ $modalMytasks->created_at }}</td>
                            <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                colspan="2">
                                {{ $modalMytasks->latest_update }}</td>

                            <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                colspan="2">
                                {{ $modalMytasks->due_date }}</td>
                            <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                colspan="2">
                                {{ $modalMytasks->raisedbyuser }}</td>

                            <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                colspan="2">
                                {{ $modalMytasks->createdbyteam }}</td>
                            <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                colspan="2">
                                {{ $modalMytasks->creator }}</td>
                        </tr>

                        <tr>

                            <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                colspan="2">
                                Progress:</th>
                            <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                colspan="2">Owner:</th>
                            <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                colspan="2">Processor:
                            </th>
                            <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                colspan="2">
                                Support:</th>
                            <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                colspan="2">
                                Priority:</th>
                            <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                colspan="2">
                                Status:</th>

                        </tr>

                        <tr>
                            <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                colspan="2">
                                {{ $modalMytasks->progress }}%</td>
                            <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                colspan="2">
                                @foreach (array_filter(explode(';', $modalMytasks->owner)) as $owner)
                                    {{ $owner }}<br>
                                @endforeach
                            </td>
                            <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                colspan="2">
                                @foreach (array_filter(explode(';', $modalMytasks->current_processor)) as $processor)
                                    {{ $processor }}<br>
                                @endforeach
                            </td>
                            <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                colspan="2">
                                @foreach (array_filter(explode(';', $modalMytasks->support)) as $supporter)
                                    {{ $supporter }}<br>
                                @endforeach
                            </td>
                            <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                colspan="2">
                                {{ $modalMytasks->priority }}</td>
                            <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                colspan="2">
                                {{ ucfirst($modalMytasks->current_status) }}</td>

                        </tr>

                        <tr>
                            <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                colspan="6">
                                Description:</th>
                            <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                colspan="6">
                                Feedback:</th>
                        </tr>
                        <tr>

                            <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                colspan="6" rowspan="4">
                                {{ $modalMytasks->description }}</td>

                            <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                colspan="6" rowspan="4">
                                {{ $modalMytasks->feedback }}</td>

                        </tr>
                    @endif
                </table>



            </div>

            {{-- Show Attachments --}}

            <div style="background-color:rgba(0, 0, 0, 0.7)">
                <h6 style="text-align: center; color:blanchedalmond"> Attachments: </h6>
            </div>
            <div class="row justify-content-center">
                <table class="table table-hover table-bordered table-hover p-0 my-table-log mt-1"
                    style="text-align: center; font-size: 12.5px; width:90%">

                    @if (!empty($mytasks_attach))

                        <tr>
                            @foreach ($mytasks_attach as $attach)
                                @if ($loop->iteration % 3 == 1)
                        </tr>
                        <tr>
                    @endif
                    <td>
                        <button type="button" class="btn btn-sm btn-info" data-dismiss="modal"
                            wire:click="downloadattach('{{ $attach->id }}')">{{ $attach->filename }}</button>
                    </td>
                    @endforeach
                    </tr>

                    @endif

                </table>
            </div>

            {{-- Show Log Table --}}
            <div style="background-color:rgba(0, 0, 0, 0.7)">
                <h6 style="text-align: center; color:blanchedalmond"> Logs: </h6>
            </div>
            <div class="row justify-content-center">

                <table class="table table-hover table-bordered table-hover p-0 my-table-log mt-1"
                    style="text-align: center; font-size: 12.5px; width:90%">

                    @if (!empty($mytasks_tasklog))
                        @foreach ($mytasks_tasklog as $log)
                            {{-- @if ($loop->iteration % 3 == 1)
                        </tr>
                        <tr> --}}
                            {{-- @endif --}}
                            <tr>
                                <td wire:click="viewDetailsLogsubtask('{{ $log->id }}')"
                                    style="cursor: pointer; color: azure; background-color:rgb(2, 52, 15);">
                                    {{ $log->action }}</td>

                                <td style="background-color:rgb(6, 5, 56); color:azure; font-size:10px">
                                    {{ $log->created_at }} by {{ App\Models\User::find($log->user_id)->name }}
                                </td>
                            </tr>
                        @endforeach
                    @endif


                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    wire:click="closemodalMytasksModal">Close</button>
            </div>
        </div>
    </div>

</div>

<!-- Modal Sub Task Log -->
<div wire:ignore.self class="modal fade" id="viewLogsubtaskModal" tabindex="-1" data-backdrop="static"
    data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modal-content-bg bg-light">
            <div class="modal-header">
                <h5 class="modal-title text-primary">Log:
                    @if (empty($subtasklogmodal->uuid))
                        ''
                    @else
                        @if ($subtasklogmodal->label_for_system == 'Parent')
                            {{ $subtasklogmodal->action }} {{ $subtasklogmodal->created_at }} by
                            {{ App\Models\User::find($log->user_id)->name }} {{ $subtasklogmodal->uuid }}
                        @else
                            {{ $subtasklogmodal->action }} {{ $subtasklogmodal->created_at }} by
                            {{ App\Models\User::find($log->user_id)->name }}
                            {{ $subtasklogmodal->uuid_sub_task }}
                        @endif
                    @endif
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    wire:click="closeLogsubtaskModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <table class="table table-bordered table-modal-dispatch">
                    <thead>
                        @if (empty($subtasklogmodal->uuid))
                            ''
                        @else
                            <tr>

                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Issue:
                                </th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Impact:
                                </th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">RC:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">
                                    Solution:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">
                                    Solution2:</th>

                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">
                                    Status:</th>
                            </tr>

                            <tr>

                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $subtasklogmodal->issue }}</td>

                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $subtasklogmodal->impact }}</td>

                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $subtasklogmodal->rc }}</td>

                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $subtasklogmodal->solution }}</td>

                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $subtasklogmodal->solution2 }}</td>

                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $subtasklogmodal->solution3 }}</td>
                            </tr>

                            <tr>

                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Created
                                    At:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Latest
                                    Update:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Due
                                    Date:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Raised
                                    By:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Created
                                    By Team:</th>

                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Creator:
                                </th>

                            </tr>

                            <tr>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $subtasklogmodal->task_created_at }}</td>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $subtasklogmodal->latest_update }}</td>

                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $subtasklogmodal->due_date }}</td>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $subtasklogmodal->raisedbyuser }}</td>

                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $subtasklogmodal->createdbyteam }}</td>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $subtasklogmodal->creator }}</td>
                            </tr>


                            <tr>


                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">
                                    Progress:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Owner:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">Processor:
                                </th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">
                                    Support:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">
                                    Priority:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="2">
                                    Status:</th>

                            </tr>

                            <tr>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $subtasklogmodal->progress }}%</td>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    @foreach (array_filter(explode(';', $subtasklogmodal->owner)) as $owner)
                                        {{ $owner }}<br>
                                    @endforeach
                                </td>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    @foreach (array_filter(explode(';', $subtasklogmodal->current_processor)) as $processor)
                                        {{ $processor }}<br>
                                    @endforeach
                                </td>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    @foreach (array_filter(explode(';', $subtasklogmodal->support)) as $supporter)
                                        {{ $supporter }}<br>
                                    @endforeach
                                </td>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ $subtasklogmodal->priority }}</td>
                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="2">
                                    {{ ucfirst($subtasklogmodal->current_status) }}</td>

                            </tr>

                            <tr>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="6">
                                    Description:</th>
                                <th style="background-color: rgba(29, 3, 55, 0.9); vertical-align: middle;"
                                    colspan="6">
                                    Feedback:</th>
                            </tr>
                            <tr>

                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="6" rowspan="4">
                                    {{ $subtasklogmodal->description }}</td>


                                <td style="color:rgb(104, 32, 32) ; font-weight:bold;background-color: rgba(171, 151, 238, 0.8); vertical-align: middle;"
                                    colspan="6" rowspan="4">
                                    {{ $subtasklogmodal->feedback }}</td>

                            </tr>
                        @endif
                </table>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    wire:click="closeLogsubtaskModal">Close</button>
            </div>
        </div>
    </div>

</div>

{{-- Owner Fb Search Modal --}}
<div wire:ignore.self class="modal fade" id="viewOwnerFbSearchModal" tabindex="-1" data-backdrop="static"
    data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-l" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Owner
                </h5>

            </div>
            <div class="modal-body">

                <div class="row justify-content-center">
                    <input type="search" name="searchTermFirstOwnerFb" id="searchTermFirstOwnerFb"
                        class="form-control" placeholder="search" wire:model="searchTermFirstOwnerFb">

                    <div class="col-md-9 mt-1">

                        <table class="table table-bordered table-hover table-modal-search-owner">
                            <thead>
                                <tr>
                                    <th>Select</th>
                                    <th>Name</th>
                                    <th>Job ID</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($users_owner_fb))
                                    @foreach ($users_owner_fb as $result)
                                        <tr>
                                            <td> <input class="form-check-input-sm" type="checkbox"
                                                    name={{ $result->email }} value="{{ $result->email }}"
                                                    wire:model="selectfbems_fb">

                                            </td>
                                            <td> {{ $result->name }} </td>
                                            <td> {{ $result->jobid }} </td>

                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="bg-secondary">Search at Least 3 Character To
                                            Show Result</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary" wire:click="getSelectedOwnersFb">Select
                    Confirm</button>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"
                    wire:click="searchmodalownerfbclose">Close</button>
            </div>
        </div>
    </div>
</div>


</div>

</div>

</div>

@push('scripts')
<script>
    window.addEventListener('show-view-dispatched-by-me-modal', event => {
        $('#viewDispatchedByMeModal').modal('show');
    });

    window.addEventListener('show-cancel-confirmation-modal', event => {
        $('#CancelTaskModal').modal('show');
    });

    window.addEventListener('show-edit-task-management-modal', event => {
        $('#editTaskModal').modal('show');
    });

    window.addEventListener('show-view-log-modal', event => {
        $('#viewLogModal').modal('show');
    });

    window.addEventListener('show-view-owner-edit-search-modal', event => {
        $('#viewOwnerEditSearchModal').modal('show');
    });

    window.addEventListener('show-view-support-edit-search-modal', event => {
        $('#viewSupportEditSearchModal').modal('show');
    });

    window.addEventListener('show-ua-info-modal', event => {
        $('#viewUAInfoModal').modal('show');
    });

    window.addEventListener('show-view-assign-modal', event => {
        $('#viewControlAssignModal').modal('show');
    });

    window.addEventListener('show-subtask-cancel-confirmation-modal', event => {
        $('#viewSubtaskCancelModal').modal('show');
    });

    window.addEventListener('show-complete-confirmation-modal', event => {
        $('#viewCompleteConfirmationModal').modal('show');
    });


    window.addEventListener('show-subtask-complete-confirmation-modal', event => {
        $('#viewSubtaskCompleteModal').modal('show');
    });

    window.addEventListener('show-subtask-assign-back-modal', event => {
        $('#AssignBackModal').modal('show');
    });

    window.addEventListener('show-view-my-tasks-modal', event => {
        $('#viewMytasks_Modal').modal('show');
    });

    window.addEventListener('show-view-log-subtask-modal', event => {
        $('#viewLogsubtaskModal').modal('show');
    });



    window.addEventListener('close-view-dispatched-by-me-modal', event => {

        $('#viewDispatchedByMeModal').modal('hide');
    });

    window.addEventListener('close-modal-cancel', event => {

        $('#CancelTaskModal').modal('hide');
    });

    window.addEventListener('close-edit-task-management-modal', event => {
        $('#editTaskModal').modal('hide');
    });

    window.addEventListener('close-view-log-modal', event => {
        $('#viewLogModal').modal('hide');
    });

    window.addEventListener('close-view-log-subtask-modal', event => {
        $('#viewLogsubtaskModal').modal('hide');
    });


    window.addEventListener('close-view-owner-edit-search-modal', event => {
        $('#viewOwnerEditSearchModal').modal('hide');
    });

    window.addEventListener('close-view-support-edit-search-modal', event => {
        $('#viewSupportEditSearchModal').modal('hide');
    });


    window.addEventListener('close-view-assign-modal', event => {
        $('#viewControlAssignModal').modal('hide');
    });

    window.addEventListener('close-subtask-cancel-confirmation-modal', event => {
        $('#viewSubtaskCancelModal').modal('hide');
    });

    window.addEventListener('close-complete-confirmation-modal', event => {
        $('#viewCompleteConfirmationModal').modal('hide');
    });

    window.addEventListener('close-subtask-complete-confirmation-modal', event => {
        $('#viewSubtaskCompleteModal').modal('hide');
    });

    window.addEventListener('close-subtask-assign-back-modal', event => {
        $('#AssignBackModal').modal('hide');
    });

    window.addEventListener('close-view-my-tasks-modal', event => {

        $('#viewMytasks_Modal').modal('hide');
    });

    // setInterval(function() {
    //     location.reload();
    // }, 1800000); // 30 minutes expressed in milliseconds
</script>
@endpush
