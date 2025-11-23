<?php

  // check if user is logged in or not
  checkIfuserIsNotLoggedIn();

  // check if the user is admin or not
  checkIfIsNotAdmin();

  //get the id from the URL /manage-users.edit?id=1
  $id = $_GET['id'];
?>

<?php require "parts/header.php"; ?>
<div class="container mx-auto my-5" style="max-width: 700px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="display-6 fw-bold">Change Password</h1>
      </div>
      <div class="card mb-2 p-4">
        <!--
        Requirements:
        - [DONE] setup the form with action route and method
        - [DONE] Add names into the fields
        - [DONE] setup a hidden input for the $user['id']
        - display the error message
        -->
        <form method="POST" action="<?= BASE_PATH ?>/user/changepwd">
          <input type="hidden" name="csrf_token" value="<?= e(getCsrfToken()); ?>">
          <div class="mb-3">
          <?php require "parts/error_message.php"?>
            <div class="row">
              <div class="col">
                <label for="password" class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control form-control-lg" id="password" />
              </div>
              <div class="col">
                <label for="confirm-password" class="form-label fw-semibold"
                  >Confirm Password</label
                >
                <input
                  name="confirm_password"
                  type="password"
                  class="form-control form-control-lg"
                  id="confirm-password"
                />
              </div>
            </div>
          </div>

          <!-- hidden input field for id -->
          <input type="hidden" name="id" value="<?= e($id); ?>">
    
          <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg fw-bold">
              Change Password
            </button>
          </div>
        </form>
      </div>
      <div class="text-center mt-3">
        <a href="<?= BASE_PATH ?>/manage-users" class="btn btn-outline-secondary btn-lg px-4 fw-bold" style="border-radius:14px;"
          ><i class="bi bi-arrow-left"></i> Back to Users</a>
      </div>
    </div>
    <?php require 'parts/footer.php';
