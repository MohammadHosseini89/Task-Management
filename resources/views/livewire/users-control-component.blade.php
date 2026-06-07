<div wire:poll.700ms>
    <style>
        .bg-custom {
            background: linear-gradient(to bottom,
                    rgba(41, 11, 125, 0.7),
                    rgba(54, 23, 233, 0.7));
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

                    <h5 style="float: left;"><strong>All Users</strong></h5>
                    <button class="btn btn-sm btn-primary" style="float: right;" data-toggle="modal"
                        data-target="#addUserModal">Add New User</button>
                </div>
                <div class="ml-4" style="width:50%">
                    <form action="{{ route('upload-excel-as-admin-for-users') }}" method="POST"
                        enctype="multipart/form-data" class="form-inline">
                        @csrf
                        <div class="form-group">
                            <label for="csv_file" class="sr-only">Select CSV File For Users</label>
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

                    <table class="table table-hover  table-responsive  table-bordered  -xl text-nowrap p-1"
                        style=" height: 100%; width: 100%; text-align: center; font-size:12px;">
                        <thead>
                            <th> Action </th>
                            <th wire:click="sortBy('id')" style="cursor: pointer">ID</th>
                            <th wire:click="sortBy('name')" style="cursor: pointer">Name</th>
                            <th wire:click="sortBy('email')" style="cursor: pointer">Email</th>
                            <th wire:click="sortBy('phone')" style="cursor: pointer">Phone</th>
                            <th wire:click="sortBy('status')" style="cursor: pointer">Status</th>
                            <th wire:click="sortBy('jobid')" style="cursor: pointer">Job ID</th>
                            <th wire:click="sortBy('is_superuser')" style="cursor: pointer">SuperUser</th>
                            <th wire:click="sortBy('route1')" style="cursor: pointer">Team Manager</th>
                            <th wire:click="sortBy('route2')" style="cursor: pointer">Route2</th>
                            <th wire:click="sortBy('route3')" style="cursor: pointer">Route3</th>
                            <th wire:click="sortBy('route4')" style="cursor: pointer">Route4</th>
                            <th wire:click="sortBy('route5')" style="cursor: pointer">Route5</th>
                            <th wire:click="sortBy('route6')" style="cursor: pointer">Route6</th>
                            <th wire:click="sortBy('route7')" style="cursor: pointer">Route7</th>
                            <th wire:click="sortBy('route8')" style="cursor: pointer">Route8</th>
                            <th wire:click="sortBy('route9')" style="cursor: pointer">route9</th>
                            <th wire:click="sortBy('route10')" style="cursor: pointer">route10</th>
                            <th wire:click="sortBy('route11')" style="cursor: pointer">route11</th>
                            <th wire:click="sortBy('route12')" style="cursor: pointer">route12</th>
                            <th wire:click="sortBy('route13')" style="cursor: pointer">route13</th>
                            <th wire:click="sortBy('route14')" style="cursor: pointer">route14</th>
                            <th wire:click="sortBy('route15')" style="cursor: pointer">route15</th>
                            <th wire:click="sortBy('route16')" style="cursor: pointer">route16</th>
                            <th wire:click="sortBy('route17')" style="cursor: pointer">route17</th>
                            <th wire:click="sortBy('route18')" style="cursor: pointer">route18</th>
                            <th wire:click="sortBy('password')" style="cursor: pointer">Password</th>

                            </tr>
                        </thead>


                        <tbody>
                            @if ($users->count() > 0)
                                @foreach ($users as $user)
                                    <tr>
                                        <td style="text-align: center;">
                                            <button class="btn btn-sm btn-secondary"
                                                wire:click="viewUserDetails({{ $user->id }})">View</button>
                                            <button class="btn btn-sm btn-primary"
                                                wire:click="editUsers({{ $user->id }})">Edit</button>
                                            <button class="btn btn-sm btn-danger"
                                                wire:click="deleteConfirmation({{ $user->id }})">Delete</button>
                                        </td>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->status }}</td>
                                        <td>{{ $user->jobid }}</td>
                                        <td>{{ $user->is_superuser }}</td>
                                        <td>{{ $user->route1 }}</td>
                                        <td>{{ $user->route2 }}</td>
                                        <td>{{ $user->route3 }}</td>
                                        <td>{{ $user->route4 }}</td>
                                        <td>{{ $user->route5 }}</td>
                                        <td>{{ $user->route6 }}</td>
                                        <td>{{ $user->route7 }}</td>
                                        <td>{{ $user->route8 }}</td>
                                        <td>{{ $user->route9 }}</td>
                                        <td>{{ $user->route10 }}</td>
                                        <td>{{ $user->route11 }}</td>
                                        <td>{{ $user->route12 }}</td>
                                        <td>{{ $user->route13 }}</td>
                                        <td>{{ $user->route14 }}</td>
                                        <td>{{ $user->route15 }}</td>
                                        <td>{{ $user->route16 }}</td>
                                        <td>{{ $user->route17 }}</td>
                                        <td>{{ $user->route18 }}</td>
                                        <td>{{ $user->password }}</td>


                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" style="text-align: center;"><small>No User Found</small></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="addUserModal" tabindex="-1" data-backdrop="static"
        data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf
                        <div class="row justify-content-center">
                            <label for="name" class="col">Name</label>
                            <div class="col">
                                <input type="text" id="name" class="form-control" name="name"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="email" class="col">email</label>
                            <div class="col">
                                <input type="text" id="email" class="form-control" name="email"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="status" class="col">Status</label>
                            <div class="col">
                                <input type="text" id="status" class="form-control" name="status"
                                    value="{{ old('status') }}">
                                @error('status')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="is_superuser" class="col">Is Superuser</label>
                            <div class="col">
                                <input type="text" id="is_superuser" class="form-control" name="is_superuser"
                                    value="{{ old('is_superuser') }}">
                                @error('is_superuser')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="row justify-content-center">
                            <label for="route1" class="col">Team Manager</label>
                            <div class="col">
                                <input type="text" id="route1" class="form-control" name="route1"
                                    value="{{ old('route1') }}">
                                @error('route1')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="route2" class="col">Route2</label>
                            <div class="col">
                                <input type="text" id="route2" class="form-control" name="route2"
                                    value="{{ old('route2') }}">
                                @error('route2')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="route3" class="col">Route3</label>
                            <div class="col">
                                <input type="text" id="route3" class="form-control" name="route3"
                                    value="{{ old('route3') }}">
                                @error('route3')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="route5" class="col">Route5</label>
                            <div class="col">
                                <input type="text" id="route5" class="form-control" name="route5"
                                    value="{{ old('route5') }}">
                                @error('route5')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <label for="route6" class="col">Route6</label>
                            <div class="col">
                                <input type="text" id="route6" class="form-control" name="route6"
                                    value="{{ old('route6') }}">
                                @error('route6')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="route7" class="col">Route7</label>
                            <div class="col">
                                <input type="text" id="route7" class="form-control" name="route7"
                                    value="{{ old('route7') }}">
                                @error('route7')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="route8" class="col">Route8</label>
                            <div class="col">
                                <input type="text" id="route8" class="form-control" name="route8"
                                    value="{{ old('route8') }}">
                                @error('route8')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="route9" class="col">Route9</label>
                            <div class="col">
                                <input type="text" id="route9" class="form-control" name="route9"
                                    value="{{ old('route9') }}">
                                @error('route9')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>


                        </div>

                        <div class="row justify-content-center">
                            <label for="route10" class="col">Route10</label>
                            <div class="col">
                                <input type="text" id="route10" class="form-control" name="route10"
                                    value="{{ old('route10') }}">
                                @error('route10')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="route11" class="col">Route11</label>
                            <div class="col">
                                <input type="text" id="route11" class="form-control" name="route11"
                                    value="{{ old('route11') }}">
                                @error('route11')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="route12" class="col">Route12</label>
                            <div class="col">
                                <input type="text" id="route12" class="form-control" name="route12"
                                    value="{{ old('route12') }}">
                                @error('route12')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="route13" class="col">Route13</label>
                            <div class="col">
                                <input type="text" id="route13" class="form-control" name="route13"
                                    value="{{ old('route13') }}">
                                @error('route13')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>


                        </div>

                        <div class="row justify-content-center">
                            <label for="route14" class="col">Route14</label>
                            <div class="col">
                                <input type="text" id="route14" class="form-control" name="route14"
                                    value="{{ old('route14') }}">
                                @error('route14')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="route15" class="col">Route15</label>
                            <div class="col">
                                <input type="text" id="route15" class="form-control" name="route15"
                                    value="{{ old('route15') }}">
                                @error('route15')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="route16" class="col">Route16</label>
                            <div class="col">
                                <input type="text" id="route16" class="form-control" name="route16"
                                    value="{{ old('route16') }}">
                                @error('route16')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="route17" class="col">Route17</label>
                            <div class="col">
                                <input type="text" id="route17" class="form-control" name="route17"
                                    value="{{ old('route17') }}">
                                @error('route17')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <label for="route18" class="col">Route18</label>
                            <div class="col">
                                <input type="text" id="route18" class="form-control" name="route18"
                                    value="{{ old('route18') }}">
                                @error('route18')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="phone" class="col">Phone</label>
                            <div class="col">
                                <input type="text" id="phone" class="form-control" name="phone"
                                    value="{{ old('phone') }}">
                                @error('phone')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="route4" class="col">Route4</label>
                            <div class="col">
                                <input type="text" id="route4" class="form-control" name="route4"
                                    value="{{ old('route4') }}">
                                @error('route4')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="password" class="col">Password</label>
                            <div class="col">
                                <input type="password" id="password" class="form-control" name="password"
                                    value="{{ old('password') }}">
                                @error('password')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <br>

                        <div class="row justify-content-center">
                            <div class="col-9">
                                <button type="submit" class="btn btn-sm btn-primary">Add User</button>
                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"
                                    wire:click="closeModalAdd">Close</button>
                            </div>
                        </div>



                    </form>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="editUserModal" tabindex="-1" data-backdrop="static"
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

                    <form wire:submit.prevent="editUserData">

                        <div class="row justify-content-center">
                            <div class="col">
                                <label for="name_edit" class="col">Name</label>
                                <div class="col">
                                    <input type="text" id="name_edit" class="form-control" wire:model="name">
                                    @error('name')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col">
                                <label for="email_edit" class="col">Email</label>
                                <div class="col">
                                    <input type="text" id="email_edit" class="form-control" wire:model="email">
                                    @error('email')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>



                            <div class="col">
                                <label for="status_edit" class="col">Status</label>
                                <div class="col">
                                    <input type="text" id="status_edit" class="form-control" wire:model="status">
                                    @error('status')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col">
                                <label for="is_superuser_edit" class="col">Is Superuser</label>
                                <div class="col">
                                    <input type="text" id="is_superuser_edit" class="form-control"
                                        wire:model="is_superuser">
                                    @error('is_superuser')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col">
                                <label for="route1_edit" class="col">Team Manager</label>
                                <div class="col">
                                    <input type="route1" id="route1_edit" class="form-control" wire:model="route1">
                                    @error('route1')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>



                            <div class="col">
                                <label for="route2_edit" class="col">Route2</label>
                                <div class="col">
                                    <input type="text" id="route2_edit" class="form-control" wire:model="route2">
                                    @error('route2')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col">
                                <label for="route3_edit" class="col">Route3</label>
                                <div class="col">
                                    <input type="text" id="route3_edit" class="form-control" wire:model="route3">
                                    @error('route3')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col">
                                <label for="route5_edit" class="col">Route5</label>
                                <div class="col">
                                    <input type="text" id="route5_edit" class="form-control" wire:model="route5">
                                    @error('route5')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col">
                                <label for="route6_edit" class="col">Route6</label>
                                <div class="col">
                                    <input type="text" id="route6_edit" class="form-control" wire:model="route6">
                                    @error('route6')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col">
                                <label for="route7_edit" class="col">Route7</label>
                                <div class="col">
                                    <input type="text" id="route7_edit" class="form-control" wire:model="route7">
                                    @error('route7')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col">
                                <label for="route8_edit" class="col">Route8</label>
                                <div class="col">
                                    <input type="text" id="route8_edit" class="form-control" wire:model="route8">
                                    @error('route8')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col">
                                <label for="route9_edit" class="col">Route9</label>
                                <div class="col">
                                    <input type="text" id="route9_edit" class="form-control" wire:model="route9">
                                    @error('route9')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col">
                                <label for="route10_edit" class="col">Route10</label>
                                <div class="col">
                                    <input type="text" id="route10_edit" class="form-control" wire:model="route10">
                                    @error('route10')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="row justify-content-center">
                            <div class="col">
                                <label for="route11_edit" class="col">Route11</label>
                                <div class="col">
                                    <input type="text" id="route11_edit" class="form-control" wire:model="route11">
                                    @error('route11')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col">
                                <label for="route12_edit" class="col">Route12</label>
                                <div class="col">
                                    <input type="text" id="route12_edit" class="form-control" wire:model="route12">
                                    @error('route12')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col">
                                <label for="route13_edit" class="col">Route13</label>
                                <div class="col">
                                    <input type="text" id="route13_edit" class="form-control" wire:model="route13">
                                    @error('route13')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col">
                                <label for="route14_edit" class="col">Route14</label>
                                <div class="col">
                                    <input type="text" id="route14_edit" class="form-control" wire:model="route14">
                                    @error('route14')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col">
                                <label for="route15_edit" class="col">Route15</label>
                                <div class="col">
                                    <input type="text" id="route15_edit" class="form-control" wire:model="route15">
                                    @error('route15')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col">
                                <label for="route16_edit" class="col">Route15</label>
                                <div class="col">
                                    <input type="text" id="route16_edit" class="form-control" wire:model="route16">
                                    @error('route16')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col">
                                <label for="route17_edit" class="col">Route17</label>
                                <div class="col">
                                    <input type="text" id="route17_edit" class="form-control" wire:model="route17">
                                    @error('route17')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col">
                                <label for="route18_edit" class="col">Route18</label>
                                <div class="col">
                                    <input type="text" id="route18_edit" class="form-control" wire:model="route18">
                                    @error('route18')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="row justify-content-center">
                            <div class="col">
                                <label for="phone_edit" class="col">Phone</label>
                                <div class="col">
                                    <input type="text" id="phone_edit" class="form-control" wire:model="phone">
                                    @error('phone')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col">
                                <label for="route4_edit" class="col">Route4</label>
                                <div class="col">
                                    <input type="text" id="route4_edit" class="form-control" wire:model="route4">
                                    @error('route4')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col">
                                <label for="password_edit" class="col">Password</label>
                                <div class="col">
                                    <input type="password" id="password_edit" class="form-control"
                                        wire:model="password">
                                    @error('password')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="form-group row justify-content-center">
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="change_password" wire:model="changePassword">
                                    <label class="form-check-label" for="change_password">
                                        Check for Reset Password
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <div class="row justify-content-center">
                                <div class="col5">
                                    <button type="submit" class="btn btn-sm btn-primary mt-2">Edit User</button>
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

    <div wire:ignore.self class="modal fade" id="deleteUserModal" tabindex="-1" data-backdrop="static"
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
                    <h6>Are you sure? You want to delete this User data!</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"
                        wire:click="closeModalDelete">Close</button>
                    <button class="btn btn-sm btn-danger" wire:click="deleteUserData()">Yes! Delete</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="viewUserModal" tabindex="-1" data-backdrop="static"
        data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content modal-content-bg bg-light">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">User Information</h5>
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
                                <th class="bg-primary">Name:</th>
                                <td class="bg-info">{{ $view_user_name }}</td>
                                <th class="bg-primary">Email:</th>
                                <td class="bg-info">{{ $view_user_email }}</td>
                                <th class="bg-primary">Status:</th>
                                <td class="bg-info">{{ $view_user_status }}</td>
                                <th class="bg-primary">Phone:</th>
                                <td class="bg-info">{{ $view_user_phone }}</td>

                            </tr>

                            <tr>
                                <th class="bg-primary">Is Superuser:</th>
                                <td class="bg-info">{{ $view_user_is_superuser }}</td>
                                <th class="bg-primary">Team Manager:</th>
                                <td class="bg-info">{{ $view_user_route1 }}</td>
                                <th class="bg-primary">Route2:</th>
                                <td class="bg-info">{{ $view_user_route2 }}</td>
                                <th class="bg-primary">Route3:</th>
                                <td class="bg-info">{{ $view_user_route3 }}</td>

                            </tr>

                            <tr>
                                <th class="bg-primary">Route4:</th>
                                <td class="bg-info">{{ $view_user_route4 }}</td>
                                <th class="bg-primary">Route5:</th>
                                <td class="bg-info">{{ $view_user_route5 }}</td>
                                <th class="bg-primary">Route6:</th>
                                <td class="bg-info">{{ $view_user_route6 }}</td>
                                <th class="bg-primary">Route7:</th>
                                <td class="bg-info">{{ $view_user_route7 }}</td>

                            </tr>

                            <tr>
                                <th class="bg-primary">Route8:</th>
                                <td class="bg-info">{{ $view_user_route8 }}</td>
                                <th class="bg-primary">Route9:</th>
                                <td class="bg-info">{{ $view_user_route9 }}</td>
                                <th class="bg-primary">Route10:</th>
                                <td class="bg-info">{{ $view_user_route10 }}</td>
                                <th class="bg-primary">Route11:</th>
                                <td class="bg-info">{{ $view_user_route11 }}</td>

                            </tr>

                            <tr>
                                <th class="bg-primary">Route12:</th>
                                <td class="bg-info">{{ $view_user_route12 }}</td>
                                <th class="bg-primary">Route13:</th>
                                <td class="bg-info">{{ $view_user_route13 }}</td>
                                <th class="bg-primary">Route14:</th>
                                <td class="bg-info">{{ $view_user_route14 }}</td>
                                <th class="bg-primary">Route15:</th>
                                <td class="bg-info">{{ $view_user_route15 }}</td>

                            </tr>

                            <tr>
                                <th class="bg-primary">Route16:</th>
                                <td class="bg-info">{{ $view_user_route16 }}</td>
                                <th class="bg-primary">Route17:</th>
                                <td class="bg-info">{{ $view_user_route17 }}</td>
                                <th class="bg-primary">Route18:</th>
                                <td class="bg-info">{{ $view_user_route18 }}</td>
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
        window.addEventListener('show-edit-user-modal', event => {
            $('#editUserModal').modal('show');
        });

        window.addEventListener('show-delete-confirmation-modal', event => {
            $('#deleteUserModal').modal('show');
        });

        window.addEventListener('show-view-user-modal', event => {
            $('#viewUserModal').modal('show');
        });

        window.addEventListener('close-modal-view', event => {
            $('#viewUserModal').modal('hide');
        });

        window.addEventListener('close-modal-delete', event => {
            $('#deleteUserModal').modal('hide');
        });

        window.addEventListener('close-modal-edit', event => {
            $('#editUserModal').modal('hide');
        });

        window.addEventListener('close-modal-add', event => {
            $('#addUserModal').modal('hide');
        });
    </script>
@endpush
