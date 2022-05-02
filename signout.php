<?php 
    session_start();
    if(isset($_SESSION["signedin"])){
        session_unset();
        session_destroy();
        header("location: signin.php");
    }
?>