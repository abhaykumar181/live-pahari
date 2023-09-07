<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('backend.layouts.includes.head')
    <title>Admin Login</title>
</head>
<body>
    <div class="bg-dark vh-100">
        <div class="container">
            <div class="row ">
                <div class="col-lg-5 col-md-5 position-absolute top-50 start-50 translate-middle">
                    <div class="login-form">
                        @include('backend.layouts.includes.notices')
                        <div class="text-center fs-2 text-white mb-3 fw-bold">Pahari Host</div>
                        <div class="bg-white p-5 py-4">
                            <form class="login_form" action="{{route('admin.checklogin')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3 text-center fw-medium">Sign in to start your session</div>
                                <div class="mb-3 ">
                                    <div class="input-group mb-3">
                                    <span class="input-group-text user-select-none"><i class="fa-regular fa-envelope"></i></span>
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
                                    <span class="input-group-text user-select-none"><i class="fa-solid fa-lock"></i></span>
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

    @include('backend.layouts.includes.scripts')
</body>
</html>


