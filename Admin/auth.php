<?php

require('../AutoLoad.php');

if(!isset($_GET['page'])){$_GET['page'] = 'login';}

if(Session::exists('admin_id')){
    Redirect::to('index.php?page=dashboard');
}

$title = ucfirst($_GET['page']);

$validate = new Validate();

if(Input::exists()){
    $validation = $validate->check($_POST, [
        'user_name' => [
            'display' => 'Username',
            'required' => true,
        ],
        'user_password' => [
            'display' => 'Password',
            'required' => true,
        ],
    ]);

    if($validation->passed()){
        $user = new User();
        $login = $user->AdminLogin(Input::get('user_name'), Input::get('user_password'));

        if($login){
            Session::put('success', 'Login successful');
            Session::put('admin_id', $login);
            Redirect::to('index.php?page=dashboard');
        }else{
            Session::put('error', 'Login failed');
        }
    }else{
        Session::put('error', $validation->errors()[0]);
    }
}

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
    <link href="../Assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <link href="../Assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

    <link href="../Assets/css/style.css" rel="stylesheet">
</head>

<body>

    <main>
        <div class="container">

            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <?php 

                            $page = $_GET['page'];

                            if(file_exists("{$page}.php")){
                                require("{$page}.php");
                            }else{
                                Redirect::to('auth.php?page=login');
                            }

                            ?>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="../Assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../Assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../Assets/vendor/simple-datatables/simple-datatables.js"></script>

    <!-- Template Main JS File -->
    <script src="../Assets/js/main.js"></script>

</body>

</html>