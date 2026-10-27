<?php

require "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $phone = trim($_POST["phone"] ?? "");
    $department = trim($_POST["department"] ?? "");

    if ($name === "" || $email === "" || $password === "") {

        $message = "Please fill all required fields.";

    } else {

        $check = $conn->prepare(
            "SELECT id FROM users WHERE email = ?"
        );

        $check->bind_param("s", $email);
        $check->execute();

        $result = $check->get_result();

        if ($result->num_rows > 0) {

            $message = "Email already registered.";

        } else {

            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $role = "employee";
            $status = "pending";

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

                $message =
                    "Registration successful. Wait for admin approval.";

            } else {

                $message = "Registration failed.";

            }

            $stmt->close();
        }

        $check->close();
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Employee Registration</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="form-container">

    <h2>Employee Registration</h2>

    <?php if ($message): ?>

        <div class="message">
            <?= htmlspecialchars($message) ?>
        </div>

    <?php endif; ?>

    <form method="POST">

        <label>Name</label>

        <input
            type="text"
            name="name"
            required
        >

        <label>Email</label>

        <input
            type="email"
            name="email"
            required
        >

        <label>Password</label>

        <input
            type="password"
            name="password"
            required
        >

        <label>Phone</label>

        <input
            type="text"
            name="phone"
        >

        <label>Department</label>

        <input
            type="text"
            name="department"
        >

        <button type="submit">
            Register
        </button>

    </form>

    <p style="margin-top:20px;text-align:center;">
        Already registered?
        <a href="login.php">Login</a>
    </p>

</div>

</body>

</html>