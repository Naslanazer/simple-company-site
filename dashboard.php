<?php

require "db.php";

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit;

}

$userId = $_SESSION["user_id"];
$role = $_SESSION["role"];
$name = $_SESSION["name"];

?>

<!DOCTYPE html>
<html>

<head>

    <title>Dashboard</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<header>

    <div class="logo">
        ABC Company
    </div>

    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </nav>

</header>

<div class="dashboard">

    <div class="dashboard-header">

        <h1>
            Welcome, <?= htmlspecialchars($name) ?>
        </h1>

        <p>
            Role:
            <strong>
                <?= htmlspecialchars(ucfirst($role)) ?>
            </strong>
        </p>

        <a href="logout.php" class="logout">
            Logout
        </a>

    </div>


    <?php if ($role === "admin"): ?>

        <div class="card">

            <h3>Employee Management</h3>

            <p>
                View registered employees and approve
                pending employee accounts.
            </p>

        </div>

        <?php include "users.php"; ?>


    <?php elseif ($role === "employee"): ?>

        <div class="card">

            <h3>Administrator Details</h3>

            <p>
                You are an approved employee.
                Below are the company administrators.
            </p>

        </div>

        <?php

        $stmt = $conn->prepare(
            "SELECT name, email, phone, department
             FROM users
             WHERE role = 'admin'
             AND status = 'approved'"
        );

        $stmt->execute();

        $admins = $stmt->get_result();

        ?>

        <table>

            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Department</th>
            </tr>

            <?php while ($admin = $admins->fetch_assoc()): ?>

                <tr>

                    <td>
                        <?= htmlspecialchars($admin["name"]) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($admin["email"]) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($admin["phone"]) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($admin["department"]) ?>
                    </td>

                </tr>

            <?php endwhile; ?>

        </table>

        <?php $stmt->close(); ?>

    <?php endif; ?>

</div>

</body>

</html>