<?php

require('../AutoLoad.php');

if(!isset($_GET['page'])){$_GET['page'] = 'dashboard';}

if(!Session::exists('doctor_id')){Redirect::to('auth.php?page=login');}

if(Input::get('page') == 'logout'){
    $sessions = new Sessions();
    $res = $sessions->create([
        'user_id' => Session::get('doctor_id'),
        'session_status' => 'logout',
    ]);
    if($res){
        Session::delete('doctor_id');
        Session::put('success', 'Logout successful');
        Redirect::to('auth.php?page=login');
    }
}

$user = new User();

$doctor = $user->find([
    'conditions' => 'user_id = ?',
    'bind' => [Session::get('doctor_id')]
]);

$get_doctor = new Doctor();
$doc = $get_doctor->find([
    'conditions' => 'doctor_id = ?',
    'bind' => [Session::get('doctor_id')]
]);

// get all patients for the doctor
$patient = new Patientes();
$patients = $patient->find([
    'conditions' => 'doctor_id = ?',
    'bind' => [Session::get('doctor_id')]
]);

// get all appointments for the doctor
$appointment = new Appointment();
$appointments = $appointment->find([
    'conditions' => 'doctor_id = ?',
    'bind' => [Session::get('doctor_id')]
]);

$title = ucfirst($_GET['page']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>
        <?= $title ?> | <?= Config::get('website/name') ?>
    </title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <link href="../Assets/img/favicon.png" rel="icon">
    <link href="../Assets/img/apple-touch-icon.png?" rel="apple-touch-icon">

    <link href="../Assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">

    <link href="../Assets/css/style.css" rel="stylesheet">
</head>

<body>

    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.php?page=dashboard" class="logo d-flex align-items-center">
                <span class="d-none d-lg-block">
                    <span>Doctor</span>
                </span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>
        

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <!-- <li class="nav-item dropdown">

                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number">2</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            You have 2 new notifications
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-check-circle text-success"></i>
                            <div>
                                <h4>Sit rerum fuga</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>2 hrs. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-info-circle text-primary"></i>
                            <div>
                                <h4>Dicta reprehenderit</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>4 hrs. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="dropdown-footer">
                            <a href="#">Show all notifications</a>
                        </li>

                    </ul>

                </li> -->

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                        <span class="d-none d-md-block dropdown-toggle ps-2 text-uppercase">
                            <?= $doctor[0]->user_name ?>
                        </span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>
                                <?= $doctor[0]->user_first_name ?> <?= $doctor[0]->user_last_name ?>
                            </h6>
                            <span>
                                <?= $doctor[0]->user_email ?>
                            </span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="?page=profile">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="?page=logout">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>

                    </ul>
                </li>

            </ul>
        </nav>

    </header>

    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link " href="index.php?page=dashboard">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-heading">Manage</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="?page=patients">
                    <i class="bi bi-people-fill"></i>
                    <span>Patients</span>
                </a>
            </li>

        </ul>

    </aside>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>
                <?= ucfirst($_GET['page']) ?>
            </h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php?page=dashboard">Home</a></li>
                    <li class="breadcrumb-item active">
                        <?= ucfirst($_GET['page']) ?>
                    </li>
                </ol>
            </nav>
        </div>

        <?php

        Session::display_session_msg();

        $page = $_GET['page'];

        if(file_exists("{$page}.php")){
            require("{$page}.php");
        }else{
            echo "<script>window.location.href = 'index.php?page=dashboard'</script>";
        }

        ?>

    </main>

    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>Nicedoctor</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </footer>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script src="../Assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script src="../Assets/js/main.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.datatable').DataTable();
            $('#show-password').on('click', function() {
                var passwordField = $('#profile-password');
                if (passwordField.attr('type') == 'password') {
                    passwordField.attr('type', 'text');
                    // remove eye icon
                    $("#eye-icon").removeClass("bi bi-eye");
                    // add eye slash icon
                    $("#eye-icon").addClass("bi bi-eye-slash");

                } else {
                    passwordField.attr('type', 'password');
                    // remove eye slash icon
                    $("#eye-icon").removeClass("bi bi-eye-slash");
                    // add eye icon
                    $("#eye-icon").addClass("bi bi-eye");
                }
            });
        });
    </script>
</body>

</html>