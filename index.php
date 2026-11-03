
<?php
include 'db.php';

$message = "";

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
        die("SQL Error: " . mysqli_error($conn));
    }

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
        $message = "Employee details inserted successfully!";
    } else {
        $message = "Error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
}

$result = mysqli_query($conn, "SELECT * FROM employees");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Registration</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h2>Employee Registration Form</h2>

    <p class="message">
        <?php echo htmlspecialchars($message); ?>
    </p>

    <form method="POST" action="">

        <label>Employee Name</label>
        <input type="text" name="name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Phone Number</label>
        <input type="text" name="phone" required>

        <label>Department</label>
        <input type="text" name="department" required>

        <label>Designation</label>
        <input type="text" name="designation" required>

        <label>Salary</label>
        <input type="number" name="salary"
               step="0.01" min="0" required>

        <button type="submit" name="submit">
            Submit
        </button>

        <button type="reset" class="reset">
            Reset
        </button>

    </form>

</div>


<div class="table-container">

    <h2>Employee Details</h2>

    <table>

        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Department</th>
            <th>Designation</th>
            <th>Salary</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>

        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['phone']); ?></td>
            <td><?php echo htmlspecialchars($row['department']); ?></td>
            <td><?php echo htmlspecialchars($row['designation']); ?></td>
            <td><?php echo $row['salary']; ?></td>
        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>