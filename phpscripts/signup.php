<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require 'db.php';

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password before saving
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $fname, $lname, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo "<script>
                Swal.fire('Success!', 'Account created successfully!', 'success')
                .then(() => window.location.href = '../login.html');
              </script>";
    } else {
        echo "<script>
                Swal.fire('Error', 'Email already exists or something went wrong.', 'error');
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
