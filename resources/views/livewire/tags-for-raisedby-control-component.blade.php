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

                    <h5 style="float: left; color:azure"><strong>All Raised By</strong></h5>
                    <button class="btn btn-sm btn-primary" style="float: right;" data-toggle="modal"
                        data-target="#addRaisedbyModal">Add New Raised By</button>
                </div>
                <div class="ml-4" style="width:50%">
                    <form action="{{ route('upload-excel-as-admin-for-raisedby') }}" method="POST"
                        enctype="multipart/form-data" class="form-inline">
                        @csrf
                        <div class="form-group">
                            <label for="csv_file" class="sr-only">Select CSV File For Raisedby</label>
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

                            <th >ID</th>
                            <th >Raised By</th>
                            <th> Action </th>
                            </tr>
                        </thead>


                        <tbody>
                            @if ($Raisedby->count() > 0)
                                @foreach ($Raisedby as $myraisedby)
                                    <tr>

                                        <td>{{ $myraisedby->id }}</td>
                                        <td>{{ $myraisedby->raisedby_tags }}</td>

                                        <td class="col-md-2" style="text-align: center;">
                                            {{-- <button class="btn btn-sm btn-secondary"
                                                wire:click="viewRaisedbyDetails({{ $myraisedby->id }})">View</button> --}}
                                            <button class="btn btn-xs btn-block btn-primary"
                                                wire:click="editRaisedby({{ $myraisedby->id }})">Edit</button>
                                            <button class="btn btn-xs btn-block btn-danger"
                                                wire:click="deleteConfirmation({{ $myraisedby->id }})">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" style="text-align: center;"><small>No Raised By Found</small>
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
    <div wire:ignore.self class="modal fade" id="addRaisedbyModal" tabindex="-1" data-backdrop="static"
        data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Raisedby</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form method="POST" action="{{ route('raisedbytags.store') }}">
                        @csrf
                    <div class="row justify-content-center">
                        <label for="raisedby_tags" class="col">Raised By</label>
                        <div class="col">
                            <input type="text" id="raisedby_tags" class="form-control" name="raisedby_tags"
                                value="{{ old('raisedby_tags') }}">
                            @error('raisedby_tags')
                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>


                    <div class="row justify-content-center">
                        <label for="" class="col-3"></label>
                        <div class="col-9">
                            <button type="submit" class="btn btn-sm btn-primary">Add Raised By</button>
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"
                                wire:click="closeModalAdd">Close</button>
                        </div>
                    </div>



                    </form>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="editRaisedbyModal" tabindex="-1" data-backdrop="static"
        data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form wire:submit.prevent="editRaisedbyData">

                        <div class="row justify-content-center">
                            <div class="col">
                                <label for="raisedby_tags" class="col">Raised By</label>
                                <div class="col">
                                    <input type="text" id="raisedby_tags" class="form-control"
                                        wire:model="raisedby_tags">
                                    @error('raisedby_tags')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="row justify-content-center">
                                <label for="" class="col5"></label>
                                <div class="col5">
                                    <button type="submit" class="btn btn-sm btn-primary mt-2">Edit Raised By</button>
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

    <div wire:ignore.self class="modal fade" id="deleteRaisedbyModal" tabindex="-1" data-backdrop="static"
        data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="closeModalDelete">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-4 pb-4">
                    <h6>Are you sure? You want to delete this Raisedby data!</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"
                        wire:click="closeModalDelete">Close</button>
                    <button class="btn btn-sm btn-danger" wire:click="deleteRaisedByData()">Yes! Delete</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="viewRaisedbyModal" tabindex="-1" data-backdrop="static"
        data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content modal-content-bg bg-light">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Raised By Information</h5>
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
                                <th class="bg-primary">Rised By:</th>
                                <td class="bg-info">{{ $view_raisedby_tags }}</td>

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

</div>

@push('scripts')
    <script>
        window.addEventListener('show-edit-raisedby-modal', event => {
            $('#editRaisedbyModal').modal('show');
        });

        window.addEventListener('show-delete-confirmation-modal', event => {
            $('#deleteRaisedbyModal').modal('show');
        });

        window.addEventListener('show-view-raisedby-modal', event => {
            $('#viewRaisedbyModal').modal('show');
        });

        window.addEventListener('close-modal-view', event => {
            $('#viewRaisedbyModal').modal('hide');
        });

        window.addEventListener('close-modal-delete', event => {
            $('#deleteRaisedbyModal').modal('hide');
        });

        window.addEventListener('close-modal-edit', event => {
            $('#editRaisedbyModal').modal('hide');
        });

        window.addEventListener('close-modal-add', event => {
            $('#addRaisedbyModal').modal('hide');
        });
    </script>
@endpush
