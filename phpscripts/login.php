<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require 'db.php';

    $email = $_POST['name']; // from form field "name"
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        echo "<script>
                Swal.fire('Welcome!', 'Login successful.', 'success')
                .then(() => window.location.href = '../welcome.html'); // <- Change to your homepage
              </script>";
    } else {
        echo "<script>
                Swal.fire('Failed', 'Incorrect credentials. Please sign up.', 'error')
                .then(() => window.location.href = '../signup.html');
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
