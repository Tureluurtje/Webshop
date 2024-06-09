<?php
session_start();

// Connect to the database
$conn = new mysqli('localhost', 'root', 'Tuinhek12!', 'webshop');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the email and password are set in the POST request
if (isset($_POST['txtEmail'], $_POST['txtPassword'])) {
    // Get the post records
    $txtEmail = $_POST['txtEmail'];
    $txtPassword = $_POST['txtPassword'];

    // Hash the password using SHA256
    $hashedPassword = hash("sha256", $txtPassword);

    // Prepare the SQL statement to select the user with the given email and hashed password
    $sql = "SELECT * FROM `users` WHERE `email` = ? AND `password` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $txtEmail, $HashedPassword);

    // Execute the SQL statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        // Set the session variables and redirect to the home page
        $_SESSION['email'] = $txtEmail;
        header("Location: ../index.html");
        exit();
    } else {
        // Display an error message
        echo "Invalid email or password";
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error: Email and password are required";
}

// Close the database connection
$conn->close();
?>
