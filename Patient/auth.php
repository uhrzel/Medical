<?php

require('../AutoLoad.php');

if(!isset($_GET['page'])){$_GET['page'] = 'login';}

if(Session::exists('patient_id')){
    Redirect::to('index.php?page=dashboard');
}

$title = ucfirst($_GET['page']);


if(isset($_POST['login'])){
    $validate = new Validate();
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
        $login = $user->PatientLogin(Input::get('user_name'), Input::get('user_password'));

        if($login){

            if($login->user_is_verify === 'pending'){
                echo '<script>alert("Your account is pending. Please contact admin")</script>';
                Session::put('verify_otp', true);
                Session::put('otp_patient_id', $login->user_id);
                Redirect::to('auth.php?page=verify-otp-login');
            }elseif($login->user_is_verify === 'rejected'){
                echo '<script>alert("Your account is rejected. Please contact admin")</script>';
                Redirect::to('auth.php?page=login');
            }elseif($login->user_is_verify === 'verified'){
                echo '<script>alert("Login success")</script>';
                Session::put('patient_id', $login->user_id);
                Redirect::to('auth.php?page=dashboard');
            }else{
                echo '<script>alert("Login failed")</script>';
            }
        }else{
            echo '<script>alert("Login failed")</script>';
        }
    }else{
        echo '<script>alert("'.$validation->errors()[0].'")</script>';
    }
}

if(isset($_POST['register'])){
    $user = new User();
    $res = $user->createUser('patient', Input::get('password'));
    
    if($res){
        $patient = new Patientes();
        $patient->create([
            'patient_id' => $res,
            'doctor_id' => Input::get('doctor_id'),
        ]);
        $otp = new OTP();
        $otp_code = rand(100000, 999999);
        $otp->create([
            'user_id' => $res,
            'otp_code' => $otp_code,
        ]);

        $subject = 'Account Verification';
        $body = 'Your OTP code is: ' . $otp_code;

        $s = $user->send_mail(Input::get('email'), $subject, $body);

        if($s){
            echo '<script>alert("Registration success. Please check your email for verification code")</script>';
            Session::put('verify_otp', true);
            Session::put('otp_patient_id', $res);
            Redirect::to('auth.php?page=verify-otp');
            Redirect::to('auth.php?page=verify-otp');
        }else{
            echo '<script>alert("Registration failed")</script>';
        }
    }
}

if(isset($_POST['verify-email'])){
    $validate = new Validate();
    $validation = $validate->check($_POST, [
        'user_email' => [
            'display' => 'Email',
            'required' => true,
            'valid_email' => true,
        ],
    ]);

    if($validation->passed()){
        $user = new User();
        $u = $user->find([
            'conditions' => 'user_email = ?',
            'bind' => [Input::get('user_email')],
        ])[0];

        if($u){

            $otp = new OTP();
            $otp_code = rand(100000, 999999);
            $otp->create([
                'user_id' => $u->user_id,
                'otp_code' => $otp_code,
            ]);

            $subject = 'Password Reset';
            $body = 'Your OTP code is: ' . $otp_code;

            $user->send_mail(Input::get('user_email'), $subject, $body);

            Session::put('verify_email', true);
            Session::put('user_id', $u->user_id);
            Session::put('success', 'Email found. Please enter your new password');
            Redirect::to('?page=verify-otp');
        }else{
            echo '<script>alert("Email not found")</script>';
            echo '<script>window.location.href = "?page=verify-email"</script>';
        }
    }else{
        echo '<script>alert("'.$validation->errors()[0].'")</script>';
        echo '<script>window.location.href = "?page=verify-email"</script>';
    }
}

if(isset($_POST['verify-otp'])){
    $validate = new Validate();
    $validation = $validate->check($_POST, [
        'otp_code' => [
            'display' => 'OTP Code',
            'required' => true,
            'min' => 6,
            'max' => 6,
        ],
    ]);

    if($validation->passed()){
        $otp = new OTP();
        $o = $otp->find([
            'conditions' => 'user_id = ? AND otp_code = ?',
            'bind' => [Session::get('user_id'), Input::get('otp_code')],
        ])[0];

        if($o){
            echo '<script>alert("OTP code verified")</script>';
            // delete otp
            $otp->delete($o->otp_id);
            Redirect::to('?page=change-password');
        }else{
            echo '<script>alert("Invalid OTP code")</script>';
            echo '<script>window.location.href = "?page=verify-otp"</script>';
        }
    }else{
        echo '<script>alert("'.$validation->errors()[0].'")</script>';
        echo '<script>window.location.href = "?page=verify-otp"</script>';
    }
}

if(isset($_POST['verify-otp-login'])){
    $validate = new Validate();
    $validation = $validate->check($_POST, [
        'otp_code' => [
            'display' => 'OTP Code',
            'required' => true,
            'min' => 6,
            'max' => 6,
        ],
    ]);

    if($validation->passed()){
        $otp = new OTP();
        $o = $otp->find([
            'conditions' => 'user_id = ? AND otp_code = ?',
            'bind' => [Session::get('otp_patient_id'), Input::get('otp_code')],
        ]);

        if($o){
            // update user_is_verify
            $user = new User();
            $user->update(Session::get('otp_patient_id'), [
                'user_is_verify' => 'verified',
            ]);
            echo '<script>alert("OTP code verified")</script>';
            // delete otp
            $otp->delete($o[0]->otp_id);
            Session::delete('verify_otp');
            Session::delete('otp_patient_id');
            echo '<script>window.location.href = "?page=login"</script>';
        }else{
            echo '<script>alert("Invalid OTP code")</script>';
        }
    }else{
        echo '<script>alert("'.$validation->errors()[0].'")</script>';
    }
}

if(isset($_POST['change-password'])){
    $validate = new Validate();
    $validation = $validate->check($_POST, [
        'user_password' => [
            'display' => 'Password',
            'required' => true,
            'min' => 6,
        ],
        'confirm_user_password' => [
            'display' => 'Confirm Password',
            'required' => true,
            'matches' => 'user_password',
        ],
    ]);

    if($validation->passed()){
        $user = new User();
        $user->update(Session::get('user_id'), [
            'user_password' => password_hash(Input::get('user_password'), PASSWORD_DEFAULT),
        ]);

        Session::delete('verify_email');
        Session::delete('user_id');
        echo '<script>alert("Password changed successfully")</script>';
        Redirect::to('?page=login');
    }else{
        echo '<script>alert("'.$validation->errors()[0].'")</script>';
        echo '<script>window.location.href = "?page=change-password"</script>';
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