<?php
  checkIfuserIsNotLoggedIn();

  $database = connectToDB();

  $sql = "SELECT 
            posts.id, posts.title, posts.content, posts.image, posts.created_at,
            users.name
          FROM likes
          JOIN posts ON likes.post_id = posts.id
          JOIN users ON posts.user_id = users.id
          WHERE likes.user_id = :user_id AND likes.type = 1
          GROUP BY posts.id
          ORDER BY posts.created_at DESC";

  $query = $database->prepare($sql);
  $query->execute([
    'user_id' => $_SESSION['user']['id']
  ]);
  $posts = $query->fetchAll();

  require "parts/header.php";
?>

<div class="container my-5">
  <div class="text-center mb-4">
    <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill" style="background: rgba(255, 36, 66, 0.12); color: #ff2442; font-weight: 800;">
      <i class="bi bi-heart-fill"></i> Favorites
    </div>
    <h1 class="display-6 fw-bold mt-3">Saved posts you love</h1>
    <p class="text-muted mb-0 fs-6">Revisit anything you liked in one place.</p>
  </div>

  <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div class="text-muted fw-semibold">Total saved: <?= e(count($posts)); ?></div>
    <a href="<?= BASE_PATH ?>/manage-posts" class="btn btn-primary btn-lg px-4 fw-bold">Create new</a>
  </div>

  <div class="row g-4">
    <?php if (empty($posts)) : ?>
      <div class="col-12">
        <div class="card ig-card p-4 text-center text-muted">
          <i class="bi bi-heart" style="font-size: 2rem;"></i>
          <p class="mt-2 mb-0">You have no favorites yet.</p>
        </div>
      </div>
    <?php endif; ?>

    <?php foreach ($posts as $post) : 
      $initial = strtoupper(substr($post['name'], 0, 1));
      $excerpt = strip_tags($post['content']);
      if (strlen($excerpt) > 140) { $excerpt = substr($excerpt, 0, 140) . '...'; }
    ?>
      <div class="col-12 col-md-6 col-xl-4">
        <div class="card feed-card h-100">
          <?php if (!empty($post['image'])) : ?>
            <img src="<?= e($post['image']); ?>" class="card-img-top" alt="Post Image">
          <?php endif; ?>
          <div class="card-body">
            <div class="feed-meta mb-3">
              <div>
                <div class="fw-bold"><?= e($post['name']); ?></div>
                <small class="text-muted">Shared a post</small>
              </div>
            </div>
            <h5 class="card-title mb-2"><?= e($post['title']); ?></h5>
            <p class="card-text text-muted mb-3"><?= e($excerpt); ?></p>
            <div class="d-flex justify-content-between align-items-center">
              <div class="text-muted small">Saved</div>
              <a href="<?= BASE_PATH ?>/post?id=<?= e($post['id']); ?>" class="btn btn-primary btn-sm px-3">Read</a>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="text-center mt-4">
    <a href="<?= BASE_PATH ?>/" class="btn btn-outline-secondary btn-lg px-4 fw-bold" style="border-radius:14px;">
      <i class="bi bi-house-door"></i> Back to Home
    </a>
  </div>
</div>

<?php require 'parts/footer.php'; ?>
