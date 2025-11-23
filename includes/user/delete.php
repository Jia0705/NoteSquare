<?php

    // Make sure only admin can access this script
    checkIfuserIsNotLoggedIn();
    checkIfIsNotAdmin();

    // 1. connect to Database
    $database = connectToDB();
    verifyCsrfToken($_POST['csrf_token'] ?? '');

    // 2. get the user_id from the form
    $user_id = $_POST["id"];

    // prevent deleting own account
    if ( $user_id == $_SESSION['user']['id'] ) {
        setError("You cannot delete your own account.", "/manage-users");
    }

    // 3. delete the user
    // 3.1
    $sql = "DELETE FROM users where id = :id";
    // 3.2
    $query = $database->prepare( $sql );
    // 3.3
    $query->execute([
        'id' => $user_id
    ]);

    // 4. redireact to manage users
    redirect( "/manage-users" );
