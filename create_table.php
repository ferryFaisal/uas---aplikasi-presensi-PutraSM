<?php
require "database.php";
// SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
// START TRANSACTION;
// SET time_zone = "+00:00";
// $sql = "CREATE TABLE IF NOT EXISTS products (
//     id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
//     name varchar(128) NOT NULL,
//     description text NOT NULL,
//     price double NOT NULL,
//     photo varchar(30) NOT NULL,
//     created datetime NOT NULL,
//     modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
//     ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9";
$sql = "CREATE TABLE IF NOT EXISTS mahasiswa (
    nim char(10) NOT NULL,
    nama varchar(50) NOT NULL,
    kelas char(2) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";

$sql2 = "CREATE TABLE IF NOT EXISTS presensi (
    tgl_presensi datetime NOT NULL,
    makul varchar(50) NOT NULL,
    kelas char(2) NOT NULL,
    nim char(10) NOT NULL,
    nama varchar(50) NOT NULL,
    status_presensi varchar(10) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";

echo "<br>";
if($conn->query($sql) === TRUE){
  echo "Table mahasiswa created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

echo "<br>";
if($conn->query($sql2) === TRUE){
  echo "Table presensi created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}
echo "<br>";
$conn->close();
?>
