<x-laravel-ui-adminlte::adminlte-layout>
    <style>
        .login-page {
            background-image: url('{{ asset('images/backadmin1.jpg') }}');
            background-size: cover;
            background-position: top;
        }

        .card {
            position: fixed;
            width: 400px;
        }

        .card-body {
            font-size: 16px;
            line-height: 400px;
        }

        body {
            background-image: url('{{ asset('images/back8.jpg') }}');
            background-size: cover;
            background-position: center;
            opacity: 0.8;
        }

        .slide-in {
            position: fixed;
            top: 25%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.30);
            transform-origin: center center;
            z-index: 9999;
            animation: slidein-zoomin 2.5s ease-in-out forwards;
        }

        @keyframes slidein-zoomin {
            0% {
                top: -100%;
                transform: translate(-50%, -50%) scale(1);
            }

            50% {
                top: 50%;
                transform: translate(-50%, -50%) scale(1.2);
            }

            100% {
                top: 25%;
                left: 50%;
                transform: translate(-50%, -50%) scale(0.30);
            }
        }

        .fixed-image {
            position: fixed;
            top: 25%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.3);
            transform-origin: center center;
            z-index: 9999;
        }
    </style>



    {{-- @if ($errors->any())
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
    @endif --}}



    <body class="hold-transition login-page">

        @if (session('error'))
            <div class="alert alert-danger  mb-2">
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

        <div class="row justify-conten-center height=100% width=100% mt-4 "
            style="display: flex; justify-content: center; align-items: center; height: 100vh;">
            <div class="hold-transition">
                <img class="slide-in" id="animated-image" src="{{ asset('images/urcompany.png') }}">
            </div>

            <div class="card">

                <div class="card-body text-white " style="background-color: rgba(0, 0, 0, 1);width: 100%">

                    <form method="post" action="{{ url('/login') }}">
                        @csrf

                        <div class="input-group mb-3">
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email"
                                class="form-control @error('email') is-invalid @enderror ">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                            </div>
                            {{-- @error('email')
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror --}}
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" name="password" placeholder="Password"
                                class="form-control @error('password') is-invalid @enderror">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            {{-- @error('password')
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror --}}

                        </div>

                        <div class="row justify-content-center">
                            <div class="col-5">
                                <button type="submit" class="btn btn-block" style="background-color: rgba(0, 0, 0, 1); color:burlywood">Sign In</button>
                            </div>

                        </div>

                    </form>

                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->

        <script>
            const animatedImage = document.getElementById('animated-image');

            animatedImage.addEventListener('animationend', () => {
                animatedImage.classList.remove('slide-in');
                animatedImage.classList.add('fixed-image');
            });
        </script>
    </body>

</x-laravel-ui-adminlte::adminlte-layout>
