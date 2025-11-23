<?php

    // Make sure only admin can access this script
    checkIfuserIsNotLoggedIn();
    checkIfIsNotAdmin();

    // 1. connect to database
    $database = connectToDB();
    verifyCsrfToken($_POST['csrf_token'] ?? '');
    // 2. get all the data from the form using $_POST
    $name = $_POST["name"];
    $role = $_POST["role"];
    $id = $_POST["id"];
    // prevent changing your own role (avoid lockout)
    if ( $id == $_SESSION['user']['id'] && $role !== $_SESSION['user']['role'] ) {
        setError( "You cannot change your own role.", '/manage-users-edit?id=' . $id );
    }
    // 3. do error checking - make sure all the fields are not empty
    if ( empty( $name ) || empty( $role ) ) {
        setError( "Please fill in the form.", '/manage-users-edit?id=' . $id );
    }
    // 4. update the user data
    
    // 4.1
    $sql = "UPDATE users SET name = :name, role = :role WHERE id = :id";
    // 4.2
    $query = $database->prepare( $sql );
    // 4.3
    $query->execute([
        'name' => $name,
        'role' => $role,
        'id' => $id
    ]);
    // 5. Redirect back to /manage-users
    redirect( "/manage-users" );
