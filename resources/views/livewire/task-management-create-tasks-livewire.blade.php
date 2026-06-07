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
    </style>



    @php
        $teams = request()->user()->load('asssignusertoteam')->asssignusertoteam->pluck('team_name');
    @endphp
    <div class="row" style="width:100%; height:100%;">
    </div>


    <div class="card">

        <div class="card-header p-2">
            <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="{{ route('tasks') }}" id="createTasksTab">Create New
                        Task</a>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{ route('dispatchedbyme') }}">Dispatched
                        by Me</a>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{ route('mytasks') }}">My Tasks</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('support') }}">I'm Support</a></li>


                <li class="nav-item"><a class="nav-link" href="{{ route('controltask') }}">Task Control</a></li>

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

        <div class="card-body">
            <div class="tab-content">

                {{-- createTasks --}}
                <div class="tab-pane active" id="createTasks">

                    <div class="row justify-content-center col-md-12 mr-1 ml-2">
                        <div class="col-md-3 col-12 ml-1 mr-1 mt-1" style="height: 20%; width: 30%">
                            <form wire:submit.prevent="storeTaskManagementData">


                                <div class="form-group">
                                    <label for="raisedby">Raised by</label>
                                    <select wire:model="raisedby" name="raisedby" id="raisedby" class="form-control"
                                        style="font-size: 12px">
                                        <option value="">Select Raised By</option>
                                        @if (!empty($raisedby_access->raisedby_access))

                                            @foreach (array_filter(explode(';', $raisedby_access->raisedby_access)) as $access)
                                                <option value="{{ $access }}">{{ $access }}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                    @error('raisedby')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror

                                </div>

                                <div class="form-group">
                                    <label for="issue">Issue</label>
                                    <input type="text" class="form-control" wire:model="issue" id="issue"
                                        name="issue" placeholder="Enter issue" style="font-size: 12px">
                                    @error('issue')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="impact">Impact</label>
                                    <input type="text" class="form-control" wire:model="impact" id="impact"
                                        name="impact" placeholder="Enter impact" style="font-size: 12px">
                                    @error('impact')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="rc">RC</label>
                                    <input type="text" class="form-control" wire:model="rc" id="rc"
                                        name="rc" placeholder="Enter RC" style="font-size: 12px">
                                    @error('rc')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror

                                </div>

                                <div class="form-group">
                                    <label for="priority">Priority</label>
                                    <select wire:model="priority" name="priority" id="priority" class="form-control"
                                        style="font-size: 12px">
                                        <option value="">Select Priority</option>
                                        <option value="P1">P1</option>
                                        <option value="P2">P2</option>
                                        <option value="P3">P3</option>
                                        <option value="P4">P4</option>
                                        <option value="P5">P5</option>
                                    </select>
                                    @error('priority')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror

                                </div>

                        </div>
                        <div class="col-md-3 col-12 ml-1 mr-1 mt-1" style="height: 20%; width: 30%">


                            <div class="form-group">
                                <label for="solution">Solution</label>
                                <input type="text" class="form-control" wire:model="solution" id="solution"
                                    name="solution" placeholder="Enter solution" style="font-size: 12px">
                                @error('solution')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror

                            </div>

                            <div class="form-group">
                                <label for="solution2">Solution 2</label>
                                <input type="text" class="form-control" wire:model="solution2" id="solution2"
                                    name="solution2" placeholder="Enter solution 2" style="font-size: 12px">
                                @error('Solution2')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="solution3">Status</label>
                                {{-- <input type="text" class="form-control" wire:model="solution3" id="solution3"
                                    name="solution3" placeholder="Enter Status" style="font-size: 12px"> --}}

                                <select wire:model="solution3" name="solution3" id="solution3" class="form-control"
                                    style="font-size: 12px">
                                    <option value="">Select Status</option>
                                    <option value="Ongoing">Ongoing</option>
                                    <option value="New Requirement">New Requirement</option>
                                    <option value="Currently Not Support">Currently Not Support</option>
                                    <option value="Clarification Required">Clarification Required</option>
                                </select>

                                @error('solution3')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="due_date">Due Date</label>
                                <input type="datetime-local" class="form-control" wire:model="due_date"
                                    id="due_date" name="due_date" style="font-size: 12px">
                                @error('due_date')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="latest_update">Latest Update</label>
                                <input type="text" class="form-control" wire:model="latest_update"
                                    id="latest_update" name="latest_update" placeholder="Enter latest update"
                                    readonly value="{{ now() }}" style="font-size: 12px">
                                @error('latest_update')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        <div class="col-md-4 col-12 ml-1 mr-1 mt-1" style="height: 20%; width: 30%">
                            <div class="form-group">
                                <label for="progress">Progress</label>
                                <input type="text" class="form-control" wire:model="progress" id="progress"
                                    name="progress" placeholder="Enter progress" style="font-size: 12px">
                                @error('progress')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="searchmodalowneropen">Owner</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i style="color: black"
                                                class="fa fa-search"></i></span>
                                    </div>
                                    @if (!empty($stringowner))
                                        <input type="search" name="searchmodalowneropen" id="searchmodalowneropen"
                                            class="form-control" placeholder="{{ $stringowner }}"
                                            wire:click="searchmodalowneropen" style="font-size: 12px">
                                    @else
                                        <input type="search" name="searchmodalowneropen" id="searchmodalowneropen"
                                            class="form-control" placeholder="search"
                                            wire:click="searchmodalowneropen" style="font-size: 12px">
                                    @endif
                                </div>


                                @error('owner')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="searchmodalsupportopen">Support</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i style="color: black"
                                                class="fa fa-search"></i></span>
                                    </div>
                                    @if (!empty($stringsupport))
                                        <input type="search" name="searchmodalsupportopen"
                                            id="searchmodalsupportopen" class="form-control"
                                            placeholder="{{ $stringsupport }}" wire:click="searchmodalsupportopen"
                                            style="font-size: 12px">
                                    @else
                                        <input type="search" name="searchmodalsupportopen"
                                            id="searchmodalsupportopen" class="form-control" placeholder="search"
                                            wire:click="searchmodalsupportopen" style="font-size: 12px">
                                    @endif
                                </div>


                                @error('support')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror


                            </div>


                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" wire:model="description" id="description" name="description" rows="3"
                                    style="font-size: 12px"></textarea>
                                @error('description')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
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



                    </div>
                    <div class="row justify-content-center">
                        <button type="submit" class="btn-xs btn-primary col-md-4"
                            style="font-size: 18px; font-weight:bolder">Submit</button>
                    </div>

                    </form>
                </div>


            </div>
        </div>
    </div>

    {{-- Owner Search Modal --}}
    <div wire:ignore.self class="modal fade" id="viewOwnerSearchModal" tabindex="-1" data-backdrop="static"
        data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-l" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Owner
                    </h5>

                </div>
                <div class="modal-body">

                    <div class="row justify-content-center">
                        <input type="search" name="searchTermFirstOwner" id="searchTermFirstOwner"
                            class="form-control" placeholder="search" wire:model="searchTermFirstOwner">


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
                                    @if (!empty($users_owner))
                                        @foreach ($users_owner as $result)
                                            <tr>
                                                <td> <input class="form-check-input-sm" type="checkbox"
                                                        name={{ $result->email }} value="{{ $result->email }}"
                                                        wire:model="selectedItems">

                                                </td>
                                                <td> {{ $result->name }} </td>
                                                <td> {{ $result->jobid }} </td>

                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3">Search at Least 3 Character To Show Result</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" wire:click="getSelectedOwners">Select
                        Confirm</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"
                        wire:click="searchmodalownerclose">Close</button>
                </div>
            </div>
        </div>
    </div>


    {{-- Support Search Modal --}}
    <div wire:ignore.self class="modal fade" id="viewSupportSearchModal" tabindex="-1" data-backdrop="static"
        data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-l" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Support
                    </h5>

                </div>
                <div class="modal-body">

                    <div class="row justify-content-center">
                        <input type="search" name="searchTermFirstSupport" id="searchTermFirstSupport"
                            class="form-control" placeholder="search" wire:model="searchTermFirstSupport">


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
                                    @if (!empty($users_support))
                                        @foreach ($users_support as $result)
                                            <tr>
                                                <td> <input class="form-check-input-sm" type="checkbox"
                                                        name={{ $result->email }} value="{{ $result->email }}"
                                                        wire:model="supportselectedItems">
                                                </td>
                                                <td> {{ $result->name }} </td>
                                                <td> {{ $result->jobid }} </td>

                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3">Search at Least 3 Character To Show Result</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" wire:click="getSelectedSupports">Select
                        Confirm</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"
                        wire:click="searchmodalsupportclose">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>


@push('scripts')
    <script>
        window.addEventListener('show-view-owner-search-modal', event => {
            $('#viewOwnerSearchModal').modal('show');
        });

        window.addEventListener('show-view-support-search-modal', event => {
            $('#viewSupportSearchModal').modal('show');
        });


        window.addEventListener('close-view-owner-search-modal', event => {
            $('#viewOwnerSearchModal').modal('hide');
        });

        window.addEventListener('close-view-support-search-modal', event => {
            $('#viewSupportSearchModal').modal('hide');
        });
    </script>
@endpush
