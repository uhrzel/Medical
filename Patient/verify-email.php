<div class="card mb-3">

    <div class="card-body">

        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">
                <i class="bi bi-envelope"></i> Verify Email
            </h5>
            <p class="text-center small">Enter your email address to verify</p>
        </div>

        <?= Session::display_session_msg(); ?>

        <form class="row g-3 needs-validation" novalidate method="POST">

            <div class="col-12">
                <label for="yourEmail" class="form-label">Email</label>
                <div class="input-group has-validation">
                    <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-envelope"></i></span>
                    <input type="text" name="user_email" class="form-control" id="yourEmail" required autofocus value="<?= Input::get('user_email') ?>">
                    <div class="invalid-feedback">Please enter your email address.</div>
                </div>
            </div>

            <div class="col-12">
                <button class="btn btn-primary w-100" type="submit" name="verify-email">Verify</button>
            </div>

            <!-- go back to login page -->
            <div class="col-12">
                <p class="small mb-0"><a href="?page=login">Go back to login page</a></p>
            </div>
        </form>

    </div>
</div>