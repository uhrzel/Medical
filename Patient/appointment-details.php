<?php

if(!isset($_GET['id'])) {header('Location: index.php?page=dashboard');}

$id = $_GET['id'];

$appointment = new Appointment();
$a = $appointment->find([
  'conditions' => 'appointment_id = ?',
  'bind' => [$id]
])[0];

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
                <?= $a->appointment_specialization ?>
                <div class="float-end">
                  <button class="btn btn-info text-light" data-bs-toggle="modal" data-bs-target="#editAppointmentModal">
                    <i class="bi bi-pencil"></i> Edit
                </div>
              </h5>
              
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="appointment_date" class="form-label">Date</label>
                    <input type="text" name="appointment_date" class="form-control" value="<?= date('l, F d, Y h:i A', strtotime($a->appointment_datetime)) ?>" disabled>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="patient_id" class="form-label">Patient</label>
                    <?php $patient = new Patientes(); $p = $patient->find(['conditions' => 'user_id = ?', 'bind' => [$a->patient_id]])[0]; ?>
                    <input type="text" name="patient_id" class="form-control" value="<?= $p->user_first_name . ' ' . $p->user_last_name ?>" disabled>
                  </div>
                </div>
              </div>

            </div>

          </div>
        </div>

      </div>
    </div><!-- End Left side columns -->

  </div>
</section>

<!-- Add Appointment Modal -->
<div class="modal fade" id="addAppointmentModal" tabindex="-1" aria-labelledby="addAppointmentModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="bi bi-plus"></i> Add Appointment
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST">
        <div class="modal-body">

          <div class="mb-3">
            <label for="doctor_id" class="form-label">Doctor</label>
            <select name="doctor_id" class="form-control form-select">
              <?php foreach($doctors as $d): ?>
              <option value="<?= $d->user_id ?>"><?= $d->user_first_name . ' ' . $d->user_last_name ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="user_id" class="form-label">Patient</label>
            <select name="patient_id" class="form-control form-select">
              <?php foreach($patients as $p): ?>
              <option value="<?= $p->user_id ?>"><?= $p->user_first_name . ' ' . $p->user_last_name ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="appointment_specialization" class="form-label">Specialization</label>
            <textarea name="specialization" class="form-control" rows="3" required></textarea>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="consultancy_fee" class="form-label">Consultancy Fee</label>
                <input type="number" class="form-control" id="consultancy_fee" name="consultancy_fee" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="appointment_datetime" class="form-label">Appointment Date and Time</label>
                <input type="datetime-local" class="form-control" id="appointment_datetime" name="datetime"
                  required>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="addAppointment">Add Appointment</button>
        </div>
      </form>
    </div>
  </div>
</div>