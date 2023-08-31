<?php

    require("includes/header.php");

    $reqServiceCours = $database->prepare("SELECT * FROM services WHERE payeur_token=:payeur AND reserver=:reserver AND confirmer!=:confirmer AND statut=:statut");
    $reqServiceCours->bindvalue(":payeur", $unique_id);
    $reqServiceCours->bindvalue(":reserver", "oui");
    $reqServiceCours->bindvalue(":confirmer", "oui");
    $reqServiceCours->bindvalue(":statut", 1);
    $reqServiceCours->execute();

    $countServiceCours = $reqServiceCours->rowCount();



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
                swal("Réussi","<?=$success?>", "success")
            </script>
            <?php
        }

    ?>

        <!-- --------------------------------------------------- -->
        <!-- Header End -->
        <!-- --------------------------------------------------- -->
        <div class="container-fluid">
          <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8">Confirmation des services</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a class="text-muted" href="index.php">Accueil</a></li>
                      <li class="breadcrumb-item" aria-current="page">Confirmation des services</li>
                    </ol>
                  </nav>
                </div>
              </div>
            </div>
          </div>
          <div class="card overflow-hidden">
            <div class="card-body p-0">
              
            <?php

                if ($countServiceCours != 0){

                    while($dataServiceCours = $reqServiceCours->fetch()){
                        ?>
                        <div class="p-4 rounded-2 bg-light mb-3 col-md-6">
                            <div class="d-flex align-items-center gap-3">
                            <img src="../../dist/images/profile/<?=$avatarProfile?>" alt="" class="rounded-circle" width="33" height="33">
                            <h6 class="fw-semibold mb-0 fs-4">Moi</h6>
                            <span class="fs-2"><span class="p-1 bg-muted rounded-circle d-inline-block"></span> <?=$dataServiceCours['date']?></span>
                            </div>
                            <p class="my-3"><?=nl2br($dataServiceCours['description'])?>
                            </p>
                            <p class="my-3">Budget : <?=$dataServiceCours['prix']?> FCFA</p>
                            <p class="my-3">Date limite du service : <?=$dataServiceCours['date_limite']?></p>
                            <div class="d-flex align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <a class="text-white btn btn-primary" href="confirmer-service.php?token=<?=$dataServiceCours['service_token']?>">
                                Confirmer la réalisation du service
                                </a>
                            </div>
                            </div>
                        </div>
                        <?php
                    }

                }

            ?>

            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ---------------------------------------------- -->
    <!-- ---------------------------------------------- -->
    <!-- Import Js Files -->
    <!-- ---------------------------------------------- -->
    <script src="../../dist/libs/jquery/dist/jquery.min.js"></script>
    <script src="../../dist/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="../../dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- ---------------------------------------------- -->
    <!-- core files -->
    <!-- ---------------------------------------------- -->
    <script src="../../dist/js/app.min.js"></script>
    <script src="../../dist/js/app.init.js"></script>
    <script src="../../dist/js/app-style-switcher.js"></script>
    <script src="../../dist/js/sidebarmenu.js"></script>
    
    <script src="../../dist/js/custom.js"></script>
    <!-- ---------------------------------------------- -->
    <!-- current page js files -->
    <!-- ---------------------------------------------- -->
    <script src="../../dist/js/apps/chat.js"></script>
  </body>

</html>