<?php
// connect to the database
$database = connectToDB();

// get the comment ID from the URL
$comment_id = $_GET["id"];
$post_id = $_GET["post_id"];
$user_id = $_SESSION["user"]["id"];

// error checking
// make sure all the fields are not empty
if (empty($comment_id) || empty($user_id) || empty($post_id)) {
    setError( "All the fields are required.", "/post?id=" . $post_id);
}

$sql = "SELECT * FROM comments WHERE id = :comment_id AND user_id = :user_id";
// prepare (put everything into the bowl)
$query = $database->prepare($sql);
// execute (cook it)
$query->execute([
    'comment_id' => $comment_id,
    'user_id' => $user_id
]);
$comment = $query->fetch();

if (!$comment) {
    setError( "You cannot edit this comment.", "/post?id=" . $post_id);
}

// update comment form processing
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    verifyCsrfToken($_POST['csrf_token'] ?? '');
    $updated_comment = $_POST["comment"];

// error checking
// make sure all the fields are not empty
    if (empty($updated_comment)) {
        setError( "All the fields are required.", "/comment/edit?id=" . $comment_id . "&post_id=" . $post_id);
    }

    $sql = "UPDATE comments SET comment = :comment WHERE id = :id";
// prepare (put everything into the bowl)
    $query = $database->prepare($sql);
// execute (cook it)
    $query->execute([
        'comment' => $updated_comment,
        'id' => $comment_id
    ]);

    redirect( "/post?id=" . $post_id );
}

?>

<!-- comment Form -->
<?php require 'parts/header.php'; ?>

<div class="container my-5" style="max-width: 640px;">
    <div class="card ig-card p-4 p-md-5">
        <div class="d-flex align-items-center gap-2 mb-3">
            <div>
                <h2 class="h4 fw-bold mb-0">Edit your comment</h2>
                <small class="text-muted">Update and go back to the post.</small>
            </div>
        </div>
        <form method="POST" action="">
            <input type="hidden" name="csrf_token" value="<?= e(getCsrfToken()); ?>">
            <div class="mb-4">
                <label for="comment" class="form-label fw-semibold">Your Comment</label>
                <textarea class="form-control form-control-lg" id="comment" name="comment" rows="4" required><?= e($comment['comment']); ?></textarea>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary btn-lg px-4">Save Changes</button>
            </div>
        </form>
    </div>
    <div class="text-center mt-3">
        <a href="<?= BASE_PATH ?>/post?id=<?= e($post_id); ?>" class="btn btn-outline-secondary btn-lg px-4 fw-bold" style="border-radius:14px;">
            <i class="bi bi-arrow-left"></i> Back to Post
        </a>
    </div>
</div>

<?php require 'parts/footer.php'; ?>
