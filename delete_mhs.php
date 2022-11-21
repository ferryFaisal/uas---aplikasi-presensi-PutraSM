<?php
include 'database.php';
// menyimpan data id kedalam variabel
$nim   = $_GET['nim'];
// query SQL untuk insert data
$sql="DELETE from mahasiswa where nim='$nim'";
if ($conn->query($sql) === TRUE) {
    echo "<br>Delete succesfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
// mengalihkan ke halaman index.php
header("location:table_mhs.php");
?>