<?php

    if (isset($_GET['token']) && isset($_GET['payer'])){

        require("database/database.php");

        $token_service = $_GET['token'];
        $payer = $_GET['payer'];

        $servicePris = $database->prepare("UPDATE services SET reserver=:reserver, payer_token=:payer WHERE service_token=:token");
        $servicePris->bindvalue(":reserver", "oui");
        $servicePris->bindvalue(":payer", $payer);
        $servicePris->bindvalue(":token", $token_service);
        $servicePris->execute();

        header("Location:index.php");

    }