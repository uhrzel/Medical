<?php

if(Input::exists()){
  $user = new User();
  
  $random_password = rand();

  $res = $user->createUser('patient', $random_password);

  if($res){
    $patient = new Patientes();

    $patient->create([
      'patient_id' => $res,
      'doctor_id' => Input::get('doctor_id')
    ]);

    $otp = new Otp();
    $otp_code = rand(100000, 999999);
    
    $otp->createOtp($res, $otp_code);

    $subject = 'Patient Account Created';
    $body = '<p>Your account has been created successfully. Please use the following credentials to login.</p>
    <p>Username: <strong>'.Input::get('username').'</strong></p>
    <p>Password: <strong>'.$random_password.'</strong></p>
    <p>OTP: <strong>'.$otp_code.'</strong></p>
    <p>Doctor: <strong>'.$doctor[0]->user_first_name.' '.$doctor[0]->user_last_name.'</strong></p>
    <p>Click <a href="'.Config::get('website/patient-url').'">here</a> to login.</p>
    <p>Thank you.</p>';
    
    $user->send_email(Input::get('email'), $subject, $body, $otp_code);

    Session::flash('success', 'Patient added successfully');
    echo '<script>window.location.href = "index.php?page=patients"</script>';
  }else{
    Session::flash('error', 'Patient not added');
    echo '<script>window.location.href = "index.php?page=patients"</script>';
  }

}

?>

<section class="section dashboard">
  <div class="row">

    <!-- Left side columns -->
    <div class="col-lg-12">
      <div class="row">

        <div class="col-12">
          <div class="card top-selling overflow-auto">

            <div class="card-body pb-0">
              <h5 class="card-title">
                Patient/s List <span class="badge bg-primary text-light fw-bold"><?= count($patients) ?></span>
                <div class="float-end">
                  <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addPatientModal">
                    <i class="bi bi-plus"></i> Add Patient
                  </button>
                </div>
              </h5>

              <?php if(count($patients) == 0): ?>
              <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle"></i> No patient/s found.
              </div>
              <?php else : ?>
              <div class="table-responsive">
                <table class="table table-borderless datatable">
                  <thead>
                    <tr>
                      <th scope="col">Name</th>
                      <th scope="col">Email</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($patients as $p): ?>
                      <?php $u = $user->find([
                      'conditions' => 'user_id = ?',
                      'bind' => [$p->patient_id
                    ]])[0]; ?>
                    <tr>
                      <td><?= $u->user_first_name . ' ' . $u->user_last_name ?></td>
                      <td><?= $u->user_email ?></td>
                      <td>
                        <a href="?page=patient&id=<?= $u->user_id ?>" class="btn btn-sm btn-primary">
                          <i class="bi bi-eye"></i>
                        </a>
                      </td>
                    </tr>
                      <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <?php endif; ?>

            </div>

          </div>
        </div>

      </div>
    </div><!-- End Left side columns -->

  </div>
</section>

<!-- Add Patient Modal -->
<div class="modal fade" id="addPatientModal" tabindex="-1" aria-labelledby="addPatientModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="bi bi-person-plus"></i> Add Patient
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST">
        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="first_name" class="form-label">First Name</label>
              <input type="text" class="form-control" id="first_name" name="first_name" required>
            </div>
            <div class="col-md-6">
              <label for="last_name" class="form-label">Last Name</label>
              <input type="text" class="form-control" id="last_name" name="last_name" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="number" class="form-label">Contact Number</label>
              <input type="text" class="form-control" id="number" name="number" required>
            </div>
            <div class="col-md-6">
              <label for="gender" class="form-label">Gender</label>
              <select name="gender" class="form-control form-select">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>
          </div>
          <input type="hidden" name="doctor_id" value="<?= Session::get('doctor_id') ?>">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="add_patient">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>