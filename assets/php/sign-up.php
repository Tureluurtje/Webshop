<?php
// database connection code
if(isset($_POST['txtName']) && isset($_POST['txtEmail']) && isset($_POST['txtPassword'])) {

    // $con = mysqli_connect('localhost', 'database_user', 'database_password','database');
    $con = mysqli_connect('localhost', 'root', 'Tuinhek12!','webshop');

    // get the post records
    $txtName = $_POST['txtName'];
    $txtEmail = $_POST['txtEmail'];
    $txtPassword = $_POST['txtPassword'];

    // database insert SQL code
    $sql = "INSERT INTO `users` (`name`, `email`, `password`) VALUES ('$txtName', '$txtEmail', '$txtPassword')";

    // insert in database
    if($con) {
        if($rs = mysqli_query($con, $sql)) {
            echo "Contact Records Inserted";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }
    } else {
        echo "Error: Unable to connect to MySQL";
    }

}
else
	echo "error";