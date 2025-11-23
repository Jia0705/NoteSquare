<?php

// 1. connect to the database
$database = connectToDB();
verifyCsrfToken($_POST['csrf_token'] ?? '');

// 2. get all the data from the form using $_POST
$post_id = $_POST["id"];
$title = $_POST["title"];
$content = $_POST["content"];
$status = $_POST["status"];

// Make sure the post exists and belongs to this user (unless admin/editor)
$sql = "SELECT user_id FROM posts WHERE id = :id";
$query = $database->prepare($sql);
$query->execute(['id' => $post_id]);
$post = $query->fetch();

if (!$post) {
    setError("Post not found.", "/manage-posts");
}

// If normal user and not the owner -> block
if ($_SESSION['user']['role'] === 'user' && $post['user_id'] != $_SESSION['user']['id']) {
    setError("Oops", "/manage-posts");
}

// 3. do error checking - make sure all the fields are not empty
if (empty($title) || empty($content) || empty($status)) {
    setError("Please fill in everything.", '/manage-posts-edit?id=' . $post_id);
    exit;
}

// Image upload
$image = null; // Default image is null
if (!empty($_FILES['image']['name'])) { // Check if image is uploaded
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }
    $ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    
    // Check if the file type is allowed
    $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];
    $allowedMimes = ['image/jpeg', 'image/png', 'image/gif'];

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES['image']['tmp_name']);
    finfo_close($finfo);

    if (in_array($ext, $allowedFileTypes, true) && in_array($mime, $allowedMimes, true) && $_FILES["image"]["size"] <= 2000000) {
        $targetFile = $targetDir . bin2hex(random_bytes(16)) . '.' . $ext; // unique name to avoid collisions
        // Delete the old image if a new one is uploaded
        $sql = "SELECT image FROM posts WHERE id = :id";
        $query = $database->prepare($sql);
        $query->execute(['id' => $post_id]);
        $oldPost = $query->fetch();
        if (!empty($oldPost['image']) && file_exists($oldPost['image']) && $oldPost['image'] !== 'null') {
            unlink($oldPost['image']);
        }
        // Move the new image to the target directory
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
        $image = $targetFile;
    } else {
        setError("Invalid file type or file too large. Please upload a valid image.", '/manage-posts-edit?id=' . $post_id);
        exit;
    }
}

// 4. update the post 
// Prepare the base SQL query for updating
$sql = "UPDATE posts SET `title` = :title, `content` = :content, `status` = :status";

// Include the image in the update if one is provided
if ($image) {
    $sql .= ", `image` = :image";
}
$sql .= " WHERE `id` = :id";

// Prepare and execute the query
$query = $database->prepare($sql);
$params = [
    'title' => $title,
    'content' => $content,
    'status' => $status,
    'id' => $post_id
];
if ($image) {
    $params['image'] = $image;
}
$query->execute($params);

// 5. Redirect back to /manage-posts
$_SESSION["success"] = "Post updated successfully.";
redirect("/manage-posts");
