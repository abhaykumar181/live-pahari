<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" type="text/css" href="{{asset('bootstrap/css/bootstrap.css')}}" />
    <title>Admin Login</title>
    @stack('styles')
</head>
<body>
    <div class="bg-dark vh-100">
        <div class="container">
            <div class="row ">
                <div class="col-lg-5 col-md-5 position-absolute top-50 start-50 translate-middle">
                    <div class="login-form">
                        <div class="text-center fs-2 text-white mb-3 fw-bold">Pahari Host</div>
                        <div class="bg-white p-5 py-4">
                            <form class="login_form" action="{{route('admin.checklogin')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3 text-center fw-medium">Sign in to start your session</div>
                                @if(session()->has('error'))
                                <div class="mb-3 text-center text-danger fw-medium">{{ session()->get('error') }}</div>
                                @endif
                                <div class="mb-3 ">
                                    <div class="input-group mb-3">
                                    <span class="input-group-text material-symbols-outlined user-select-none">person</span>
                                    <input type="text" class="form-control shadow-sm" name="email" placeholder="Email" > 
                                </div>

                                <span class="text-danger">
                                @error('email')
                                {{ 'Email is required.' }}
                                @enderror
                                </span>

                                </div>
                                <div class="mb-3">
                                    <div class="input-group mb-3">
                                    <span class="input-group-text material-symbols-outlined user-select-none">lock</span>
                                    <input type="password" class="form-control shadow-sm" name="password" placeholder="Password" >
                                    </div>
                                </div>
                                
                                <span class="text-danger ">
                                @error('password')
                                {{ 'Password is required.' }}
                                @enderror
                                </span>

                                <div>
                                    <button type="submit" class="btn btn-primary w-100 btn-lg">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="jquery/jquery-3.7.0.min.js"></script>
    <script type="text/javascript" src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/admin-login.js')}}"></script>
    <script src="{{asset('jquery/jquery.validate.min.js')}}"></script>
</body>
</html>


