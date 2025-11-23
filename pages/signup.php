<?php 
require "parts/header.php"; ?>

<div class="auth-shell container">
  <div class="auth-card card p-4 p-md-5 ig-card">
    <div class="text-center mb-4">
      <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill" style="background: rgba(255, 36, 66, 0.12); color: #ff2442; font-weight: 800;">
        <i class="bi bi-camera-fill"></i> Join NoteSquare
      </div>
      <h1 class="h2 fw-bold mt-3 mb-1">Create your NoteSquare account</h1>
      <p class="text-muted mb-0 fs-6">Sign up to share, like, and discuss posts.</p>
    </div>

    <?php require 'parts/error_message.php'; ?>
    <form method="POST" action="<?= BASE_PATH ?>/auth/signup" class="mt-3">
      <input type="hidden" name="csrf_token" value="<?= e(getCsrfToken()); ?>">
      <div class="mb-4">
        <label for="name" class="form-label fw-semibold fs-6">Name</label>
        <input type="text" class="form-control form-control-lg" id="name" name="name" placeholder="Your full name" />
      </div>
      <div class="mb-4">
        <label for="email" class="form-label fw-semibold fs-6">Email address</label>
        <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="you@example.com" />
      </div>
      <div class="mb-4">
        <label for="password" class="form-label fw-semibold fs-6">Password</label>
        <input
          type="password"
          class="form-control form-control-lg"
          id="password"
          name="password"
          placeholder="At least 8 characters"
        />
      </div>
      <div class="mb-4">
        <label for="confirm_password" class="form-label fw-semibold fs-6"
          >Confirm Password</label
        >
        <input
          type="password"
          class="form-control form-control-lg"
          id="confirm_password"
          name="confirm_password"
          placeholder="Repeat your password"
        />
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-primary py-3 fs-5">
          Create account
        </button>
      </div>
    </form>

    <div class="d-flex justify-content-between align-items-center gap-3 pt-3">
      <a href="<?= BASE_PATH ?>/" class="text-decoration-none fs-6 fw-semibold"
        ><i class="bi bi-arrow-left-circle"></i> Back to home</a
      >
      <a href="<?= BASE_PATH ?>/login" class="text-decoration-none fs-6 fw-semibold"
        >Already a member? Login <i class="bi bi-arrow-right-circle"></i
      ></a>
    </div>
  </div>
</div>
<?php require 'parts/footer.php';
