<?php
    session_start();
    if($_SESSION['login_s'] != '5'){
      header('location:../../login.php');
    }
    if(isset($_GET['c_selected'])){
        $_SESSION['c_id'] = $_GET['c_selected'];
        header('location:selectConferenceTrack.php');
    }
?>