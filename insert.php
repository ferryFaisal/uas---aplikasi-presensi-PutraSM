<?php
require "database.php";
// insert data into table
$sql = "INSERT INTO user (email, name, password, role, date_created, date_modified) 
VALUES ('$email', '$name', '$pass', '$role', current_timestamp(), current_timestamp())";

if ($conn->query($sql) === TRUE) {
    // echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>