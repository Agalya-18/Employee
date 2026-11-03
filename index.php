<?php
include 'db.php';

$message = "";
$message_type = "";

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];
    $designation = $_POST['designation'];
    $salary = $_POST['salary'];

    $sql = "INSERT INTO employees
    (first_name, email, phone, department, designation, salary)
    VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        $message = "Database Error: " . mysqli_error($conn);
        $message_type = "error";
    } else {

        mysqli_stmt_bind_param(
            $stmt,
            "sssssd",
            $name,
            $email,
            $phone,
            $department,
            $designation,
            $salary
        );

        if (mysqli_stmt_execute($stmt)) {
            $message = "Employee registered successfully!";
            $message_type = "success";
        } else {
            $message = "Error: " . mysqli_stmt_error($stmt);
            $message_type = "error";
        }

        mysqli_stmt_close($stmt);
    }
}

$result = mysqli_query(
    $conn,
    "SELECT * FROM employees ORDER BY id DESC"
);

if (!$result) {
    die("Database Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Management System</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<div class="main-header">
    <h1>Employee Management System</h1>
    <p>Register and manage employee information easily</p>
</div>

<div class="container">

    <div class="form-header">
        <h2>Employee Registration</h2>
        <p>Enter the employee details below</p>
    </div>

    <?php if ($message != "") { ?>
        <div class="message <?php echo $message_type; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php } ?>

    <form method="POST" action="">

        <div class="form-group">
            <label>Employee Name</label>
            <input type="text" name="name"
                   placeholder="Enter employee name" required>
        </div>

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email"
                   placeholder="Enter email address" required>
        </div>

        <div class="form-group">
            <label>Phone Number</label>
            <input type="text" name="phone"
                   placeholder="Enter phone number" required>
        </div>

        <div class="form-group">
            <label>Department</label>
            <input type="text" name="department"
                   placeholder="Enter department" required>
        </div>

        <div class="form-group">
            <label>Designation</label>
            <input type="text" name="designation"
                   placeholder="Enter designation" required>
        </div>

        <div class="form-group">
            <label>Salary (₹)</label>
            <input type="number" name="salary"
                   placeholder="Enter salary"
                   step="0.01" min="0" required>
        </div>

        <div class="button-group">
            <button type="submit" name="submit" class="submit-btn">
                Register Employee
            </button>

            <button type="reset" class="reset-btn">
                Reset
            </button>
        </div>

    </form>

</div>


<div class="table-container">

    <div class="table-header">
        <h2>Employee Details</h2>
        <p>View all registered employees</p>
    </div>

    <div class="table-responsive">

        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Salary</th>
                </tr>
            </thead>

            <tbody>

                <?php if (mysqli_num_rows($result) > 0) { ?>

                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>

                        <td class="employee-name">
                            <?php echo htmlspecialchars($row['first_name']); ?>
                        </td>

                        <td><?php echo htmlspecialchars($row['email']); ?></td>

                        <td><?php echo htmlspecialchars($row['phone']); ?></td>

                        <td>
                            <span class="department">
                                <?php echo htmlspecialchars($row['department']); ?>
                            </span>
                        </td>

                        <td><?php echo htmlspecialchars($row['designation']); ?></td>

                        <td class="salary">
                            ₹<?php echo number_format((float)$row['salary'], 2); ?>
                        </td>
                    </tr>

                    <?php } ?>

                <?php } else { ?>

                    <tr>
                        <td colspan="7" class="no-data">
                            No employee records found.
                        </td>
                    </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>