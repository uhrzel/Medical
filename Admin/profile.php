<?php

$id = Session::get('admin_id');

if(isset($_POST['update-profile'])){

    $user->update($id,[
        'user_first_name' => Input::get('edit_first_name'),
        'user_last_name' => Input::get('edit_last_name'),
        'user_name' => Input::get('edit_username'),
        'user_email' => Input::get('edit_email'),
        'user_number' => Input::get('edit_phone'),
        'user_gender' => Input::get('edit_gender')
    ]);


    Session::flash('success', 'Profile updated successfully');
    echo '<script>window.location.href = "?page=profile";</script>';

}

if(isset($_POST['change-password-admin'])){

    if($admin[0]->user_password == Input::get('current_password')){
        if(Input::get('new_password') == Input::get('confirm_new_password')){
        $user->update($id,[
            'user_password' => Input::get('new_password')
        ]);
        
            Session::flash('success', 'Password changed successfully');
            echo '<script>window.location.href = "?page=profile";</script>';
        }else{
        Session::flash('error', 'Password does not match');
        echo '<script>window.location.href = "?page=profile";</script>';
        }
    }else{
        Session::flash('error', 'Current password is incorrect');
        echo '<script>window.location.href = "?page=profile";</script>';
    }

}

?>

<section class="section profile">
    <div class="row">
        <div class="col-xl-4">

            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                    <!-- <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle"> -->
                    <i class="bi bi-person-circle" style="font-size: 100px;"></i>
                    <h2>
                        <?= $admin[0]->user_first_name . ' ' . $admin[0]->user_last_name ?>
                    </h2>
                    <h3>
                        <?= $admin[0]->user_email ?>
                    </h3>
                    <div class="social-links mt-2">
                        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-xl-8">

            <div class="card">
                <div class="card-body pt-3">
                    <ul class="nav nav-tabs nav-tabs-bordered">

                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab"
                                data-bs-target="#profile-overview">Overview</button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                Profile</button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab"
                                data-bs-target="#profile-change-password">Change Password</button>
                        </li>

                    </ul>
                    <div class="tab-content pt-2">

                        <div class="tab-pane fade show active profile-overview" id="profile-overview">

                            <h5 class="card-title">Profile Details</h5>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label ">
                                    <i class="bi bi-person-circle"></i>
                                    Full Name
                                </div>
                                <div class="col-lg-9 col-md-8">
                                    <?= $admin[0]->user_first_name . ' ' . $admin[0]->user_last_name ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">
                                    <i class="bi bi-envelope"></i>
                                    Email
                                </div>
                                <div class="col-lg-9 col-md-8">
                                    <?= $admin[0]->user_email ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">
                                    <i class="bi bi-telephone"></i>
                                    Phone
                                </div>
                                <div class="col-lg-9 col-md-8">
                                    <?= $admin[0]->user_number ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">
                                    <i class="bi bi-gender-ambiguous"></i>
                                    Gender
                                </div>
                                <div class="col-lg-9 col-md-8">
                                    <?= $admin[0]->user_gender ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">
                                    <i class="bi bi-person-badge-fill"></i>
                                    Role
                                </div>
                                <div class="col-lg-9 col-md-8">
                                    <?= $admin[0]->user_roles ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">
                                    <i class="bi bi-person-bounding-box"></i>
                                    Username
                                </div>
                                <div class="col-lg-9 col-md-8">
                                    <?= $admin[0]->user_name ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">
                                    <i class="bi bi-key-fill"></i>
                                    Password
                                </div>
                                <div class="col-lg-9 col-md-8">

                                    <div class="input-group mb-3">
                                        <input  id="profile-password" value="<?= $admin[0]->user_password ?>" type="password" class="form-control" aria-describedby="button-addon2" disabled>
                                        <a href="#profile-password" class="btn btn-info text-white" id="show-password">
                                            <i class="bi bi-eye" id="eye-icon"></i>
                                        </a>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                            <form method="POST" class="needs-validation" novalidate>

                                <div class="row mb-3">
                                    <label for="edit_first_name" class="col-md-4 col-lg-3 col-form-label">First Name</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="edit_first_name" type="text" class="form-control" value="<?= $admin[0]->user_first_name ?>" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="edit_last_name" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="edit_last_name" type="text" class="form-control" value="<?= $admin[0]->user_last_name ?>" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="edit_email" type="email" class="form-control" value="<?= $admin[0]->user_email ?>" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="username" class="col-md-4 col-lg-3 col-form-label">Username</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="edit_username" type="text" class="form-control" value="<?= $admin[0]->user_name ?>" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="edit_phone" type="text" class="form-control" value="<?= $admin[0]->user_number ?>" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="gender" class="col-md-4 col-lg-3 col-form-label">Gender</label>
                                    <div class="col-md-8 col-lg-9">
                                        <select name="edit_gender" class="form-select form-control">
                                        <?php 
                                            $gender = ['Male', 'Female'];

                                            $new_gender = [];
                                            
                                            foreach ($gender as $g) {
                                                $new_gender[] = '<option value="' . $g . '">' . $g . '</option>';
                                            }

                                            echo implode('', $new_gender);
                                        ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary" name="update-profile">Save Changes</button>
                                </div>
                            </form>

                        </div>

                        <div class="tab-pane fade pt-3" id="profile-change-password">
                            <!-- Change Password Form -->
                            <form method="POST" class="needs-validation h-100 my-5" novalidate>

                                <div class="row mb-3">
                                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current
                                        Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="current_password" type="password" class="form-control"
                                            id="currentPassword" name="current_password">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New
                                        Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="new_password" type="password" class="form-control" id="newPassword" name="new_password">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New
                                        Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="confirm_new_password" type="password" class="form-control"
                                            id="renewPassword" name="confirm_new_password">
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary" name="change-password-admin">Change Password</button>
                                </div>
                            </form><!-- End Change Password Form -->

                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</section>