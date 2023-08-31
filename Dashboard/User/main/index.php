<?php
    require("includes/header.php");

    $reqService = $database->prepare("SELECT * FROM services WHERE statut=:statut AND payeur_token!=:payeur AND reserver=:reserver ORDER BY id DESC");
    $reqService->bindvalue(":statut", 1);
    $reqService->bindvalue(":payeur", $unique_id);
    $reqService->bindvalue(":reserver", "non");
    $reqService->execute();

    $countService = $reqService->rowCount();

    if (isset($_GET['reserver']) && !empty($_GET['reserver'])){

        $msgReserver = $_GET['reserver'];

    }

    if (isset($_POST['submit'])){

        $montant = $_POST['montant'];

        if (!empty($montant)){

            $newSolde = $solde + $montant;

            $updateSolde = $database->prepare("UPDATE users SET solde=:solde WHERE unique_id=:unique_id");
            $updateSolde->bindvalue(":solde", $newSolde);
            $updateSolde->bindvalue(":unique_id", $unique_id);
            $updateSolde->execute();

            // Actualiser la page
            ?>
            <script>
                window.location.href = window.location.href;
            </script>
            <?php


        }else{
            $error = "Veuillez remplir le champs";
        }

    }

?>

    <?php
        if (isset($error)){
            ?>
            <script>
                swal("Oups", "<?=$error?>", "error")
            </script>
            <?php
        }elseif (isset($success)){
            ?>
            <script>
                swal("Réussi", "<?=$success?>", "success")
            </script>
            <?php
        }
    ?>

        <!-- Header End -->
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-8 d-flex align-items-stretch">
              <div class="card w-100 bg-light-info overflow-hidden shadow-none">
                <div class="card-body position-relative">
                  <div class="row">
                    <div class="col-sm-7">
                      <div class="d-flex align-items-center mb-7">
                        <div class="rounded-circle overflow-hidden me-6">
                          <img src="../../dist/images/profile/<?=$avatarProfile?>" alt="" width="40" height="40">
                        </div>
                        <h5 class="fw-semibold mb-0 fs-5">Bienvenue <?=$_SESSION['username']?></h5>
                      </div>
                      <div class="d-flex align-items-center">
                        <div class="border-end pe-4 border-muted border-opacity-10">
                          <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center"><?=$solde?> FCFA<i class="ti ti-arrow-up-right fs-5 lh-base text-success"></i></h3>
                          <p class="mb-0 text-dark">Solde</p>
                        </div>
                        
                      </div>
                    </div>
                    <div class="col-sm-5">
                      <div class="welcome-bg-img mb-n7 text-end">
                        <img src="../../assets/images/welcome-bg.svg" alt="" class="img-fluid">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-4 d-flex align-items-stretch">
              <div class="card w-100">
                <div class="card-body p-4">
                  <h4 class="fw-semibold">Recharge</h4>
                  <form action="" method="post">
                    <input type="text" class="form-control mb-3" name="montant" placeholder="Ecrivez le montant souhaité">
                    <input type="submit" class="mb-2 fs-3 btn btn-success" name="submit" value="Recharger mon compte">
                  </form>
                </div>
              </div>
            </div>
            
            <div class="row">

                <?php

                    if ($countService != 0){
                        while ($dataService = $reqService->fetch()){
                            $reqAvatar = $database->prepare("SELECT * FROM users WHERE unique_id=:unique_id");
                            $reqAvatar->bindvalue(":unique_id", $dataService['payeur_token']);
                            $reqAvatar->execute();

                            $dataAvatar = $reqAvatar->fetch();
                            $avatarService = $dataAvatar['avatar'];
                            $usernameAvatar = $dataAvatar['username'];
                            $dateService = $dataService['date'];
                            $budget =$dataService['prix'];
                            $date_limite = $dataService['date_limite'];

                            ?>
                            <div class="col-md-6">
                                <div class="p-4 rounded-2 bg-light mb-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="../../dist/images/profile/<?=$avatarService?>" alt="" class="rounded-circle" width="33" height="33">
                                        <h6 class="fw-semibold mb-0 fs-4"><?=$usernameAvatar?></h6>
                                        <span class="fs-2"><span class="p-1 bg-muted rounded-circle d-inline-block"></span> <?=$dataService['date']?></span>
                                        </div>
                                        <p class="my-3"><?=nl2br($dataService['description'])?>
                                        </p>
                                        <p class="my-3">Budget : <?=$budget?> FCFA</p>
                                        <p class="my-3">Date limite du service : <?=$date_limite?></p>
                                        <div class="d-flex align-items-center">
                                            <a href="prendre.php?token=<?=$dataService['service_token']?>&payer=<?=$unique_id?>" class="btn btn-success">Je prends</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }else{
                        ?>
                        <div class="text-center">
                            <p class="btn btn-danger">Aucun service disponible actuellement</p>
                        </div>
                        <?php
                    }

                ?>

            </div>

          </div>
        </div>
        <!-- container-fluid over -->
      </div>
    </div>
    <!-- Customizer -->
   <?php
        require("includes/settings.php");
   ?>
        <!-- Customizer -->
    <!-- Import Js Files -->
    <script src="../../dist/libs/jquery/dist/jquery.min.js"></script>
    <script src="../../dist/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="../../dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- core files -->
    <script src="../../dist/js/app.min.js"></script>
    <script src="../../dist/js/app.init.js"></script>
    <script src="../../dist/js/app-style-switcher.js"></script>
    <script src="../../dist/js/sidebarmenu.js"></script>
    <script src="../../dist/js/custom.js"></script>
    <!-- current page js files -->
    <script src="../../dist/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="../../dist/js/dashboard2.js"></script>
  </body>

</html>