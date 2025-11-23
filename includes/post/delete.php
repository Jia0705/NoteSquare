<?php

$database = connectToDB();  
verifyCsrfToken($_POST['csrf_token'] ?? '');

// get the post ID
$post_id = $_POST["id"];

// Load post with user_id and image
$sql = "SELECT user_id, image FROM posts WHERE id = :id";

// prepare (put everything into the bowl)
$query = $database->prepare($sql);
// execute (cook it)
$query->execute([
    'id' => $post_id
]);
$post = $query->fetch();

if (!$post) {
    setError("Post not found.", "/manage-posts");
}

// Only owner or admin/editor can delete
if ($_SESSION['user']['role'] === 'user' && $post['user_id'] != $_SESSION['user']['id']) {
    setError("You are not allowed to delete this post.", "/manage-posts");
}

// delete the image file 
if (!empty($post['image']) && file_exists($post['image'])) {
    unlink($post['image']);
}

// delete the post from the database
$sql = "DELETE FROM posts WHERE id = :id";
$query = $database->prepare($sql);
$query->execute(['id' => $post_id]);

// redirect back to /manage-posts page
$_SESSION["success"] = "Post deleted successfully.";
redirect( "/manage-posts" );
