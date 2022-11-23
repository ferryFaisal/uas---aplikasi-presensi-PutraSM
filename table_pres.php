<!DOCTYPE html>
<html lang="en">
<?php
session_start();
// if (isset($_SESSION['role'])) {
//   if ($_SESSION['role'] == 'Admin') {

//   } else {
//     header("Location: admin.php");
//   }
// } else {
//   header("Location:login.php");
// }

$nameErr = $emailErr = $passErr = $repassErr = $roleErr = "";
$name = $email = $pass = $repass = $role = "";
$valName = $valEmail = $valPass = $valRepass = $valRole = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['Upload'])) {
    $name = cek($_POST['name']);
    $email = cek($_POST['inputEmail']);
    $role = cek($_POST['role']);
    require 'database.php';
    $password = cek($_POST['inputPassword']);
    $sql = "SELECT email from user WHERE email = '$email'";
    $result = $conn->query($sql);
    //cek email terdaftar
    if ($result->num_rows == 0) {
      //cek pw sama
      // echo "pw1 : ".cek($password).", pw2 : ".$cpassword."<br>";
        // echo "masuk";
        $sql = "INSERT INTO user (email, name, password, role, date_create, date_modified) 
        VALUES 
        ('$email','$name','$password','$role',current_timestamp(),current_timestamp())";
        if ($conn->query($sql) === TRUE) {
          echo '<script>alert("User baru telah ditambahkan")</script>';
          // echo "New record created succesfully";
          // header("Location:login.php");
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
      $emailErr = "Email sudah terdaftar";
      echo '<script>alert("Email sudah terdaftar")</script>';
      // echo $emailErr;
    }
    $conn->close();
    //insert in mysql?
    // echo "email: $email, name: $name, pw: $password, role: $role";
  }
}

function cek($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin - Tables</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">
<?php
// session_start();
//pemeriksaan session
// if (isset($_SESSION['role'])) {//jika sudah login
//     if ($_SESSION['role'] != 'Admin') {
//         header ("Location: index.php");
//     }
//     //menampilkan isi session
//     // echo "<h1>Selamat Datang ".$_SESSION['name']."</h1>";
//     // echo "<h2>Halaman ini hanya bisa diakses jika Anda sudah login</h2>";
//     // echo "<h2>Klik <a href='logout.php'>di sini (logout.php)</a>
//     // untuk LOGOUT</h2>";
// } else {
//     //session belum ada artinya belum login
//     header("Location:login.php");
//     // die("Anda belum login! Anda tidak berhak masuk ke halaman ini. Silahkan login
//     // <a href='login.php'>di sini</a>");
// }
?>
  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="index.php">Start Bootstrap</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-bell fa-fw"></i>
          <span class="badge badge-danger">9+</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-envelope fa-fw"></i>
          <span class="badge badge-danger">7</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#">Settings</a>
          <a class="dropdown-item" href="#">Activity Log</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
    </ul>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="admin.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <!-- <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-folder"></i>
          <span>Pages</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header">Login Screens:</h6>
          <a class="dropdown-item" href="login.php">Login</a>
          <a class="dropdown-item" href="register.php">Register</a>
          <a class="dropdown-item" href="forgot-password.php">Forgot Password</a>
          <div class="dropdown-divider"></div>
          <h6 class="dropdown-header">Other Pages:</h6>
          <a class="dropdown-item" href="404.php">404 Page</a>
          <a class="dropdown-item" href="blank.php">Blank Page</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="charts.php">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li> -->
      <li class="nav-item">
        <a class="nav-link" href="table_mhs.php">
          <i class="fas fa-fw fa-table"></i>
          <span>Table Mahasiswa</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="table_user.php">
          <i class="fas fa-fw fa-table"></i>
          <span>Table User</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="table_pres.php">
          <i class="fas fa-fw fa-table"></i>
          <span>Table Presensi</span></a>
      </li>
    </ul>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <!-- <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Table Mahasiswa</a>
          </li>
          <li class="breadcrumb-item active">Tables</li>
        </ol> -->

        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Data Table Mahasiswa
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <!-- Button trigger modal -->
              <!-- <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModal">
                Tambah Mahasiswa
              </button> -->
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <thead>
                  <tr>
                    <th>Tanggal Presensi</th>
                    <th>Makul</th>
                    <th>Kelas</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Tanggal Presensi</th>
                    <th>Makul</th>
                    <th>Kelas</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Status</th>
                  </tr>
                </tfoot>
                <tbody>
                <?php
                require 'database.php';
                $sql = "SELECT * from presensi ORDER BY tgl_presensi,makul,kelas,nim";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                  // output data of each row
                  while($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                          <td><?=$row['tgl_presensi']?></td>
                          <td><?=$row['makul']?></td>
                          <td><?=$row['kelas']?></td>
                          <td><?=$row['nim']?></td>
                          <td><?=$row['nama']?></td>
                          <td><?=$row['status_presensi']?></td>
                      </tr>
                    <?php
                  }
                } else {
                  echo "0 results";
                }
                $conn->close();
				        ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>

        <p class="small text-center text-muted my-5">
          <em>More table examples coming soon...</em>
        </p>

      </div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Your Website 2019</span>
          </div>
        </div>
      </footer>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="js/demo/datatables-demo.js"></script>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <div class="form-group">
              <div class="form-label-group">
                <input type="text" id="Name" name="name" class="form-control" placeholder="Name" required autofocus>
                <label for="Name">Name</label>
              </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email address" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Format email salah">
              <label for="inputEmail">Email address</label>
            </div>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <label class="input-group-text" for="inputGroupSelect01">Role</label>
            </div>
            <select class="custom-select" id="inputGroupSelect01" name="role" required>
              <option value="" selected>->Select here<-</option>
              <option value="Admin">Admin</option>
              <option value="Dosen">Dosen</option>
            </select>
          </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required minlength=8 pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters">
                <label for="inputPassword">Password</label>
              </div>
            </div>
          <input type="submit" class="btn btn-primary col-md-3 offset-md-2" name="Upload" value="Add">
          <!-- <a href="select.php"><input class='btn btn-primary col-md-3 offset-md-2' value="Cancel" action=tables_products.php></a>  -->
          <button type="button" class="btn btn-secondary col-md-3 offset-md-2" data-dismiss="modal">Close</button>
        </form>       
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>
</body>

</html>
