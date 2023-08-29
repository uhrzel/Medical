<div class="card mb-3">

    <div class="card-body">

        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">
                <i class="bi bi-key"></i> Change Password
            </h5>
            <p class="text-center small">Enter your new password</p>
        </div>

        <?= Session::display_session_msg(); ?>

        <form class="row g-3 needs-validation" novalidate method="POST" action="?page=login">

            <div class="col-12">
                <label for="yourPassword" class="form-label">New Password</label>
                <input type="password" name="user_password" class="form-control" id="yourPassword" required>
                <div class="invalid-feedback">Please enter your new password!</div>
            </div>

            <div class="col-12">
                <label for="yourPassword" class="form-label">Confirm Password</label>
                <input type="password" name="confirm_user_password" class="form-control" id="yourPassword" required>
                <div class="invalid-feedback">Please confirm your new password!</div>
            </div>

            <div class="col-12">
                <button class="btn btn-primary w-100" type="submit" name="change-password">Change Password</button>
            </div>

            <!-- go back to login page -->
            <div class="col-12">
                <p class="small mb-0"><a href="?page=login">Go back to login page</a></p>
            </div>
        </form>

    </div>
</div>