<?php

$stmt = $conn->prepare(
    "SELECT id, name, email, phone, department, status
     FROM users
     WHERE role = 'employee'
     ORDER BY id DESC"
);

$stmt->execute();

$employees = $stmt->get_result();

?>

<h2 style="margin-top:30px;">
    Employee Details
</h2>

<table>

    <tr>

        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Department</th>
        <th>Status</th>
        <th>Action</th>

    </tr>

    <?php while ($employee = $employees->fetch_assoc()): ?>

        <tr>

            <td>
                <?= htmlspecialchars($employee["name"]) ?>
            </td>

            <td>
                <?= htmlspecialchars($employee["email"]) ?>
            </td>

            <td>
                <?= htmlspecialchars($employee["phone"]) ?>
            </td>

            <td>
                <?= htmlspecialchars($employee["department"]) ?>
            </td>

            <td>
                <?= htmlspecialchars(ucfirst($employee["status"])) ?>
            </td>

            <td>

                <?php if ($employee["status"] === "pending"): ?>

                    <a
                        href="approve.php?id=<?= $employee["id"] ?>"
                        class="approve"
                        onclick="return confirm('Approve this employee?')"
                    >
                        Approve
                    </a>

                <?php else: ?>

                    Approved

                <?php endif; ?>

            </td>

        </tr>

    <?php endwhile; ?>

</table>

<?php

$stmt->close();

?>