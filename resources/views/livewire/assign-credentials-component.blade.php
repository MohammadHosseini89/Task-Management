<div wire:poll.700ms>
    <style>
        .bg-custom {

            background:
                rgb(9, 9, 9);
        }

        .modal-body {
            background: linear-gradient(to bottom,
                    rgba(10, 4, 27, 0.7),
                    rgba(1, 1, 2, 0.7));
        }

        .form-group {
            color: bisque;
            font-size: 10px;
        }


        .table-bordered {
            vertical-align: middle;
            text-align: center;
        }

        .table-bordered td,
        .table-bordered th {
            /* padding: 0;
            margin: 0; */
            text-align: center;
            line-height: 1.5;
            font-size: 12px;
            font-weight: bolder;
            color: bisque;
            vertical-align: middle;


        }

        .card {
            background: linear-gradient(to bottom,
                    rgba(10, 4, 27, 0.7),
                    rgba(1, 1, 2, 0.7));
        }

        .nav-link {
            font-size: 12px;
            font-weight: bold;

        }
    </style>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="row mt5" style="width:100%;">
        <div class="col-md-12 mt-1 ml-2">
            <div class="card">
                <div class="card-header">
                    <h5 style="float: left; color:azure"><strong>All User Credentials</strong></h5>
                    {{-- <button class="btn btn-sm btn-primary" style="float: right;" data-toggle="modal"
                        data-target="#addCredentialModal">Add New Credential To User</button> --}}
                </div>
                <div class="ml-4" style="width:50%">
                    <form action="{{ route('teams.import') }}" method="POST" enctype="multipart/form-data"
                        class="form-inline">
                        @csrf
                        <div class="form-group">
                            <label for="csv_file" class="sr-only">Select CSV File For Assign Credentials</label>
                            <input type="file" name="csv_file" class="form-control-file" id="csv_file">
                        </div>
                        <button type="submit" class="btn btn-primary ml-2">Upload</button>
                    </form>
                </div>

                <div class="card-body table-hover text-nowrap p-1 ml-2">
                    @if (session()->has('message'))
                        <div class="alert alert-success text-center">{{ session('message') }}</div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <input type="search" class="form-control w-25" placeholder="search" wire:model="searchTerm"
                                style="float: right;" />
                        </div>
                    </div>

                    <table class="table table-hover table-bordered  -xl text-nowrap p-1"
                        style=" height: 100%; width: 100%; text-align: center; font-size:12px;">
                        <thead class="bg-dark">

                            <th>ID</th>
                            <th>Email</th>
                            <th>User ID</th>
                            <th>Team Name</th>
                            <th>Position Name</th>
                            <th>Access to RaisedBy</th>
                            <th>Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            @if ($teams->count() > 0)
                                @foreach ($teams as $myteamdata)
                                    <tr>

                                        <td>{{ $myteamdata->id }}</td>
                                        <td>{{ $myteamdata->email }}</td>
                                        <td>{{ $myteamdata->user_id }}</td>
                                        <td>{{ $myteamdata->team_name }}</td>
                                        <td>{{ $myteamdata->position_name }}</td>
                                        <td>{{ $myteamdata->raisedby_access }}</td>

                                        <td class="col-md-2" style="text-align: center;">
                                            <button class="btn btn-xs btn-block btn-primary"
                                                wire:click="editeMyTeams({{ $myteamdata->id }})">Edit</button>
                                            <button class="btn btn-xs btn-block btn-danger"
                                                wire:click="deleteConfirmation({{ $myteamdata->id }})">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" style="text-align: center;"><small>No Credentials Found</small>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    {{-- <div wire:ignore.self class="modal fade" id="addCredentialModal" tabindex="-1" data-backdrop="static"
        data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Credential</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form method="POST" action="{{ route('raisedbytags.store') }}">
                        @csrf
                        <div class="row justify-content-center">
                            <label for="team_name" class="col">Team</label>
                            <div class="col">
                                <input type="text" id="team_name" class="form-control" name="team_name"
                                    value="{{ old('team_name') }}">
                                @error('team_name')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="position_name" class="col">Position</label>
                            <div class="col">
                                <input type="text" id="position_name" class="form-control" name="position_name"
                                    value="{{ old('position_name') }}">
                                @error('position_name')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="raisedby_access" class="col">Raised By Access</label>
                            <div class="col">
                                <input type="text" id="raisedby_access" class="form-control" name="raisedby_access"
                                    value="{{ old('raisedby_access') }}">
                                @error('raisedby_access')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>


                        <div class="row justify-content-center">
                            <label for="" class="col-3"></label>
                            <div class="col-9">
                                <button type="submit" class="btn btn-sm btn-primary">Add Cedentials</button>
                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"
                                    wire:click="closeModalAdd">Close</button>
                            </div>
                        </div>



                    </form>
                </div>
            </div>
        </div>
    </div> --}}

    <div wire:ignore.self class="modal fade" id="editMyTeamsModal" tabindex="-1" data-backdrop="static"
        data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Credentials</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form wire:submit.prevent="editMyTeamsData">

                        <div class="row justify-content-center">
                            <div class="col">
                                <label for="team_name" class="col">Team</label>
                                <div class="col">
                                    <input type="text" id="team_name" class="form-control" wire:model="team_name">
                                    @error('team_name')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col">
                                <label for="position_name" class="col">Position</label>
                                <div class="col">
                                    <input type="text" id="position_name" class="form-control"
                                        wire:model="position_name">
                                    @error('position_name')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col">
                                <label for="searchmodalraisedbyaccessopen" class="col">Raised By Access</label>
                                <div class="col">
                                    @if (!empty($stringraisedbyaccess_edit))
                                        <input type="search" name="searchmodalraisedbyaccessopen"
                                            id="searchmodalraisedbyaccessopen" class="form-control"
                                            placeholder="{{ $stringraisedbyaccess_edit }}"
                                            wire:click="searchmodalraisedbyaccessopen">
                                    @else
                                        <input type="search" name="searchmodalraisedbyaccessopen"
                                            id="searchmodalraisedbyaccessopen" class="form-control"
                                            placeholder="{{ $raisedby_access }}" wire:click="searchmodalraisedbyaccessopen">
                                    @endif

                                    @error('searchmodalraisedbyaccessopen')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="row justify-content-center">
                                <div class="col5">
                                    <button type="submit" class="btn btn-sm btn-primary mt-2">Edit
                                        Credentials</button>
                                    <button type="button" class="btn btn-sm btn-secondary mt-2" data-dismiss="modal"
                                        wire:click="closeModalEdit">Close</button>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="deleteMyTeamsModal" tabindex="-1" data-backdrop="static"
        data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click="closeModalDelete">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-4 pb-4">
                    <h6>Are you sure? You want to delete this Credential data!</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"
                        wire:click="closeModalDelete">Close</button>
                    <button class="btn btn-sm btn-danger" wire:click="deleteMyTeamsData()">Yes! Delete</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="viewMyTeamsModal" tabindex="-1" data-backdrop="static"
        data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content modal-content-bg bg-light">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Credentials Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click="closeViewUserModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-fixed w-auto table-hover text-nowrap p-0"
                        style="text-align: center; font-size: 12.5px;">
                        <tbody>
                            <tr>
                                <th class="bg-primary">Team:</th>
                                <td class="bg-info">{{ $view_team_name }}</td>
                                <th class="bg-primary">Position:</th>
                                <td class="bg-info">{{ $view_position_name }}</td>
                                <th class="bg-primary">Rised By Access:</th>
                                <td class="bg-info">{{ $view_raisedby_access }}</td>

                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click="closeModalView">Close</button>
                </div>
            </div>
        </div>

    </div>

        {{-- Raised By Search Modal --}}
        <div wire:ignore.self class="modal fade" id="viewRaisedbyaccessSearchModal" tabindex="-1" data-backdrop="static"
        data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-l" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Raisedby Access
                    </h5>

                </div>
                <div class="modal-body">

                    <div class="row justify-content-center">
                        <input type="search" name="searchTermFirstRaisedbyEdit" id="searchTermFirstRaisedbyEdit"
                            class="form-control" placeholder="search" wire:model="searchTermFirstRaisedbyEdit">


                        <div class="col-md-9 mt-1">


                            <table class="table table-bordered table-hover table-modal-search-owner">
                                <thead>
                                    <tr>
                                        <th>Select</th>
                                        <th>Raised By Access</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($raisedby_access_edit))
                                        @foreach ($raisedby_access_edit as $result)
                                            <tr>
                                                <td> <input class="form-check-input-sm" type="checkbox"
                                                        name={{ $result->raisedby_tags }} value="{{ $result->raisedby_tags }}"
                                                        wire:model="selectedItems_edit">

                                                </td>
                                                <td> {{ $result->raisedby_tags }} </td>

                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3" class="bg-secondary">Search at Least 1
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
                    <button type="button" class="btn btn-sm btn-primary" wire:click="getSelectedAccessRaisedByEdit">Select
                        Confirm</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"
                        wire:click="searchmodalraisedbyaccessclose">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script>
        window.addEventListener('show-edit-myteams-modal', event => {
            $('#editMyTeamsModal').modal('show');
        });

        window.addEventListener('show-delete-confirmation-modal', event => {
            $('#deleteMyTeamsModal').modal('show');
        });

        window.addEventListener('show-view-myteams-modal', event => {
            $('#viewMyTeamsModal').modal('show');
        });

        window.addEventListener('show-view-raisedbyaccess-edit-search-modal', event => {
            $('#viewRaisedbyaccessSearchModal').modal('show');
        });

        window.addEventListener('close-modal-view', event => {
            $('#viewMyTeamsModal').modal('hide');
        });

        window.addEventListener('close-modal-delete', event => {
            $('#deleteMyTeamsModal').modal('hide');
        });

        window.addEventListener('close-modal-edit', event => {
            $('#editMyTeamsModal').modal('hide');
        });

        window.addEventListener('close-modal-add', event => {
            $('#addCredentialModal').modal('hide');
        });

        window.addEventListener('close-view-raisedbyaccess-edit-search-modal', event => {
            $('#viewRaisedbyaccessSearchModal').modal('hide');
        });

    </script>
@endpush
