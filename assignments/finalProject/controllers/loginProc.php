<?php
session_start();
require_once(dirname(__DIR__) . '/classes/Pdo_methods.php');

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

if(empty($email) || empty($password)) {
    $_SESSION['login_error'] = 'Email and password required.';
    header('location: ../index.php?page=login');
    exit;
}

$pdo = new PdoMethods();
$sql = "SELECT * FROM admins WHERE email = :email";
$bindings = [
    [':email', $email, 'str']
];

$result = $pdo->selectBinded($sql, $bindings);

if($result === 'error' || count($result) === 0) {
    $_SESSION['login_error'] = 'invalide email or password.';
    header('location: ../index.php?page=login');
    exit;
}

$admin = $result[0];

if(!password_verify($password, $admin['password'])) {
    $_SESSION['login_error'] = 'Invalid email or password.';
    header('location: ../index.php?page=login');
    exit;
}

// Store user info in session
$_SESSION['user_id']   = $admin['id'];
$_SESSION['status']    = $admin['status'];
$_SESSION['fname']     = $admin['fname'];
$_SESSION['lname']     = $admin['lname'];

header('location: ../index.php?page=welcome');
exit;
?>