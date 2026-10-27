<?php

require "db.php";

if (!isset($_SESSION["user_id"]) ||
    $_SESSION["role"] !== "admin") {

    header("Location: login.php");
    exit;

}

$id = intval($_GET["id"] ?? 0);

if ($id > 0) {

    $stmt = $conn->prepare(
        "UPDATE users
         SET status = 'approved'
         WHERE id = ?
         AND role = 'employee'"
    );

    $stmt->bind_param("i", $id);

    $stmt->execute();

    $stmt->close();
}

header("Location: dashboard.php");

exit;

?>