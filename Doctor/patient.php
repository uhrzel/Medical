<?php

if(!isset($_GET['id'])){header('Location: ?page=patients');exit;}

$id = $_GET['id'];

$user = new User();
$patient = $user->find([
  'conditions' => 'user_id = ?',
  'bind' => [$id]
]);

if(isset($_POST['add_medical'])){
  
  $medical = new Medical();
  $medical->create([
    'doctor_id' => Input::get('doctor_id'),
    'patient_id' => Input::get('patient_id'),
    'blood_pressure' => Input::get('blood_pressure'),
    'blood_sugar' => Input::get('blood_sugar'),
    'weight' => Input::get('weight'),
    'body_temperature' => Input::get('body_temperature'),
    'prescription' => Input::get('prescription'),
  ]);

  Session::flash('success', 'Medical record added.');
  echo '<script>window.location.href = "?page=patient&id='.$id.'";</script>';
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
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#medical-history">Medical</button>
          </li>

        </ul>
        <div class="tab-content pt-2">

          <div class="tab-pane fade show active profile-overview" id="profile-overview">

            <h5 class="card-title">Patient Profile Details</h5>

            <div class="row">
              <div class="col-lg-3 col-md-4 label ">
                <i class="bi bi-person-circle"></i>
                Full Name
              </div>
              <div class="col-lg-9 col-md-8">
                <?= $patient[0]->user_first_name . ' ' . $patient[0]->user_last_name ?>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-3 col-md-4 label">
                <i class="bi bi-envelope"></i>
                Email
              </div>
              <div class="col-lg-9 col-md-8">
                <?= $patient[0]->user_email ?>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-3 col-md-4 label">
                <i class="bi bi-telephone"></i>
                Phone
              </div>
              <div class="col-lg-9 col-md-8">
                <?= $patient[0]->user_number ?>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-3 col-md-4 label">
                <i class="bi bi-gender-ambiguous"></i>
                Gender
              </div>
              <div class="col-lg-9 col-md-8">
                <?= $patient[0]->user_gender ?>
              </div>
            </div>

            <!-- <div class="row">
              <div class="col-lg-3 col-md-4 label">
                <i class="bi bi-person-badge-fill"></i>
                Role
              </div>
              <div class="col-lg-9 col-md-8">
                <?= $patient[0]->user_roles ?>
              </div>
            </div> -->

            <!-- <div class="row">
              <div class="col-lg-3 col-md-4 label">
                <i class="bi bi-person-bounding-box"></i>
                Username
              </div>
              <div class="col-lg-9 col-md-8">
                <?= $patient[0]->user_name ?>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-3 col-md-4 label">
                <i class="bi bi-key-fill"></i>
                Password
              </div>
              <div class="col-lg-9 col-md-8">

                <div class="input-group mb-3">
                  <input id="profile-password" value="<?= $patient[0]->user_password ?>" type="password"
                    class="form-control" aria-describedby="button-addon2" disabled>
                  <a href="#profile-password" class="btn btn-info text-white" id="show-password">
                    <i class="bi bi-eye" id="eye-icon"></i>
                  </a>
                </div>

              </div>
            </div> -->

            <!-- <div class="row">
              <div class="col-lg-3 col-md-4 label">
                <i class="bi bi-trash"></i>
                Delete Account
              </div>
              <div class="col-lg-9 col-md-8">
                
                <form method="POST" action="delete.php?table=users&id=<?= $patient[0]->user_id ?>">
                  <button type="submit" name="delete_patient" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this account?')">
                    <i class="bi bi-trash"></i>
                    Delete Account
                  </button>
                </form>

              </div>
            </div> -->

          </div>

          <div class="tab-pane fade profile-edit pt-3" id="medical-history">

            <h5 class="title">
              <i class="bi bi-file-medical"></i>
              Medical History
            </h5>

            <a class="float btn btn-info text-light" href="#addMedicalModal" data-bs-toggle="modal">
                <i class="bi bi-plus-circle"></i>
                Add Medical
              </a>
            <div class="table-responsive">
              <table class="table table-centered table-nowrap mb-0">
                <thead>
                  <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Doctor</th>
                    <th scope="col">Blood Pressure</th>
                    <th scope="col">Blood Sugar</th>
                    <th scope="col">Weight</th>
                    <th scope="col">Body Temperature</th>
                    <th scope="col">Prescription</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $medical = new Medical();
                  $medicals = $medical->find([
                    'conditions' => 'patient_id = ?',
                    'bind' => [$patient[0]->user_id]
                  ]);
                  ?>
                  <?php foreach ($medicals as $medical) : ?>
                  <?php $d = $user->find([
                      'conditions' => 'user_id = ?',
                      'bind' => [$medical->doctor_id]
                    ])[0]; ?>
                  <tr>
                    <td><?= date('l, F j, Y', strtotime($medical->created_at)) ?></td>
                    <td><?= $d->user_first_name . ' ' . $d->user_last_name ?></td>
                    <td><?= $medical->blood_pressure ?></td>
                    <td><?= $medical->blood_sugar ?></td>
                    <td><?= $medical->weight ?></td>
                    <td><?= $medical->body_temperature ?></td>
                    <td><?= $medical->prescription ?></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>

          </div>

        </div>

      </div>
    </div>
  </div>

</section>


<!-- Add Medical Modal -->
<div class="modal fade" id="addMedicalModal" tabindex="-1" aria-labelledby="addMedicalModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="bi bi-file-medical"></i> Add Medical
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST">
        <div class="modal-body">

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="blood-pressure" class="form-label">Blood Pressure</label>
              <input type="text" class="form-control" id="blood-pressure" name="blood_pressure">
            </div>
            <div class="col-md-6">
              <label for="blood-sugar" class="form-label">Blood Sugar</label>
              <input type="text" class="form-control" id="blood-sugar" name="blood_sugar">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="weight" class="form-label">Weight</label>
              <input type="text" class="form-control" id="weight" name="weight">
            </div>
            <div class="col-md-6">
              <label for="body-temperature" class="form-label">Body Temperature</label>
              <input type="text" class="form-control" id="body-temperature" name="body_temperature">
            </div>
          </div>

          <div class="mb-3">
            <label for="prescription" class="form-label">Prescription</label>
            <textarea class="form-control" id="prescription" rows="3" name="prescription"></textarea>
          </div>

          <input type="hidden" name="patient_id" value="<?= $id ?>">
          <input type="hidden" name="doctor_id" value="<?= Session::get('doctor_id') ?>">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="add_medical">Add Medical</button>
        </div>
      </form>
    </div>
  </div>
</div>