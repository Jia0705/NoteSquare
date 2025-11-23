<?php

// connect to database
function connectToDB() {
    // Step 1: list out all the database info
    $config = require __DIR__ . '/../config.php';

    $host = $config['db_host'];
    $database_name = $config['db_name'];
    $database_user = $config['db_user'];
    $database_password = $config['db_password'];

    // Step 2: connect to the database
    $database = new PDO(
        "mysql:host=$host;dbname=$database_name",
        $database_user,
        $database_password
    );

    // Throw exceptions on errors (easier to debug)
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $database;
}

// generic redirect respecting BASE_PATH
function redirect( $path ) {
    $normalized = '/' . ltrim( $path, '/' );
    header( 'Location: ' . BASE_PATH . $normalized );
    exit;
}

// set error message
function setError( $error_message, $redirect_page ) {
    $_SESSION["error"] = $error_message;
    redirect( $redirect_page );
}

// HTML escape helper (for XSS protection)
function e($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

// check if user is logged in or not
function checkIfuserIsNotLoggedIn() {
  if ( !isset( $_SESSION['user'] ) ) {
    redirect( '/login' );
  }
}

// check if current user is an admin or not
function checkIfIsNotAdmin() {
    if ( isset( $_SESSION['user'] ) && $_SESSION['user']['role'] != 'admin' ) {
        redirect( '/dashboard' );
    }
}

// CSRF helpers
function getCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrfToken($token) {
    $token = (string)$token;
    if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        setError('Invalid security token. Please try again.', '/');
    }
}
