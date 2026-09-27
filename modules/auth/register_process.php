<?php

include '../../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Check email already exists
    $check_email = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $check_email);

    if (mysqli_num_rows($result) > 0) {

        echo "Email already exists!";

    } else {

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert query
        $sql = "INSERT INTO users(full_name, email, password, role)
                VALUES('$full_name', '$email', '$hashed_password', '$role')";

        if (mysqli_query($conn, $sql)) {

            header("Location: ../../login.php");

        } else {

            echo "Registration Failed!";
        }
    }
}

?>