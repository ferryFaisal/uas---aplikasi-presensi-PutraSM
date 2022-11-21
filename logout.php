<?php
session_start();
if (isset($_SESSION['name'])){
    $_SESSION=[];
    unset ($_SESSION);
    session_destroy();
    //
    header("Location:login.php");
}
?>