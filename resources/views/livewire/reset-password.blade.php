<div>

    <style>
        .nav-link {
            font-size: 12px;
            font-weight: bold;

        }
    </style>
    @if (session('error'))
        <div class="alert alert-danger mb-2">
            {{ session('error') }}
        </div>
    @endif

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


    <div class="row justify-content-center">
        <div class="rounded bg-yellow ml-2 col-md-8 mt-2">
            <p
                style="color:black; font-size:14px; font-weight:bolder;
            margin: 0; display: flex; align-items: center; justify-content: center; height: 100%;">
                Password Should Be at Least 8 Characters,
                Combining (Uppercase-Lowercase-Numbers-Special Characters) </p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="card col-md-6 mt-5">
            <div class="card-body login-card-body">


                <form wire:submit.prevent="resetpassword">

                    <div class="input-group mb-3">
                        <input type="email" id="email" name="email" class="form-control" readonly
                            class="form-control" placeholder="{{ $email }}">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                        </div>

                    </div>

                    {{-- <div class="input-group mb-3">
                        <input type="password" id="current_password" name="current_password" class="form-control"
                            class="form-control" wire:model="current_password" placeholder="Current Password">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
                        </div>

                    </div> --}}

                    <div class="input-group mb-3">
                        <input type="password" id="password" name="password" class="form-control" wire:model="password"
                            class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
                        </div>

                    </div>

                    <div class="input-group mb-3">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-control" class="form-control" wire:model="password_confirmation"
                            placeholder="Confirm Password">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                        </div>
                    </div>
                </form>

            </div>
            <!-- /.login-card-body -->
        </div>

    </div>

</div>
