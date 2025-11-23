<?php

$database = connectToDB(); 
verifyCsrfToken($_POST['csrf_token'] ?? '');

// get the form data
$title = $_POST["title"];
$content = $_POST["content"];
$user_id = $_SESSION["user"]["id"];
$status = $_POST["status"] ?? "publish";

// error checking
// make sure all the fields are not empty
if ( empty( $title ) || empty( $content ) ) {
    setError( "All the fields are required.", "/manage-posts-add" );
}

// Image upload
$image = null; // Default image is null
if (!empty($_FILES['image']['name'])) { // Check if image is uploaded
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }
    $ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];
    $allowedMimes = ['image/jpeg', 'image/png', 'image/gif'];

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES['image']['tmp_name']);
    finfo_close($finfo);

    if (in_array($ext, $allowedFileTypes, true) && in_array($mime, $allowedMimes, true) && $_FILES["image"]["size"] <= 2000000) {
        $targetFile = $targetDir . bin2hex(random_bytes(16)) . '.' . $ext; // unique name to avoid collisions
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
        $image = $targetFile;
    } else {
        setError("Invalid image file.", "/manage-posts-add");
    }
}


// insert data into the database
$sql = "INSERT INTO posts (`title`, `content`, `user_id`, `image`, `status`) VALUES (:title, :content, :user_id, :image, :status)";
// prepare (put everything into the bowl)
$query = $database->prepare($sql);
// execute (cook it)
$query->execute([
    'title' => $title,
    'content' => $content,
    'user_id' => $user_id,
    'image' => $image,
    'status' => $status
]);

// redirect to manage posts
$_SESSION["success"] = "Post added successfully.";
redirect( "/manage-posts" );
