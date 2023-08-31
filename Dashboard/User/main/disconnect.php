<?php

session_start();

    require_once("database/database.php");

    if (isset($_SESSION['username'])){

        session_unset();
        session_destroy();
        header("Location:connexion.php");

    }else{
        session_unset();
        session_destroy();
        header("Location:connexion.php");
    }