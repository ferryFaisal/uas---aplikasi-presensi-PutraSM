<?php
include 'database.php';
// menyimpan data id kedalam variabel
$email   = $_GET['email'];
// query SQL untuk insert data
$sql="DELETE from user where email='$email'";
if ($conn->query($sql) === TRUE) {
    echo "<br>Delete succesfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
// mengalihkan ke halaman index.php
header("location:table_user.php");
?>