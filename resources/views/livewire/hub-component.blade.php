<div wire:poll.180000ms>

    <style>
        .bg-custom {
            background: rgba(255, 255, 255, 0.92);

        }

        .my-container {
            height: 50%;
            width: 50%;
        }

        .my-table {
            height: 100%;
            width: 100%;
            font-size: 10px;
        }

        th,
        td {
            /* Set the width of each column as a percentage of the table's overall width */
            width: 25%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-weight: bold;
            color: azure;
            font-family: "Arial", sans-serif;
        }

        .table-bordered {
            border: 1px solid burlywood;
        }

        .a {
            color: burlywood
        }

        .nav-link {
            font-size: 12px;
            font-weight: bold;

        }
    </style>

    <div class="row justify-content-center">
        <div class="col-md-5 mt-3">

            <div class="card card-widget widget-user">
                <div class="card-footer p-0">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link bg-light">
                                Name <span class="float-right badge ">{{ $user_name }} </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link bg-light">
                                Mail <span class="float-right badge ">{{ Str::upper(request()->user()->email) }}
                                </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link bg-light">
                                Status <span class="float-right badge ">
                                    @if ($status_user == 'active')
                                        Active
                                    @else
                                        {{ $status_user }}
                                    @endif
                                </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link bg-light">
                                Member Since <span class="float-right badge ">{{ $member_since }} </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link bg-light">
                                Access Count <span class="float-right badge ">{{ $access_count }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link bg-light">
                                Login Counts <span class="float-right badge ">{{ $loginHistoryCount }}</span>
                            </a>
                        </li>
                        @if (count($lastTwoLoginHistories) > 1)
                            <li class="nav-item">
                                <a class="nav-link bg-light">
                                    Last Login Time <span
                                        class="float-right badge ">{{ $lastTwoLoginHistories[0]->login_time }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link bg-light">
                                    Last Login IP <span
                                        class="float-right badge ">{{ $lastTwoLoginHistories[0]->ip_address }}</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link bg-light">
                                    Last Second Login Time <span
                                        class="float-right badge ">{{ $lastTwoLoginHistories[1]->login_time }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link bg-light">
                                    Last Second Login IP <span
                                        class="float-right badge ">{{ $lastTwoLoginHistories[1]->ip_address }}</span>
                                </a>
                            </li>
                        @elseif (count($lastTwoLoginHistories) > 0)
                            <li class="nav-item">
                                <a class="nav-link bg-light">
                                    Last Login Time <span
                                        class="float-right badge ">{{ $lastTwoLoginHistories[0]->login_time }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link bg-light">
                                    Last Login IP <span
                                        class="float-right badge ">{{ $lastTwoLoginHistories[0]->ip_address }}</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>


</div>
