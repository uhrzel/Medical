<?php

if(isset($_POST['cancel_appointment'])){
  $validate = new Validate();
  $validation = $validate->check($_POST, [
      'appointment_id' => [
          'display' => 'Appointment ID',
          'required' => true,
      ],
  ]);

  if($validation->passed()){
      $appointment = new Appointment();
      $a = $appointment->find([
          'conditions' => 'appointment_id = ?',
          'bind' => [Input::get('appointment_id')],
      ])[0];

      if($a){
          if($a->appointment_status === 'Pending'){
              $appointment->update($a->appointment_id, [
                  'appointment_status' => 'Cancelled',
              ]);

              echo '<script>alert("Appointment cancelled")</script>';
              echo '<script>window.location.href = "?page=appointments"</script>';
          }else{
              echo '<script>alert("Appointment already cancelled")</script>';
          }
      }else{
          echo '<script>alert("Appointment not found")</script>';
      }
  }else{
      echo '<script>alert("'.$validation->errors()[0].'")</script>';
  }
}

if(isset($_POST['decide_appointment'])){
  $validate = new Validate();
  $validation = $validate->check($_POST, [
      'appointment_id' => [
          'display' => 'Appointment ID',
          'required' => true,
      ]
  ]);

  if($validation->passed()){
      $appointment = new Appointment();
      $a = $appointment->find([
          'conditions' => 'appointment_id = ?',
          'bind' => [Input::get('appointment_id')],
      ])[0];

      if($a){
          if($a->appointment_status === 'Pending'){
              $appointment->update($a->appointment_id, [
                  'appointment_status' => 'Decided'
              ]);

              echo '<script>alert("Appointment status updated")</script>';
              echo '<script>window.location.href = "?page=appointments"</script>';
          }else{
              echo '<script>alert("Appointment already cancelled")</script>';
          }
      }else{
          echo '<script>alert("Appointment not found")</script>';
      }
  }else{
      echo '<script>alert("'.$validation->errors()[0].'")</script>';
  }
}

?>

<section class="section dashboard">
  <div class="row">

    <!-- Left side columns -->
    <div class="col-lg-12">
      <div class="row">

        <div class="col-xxl-6 col-md-6">
          <a class="card info-card sales-card" href="index.php?page=appointments">

            <div class="card-body">
              <h5 class="card-title">Appointment/s</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-calendar-check"></i>
                </div>
                <div class="ps-3">
                  <h6>
                    <?= count($appointments) ?>
                  </h6>
                </div>
              </div>
            </div>

          </a>
        </div>

        <div class="col-xxl-6 col-md-6">
          <a class="card info-card sales-card" href="index.php?page=patients">

            <div class="card-body">
              <h5 class="card-title">Patient/s</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                  <h6>
                    <?= count($patients) ?>
                  </h6>
                </div>
              </div>
            </div>

          </a>
        </div>

        <div class="col-12">
          <div class="card top-selling overflow-auto">

            <div class="card-body pb-0">
              <h5 class="card-title">
                Appointment List
              </h5>
              
              <?php if(count($appointments) == 0): ?>
                <div class="alert alert-warning">
                  No appointment found.
                </div>
              <?php else : ?>
                <div class="table-responsive">
                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">Patient</th>
                        <th scope="col">Specialization</th>
                        <th scope="col">Fee</th>
                        <th scope="col">Date & Time</th>
                        <th scope="col">Status</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($appointments as $a): ?>
                        <?php $p = $user->find([
                          'conditions' => 'user_id = ?',
                          'bind' => [$a->patient_id]
                        ])[0]; ?>
                      <tr>
                        <td><?= $p->user_first_name . ' ' . $p->user_last_name ?></td>
                        <td><?= $a->appointment_specialization ?></td>
                        <td><?php if($a->appointment_consultancy_fee == ''): ?>
                          <form action="index.php?page=set-fee" method="POST">
                            <div class="input-group">
                              <input type="hidden" name="appointment_id" value="<?= $a->appointment_id ?>">
                              <input type="number" name="appointment_consultancy_fee" class="form-control" placeholder="Fee" required>
                              <button type="submit" class="btn btn-primary" name="set_fee" title="Set Fee" onclick="return confirm('Are you sure you want to set this fee?');">
                                <i class="bi bi-check"></i>
                              </button>
                            </div>
                          </form>
                        <?php else: ?>
                          <?= $a->appointment_consultancy_fee ?>
                        <?php endif; ?></td>
                        <td><?= date('F d, Y h:i A', strtotime($a->appointment_datetime)) ?></td>
                        <td>
                          <?php if($a->appointment_status == 'Pending'): ?>
                            <span class="badge bg-warning text-dark">
                              <?= ucfirst($a->appointment_status) ?>
                            </span>
                          <?php elseif($a->appointment_status == 'Decided'): ?>
                            <span class="badge bg-success">
                              <?= ucfirst($a->appointment_status) ?>
                            </span>
                          <?php elseif($a->appointment_status == 'Cancelled'): ?>
                            <span class="badge bg-danger">
                              <?= ucfirst($a->appointment_status) ?>
                            </span>
                          <?php endif; ?>
                        </td>
                        <td>
                          <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="bi bi-three-dots"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                              <li>
                                <a class="dropdown-item" href="index.php?page=appointment-details&id=<?= $a->appointment_id ?>">
                                  <i class="bi bi-eye"></i>
                                  View Details
                                </a>
                              </li>
                              <?php if($a->appointment_status == 'Pending'): ?>
                                <form method="POST">
                                  <input type="hidden" name="appointment_id" value="<?= $a->appointment_id ?>">
                                  <button type="submit" class="dropdown-item" name="decide_appointment" onclick="return confirm('Are you sure you want to decide this appointment?');">
                                    <i class="bi bi-check"></i>
                                    Decide
                                  </button>
                                </form>
                                <li>
                                <form method="POST">
                                  <input type="hidden" name="appointment_id" value="<?= $a->appointment_id ?>">
                                  <button type="submit" class="dropdown-item" name="cancel_appointment" onclick="return confirm('Are you sure you want to cancel this appointment?');">
                                    <i class="bi bi-x"></i>
                                    Cancel
                                  </button>
                                </form>
                                </li>
                              <?php endif; ?>
                            </ul>
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