<?php
// login.php
session_start();
require_once 'users.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';
    $found = false;
    foreach ($users as $user) {
        if ($user['username'] === $username && $user['password'] === $password && $user['role'] === $role) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['userRole'] = $user['role'];
            $found = true;
            break;
        }
    }
    if ($found) {
        echo json_encode(["success" => true, "role" => $_SESSION['userRole'], "fullname" => $_SESSION['fullname']]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid credentials or role."]);
    }
    exit;
}
echo json_encode(["success" => false, "message" => "Invalid request."]);
