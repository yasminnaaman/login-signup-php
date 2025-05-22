<?php
// Connect to database
$conn = new mysqli("localhost", "root", "", "user_account");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected to database successfully.";
}

// Handle signup
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $conn->real_escape_string($_POST["fname"]);
    $lname = $conn->real_escape_string($_POST["lname"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Check if email exists
    $check = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($check->num_rows > 0) {
        echo "<script>
                window.onload = () => {
                    Swal.fire('Error', 'Email already exists!', 'error');
                };
              </script>";
    } else {
        $insert = $conn->query("INSERT INTO users (fname, lname, email, password) VALUES ('$fname', '$lname', '$email', '$password')");
        if ($insert) {
            echo "<script>
                    window.onload = () => {
                        Swal.fire('Success', 'Account created!', 'success')
                        .then(() => window.location.href='login.html');
                    };
                  </script>";
        } else {
            $error = $conn->error;
            echo "<script>
                    window.onload = () => {
                        Swal.fire('Error', 'Signup failed. Try again!<br>Error: $error', 'error');
                    };
                  </script>";
        }
    }
}
?>

<!-- Include SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
