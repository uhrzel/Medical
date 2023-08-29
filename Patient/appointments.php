<?php

if(Input::exists()){
  $appointment = new Appointment();

  $res = $appointment->create([
    'doctor_id' => Input::get('doctor_id'),
    'patient_id' => Session::get('patient_id'),
    'appointment_specialization' => Input::get('specialization'),
    'appointment_consultancy_fee' => Input::get('consultancy_fee'),
    'appointment_datetime' => Input::get('datetime'),
    'appointment_status' => 'Pending'
  ]);

  if($res){
    Session::flash('success', 'Appointment added');
    echo '<script>window.location.href = "index.php?page=appointments"</script>';
  }else{
    Session::flash('error', 'Doctor not added');
    echo '<script>window.location.href = "index.php?page=appointments"</script>';
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
                Appointment/s List <span class="badge bg-primary text-light fw-bold"><?= count($appointments) ?></span>
                <div class="float-end">
                  <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">
                    <i class="bi bi-plus"></i> Book Appointment
                  </button>
                </div>
              </h5>

              <?php if(count($appointments) == 0): ?>
              <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle"></i> No Appointment/s found.
              </div>
              <?php else : ?>
              <div class="table-responsive">
                <table class="table table-borderless datatable">
                  <thead>
                    <tr>
                      <th scope="col">Doctor</th>
                      <th scope="col">Specialization</th>
                      <th scope="col">Patient</th>
                      <th scope="col">Clinic</th>
                      <th scope="col">Fee</th>
                      <th scope="col">Date and Time</th>
                      <th scope="col">Status</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($appointments as $a): ?>
                      <?php $u = new User(); ?>
                      <?php $doctor = $u->find([
                        'conditions' => 'user_id = ? AND user_roles = ?',
                        'bind' => [$a->doctor_id, 'doctor']
                      ])[0]; ?>
                      <?php $d = new Doctor(); ?>
                      <?php $doc = $d->find([
                        'conditions' => 'doctor_id = ?',
                        'bind' => [$a->doctor_id]
                      ])[0]; ?>
                      <?php $patient = $u->find([
                        'conditions' => 'user_id = ? AND user_roles = ?',
                        'bind' => [$a->patient_id, 'patient']
                      ])[0]; ?>
                      <tr>
                        <td>
                          <i class="bi bi-person-circle"></i>
                          <?= $doctor->user_first_name . ' ' . $doctor->user_last_name ?></td>
                        <td><?= $a->appointment_specialization ?></td>
                        <td>
                          <i class="bi bi-person-circle"></i>
                          <?= $patient->user_first_name . ' ' . $patient->user_last_name ?></td>
                        <td><?= $doc->doctor_clinic_address ?></td>
                        <td><?= $a->appointment_consultancy_fee ?></td>
                        <td><?= $a->appointment_datetime ?></td>
                        <td><?php if($a->appointment_status == 'Decided'): ?>
                          <span class="badge bg-success text-light fw-bold"><?= $a->appointment_status ?></span>
                          <?php else: ?>
                          <span class="badge bg-warning text-light fw-bold"><?= $a->appointment_status ?></span>
                          <?php endif; ?>
                        </td>
                        <td>
                          <div class="btn-group" role="group" aria-label="Basic example">
                            <!-- <a href="index.php?page=appointment&id=<?= $a->appointment_id ?>" class="btn btn-primary btn-sm">
                              <i class="bi bi-eye"></i>
                            </a>
                            <a href="index.php?page=appointment&id=<?= $a->appointment_id ?>" class="btn btn-success btn-sm">
                              <i class="bi bi-pencil"></i>
                            </a> -->
                            <a href="delete.php?table=appointments&id=<?= $a->appointment_id ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this appointment?')">
                              <i class="bi bi-trash"></i>
                            </a>
                          </div>
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

<!-- Add Appointment Modal -->
<div class="modal fade" id="addAppointmentModal" tabindex="-1" aria-labelledby="addAppointmentModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="bi bi-plus"></i> Book Appointment
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