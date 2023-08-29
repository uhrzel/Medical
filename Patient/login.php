<div class="card mb-3">

    <div class="card-body">

        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">
                <i class="bi bi-person-check"></i> Patient Portal Login
            </h5>
            <p class="text-center small">Enter your username and password to login.</p>
        </div>

        <?= Session::display_session_msg(); ?>

        <form class="row g-3 needs-validation" novalidate method="POST">

            <div class="col-12">
                <label for="yourUsername" class="form-label">Username</label>
                <div class="input-group has-validation">
                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                    <input type="text" name="user_name" class="form-control" id="yourUsername" required autofocus value="<?= Input::get('user_name') ?>">
                    <div class="invalid-feedback">Please enter your username.</div>
                </div>
            </div>

            <div class="col-12">
                <label for="yourPassword" class="form-label">Password</label>
                <input type="password" name="user_password" class="form-control" id="yourPassword" required>
                <p class="small mb-0"><a href="?page=verify-email">Forgot password?</a></p>
                <div class="invalid-feedback">Please enter your password!</div>
            </div>

            <div class="col-12">
                <button class="btn btn-primary w-100" type="submit" name="login">Login</button>
            </div>

            <div class="col-12">
                <p class="small mb-0">Don't have an account? <a href="?page=register">Register</a></p>
            </div>
        </form>

    </div>
</div>