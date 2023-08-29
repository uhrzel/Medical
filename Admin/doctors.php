<?php

if(Input::exists()){
  $user = new User();
  
  $random_password = rand();

  $res = $user->createUser('doctor', $random_password);

  if($res){
    $doctor = new Doctor();

    $doctor->create([
      'doctor_id' => $res,
      'doctor_specialization' => Input::get('specialization'),
      'doctor_clinic_address' => Input::get('clinic'),
    ]);

    $otp = new Otp();
    $otp_code = rand(100000, 999999);
    
    $otp->createOtp($res, $otp_code);

    $subject = 'Doctor Account Created';
    $body = '<p>Your account has been created successfully. Please use the following credentials to login.</p>
    <p>Username: <strong>'.Input::get('username').'</strong></p>
    <p>Password: <strong>'.$random_password.'</strong></p>
    <p>OTP: <strong>'.$otp_code.'</strong></p>
    <p>Thank you.</p>';
    
    $user->send_email(Input::get('email'), $subject, $body, $otp_code);

    Session::flash('success', 'Doctor added successfully');
    echo '<script>window.location.href = "index.php?page=doctors"</script>';
  }else{
    Session::flash('error', 'Doctor not added');
    echo '<script>window.location.href = "index.php?page=doctors"</script>';
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
                Doctor/s List <span class="badge bg-primary text-light fw-bold"><?= count($doctors) ?></span>
                <div class="float-end">
                  <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#adddoctorModal">
                    <i class="bi bi-plus"></i> Add Doctor
                  </button>
                </div>
              </h5>

              <?php if(count($doctors) == 0): ?>
              <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle"></i> No Doctor/s found.
              </div>
              <?php else : ?>
              <div class="table-responsive">
                <table class="table table-borderless datatable">
                  <thead>
                    <tr>
                      <th scope="col">Name</th>
                      <th scope="col">Email</th>
                      <th scope="col">Specialization</th>
                      <th scope="col">Clinic</th>
                      <th scope="col">Appointment/s</th>
                      <th scope="col">Status</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($doctors as $d): ?>
                    <?php $appointments = $appointment->find_by_doctor($d->user_id); ?>
                    <?php $doctor = new Doctor(); ?>
                    <?php $doc = $doctor->find([
                      'conditions' => 'doctor_id = ?',
                      'bind' => [$d->user_id]
                    ])[0]; ?>
                    <tr>
                      <td><?= $d->user_first_name . ' ' . $d->user_last_name ?></td>
                      <td><?= $d->user_email ?></td>
                      <td><?= $doc->doctor_specialization ?></td>
                      <td><?= $doc->doctor_clinic_address ?></td>
                      <td><?= count($appointments) ?></td>
                      <td><?= $d->user_is_verify ?></td>
                      <td>
                        <a href="?page=doctor-details&id=<?= $d->user_id ?>" class="btn btn-sm btn-primary">
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

<!-- Add doctor Modal -->
<div class="modal fade" id="adddoctorModal" tabindex="-1" aria-labelledby="adddoctorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="bi bi-person-plus"></i> Add doctor
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
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="specialization" class="form-label">Specialization</label>
              <select class="form-select" id="specialization" name="specialization" required>
                <option selected hidden disabled value="">Select Specialization</option>
                <option value="Allergist">Allergist</option>
                <option value="Anesthesiologist">Anesthesiologist</option>
                <option value="Cardiologist">Cardiologist</option>
                <option value="Dermatologist">Dermatologist</option>
                <option value="Endocrinologist">Endocrinologist</option>
                <option value="Gastroenterologist">Gastroenterologist</option>
                <option value="Hematologist">Hematologist</option>
                <option value="Infectious Disease Specialist">Infectious Disease Specialist</option>
                <option value="Nephrologist">Nephrologist</option>
                <option value="Neurologist">Neurologist</option>
                <option value="Nuclear Medicine Specialist">Nuclear Medicine Specialist</option>
                <option value="Obstetrician">Obstetrician</option>
                <option value="Oncologist">Oncologist</option>
                <option value="Ophthalmologist">Ophthalmologist</option>
                <option value="Orthopedic Surgeon">Orthopedic Surgeon</option>
                <option value="Otolaryngologist">Otolaryngologist</option>
                <option value="Pathologist">Pathologist</option>
                <option value="Pediatrician">Pediatrician</option>
                <option value="Physiatrist">Physiatrist</option>
                <option value="Plastic Surgeon">Plastic Surgeon</option>
                <option value="Psychiatrist">Psychiatrist</option>
                <option value="Pulmonologist">Pulmonologist</option>
                <option value="Radiologist">Radiologist</option>
                <option value="Rheumatologist">Rheumatologist</option>
                <option value="Surgeon">Surgeon</option>
                <option value="Urologist">Urologist</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="clinic" class="form-label">Clinic Address</label>
              <input type="text" class="form-control" id="clinic" name="clinic" required>
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
                <option selected hidden disabled value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="add_doctor">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>