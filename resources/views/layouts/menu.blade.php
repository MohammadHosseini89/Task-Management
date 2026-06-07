<!-- need to remove -->
<style>
    p {
        font-size: 12px;
        color: rgb(6, 0, 71);
        font-weight: bold;
    }
</style>

<li class="nav-item">
    <a href="{{ route('welcome') }}" class="nav-link {{ Request::is('welcome') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li>

@if (request()->user()->isSuperUser())
    <li class="nav-item menu-is-opening">
        <a class="nav-link {{ Request::is('user-control', 'admin', 'teamsassign', 'assign-credentials-control', 'raisedbycontrol', 'user-control-admin', 'batch-interface') ? 'active' : '' }}"
            class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
                Admin
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>

        <ul class="nav nav-treeview">



            @if (request()->user()->isSuperUser())
                <li class="nav-item">
                    <a href="{{ route('user-control') }}"
                        class="nav-link {{ Request::is('user-control') ? 'active' : '' }}">
                        <i class="nav-icon far fa-plus-square">

                        </i>
                        <p>User Control</p>
                    </a>
                </li>
            @endif

            @if (request()->user()->isSuperUser())
                <li class="nav-item">
                    <a href="{{ route('assign-credentials-controll') }}"
                        class="nav-link {{ Request::is('assign-credentials-controll') ? 'active' : '' }}">
                        <i class="nav-icon far fa-plus-square">

                        </i>
                        <p>Credentials Control</p>
                    </a>
                </li>
            @endif



            @if (request()->user()->isSuperUser())
                <li class="nav-item">
                    <a href="{{ route('admin') }}" class="nav-link {{ Request::is('admin') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-copy">

                        </i>
                        <p>System View</p>
                    </a>
                </li>
            @endif

            {{-- @if (request()->user()->isSuperUser())
                <li class="nav-item">
                    <a href="{{ route('teamsassign') }}"
                        class="nav-link {{ Request::is('teamsassign') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th">

                        </i>
                        <p>Assign Teams</p>
                    </a>
                </li>
            @endif --}}



            @if (request()->user()->isSuperUser())
                <li class="nav-item">
                    <a href="{{ route('raisedbycontrol') }}"
                        class="nav-link {{ Request::is('raisedbycontrol') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file">

                        </i>
                        <p>Raised By Control</p>
                    </a>
                </li>
            @endif

            @if (request()->user()->isSuperUser())
                <li class="nav-item">
                    <a href="{{ route('batch-interface') }}"
                        class="nav-link {{ Request::is('batch-interface') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file" style="color:rgb(75, 75, 179)">

                        </i>
                        <p>Batch</p>
                    </a>
                </li>
            @endif


        </ul>
    </li>
@endif

<li class="nav-item">
    <a href="{{ route('tasks') }}"
        class="nav-link {{ Request::is(
            'tasks/create',
            'tasks/dispatchedbyme',
            'tasks/mytasks',
            'tasks/imsupport',
            'tasks/cancelled',
            'tasks/control',
            'tasks/completed',
        )
            ? 'active'
            : '' }}">

        <i class="nav-icon fas fa-columns"></i>
        <p>Task Management</p>
    </a>
</li>



@if (request()->user()->isSuperUser() || request()->user()->isteammanager())
    <li class="nav-item">
        <a href="{{ route('team-manager') }}" class="nav-link {{ Request::is('team-manager') ? 'active' : '' }}">
            <i class="nav-icon fas fa-th"></i>
            <p>Team Manager View</p>
        </a>
    </li>
@endif


@if (request()->user()->isSuperUser())
    <li class="nav-item">
        <a href="{{ route('tasksoverview') }}" class="nav-link {{ Request::is('tasks/overview') ? 'active' : '' }}">
            <i class="nav-icon fas fa-chart-pie"></i>
            <p>Total Tasks Overview</p>
        </a>
    </li>
@endif

<li class="nav-item">
    <a href="{{ route('usertasksoverview') }}"
        class="nav-link {{ Request::is('tasks/user/overview') ? 'active' : '' }}">
        <i class="nav-icon fas fa-table"></i>
        <p>My Tasks Overview</p>
    </a>
</li>
