<?php
// Connect to database
$conn = new mysqli("localhost", "root", "", "user_account");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize email input
    $email = $conn->real_escape_string($_POST["email"]);
    $password = $_POST["password"];

    // Query user by email
    $query = $conn->query("SELECT * FROM users WHERE email = '$email'");

    if ($query && $query->num_rows === 1) {
        $user = $query->fetch_assoc();

        // Verify hashed password
        if (password_verify($password, $user['password'])) {
            echo "<script>
                    window.onload = () => {
                        Swal.fire('Welcome!', 'Login successful!', 'success')
                        .then(() => window.location.href='dashboard.html');
                    };
                  </script>";
        } else {
            echo "<script>
                    window.onload = () => {
                        Swal.fire('Oops', 'Incorrect password.', 'error');
                    };
                  </script>";
        }
    } else {
        echo "<script>
                window.onload = () => {
                    Swal.fire('Error', 'No account found with that email.', 'error');
                };
              </script>";
    }
}
?>

<!-- Include SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
