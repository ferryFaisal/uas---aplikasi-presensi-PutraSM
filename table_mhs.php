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

$nameErr = $nimErr = $kelasErr = "";
$name = $nim = $kelas = "";
$valName = $valNim = $valKelas = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if(empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    $valName = true;
  }

  if(empty($_POST["nim"])) {
    $nimErr = "Nim is required";
  } else {
    $nim = test_input($_POST["nim"]);
    if(!filter_var($nim, FILTER_VALIDATE_INT)) {
      $nimErr = "Invalid nim format";
  } else {
    require "database.php";
      $sql = "SELECT nim FROM mahasiswa";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              if ($row["nim"] == $nim){
                  $nimErr = "Nim already exist";
                  $valNim = false;
                  break;
              } else {
                $valNim = true;
              }
          }
      } else {
          $valNim = true;
          // echo "0 results";
      }
      $conn ->close();
    }
  }

  if(empty($_POST["kelas"])) {
    $kelasErr = "Kelas is required";
  } else {
    $kelas = test_input($_POST["kelas"]);
    $valKelas = true;
  }
  
  if($valName && $valNim && $valKelas){
    require 'database.php';
    $sql = "INSERT INTO mahasiswa (nim, nama, kelas) 
    VALUES ('$nim', '$name', '$kelas')";

    if ($conn->query($sql) === TRUE) {
        // echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
  }
}

function test_input($data) {
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
//   if ($_SESSION['role'] != 'Admin') {
//       header ("Location: index.php");
//   }
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
      <li class="nav-item active">
        <a class="nav-link" href="table_mhs.php">
          <i class="fas fa-fw fa-table"></i>
          <span>Table Mahasiswa</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="table_user.php">
          <i class="fas fa-fw fa-table"></i>
          <span>Table User</span></a>
      </li>
      <li class="nav-item">
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
              <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModal">
                Tambah Mahasiswa
              </button>
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Nim</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Nim</th>
                    <th>Name</th>
                    <th>Kelas</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
                <tbody>
                <?php
                require 'database.php';
                $sql = "SELECT * from mahasiswa ORDER BY nim";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                  // output data of each row
                  while($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                          <td><?=$row['nim']?></td>
                          <td><?=$row['nama']?></td>
                          <td><?=$row['kelas']?></td>
                          <?php echo
                          "<td><a class='btn btn-success' href='update_nim.php?nim=$row[nim]'>Edit</a> | 
                          <a class='btn btn-danger' href='delete_mhs.php?nim=$row[nim]' onClick=\"return confirm('Anda yakin akan menghapus record ini?')\">Delete</a></td>"
                          ?>
                      </tr>
                    <?php
                  }
                } else {
                  // echo "0 results";
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
      <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group">
              <p>Nim:<span class="error">*<?php echo $nimErr;?></span><br></p>
              <input class="form-control" type="number" name="nim"> 
              <br>
            </div>
            <div class="form-group">
              <p>Nama: <span class="error">*<?php echo $nameErr;?></span></p>
              <input class="form-control" type="text" name="name">
              <br>
            </div>
            <div class="form-group">
              <p>Kelas:<span class="error">*<?php echo $kelasErr;?></span></p>
              <select class="form-control" name="kelas">
                <option value="">---select---</option>
                <option value="5A">5A</option>
                <option value="5B">5B</option>
                </select>
              <br>
            </div>
            <form method="post" enctype="multipart/form-data">
              <input type="submit" class="btn btn-primary col-md-3 offset-md-2" name="Upload" value="Add">
              <!-- <a href="select.php"><input class='btn btn-primary col-md-3 offset-md-2' value="Cancel" action=tables_products.php></a>  -->
              <button type="button" class="btn btn-secondary col-md-3 offset-md-2" data-dismiss="modal">Close</button>
            </form>
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
