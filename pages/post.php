<?php

// 1. get the id from the URL
$id = $_GET["id"];
// 2. connect to Database
$database = connectToDB();
// 3. load the Post data
$sql = "SELECT 
          posts.id, posts.title, posts.content, posts.user_id, posts.image, users.name,
          COALESCE(SUM(CASE WHEN likes.type = 1 THEN 1 ELSE 0 END), 0) AS likes_count,
          COALESCE(SUM(CASE WHEN likes.type = 0 THEN 1 ELSE 0 END), 0) AS dislikes_count
        FROM posts 
        JOIN users 
        ON posts.user_id = users.id 
        LEFT JOIN likes ON likes.post_id = posts.id
        WHERE posts.id = :id
        GROUP BY posts.id, users.name";  
$query = $database->prepare($sql);
$query->execute([
  'id' => $id
]);
$post = $query->fetch();

if (!$post) {
  redirect("/");
}

// Fetch comments to the post
$sql = "SELECT comments.*, users.name AS unknown 
        FROM comments 
        JOIN users ON comments.user_id = users.id 
        WHERE comments.post_id = :post_id";
$query = $database->prepare($sql);
$query->execute(['post_id' => $id]);
$comments = $query->fetchAll();

require "parts/header.php"; ?>

<div class="container my-5" style="max-width: 1100px;">
  <div class="row g-4">
    <!-- post section -->
    <div class="col-12 col-lg-7">
      <div class="card ig-card p-3">
        <div class="d-flex align-items-center gap-3 mb-3">
          <div class="avatar-dot"><i class="bi bi-person"></i></div>
          <div>
            <div class="fw-bold"><?= e($post['name']); ?></div>
            <small class="text-muted">Shared a post</small>
          </div>
        </div>
        <h2 class="h4 fw-bold mb-3"><?= e($post['title']); ?></h2>
        <?php if (!empty($post['image'])) : ?>
            <div class="text-center mb-3">
                <img src="<?= e($post['image']); ?>" alt="Post Image" class="img-fluid rounded">
            </div>
        <?php endif; ?>
        <p class="fs-6" style="line-height: 1.7;"><?= nl2br(e($post['content'])); ?></p>

        <!-- likes section -->
        <?php if (isset($_SESSION['user'])) : ?>
          <div class="mt-3">
            <form method="POST" action="<?= BASE_PATH ?>/like" id="likeForm" class="d-flex gap-2">
                <input type="hidden" name="csrf_token" value="<?= e(getCsrfToken()); ?>">
                <input type="hidden" name="post_id" value="<?= e($id); ?>">

                <!-- like -->
                <button type="submit" name="action" value="1" 
                    class="btn btn-outline-danger btn-sm px-3">
                    <i class="bi bi-heart"></i> Like (<?= e($post['likes_count']); ?>)
                </button>

                <!-- dislike -->
                <button type="submit" name="action" value="0" 
                    class="btn btn-outline-secondary btn-sm px-3">
                    <i class="bi bi-heartbreak"></i> Pass (<?= e($post['dislikes_count']); ?>)
                </button>
            </form>
        </div>
        <?php else : ?>
          <p class="mt-3">
            Please <a href="<?= BASE_PATH ?>/login">log in</a> to like or dislike this post.
          </p>
        <?php endif; ?>
      </div>
    </div>

    <!-- comments section -->
    <div class="col-12 col-lg-5">
      <div class="card ig-card p-3 h-100">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <h3 class="h5 mb-0">Comments</h3>
          <i class="bi bi-chat-dots text-muted"></i>
        </div>
        <?php if (!empty($comments)) : ?>
            <div class="list-group list-group-flush">
                <?php foreach ($comments as $comment) : ?>
                    <div class="list-group-item border-0 px-0 mb-2">
                        <div class="d-flex align-items-start gap-2">
                          <?php $commentInitial = strtoupper(substr($comment['unknown'], 0, 1)); ?>
                          <div class="blank"></div>
                          <div class="flex-grow-1">
                              <div class="d-flex justify-content-between align-items-center">
                                <strong><?= e($comment['unknown']); ?></strong>
                                <?php if (isset($_SESSION['user']) && $comment['user_id'] == $_SESSION['user']['id']) : ?>
                                  <div class="d-flex gap-1">
                                      <a href="<?= BASE_PATH ?>/comment/edit?id=<?= e($comment['id']); ?>&post_id=<?= e($id); ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                      <form method="POST" action="<?= BASE_PATH ?>/comment/delete" class="d-inline">
                                        <input type="hidden" name="csrf_token" value="<?= e(getCsrfToken()); ?>">
                                        <input type="hidden" name="id" value="<?= e($comment['id']); ?>">
                                        <input type="hidden" name="post_id" value="<?= e($id); ?>">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this comment?');"><i class="bi bi-trash"></i></button>
                                      </form>
                                  </div>
                                <?php endif; ?>
                              </div>
                              <p class="mb-1 text-muted"><?= nl2br(e($comment['comment'])); ?></p>
                          </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p class="text-muted">No comments yet. Be the first to comment!</p>
        <?php endif; ?>

        <!-- comment form -->
        <?php if (isset($_SESSION['user'])) : ?>
            <div class="mt-3">
                <h4 class="h6">Leave a Comment</h4>
                <form method="POST" action="<?= BASE_PATH ?>/comment/add">
                    <input type="hidden" name="csrf_token" value="<?= e(getCsrfToken()); ?>">
                    <textarea class="form-control mb-3" name="comment" placeholder="Write your comment..." rows="3" required></textarea>
                    <input type="hidden" name="post_id" value="<?= e($id); ?>">
                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                </form>
            </div>
        <?php else : ?>
            <p class="mt-3">Please <a href="<?= BASE_PATH ?>/login">log in</a> to leave a comment.</p>
        <?php endif; ?>
      </div>
      <div class="text-center mt-4">
          <a href="<?= BASE_PATH ?>/" class="btn btn-outline-secondary btn-lg px-4 fw-bold" style="border-radius: 14px;">
            <i class="bi bi-house-door"></i> Back to Home
          </a>
      </div>
    </div>
  </div>
</div>
<?php require 'parts/footer.php'; ?>
