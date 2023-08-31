<?php

    if (isset($_GET['token'])){

        $token = $_GET['token'];

        require("database/database.php");

        $updateService = $database->prepare("UPDATE services SET confirmer=:confirmer, statut=:statut WHERE service_token=:token");
        $updateService->bindvalue(":confirmer", "oui");
        $updateService->bindvalue(":statut", 2);
        $updateService->bindvalue(":token", $token);
        $updateService->execute();

        header("Location:index.php");

    }