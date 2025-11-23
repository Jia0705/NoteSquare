<?php 

  // check if whoever that viewing this page is logged in
  // if not logged in, you want to redirect back to login page
  checkIfuserIsNotLoggedIn();

  // get the id from the URL
  $id = $_GET["id"];

  $database = connectToDB();
  // 2. get all the posts
  // 2.1
  $sql = "SELECT * FROM posts WHERE id =:id";
  // 2.2
  $query = $database->prepare( $sql );
  // 2.3
  $query->execute([
    'id' => $id
  ]);
  // 2.4
  $post = $query->fetch();

  // Ensure the post exists and the current user can edit it
  if (!$post) {
    setError("Post not found.", "/manage-posts");
  }
  if ($_SESSION['user']['role'] === 'user' && $post['user_id'] != $_SESSION['user']['id']) {
    setError("Oops", "/manage-posts");
  }

require "parts/header.php"; ?>
<div class="container mx-auto my-5" style="max-width: 700px;">
      <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h1 class="display-6 fw-bold mb-0">Edit Post</h1>
      </div>
      <div class="card mb-2 p-4">
        <?php require "parts/error_message.php"; ?>
        <form method="POST" action="<?= BASE_PATH ?>/post/edit" enctype="multipart/form-data">
          <input type="hidden" name="csrf_token" value="<?= e(getCsrfToken()); ?>">
          <div class="mb-3">
            <label for="post-title" class="form-label">Title</label>
            <input
              type="text"
              class="form-control form-control-lg"
              id="post-title"
              value="<?= e($post['title']); ?>"
              name="title"
            />
          </div>
          <div class="mb-3">
        <label for="image" class="form-label">Upload New Image (optional)</label>
        <input type="file" name="image" id="image" class="form-control form-control-lg">
        <?php if ($post['image']): ?>
            <p>Current Image:</p>
            <img src="<?= e($post['image']); ?>" alt="Post Image" style="max-width: 200px;">
        <?php endif; ?>
    </div>
          <div class="mb-3">
            <label for="post-content" class="form-label">Content</label>
            <textarea class="form-control form-control-lg" id="post-content" rows="10" name="content"><?= e($post['content']); ?></textarea>
          </div>
          <div class="mb-3">
            <label for="post-content" class="form-label">Status</label>
            <select class="form-select form-select-lg" id="post-status" name="status">

              <?php if ( $post['status'] == 'publish' ) : ?>
                <option value="publish" selected>Publish</option>
              <?php else: ?>
                <option value="publish">Publish</option>
              <?php endif; ?>

              <?php if ( $post['status'] == 'pending' ) : ?>
                <option value="pending" selected>Pending Review</option>
              <?php else: ?>
                <option value="pending">Pending Review</option>
              <?php endif; ?>

            </select>
          </div>
          <div class="text-end">
            <input type="hidden" name="id" value="<?= e($post['id']); ?>" />
            <button type="submit" class="btn btn-primary btn-lg px-4 fw-bold">Update</button>
          </div>
        </form>
      </div>
      <div class="text-center mt-3">
        <a href="<?= BASE_PATH ?>/manage-posts" class="btn btn-outline-secondary btn-lg px-4 fw-bold" style="border-radius:14px;"
          ><i class="bi bi-arrow-left"></i> Back to Posts</a>
      </div>
    </div>
    <?php require 'parts/footer.php';
