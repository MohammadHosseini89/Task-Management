<div wire:poll.120000ms>
    <style>
        .bg-custom {

            background:
                rgb(9, 9, 9);
        }

        .form-group {
            color: bisque;

        }
    </style>

    {{-- {{ dd( request()->user()->load('asssignusertoteam')->asssignusertoteam->pluck('team_name')->contains('Management') ) }} --}}
    {{-- {{ dd(implode(',' , request()->user()->load('asssignusertoteam')->asssignusertoteam->pluck('team_name')->toArray())) }} --}}

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('message'))
        <div class="alert alert-success text-center">{{ session('message') }}</div>
    @endif

    <div class="row justify-content ml-1">
        <div class="col-md-12 col-12 ml-2 mr-3 mt-1" style="height: 20%; width: 30%">
            <div class="ml-4" style="width:50%">
                <form action="{{ route('teams.import') }}" method="POST" enctype="multipart/form-data"
                    class="form-inline">
                    @csrf
                    <div class="form-group">
                        <label for="csv_file" class="sr-only">Select CSV For Teams</label>
                        <input type="file" name="csv_file" class="form-control-file" id="csv_file">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary ml-2">Upload</button>
                </form>
            </div>
        </div>
    </div>

    <br>

    <div class="row justify-content ml-1">
        <div class="col-md-4 col-12 ml-2 mr-3 mt-1" style="height: 20%; width: 30%">

            <form method="POST" action="{{ route('teams.assign.submit') }}">
                @csrf
                <div class="form-group">
                    <label for="user">Select User:</label>
                    <select name="user" id="user" class="form-control">
                        <option>Select User:</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="team">Select Team:</label>
                    <select name="team" id="team" class="form-control">
                        <option value="new_team">Create New Team</option>
                        @foreach ($teams->pluck('team_name')->unique() as $team_name)
                            <option value="{{ $team_name }}">{{ $team_name }}</option>
                        @endforeach

                    </select>
                </div>
                <div class="form-group">
                    <label for="position">Select Position:</label>
                    <select name="position" id="position" class="form-control">
                        <option value="new_position">Create New Position</option>
                        @foreach ($teams->pluck('position_name')->unique() as $position_name)
                            <option value="{{ $position_name }}">{{ $position_name }}</option>
                        @endforeach

                    </select>
                </div>

                <div id="new-team" class="form-group">
                    <label for="new_team_name">Create New Team:</label>
                    <input type="text" name="new_team_name" id="new_team_name" class="form-control">
                </div>
                <div id="new-position" class="form-group">
                    <label for="new_position_name">Create New Position:</label>
                    <input type="text" name="new_position_name" id="new_position_name" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Assign User to Team & Position</button>
            </form>

        </div>

        

    </div>
    <br>
</div>
