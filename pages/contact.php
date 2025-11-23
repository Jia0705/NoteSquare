<?php 
require "parts/header.php"; 

// Check if a user is logged in
checkIfuserIsNotLoggedIn();
?>
<div class="container my-5" style="max-width: 900px;">
  <div class="text-center mb-4">
    <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill" style="background: rgba(255, 36, 66, 0.12); color: #ff2442; font-weight: 800;">
      <i class="bi bi-envelope"></i> Contact NoteSquare
    </div>
    <h1 class="display-6 fw-bold mt-3">Tell us what's on your mind</h1>
    <p class="text-muted mb-0 fs-6">We typically respond within a business day.</p>
  </div>

  <?php require "parts/success_message.php"?>
  <?php require "parts/error_message.php"?>

  <div class="card ig-card p-4 p-md-5">
    <form action="<?= BASE_PATH ?>/contact/submit" method="POST" class="row g-4">
      <input type="hidden" name="csrf_token" value="<?= e(getCsrfToken()); ?>">
      <div class="col-12 col-md-6">
        <label for="name" class="form-label fw-semibold">Your Name</label>
        <input type="text" class="form-control form-control-lg" id="name" name="name" value="<?= e($_SESSION['user']['name'] ?? ''); ?>" required>
      </div>
      <div class="col-12 col-md-6">
        <label for="email" class="form-label fw-semibold">Your Email</label>
        <input type="email" class="form-control form-control-lg bg-light" id="email" name="email" value="<?= e($_SESSION['user']['email'] ?? ''); ?>" readonly required style="box-shadow: inset 0 0 0 1000px rgba(0,0,0,0.04);">
        <small class="text-muted">Email is set from your account.</small>
      </div>
      <div class="col-12">
        <label for="message" class="form-label fw-semibold">Your Message</label>
        <textarea class="form-control form-control-lg" id="message" name="message" rows="6" required placeholder="Share your feedback or questions"></textarea>
      </div>
      <div class="col-12 text-end">
        <button type="submit" class="btn btn-primary btn-lg px-4">Send Message</button>
      </div>
    </form>
  </div>

  <div class="text-center mt-4">
    <a href="<?= BASE_PATH ?>/" class="btn btn-outline-secondary btn-lg px-4 fw-bold" style="border-radius:14px;"
      ><i class="bi bi-arrow-left"></i> Back to Home</a>
  </div>
</div>
<?php require "parts/footer.php"; ?>
