<?php 
require "parts/header.php"; ?>

<div class="auth-shell container">
  <div class="auth-card card p-4 p-md-5 ig-card">
    <div class="text-center mb-4">
      <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill" style="background: rgba(255, 36, 66, 0.12); color: #ff2442; font-weight: 800;">
        <i class="bi bi-camera-fill"></i> Welcome back
      </div>
      <h1 class="h2 fw-bold mt-3 mb-1">Log in to NoteSquare</h1>
      <p class="text-muted mb-0 fs-6">Stay close to your feed and manage posts effortlessly.</p>
    </div>

    <?php require "parts/success_message.php"; ?>
    <?php require "parts/error_message.php"; ?>

    <form method="POST" action="<?= BASE_PATH ?>/auth/login" class="mt-3">
      <input type="hidden" name="csrf_token" value="<?= e(getCsrfToken()); ?>">
      <div class="mb-4">
        <label for="email" class="form-label fw-semibold fs-6">Email</label>
        <input
          type="text"
          class="form-control form-control-lg"
          id="email"
          placeholder="you@example.com"
          name="email"
        />
      </div>
      <div class="mb-4">
        <label for="password" class="form-label fw-semibold fs-6">Password</label>
        <input
          type="password"
          class="form-control form-control-lg"
          id="password"
          placeholder="Your password"
          name="password"
        />
      </div>
      <div class="d-grid mb-2">
        <button type="submit" class="btn btn-primary py-3 fs-5">Login</button>
      </div>
    </form>

    <div class="d-flex justify-content-between align-items-center gap-3 pt-3">
      <a href="<?= BASE_PATH ?>/" class="text-decoration-none fs-6 fw-semibold"
        ><i class="bi bi-arrow-left-circle"></i> Back to home</a>
      <a href="<?= BASE_PATH ?>/signup" class="text-decoration-none fs-6 fw-semibold"
        >Create account <i class="bi bi-arrow-right-circle"></i>
      </a>
    </div>
  </div>
</div>
<?php require 'parts/footer.php';
