<section class="section dashboard">
  <div class="row">

    <!-- Left side columns -->
    <div class="col-lg-12">
      <div class="row">

        <div class="col-12">
          <div class="card top-selling overflow-auto">

            <div class="card-body pb-0">
              <h5 class="card-title">
                Medical <span class="badge bg-primary text-light fw-bold"><?= count($medicals) ?></span>
              </h5>

              <?php if(count($medicals) == 0): ?>
              <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle"></i> No medical/s found.
              </div>
              <?php else : ?>
              <div class="table-responsive">
                <table class="table table-borderless datatable">
                  <thead>
                    <tr>
                      <th scope="col">Doctor</th>
                      <th scope="col">Blood Pressure</th>
                      <th scope="col">Blood Sugar</th>
                      <th scope="col">Body Temperature</th>
                      <th scope="col">Weight</th>
                      <th scope="col">Prescription</th>
                      <th scope="col">Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($medicals as $a): ?>
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
                        <td><?= $a->blood_pressure ?></td>
                        <td><?= $a->blood_sugar ?></td>
                        <td><?= $a->body_temperature ?></td>
                        <td><?= $a->weight ?></td>
                        <td><?= $a->prescription ?></td>
                        <td><?= $a->created_at ?></td>
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

<!-- Add medical Modal -->
<div class="modal fade" id="addmedicalModal" tabindex="-1" aria-labelledby="addmedicalModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="bi bi-plus"></i> Book medical
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
            <label for="medical_specialization" class="form-label">Specialization</label>
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
                <label for="medical_datetime" class="form-label">medical Date and Time</label>
                <input type="datetime-local" class="form-control" id="medical_datetime" name="datetime"
                  required>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="addmedical">Add medical</button>
        </div>
      </form>
    </div>
  </div>
</div>