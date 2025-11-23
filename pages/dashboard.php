<?php 
  // check if user is logged in or not
  checkIfuserIsNotLoggedIn();

  require "parts/header.php"; ?>

<div class="container mx-auto my-5" style="max-width: 1100px;">
  <div class="text-center mb-4">
    <div class="d-inline-flex align-items-center gap-2 px-4 py-3 rounded-pill" style="background: rgba(255, 36, 66, 0.12); color: #ff2442; font-weight: 800; font-size: 1.05rem;">
      <i class="bi bi-speedometer2"></i> Dashboard
    </div>
    <h1 class="display-6 fw-bold mt-3">Control center</h1>
    <p class="text-muted mb-0 fs-5">Different options appear based on your role.</p>
  </div>

  <?php require "parts/success_message.php"; ?>

  <div class="row g-4">
    <!-- Manage Posts-->
    <div class="col-12 col-md-6 col-lg-3">
      <div class="card p-4 h-100">
        <div class="d-flex align-items-center gap-3">
          <div class="avatar-dot"><i class="bi bi-pencil-square"></i></div>
          <div>
            <div class="fw-bold">My Posts</div>
            <small class="text-muted">Create or edit.</small>
          </div>
        </div>
        <div class="mt-3">
          <a href="<?= BASE_PATH ?>/manage-posts" class="btn btn-primary w-100 btn-lg fw-bold">Open</a>
        </div>
      </div>
    </div>

    <!-- Favorites -->
    <div class="col-12 col-md-6 col-lg-3">
      <div class="card p-4 h-100">
        <div class="d-flex align-items-center gap-3">
          <div class="avatar-dot"><i class="bi bi-heart-fill"></i></div>
          <div>
            <div class="fw-bold">Favorites</div>
            <small class="text-muted">What you liked.</small>
          </div>
        </div>
        <div class="mt-3">
          <a href="<?= BASE_PATH ?>/favorites" class="btn btn-primary w-100 btn-lg fw-bold">Open</a>
        </div>
      </div>
    </div>

    <!-- Manage Profile -->
    <div class="col-12 col-md-6 col-lg-3">
      <div class="card p-4 h-100">
        <div class="d-flex align-items-center gap-3">
          <div class="avatar-dot"><i class="bi bi-person-circle"></i></div>
          <div>
            <div class="fw-bold">Your Profile</div>
            <small class="text-muted">Name and password.</small>
          </div>
        </div>
        <div class="mt-3">
          <a href="<?= BASE_PATH ?>/manage-users-profile" class="btn btn-primary w-100 btn-lg fw-bold">Open</a>
        </div>
      </div>
    </div>

    <!-- Admin only -->
    <?php if ($_SESSION['user']['role'] == 'admin') : ?>
    <div class="col-12 col-md-6 col-lg-3">
      <div class="card p-4 h-100">
        <div class="d-flex align-items-center gap-3">
          <div class="avatar-dot"><i class="bi bi-shield-lock"></i></div>
          <div>
            <div class="fw-bold">Admin</div>
            <small class="text-muted">Users & feedback.</small>
          </div>
        </div>
        <div class="mt-3 d-grid gap-2">
          <a href="<?= BASE_PATH ?>/manage-users" class="btn btn-primary w-100 btn-lg fw-bold">Users</a>
          <a href="<?= BASE_PATH ?>/manage-contacts" class="btn btn-outline-secondary w-100 btn-lg fw-bold">Feedback</a>
        </div>
      </div>
    </div>
    <?php endif; ?>

  </div>

  <div class="mt-5 text-center">
    <a href="<?= BASE_PATH ?>/" class="btn btn-outline-secondary btn-lg px-4 fw-bold" style="border-radius:14px;">
      <i class="bi bi-house-door"></i> Back to Home
    </a>
  </div>
</div>

<?php require 'parts/footer.php'; ?>
