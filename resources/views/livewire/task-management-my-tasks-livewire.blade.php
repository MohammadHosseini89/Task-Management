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

        .form-control {
            font-size: 12px;

        }

        .table-mytask {
            border: 1px solid burlywood;
            vertical-align: middle;

        }

        .table-mytask td,
        .table-mytask th {
            text-align: center;
            color: rgb(0, 0, 0);
            font-family: "Arial", sans-serif;
            font-size: smaller;
            vertical-align: middle;

        }

        .table-modal-mytask {
            vertical-align: middle;
            text-align: center;
        }

        .table-modal-mytask td,
        .table-modal-mytask th {
            padding: 0;
            margin: 0;
            text-align: center;
            line-height: 1.5;
            font-size: 10px;
            color: rgb(234, 216, 216);
            vertical-align: middle;

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

        .table-modal-search-owner {
            border: 1px solid burlywood;

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
    </style>

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
                    <li class="nav-item"><a class="nav-link active" href="{{ route('mytasks') }}">My Tasks</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('support') }}">I'm Support</a></li>


                    <li class="nav-item"><a class="nav-link" href="{{ route('controltask') }}">Task Control</a></li>


                    <li class="nav-item"><a class="nav-link" href="{{ route('cancelled') }}">Cancelled
                            Tasks</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('completed') }}">Completed
                            Tasks</a></li>
                </ul>
            </div>

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

                    <div class="tab-pane active" id="mytasks">
                        @if (count($view_mytasks_taskmanagementmodel) == 0)
                            <table class="table table-bordered table-mytask">
                            @else
                                <table class="table table-hover col-md-12 table-bordered table-mytask">
                        @endif

                        <thead>
                            <tr>
                                <th style="vertical-align: middle;">Action</th>
                                <th style="vertical-align: middle;">Task ID</th>
                                <th style="vertical-align: middle;">Issue</th>
                                <th style="vertical-align: middle;">Solution</th>
                                <th style="vertical-align: middle;">Solution2</th>
                                <th style="vertical-align: middle;">Status</th>
                                <th style="vertical-align: middle;">Created At</th>
                                <th style="vertical-align: middle;">Latest Update</th>
                                <th style="vertical-align: middle;">Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($view_mytasks_taskmanagementmodel as $mytasks)
                                <tr>
                                    <td>
                                        <button class="btn btn-block btn-danger btn-xs"
                                            wire:click="rejectTask('{{ $mytasks->id }}')">Reject</button>
                                        <button class="btn btn-block btn-primary btn-xs"
                                            wire:click="fbTaskManagementDataDispatch({{ $mytasks->id }})">Feedback</button>

                                    </td>

                                    <td wire:click="viewDetailsMytasks('{{ $mytasks->id }}')"
                                        style="text-decoration: underline;cursor: pointer; color: rgb(39, 3, 199);">
                                        {{ $mytasks->uuid_sub_task }} </td>
                                    <td> {{ $mytasks->issue }} </td>
                                    <td> {{ $mytasks->solution }} </td>
                                    <td> {{ $mytasks->solution2 }} </td>
                                    <td> {{ $mytasks->solution3 }} </td>
                                    <td> {{ $mytasks->created_at }} </td>
                                    <td> {{ $mytasks->latest_update }} </td>
                                    <td>
                                        <div class="progress progress-xs">
                                            <div class="progress-bar progress-bar-danger"
                                                style="width: {{ $mytasks->progress }}%"></div>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                        </table>
                        {{ $view_mytasks_taskmanagementmodel->links('custom-pagination') }}
                    </div>

                </div>

            </div>
        </div>

        <!-- Modal My Tasks -->
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
                        <table class="table col-md-12 table table-bordered table-modal-mytask">

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
                                        <td wire:click="viewDetailsLog('{{ $log->id }}')"
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

        {{-- Reject Modal --}}
        <div wire:ignore.self class="modal fade" id="RejectTaskModal" tabindex="-1" data-backdrop="static"
            data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reject Confirmation
                            @if (empty($modalMytasks->uuid))
                                ''
                            @else
                                {{ $modalMytasks->uuid }}
                            @endif
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            wire:click="CloseModalReject">
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

                        <h6>Are you sure? You want to Reject this Task?</h6>

                        <form wire:submit.prevent="TaskReject">
                            <div class="form-group col-md-12">
                                <label for="feedback" style="color: rgb(204, 198, 213)"> Please Mention Reject
                                    Reason</label>
                                <textarea class="form-control" wire:model="rejectfeedback" id="rejectfeedback" name="rejectfeedback"
                                    rows="3"></textarea>
                                @error('rejectfeedback')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                    </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"
                            wire:click="CloseModalReject">Close</button>
                        <button class="btn btn-sm btn-danger" wire:click="TaskReject">Yes! Reject</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Fb --}}

        <div wire:ignore.self class="modal fade" id="fbTaskModal" tabindex="-1" data-backdrop="static"
            data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Fb Task Number:
                            @if (empty($modalMytasks->uuid))
                                ''
                            @else
                                {{ $modalMytasks->uuid }}
                            @endif
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            wire:click="closeFbTaskManagementModal">
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


                        @if (empty($modalMytasks->uuid))
                            ''
                        @else
                            <form wire:submit.prevent="fbTaskData">

                                <div class="row justify-content-center col-md-12 mr-1 ml-2">
                                    <div class="col-md-3 col-12 ml-1 mr-1 mt-1" style="height: 20%; width: 30%">

                                        <div class="form-group">
                                            <label for="issue">Issue</label>
                                            <input type="text" class="form-control" id="issue"
                                                name="fb_issue" placeholder="Enter issue 1" readonly
                                                value={{ $modalMytasks->issue }}
                                                style="background-color: rgba(10, 4, 27, 0.7); color:azure">

                                            {{-- <input type="text" class="form-control" wire:model="fb_issue" id="issue"
                                        name="fb_issue" placeholder="Enter issue 1" readonly
                                        style="background-color: rgba(10, 4, 27, 0.7); color:azure"> --}}
                                            @error('fb_issue')
                                                <span class="text-danger"
                                                    style="font-size: 11.5px;">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="impact">Impact</label>
                                            <input type="text" class="form-control" wire:model="fb_impact"
                                                id="impact" name="impact" placeholder="Enter impact">
                                            @error('impact')
                                                <span class="text-danger"
                                                    style="font-size: 11.5px;">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="rc">RC</label>
                                            <input type="text" class="form-control" wire:model="fb_rc"
                                                id="rc" name="rc" placeholder="Enter RC">
                                            @error('rc')
                                                <span class="text-danger"
                                                    style="font-size: 11.5px;">{{ $message }}</span>
                                            @enderror

                                        </div>
                                        <div class="form-group">
                                            <label for="solution">Solution</label>
                                            <input type="text" class="form-control" wire:model="fb_solution"
                                                id="solution" name="solution" placeholder="Enter solution">
                                            @error('fb_solution')
                                                <span class="text-danger"
                                                    style="font-size: 11.5px;">{{ $message }}</span>
                                            @enderror

                                        </div>

                                    </div>
                                    <div class="col-md-3 col-12 ml-1 mr-1 mt-1" style="height: 20%; width: 30%">

                                        <div class="form-group">
                                            <label for="fb_solution2">Solution 2</label>
                                            <input type="text" class="form-control" wire:model="fb_solution2"
                                                id="fb_solution2" name="fb_solution2" placeholder="Enter Solution 2">
                                            @error('fb_solution2')
                                                <span class="text-danger"
                                                    style="font-size: 11.5px;">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="fb_solution3">Status</label>
                                            <select wire:model="fb_solution3" name="fb_solution3" id="fb_solution3"
                                                class="form-control" style="font-size: 12px">
                                                <option value="">Select Status</option>
                                                <option value="Ongoing">Ongoing</option>
                                                <option value="New Requirement">New Requirement</option>
                                                <option value="Currently Not Support">Currently Not Support</option>
                                                <option value="Clarification Required">Clarification Required</option>
                                            </select>
                                            @error('fb_solution3')
                                                <span class="text-danger"
                                                    style="font-size: 11.5px;">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="due_date">Due Date</label>
                                            <input type="datetime-local" class="form-control"
                                                wire:model="fb_due_date" id="due_date" name="due_date" readonly
                                                style="background-color: rgba(10, 4, 27, 0.7); color:azure">
                                            @error('due_date')
                                                <span class="text-danger"
                                                    style="font-size: 11.5px;">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="latest_update">Latest Update</label>
                                            <input type="text" class="form-control" wire:model="fb_latest_update"
                                                id="latest_update" name="latest_update"
                                                placeholder="Enter latest update" readonly
                                                value="{{ now() }}"
                                                style="background-color: rgba(10, 4, 27, 0.7); color:azure">
                                            @error('latest_update')
                                                <span class="text-danger"
                                                    style="font-size: 11.5px;">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-md-4 col-12 ml-1 mr-1 mt-1" style="height: 20%; width: 30%">
                                        <div class="form-group">
                                            <label for="progress">Progress</label>
                                            <input type="text" class="form-control" wire:model="fb_progress"
                                                id="progress" name="progress" placeholder="Enter progress">
                                            @error('fb_progress')
                                                <span class="text-danger"
                                                    style="font-size: 11.5px;">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="searchmodalownerfbopen">Owner</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    {{-- <span class="input-group-text"><i style="color: black"
                                                    class="fa fa-search"></i></span> --}}
                                                </div>
                                                @if (!empty($stringowner_fb))
                                                    <input type="search" name="searchmodalownerfbopen"
                                                        id="searchmodalownerfbopen" class="form-control"
                                                        placeholder="{{ $stringowner_fb }}" readonly
                                                        style="background-color: rgba(10, 4, 27, 0.7); color:azure">
                                                    {{-- wire:click="searchmodalownerfbopen" > --}}
                                                @else
                                                    <input type="search" name="searchmodalownerfbopen"
                                                        id="searchmodalownerfbopen" class="form-control"
                                                        placeholder="{{ $fb_owner }}" readonly
                                                        style="background-color: rgba(10, 4, 27, 0.7); color:azure">
                                                    {{-- wire:click="searchmodalownerfbopen" readonly>  --}}
                                                @endif
                                            </div>

                                            @error('owner')
                                                <span class="text-danger"
                                                    style="font-size: 11.5px;">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="searchmodalsupportfbopen">Support</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    {{-- <span class="input-group-text"><i style="color: black"
                                                    class="fa fa-search"></i></span> --}}
                                                </div>
                                                @if (!empty($stringsupport_fb))
                                                    <input type="search" name="searchmodalsupportfbopen"
                                                        id="searchmodalsupportfbopen" class="form-control"
                                                        placeholder="{{ $stringsupport_fb }}" readonly
                                                        style="background-color: rgba(10, 4, 27, 0.7); color:azure">
                                                    {{-- wire:click="searchmodalsupportfbopen"> --}}
                                                @else
                                                    <input type="search" name="searchmodalsupportfbopen"
                                                        id="searchmodalsupportfbopen" class="form-control"
                                                        placeholder="{{ $fb_support }}" readonly
                                                        style="background-color: rgba(10, 4, 27, 0.7); color:azure">
                                                    {{-- wire:click="searchmodalsupportfbopen"> --}}
                                                @endif
                                            </div>

                                            @error('support')
                                                <span class="text-danger"
                                                    style="font-size: 11.5px;">{{ $message }}</span>
                                            @enderror

                                        </div>


                                        <div class="form-group">
                                            <label for="priority">Priority</label>
                                            <input type="text" class="form-control" id="priority"
                                                name="priority" readonly value="{{ $modalMytasks->priority }}"
                                                style="background-color: rgba(10, 4, 27, 0.7); color:azure">

                                            {{-- <select wire:model="fb_priority" name="priority" id="priority"
                                            class="form-control">
                                            <option value="">Select Priority</option>
                                            <option value="P1">P1</option>
                                            <option value="P2">P2</option>
                                            <option value="P3">P3</option>
                                            <option value="P4">P4</option>
                                            <option value="P5">P5</option>
                                        </select> --}}
                                            @error('fb_priority')
                                                <span class="text-danger"
                                                    style="font-size: 11.5px;">{{ $message }}</span>
                                            @enderror

                                        </div>

                                    </div>
                                </div>

                                <div class="row justify-content-center col-md-12">
                                    <div class="form-group col-md-4 ">
                                        <label for="description">Description</label>
                                        <textarea readonly class="form-control" id="description" name="description" rows="3"
                                            style="background-color: rgba(10, 4, 27, 0.7); color:azure">{{ $modalMytasks->description }}</textarea>


                                        {{-- <textarea readonly class="form-control col-md-12" wire:model="fb_description" id="description" name="description"
                                        rows="3" style="background-color: rgba(10, 4, 27, 0.7); color:azure">
                                </textarea> --}}
                                        @error('description')
                                            <span class="text-danger"
                                                style="font-size: 11.5px;">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="feedback">Feedback</label>
                                        <textarea class="form-control" wire:model="fb_feedback" id="feedback" name="feedback" rows="3"></textarea>
                                        @error('fb_feedback')
                                            <span class="text-danger"
                                                style="font-size: 11.5px;">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>



                                <div class="row justify-content-center col-md-12 mr-1 ml-2">
                                    <div class="form-group">
                                        <label for="file">Attachment:</label>
                                        <input type="file" name="file" wire:model="file"
                                            class="form-control-file" id="file">

                                        @error('file')
                                            <span class="text-danger"
                                                style="font-size: 11.5px;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row justify-content float-right mr-5">
                                    <button type="submit" class="btn ml-1"
                                        style="background-color: rgba(10, 4, 27, 0.7); color:azure">FeedBack</button>
                                    <button type="button" class="btn btn-secondary ml-1" data-dismiss="modal"
                                        wire:click="closeFbTaskManagementModal">Close</button>
                                </div>
                            </form>
                        @endif
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
                                @if ($tasklogmodal->label_for_system == 'Parent')
                                    {{ $tasklogmodal->action }} {{ $tasklogmodal->created_at }} by
                                    {{ App\Models\User::find($tasklogmodal->user_id)->name }} {{ $tasklogmodal->uuid }}
                                @else
                                    {{ $tasklogmodal->action }} {{ $tasklogmodal->created_at }} by
                                    {{ App\Models\User::find($tasklogmodal->user_id)->name }}
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

                        <table class="table table-bordered table-modal-mytask">
                            <thead>
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

        {{-- Support Fb Search Modal --}}
        <div wire:ignore.self class="modal fade" id="viewSupportFbSearchModal" tabindex="-1" data-backdrop="static"
            data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-l" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Select Support
                        </h5>

                    </div>
                    <div class="modal-body">

                        <div class="row justify-content-center">
                            <input type="search" name="SupportFbsearchTermFirst" id="SupportFbsearchTermFirst"
                                class="form-control" placeholder="search" wire:model="SupportFbsearchTermFirst">

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
                                        @if (!empty($users_support_fb))
                                            @foreach ($users_support_fb as $result)
                                                <tr>
                                                    <td> <input class="form-check-input-sm" type="checkbox"
                                                            name={{ $result->email }} value="{{ $result->email }}"
                                                            wire:model="supportselectfbems_fb">
                                                    </td>
                                                    <td> {{ $result->name }} </td>
                                                    <td> {{ $result->jobid }} </td>

                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3" bg-info>Search at Lest 3 Character To Show Result
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-primary"
                            wire:click="getSelectedSupportsFb">Select
                            Confirm</button>
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"
                            wire:click="searchmodalsupportfbclose">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('show-view-my-tasks-modal', event => {
            $('#viewMytasks_Modal').modal('show');
        });

        window.addEventListener('show-reject-confirmation-modal', event => {
            $('#RejectTaskModal').modal('show');
        });

        window.addEventListener('show-fb-task-management-modal', event => {
            $('#fbTaskModal').modal('show');
        });

        window.addEventListener('show-view-log-modal', event => {
            $('#viewLogModal').modal('show');
        });

        window.addEventListener('show-view-owner-fb-search-modal', event => {
            $('#viewOwnerFbSearchModal').modal('show');
        });

        window.addEventListener('show-view-support-fb-search-modal', event => {
            $('#viewSupportFbSearchModal').modal('show');
        });


        window.addEventListener('close-view-my-tasks-modal', event => {

            $('#viewMytasks_Modal').modal('hide');
        });

        window.addEventListener('close-modal-reject', event => {

            $('#RejectTaskModal').modal('hide');
        });

        window.addEventListener('close-fb-task-management-modal', event => {
            $('#fbTaskModal').modal('hide');
        });

        window.addEventListener('close-view-log-modal', event => {
            $('#viewLogModal').modal('hide');
        });

        window.addEventListener('close-view-owner-fb-search-modal', event => {
            $('#viewOwnerFbSearchModal').modal('hide');
        });

        window.addEventListener('close-view-support-fb-search-modal', event => {
            $('#viewSupportFbSearchModal').modal('hide');
        });
    </script>
@endpush
