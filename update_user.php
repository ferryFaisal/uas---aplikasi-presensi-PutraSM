<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body>

<?php
require "database.php";

if (isset($_GET['email'])) {
  $email = $_GET['email'];
  $sql = "SELECT * from user WHERE email = '$email'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
      // output data of each row
      $row = $result->fetch_assoc();
  }else {
      echo "0 results";
  }
} else {
  $row ="";
}

// define variables and set to empty values
$attrAdmin = $attrDosen = "";
$nameErr = $emailErr = $passErr = $repassErr = $roleErr = "";
$name = $email = $pass = $repass = $role = "";
$valName = $valEmail = $valPass = $valRepass = $valRole = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if(empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    // if(!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
    //     $nameErr = "Only letters and white space allowed";
    // }else{
        // $valName = true;
    // }
    $valName = true;
  }

  if(empty($_POST["pass"])){
    $passErr = "Password is require letter, number and symbol";
  }else{
    $pass = test_input($_POST["pass"]);
    if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/",$pass)) {
        $passErr = "Invalid password format";
        
    }else{
      $valPass = true;
    }
  }
    
  if(empty($_POST["role"])){
    $roleErr = "Role is required";
  }else{
    $role = test_input($_POST["role"]);
    $valRole = true;
  }
  $email = $_POST["email"];
    echo "nama = $name, pass = $pass, role = $role, email = $email";
    echo "<br>";
    echo "nama = $valName, pass = $valPass, role = $valRole, email = $valEmail";
  if($valName && $valPass && $valRole){
    require 'database.php';
    if (isset($_POST['Upload'])) {
      $sql = "UPDATE user SET 
                              name = '$name',
                              password = '$pass',
                              role = '$role',
                              date_modified = current_timestamp()
                              where email = '$email'";
      if ($conn->query($sql) === TRUE) {
        // echo "New record created succesfully";
        // header('Location:select.php');
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
      $conn->close();
      header("Location: table_user.php");
    }
    
  }

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<div class = "container" style='margin-bottom: 50px;'>
  <div class="row">
    <div class="col-md-8 offset-md-2">
      <div class="card mt-5">
        <div class="card-title text-center">
            <h2>Form Edit User </h2>
        </div>
        <div class="card-body">
        <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group">
              <input class="form-control" type="hidden" name="email" readonly value="<?=$row['email']?>"> 
              <br>
            </div>
            <div class="form-group">
              <p>Nama produk:<span class="error">*<?php echo $nameErr;?></span></p>
              <input class="form-control" type="text" name="name" value="<?=$row['name']?>"> 
              <br>
            </div>
            <div class="form-group">
              <p>Password: <span class="error">*<?php echo $passErr;?></span></p>
              <input class="form-control" type="text" name="pass" value="<?=$row['password']?>">
              <br>
            </div>
            <div class="form-group">
            <?php switch ($row['role']) {
            case 'Admin':
                # code...
                $attrAdmin = "selected";
                break;
            case 'Dosen':
                # code...
                $attrDosen = "selected";
                break;
            default:
                # code...
                $attrAdmin = $attrDosen = "";
                // break;
            }
            ?>
            <p>Role:<span class="error">*<?php echo $roleErr;?></span></p>
            <select class="form-control" name="role">
              <option value="">
              <option value="Admin" <?php echo $attrAdmin?>>Admin</option>
              <option value="Dosen" <?php echo $attrDosen?>>Dosen</option>
            </select>
              <br>
            </div>
            <br>
            <form method="post" enctype="multipart/form-data">
              <input type="submit" class="btn btn-primary col-md-3 offset-md-2" name="Upload" value="Upload">
              <a href="select.php"><input class='btn btn-primary col-md-3 offset-md-2' value="Cancel" action=select.php></a> 
        </form>
          </form>
</body>
</html>