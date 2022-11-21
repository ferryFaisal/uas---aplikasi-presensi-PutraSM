<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SB Admin - Register</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
    <style>
        .error {color: #FF0000;}
    </style>
</head>

<body class="bg-dark">
<?php
ob_start();
$nameErr = $emailErr = $passErr = $repassErr = $roleErr = "";
$name = $email = $pass = $repass = $role = "";
$valName = $valEmail = $valPass = $valRepass = $valRole = false;
if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = sanitize($_POST["name"]);
        if(!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
            $nameErr = "Only letters and white space allowed";
        }else{
            $valName = true;
        }
        // $valName = true;
    }
    if(empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = sanitize($_POST["email"]);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        } else {
            require "database.php";
            $sql = "SELECT email FROM user";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($row["email"] == $email){
                        $emailErr = "Email already exist";
                        $valEmail = false;
                        break;
                    } else {
                        $valEmail = true;
                    }
                }
                
            } else {
                $valEmail = true;
                echo "0 results";
            }
        }
    }
    if(empty($_POST["pass"])){
        $passErr = "Password is require letter, number and symbol";
    }else{
        $pass = sanitize($_POST["pass"]);
        if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/",$pass)) {
            $passErr = "Invalid password format";
        }
    } 
    if(empty($_POST["repass"])){
        $repassErr = "Repeat Password is require";
    }else{
        $repass = sanitize($_POST["repass"]);
        if ($repass != $pass){
            $repassErr = "Required password is different from password";
        } else {
            $valPass = true;
        }
	}
    if(empty($_POST["role"])){
        $roleErr = "Role is required";
    }else{
        $role = sanitize($_POST["role"]);
        $valRole = true;
    }	
}

function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
    <div class="container">
        <div class="card card-register mx-auto mt-5">
        <div class="card-header">Register an Account</div>
        <div class="card-body">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-label-group">
                            <!-- <input type="text" id="firstName" class="form-control" placeholder="First name" required="required" autofocus="autofocus"> -->
                            <input type="text" id="fullName" name="name" class="form-control" placeholder="Full name" required="required" autofocus="autofocus" value="<?php echo $name;?>">
                            <span class="error">*  <?php echo $nameErr;?></span>
                            <label for="fullName">Full name</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-label-group">
                            <select  name="role" class="form-control" placeholder="Full name" required="required">
                                <option value="">Role</option>
                                <option value="Admin">Admin</option>
                                <option value="Dosen">Dosen</option>                        
                            </select>
                            <span class="error">* <?php echo $roleErr;?></span>
                        </div>
                    </div>
                </div>
            </div>
                <div class="form-group">
                    <div class="form-label-group">
                        <!-- <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required="required"> -->
                        <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Last name" required="required" value="<?php echo $email;?>">
                        <span class="error">*  <?php echo $emailErr;?></span>
                        <label for="inputEmail">Email address</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-label-group">
                            <!-- <input type="password" id="inputPassword" class="form-control" placeholder="Password" required="required"> -->
                            <input type="password" id="inputPassword" name="pass" class="form-control" placeholder="Last name" required="required" value="<?php echo $pass;?>">
                            <span class="error">*  <?php echo $passErr;?></span>
                            <label for="inputPassword">Password</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-label-group">
                            <!-- <input type="password" id="confirmPassword" class="form-control" placeholder="Confirm password" required="required"> -->
                            <input type="password" id="confirmPassword" name="repass" class="form-control" placeholder="Last name" required="required" value="<?php echo $repass;?>">
                            <span class="error">*  <?php echo $repassErr;?></span>
                            <label for="confirmPassword">Confirm password</label>
                        </div>
                    </div>
                    </div>
                </div>
                <!-- <a class="btn btn-primary btn-block" href="login.html">Register</a> -->
                <input class="btn btn-primary" type="submit" name="submit" value="Submit">
            </form>
            <?php
            //     var_dump($name);
            //     echo "<br>";
            //     var_dump($email);
            //     echo "<br>";
            //     var_dump($pass);
            //     echo "<br>";
            //     var_dump($repass);
            //     echo "<br>";
            //     var_dump($role);
            //     echo "<br>";

            // echo"valName: $valName, valemail: $valEmail, valPass: $valPass, valRole: $valRole";
            if($valName && $valEmail && $valPass == true){
                echo "<h2>Your Input:</h2>";
                echo $name;
                echo "<br>";
                echo $email;
                echo "<br>";
                echo $pass = ($_POST['pass']);
                echo "<br>";
                echo $role;
                echo "<br>";
                echo "This date ";
                echo  date("Y-m-d");
                echo "<br>";
                include "insert.php";
                header('Location: login.php');
            }
            ?>
            <div class="text-center">
            <a class="d-block small mt-3" href="login.php">Login Page</a>
            <a class="d-block small" href="forgot.php">Forgot Password?</a>
            </div>
        </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>
