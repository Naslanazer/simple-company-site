<?php

require "db.php";

$name = "Admin";
$email = "admin@abc.com";
$password = "admin123";
$role = "admin";
$status = "approved";
$phone = "9876543210";
$department = "Management";

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare(
    "INSERT INTO users
    (name, email, password, role, status, phone, department)
    VALUES (?, ?, ?, ?, ?, ?, ?)"
);

$stmt->bind_param(
    "sssssss",
    $name,
    $email,
    $hashedPassword,
    $role,
    $status,
    $phone,
    $department
);

if ($stmt->execute()) {
    echo "Admin created successfully.<br>";
    echo "Email: admin@abc.com<br>";
    echo "Password: admin123";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

?>