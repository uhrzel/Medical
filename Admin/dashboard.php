<section class="section dashboard">
  <div class="row">

    <!-- Left side columns -->
    <div class="col-lg-12">
      <div class="row">

        <div class="col-xxl-4 col-md-4">
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

        <div class="col-xxl-4 col-md-4">
          <a class="card info-card sales-card" href="index.php?page=doctors">

            <div class="card-body">
              <h5 class="card-title">Doctor/s</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                  <h6>
                    <?= count($doctors) ?>
                  </h6>
                </div>
              </div>
            </div>

          </a>
        </div>

        <div class="col-xxl-4 col-md-4">
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

        <div class="col-12">
          <div class="card top-selling overflow-auto">

            <div class="card-body pb-0">
              <h5 class="card-title">
                Session Logs
              </h5>
              
              <?php if(count($sessions) == 0): ?>
                <div class="alert alert-warning">
                  No session logs found.
                </div>
              <?php else : ?>
                <div class="table-responsive">
                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Date and Time</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($sessions as $log): ?>
                        <?php $ses_user = $user->findBy('user_id', $log->user_id)[0] ?>
                      <tr>
                        <td><?= $ses_user->user_first_name . ' ' . $ses_user->user_last_name ?></td>
                        <td><?= $ses_user->user_email ?></td>
                        <td><?= $ses_user->user_roles ?></td>
                        <td><?= $log->created_at ?></td>
                        <td><?= $log->session_status ?></td>
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