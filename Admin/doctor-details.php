<?php

if(!isset($_GET['id'])){header('Location: ?page=doctors');exit;}

$id = $_GET['id'];

$user = new User();
$doctor = $user->find([
  'conditions' => 'user_id = ?',
  'bind' => [$id]
]);

$get_doctor = new Doctor();

$doctor_details = $get_doctor->find([
  'conditions' => 'doctor_id = ?',
  'bind' => [$id]
]);

if(isset($_POST['update-doctor'])){
  
  $user->update($id,[
    'user_first_name' => Input::get('edit_first_name'),
    'user_last_name' => Input::get('edit_last_name'),
    'user_name' => Input::get('edit_username'),
    'user_email' => Input::get('edit_email'),
    'user_number' => Input::get('edit_phone'),
    'user_gender' => Input::get('edit_gender')
  ]);

  $get_doctor->update($id,[
    'doctor_specialization' => Input::get('edit_specialization'),
    'doctor_clinic_address' => Input::get('edit_clinic')
  ]);


    Session::flash('success', 'Profile updated successfully');
    echo '<script>window.location.href = "?page=doctor-details&id='.$id.'";</script>';

}

if(isset($_POST['change-password-doctor'])){

  if(password_verify(Input::get('current_password'), $doctor[0]->user_password)){
    if(Input::get('new_password') == Input::get('confirm_new_password')){
      $user->update($id,[
        'user_password' => password_hash(Input::get('new_password'), PASSWORD_DEFAULT)
      ]);
    
        Session::flash('success', 'Password changed successfully');
        echo '<script>window.location.href = "?page=doctor-details&id='.$id.'";</script>';
    }else{
      Session::flash('error', 'Password does not match');
      echo '<script>window.location.href = "?page=doctor-details&id='.$id.'";</script>';
    }
  }else{
    Session::flash('error', 'Current password is incorrect');
    echo '<script>window.location.href = "?page=doctor-details&id='.$id.'";</script>';
  }

}

?>

<section class="section profile">
  <div class="row">

    <div class="card">
      <div class="card-body pt-3">
        <ul class="nav nav-tabs nav-tabs-bordered">

          <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
          </li>

          <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
              Profile</button>
          </li>

          <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change
              Password</button>
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
                <?= $doctor[0]->user_first_name . ' ' . $doctor[0]->user_last_name ?>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-3 col-md-4 label ">
                <i class="bi bi-person-badge"></i>
                Specialization
              </div>
              <div class="col-lg-9 col-md-8">
                <?= $doctor_details[0]->doctor_specialization ?>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-3 col-md-4 label">
                <i class="bi bi-geo-alt-fill"></i>
                Clinic
              </div>
              <div class="col-lg-9 col-md-8">
                <?= $doctor_details[0]->doctor_clinic_address ?>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-3 col-md-4 label">
                <i class="bi bi-envelope"></i>
                Email
              </div>
              <div class="col-lg-9 col-md-8">
                <?= $doctor[0]->user_email ?>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-3 col-md-4 label">
                <i class="bi bi-telephone"></i>
                Phone
              </div>
              <div class="col-lg-9 col-md-8">
                <?= $doctor[0]->user_number ?>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-3 col-md-4 label">
                <i class="bi bi-gender-ambiguous"></i>
                Gender
              </div>
              <div class="col-lg-9 col-md-8">
                <?= $doctor[0]->user_gender ?>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-3 col-md-4 label">
                <i class="bi bi-person-badge-fill"></i>
                Role
              </div>
              <div class="col-lg-9 col-md-8">
                <?= $doctor[0]->user_roles ?>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-3 col-md-4 label">
                <i class="bi bi-person-bounding-box"></i>
                Username
              </div>
              <div class="col-lg-9 col-md-8">
                <?= $doctor[0]->user_name ?>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-3 col-md-4 label">
                <i class="bi bi-key-fill"></i>
                Password
              </div>
              <div class="col-lg-9 col-md-8">

                <div class="input-group mb-3">
                  <input id="profile-password" value="<?= $doctor[0]->user_password ?>" type="password"
                    class="form-control" aria-describedby="button-addon2" disabled>
                  <a href="#profile-password" class="btn btn-info text-white" id="show-password">
                    <i class="bi bi-eye" id="eye-icon"></i>
                  </a>
                </div>

              </div>
            </div>

            <div class="row">
              <div class="col-lg-3 col-md-4 label">
                <i class="bi bi-trash"></i>
                Delete Account
              </div>
              <div class="col-lg-9 col-md-8">
                
                <form method="POST" action="delete.php?table=users&id=<?= $doctor[0]->user_id ?>">
                  <button type="submit" name="delete_doctor" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this account?')">
                    <i class="bi bi-trash"></i>
                    Delete Account
                  </button>
                </form>

              </div>
            </div>

          </div>

          <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

            <form method="POST" class="needs-validation" novalidate>

              <div class="row mb-3">
                <label for="edit_first_name" class="col-md-4 col-lg-3 col-form-label">First Name</label>
                <div class="col-md-8 col-lg-9">
                  <input name="edit_first_name" type="text" class="form-control"
                    value="<?= $doctor[0]->user_first_name ?>" required>
                </div>
              </div>

              <div class="row mb-3">
                <label for="edit_last_name" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                <div class="col-md-8 col-lg-9">
                  <input name="edit_last_name" type="text" class="form-control" value="<?= $doctor[0]->user_last_name ?>"
                    required>
                </div>
              </div>

              <div class="row mb-3">
                <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                <div class="col-md-8 col-lg-9">
                  <input name="edit_email" type="email" class="form-control" value="<?= $doctor[0]->user_email ?>"
                  required>
                </div>
              </div>

              <div class="row mb-3">
                <label for="username" class="col-md-4 col-lg-3 col-form-label">Username</label>
                <div class="col-md-8 col-lg-9">
                  <input name="edit_username" type="text" class="form-control" value="<?= $doctor[0]->user_name ?>"
                  required>
                </div>
              </div>

              <div class="row mb-3">
                <label for="phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                <div class="col-md-8 col-lg-9">
                  <input name="edit_phone" type="text" class="form-control" value="<?= $doctor[0]->user_number ?>"
                    required>
                </div>
              </div>

              <div class="row mb-3">
                <label for="specialization" class="col-md-4 col-lg-3 col-form-label">Specialization</label>
                <div class="col-md-8 col-lg-9">
                  <input name="edit_specialization" type="text" class="form-control"
                    value="<?= $doctor_details[0]->doctor_specialization ?>" required>
                </div>
              </div>

              <div class="row mb-3">
                <label for="clinic" class="col-md-4 col-lg-3 col-form-label">Clinic</label>
                <div class="col-md-8 col-lg-9">
                  <input name="edit_clinic" type="text" class="form-control" value="<?= $doctor_details[0]->doctor_clinic_address ?>"
                    required>
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
                <button type="submit" class="btn btn-primary" name="update-doctor">Save Changes</button>
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
                  <input name="current_password" type="password" class="form-control" id="currentPassword" name="current_password">
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
                  <input name="confirm_new_password" type="password" class="form-control" id="renewPassword" name="confirm_new_password">
                </div>
              </div>

              <div class="text-center">
                <button type="submit" class="btn btn-primary" name="change-password-doctor">Change Password</button>
              </div>
            </form><!-- End Change Password Form -->

          </div>

        </div>

      </div>
    </div>

  </div>
</section>
