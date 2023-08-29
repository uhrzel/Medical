<div class="card mb-3">

    <div class="card-body">

        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">
                <i class="bi bi-check-circle"></i> Verify OTP
            </h5>
            <p class="text-center small">Enter the OTP sent to your email</p>
        </div>

        <?= Session::display_session_msg(); ?>

        <form class="row g-3 needs-validation" novalidate method="POST" action="?page=login">

            <div class="col-12">
                <label for="yourOTP" class="form-label">
                    One Time Password (OTP)
                </label>
                <div class="input-group has-validation">
                    <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-key-fill"></i></span>
                    <input type="number" name="otp_code" class="form-control" id="yourOTP" required autofocus value="<?= Input::get('otp_code') ?>">
                    <div class="invalid-feedback">Please enter your OTP.</div>
                </div>
            </div>

            <div class="col-12">
                <button class="btn btn-primary w-100" type="submit" name="verify-otp">Verify</button>
            </div>

            <!-- go back to login page -->
            <div class="col-12">
                <p class="small mb-0"><a href="?page=login">Go back to login page</a></p>
            </div>
        </form>

    </div>
</div>