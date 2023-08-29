<div class="card mb-3">

    <div class="card-body">

        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">
                <i class="bi bi-person-check"></i> Patient Registration Form
            </h5>
            <p class="text-center small">Please fill out the form below to register.</p>
        </div>

        <?= Session::display_session_msg(); ?>

        <form class="row g-3 needs-validation" novalidate method="POST">

            <div class="col-6">
                <label for="yourFirstName" class="form-label">First Name</label>
                <input type="text" name="first_name" class="form-control" id="yourFirstName" required autofocus value="<?= Input::get('first_name') ?>">
                <div class="invalid-feedback">Please enter your first name.</div>
            </div>

            <div class="col-6">
                <label for="yourLastName" class="form-label">Last Name</label>
                <input type="text" name="last_name" class="form-control" id="yourLastName" required autofocus value="<?= Input::get('last_name') ?>">
                <div class="invalid-feedback">Please enter your last name.</div>
            </div>

            <div class="col-7">
                <label for="yourNumber" class="form-label">Phone Number</label>
                <input type="number" name="number" class="form-control" id="yourNumber" required autofocus value="<?= Input::get('phone_number') ?>">
                <div class="invalid-feedback">Please enter your phone number.</div>
            </div>

            <div class="col-5">
                <label for="yourGender" class="form-label">Gender</label>
                <select name="gender" class="form-select form-control">
                    <option selected disabled hidden value="">Select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
                <div class="invalid-feedback">Please select gender.</div>
            </div>

            <div class="col-12">
                <label for="yourDoctor" class="form-label">Doctor</label>
                <select name="doctor_id" class="form-select form-control">
                    <option selected disabled hidden value="">Select Doctor</option>
                    <?php $doctor = new User(); ?>
                <?php $doctors = $doctor->find([
                    'conditions' => 'user_roles = ?',
                    'bind' => ['doctor']
                ]); ?>
                    <?php foreach ($doctors as $doc) : ?>
                        <option value="<?= $doc->user_id ?>"><?= $doc->user_first_name . ' ' . $doc->user_last_name ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Please select gender.</div>
            </div>

            <div class="col-12">
                <label for="yourUsername" class="form-label">Username</label>
                <div class="input-group has-validation">
                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                    <input type="text" name="username" class="form-control" id="yourUsername" required autofocus value="<?= Input::get('name') ?>">
                    <div class="invalid-feedback">Please enter your username.</div>
                </div>
            </div>

            <div class="col-12">
                <label for="yourEmail" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="yourEmail" required autofocus value="<?= Input::get('email') ?>">
                <div class="invalid-feedback">Please enter your email.</div>
            </div>

            <div class="col-12">
                <label for="yourPassword" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="yourPassword" required>
                <div class="invalid-feedback">Please enter your password!</div>
            </div>

            <div class="col-12">
                <label for="yourPassword" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirm" class="form-control" id="yourPassword" required>
                <div class="invalid-feedback">Please enter your password!</div>
            </div>

            <div class="col-12">
                <button class="btn btn-primary w-100" type="submit" name="register">Register</button>
            </div>

            <div class="col-12">
                <p class="small mb-0">Already have an account? <a href="?page=login">Login</a></p>
            </div>
        </form>

    </div>
</div>