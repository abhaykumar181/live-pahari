<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminDashboard</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://staging-admin.mytemperament.com/datatables/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://staging-admin.mytemperament.com/fontawesome6/css/all.min.css">
    <link rel="stylesheet" href="https://staging-admin.mytemperament.com/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://staging-admin.mytemperament.com/css/dashboard-styles.css">
    <script src="https://staging-admin.mytemperament.com/js/jquery.min.js"></script>
    <script src="https://staging-admin.mytemperament.com/js/bootstrap.min.js"></script>
    <script src="https://staging-admin.mytemperament.com/js/jquery.validate.min.js"></script>
    <script src="https://staging-admin.mytemperament.com/datatables/js/jquery.dataTables.min.js"></script>
    <script src="https://staging-admin.mytemperament.com/datatables/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://staging-admin.mytemperament.com/js/sweetalert.min.js"></script>
    <script src="https://staging-admin.mytemperament.com/js/main.js"></script>
    <script src="https://staging-admin.mytemperament.com/js/form-validations.js"></script>
</head>
<body class="sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2 bg-dark px-0 sidebar-fix">
                    <div class="sidebar-nav sidebar-dark px-0 box-shadow-none min-vh-100">
                        <a href="javascript:;" class="brand-link px-3">
                            <span class="brand-text font-weight-light"><b>AdminDashboard</b></span>
                        </a>
                        <div class="sidebar">
                            <ul class="nav flex-column">
                                <li class="nav-item mb-1 active"><a class="nav-link px-3" href="https://staging-admin.mytemperament.com/dashboard"> <i class="fa-solid fa-gauge"></i> Dashboard</a></li>
                                <li class="nav-item mb-1 "><a class="nav-link px-3" href="https://staging-admin.mytemperament.com/dashboard/participants"> <i class="fa-solid fa-list"></i> Participants</a></li>
                                <li class="nav-item mb-1 "><a class="nav-link px-3" href="https://staging-admin.mytemperament.com/dashboard/users"> <i class="fa-solid fa-users"></i> Users</a></li>
                                <li class="nav-item mb-1 "><a class="nav-link px-3" href="https://staging-admin.mytemperament.com/dashboard/translations"> <i class="fa-solid fa-language"></i> Translations</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-10 px-0 content-right">
                    <nav class="navbar navbar-expand navbar-white navbar-light main-header sticky-top">
                        <ul class="navbar-nav w-100 px-4 align-items-center">
                            <li class="nav-item">
                                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                                    <i class="fas fa-bars"></i>
                                </a>
                            </li>
                            <li class="nav-item d-none d-sm-inline-block">
                                <a href="index3.html" class="nav-link">Home</a>
                            </li>
                            <li class="nav-item logout-menu">
                                <div class="dropdown">
                                    <a class="dropdown-toggle text-dark d-flex align-items-center" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">  
                                        <div class="rounded text-white bg-primary logout-dropdown">A</div>
                                    </a>
                                    <ul class="dropdown-menu shadow animated--grow-in" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <a class="dropdown-item" href="javascript:;"> <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="https://staging-admin.mytemperament.com/logout"> <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </nav>
                    <div class="content-wrapper pb-5">
                        <div class="content-wrapper-inner">
                            <div class="content-header">
                                <div class="container-fluid">
                                    <div class="row mb-2 align-items-center py-3">
                                        <div class="col-sm-6">
                                            <h1 class="m-0">Dashboard</h1>
                                        </div>
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right mb-0 justify-content-end">
                                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                                <li class="breadcrumb-item active">Dashboard </li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <section class="content">
                                <!-- Main content section content here -->
                            </section>
                        </div>
                    </div>
                    <footer class="main-footer py-3 text-center bg-white sticky-bottom">
                        <strong>Copyright © 2022 <a href="#">Validation Engine</a>.</strong>
                        All rights reserved.
                        <div class="float-right d-none d-sm-inline-block"><b>Version</b> 3.2.0</div>
                    </footer>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
