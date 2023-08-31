<?php

    require("includes/header.php");

    if (isset($_POST['submit'])){

        $avatar = $_POST['avatar'];

        if (!empty($avatar)){

            $updateAvatar = $database->prepare("UPDATE users SET avatar=:avatar WHERE unique_id=:unique_id");
            $updateAvatar->bindvalue(":avatar", $avatar);
            $updateAvatar->bindvalue(":unique_id", $unique_id);
            $updateAvatar->execute();

            $success = "Avatar changé";

            // Actualiser la page
            ?>
            <script>
                window.location.href = window.location.href;
            </script>
            <?php

        }else{
            $error = "Veuillez sélectionner un avatar";
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
                  <h4 class="fw-semibold mb-8">Profile Utilisateur</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a class="text-muted" href="index.php">Accueil</a></li>
                      <li class="breadcrumb-item" aria-current="page">Profile</li>
                    </ol>
                  </nav>
                </div>
                <div class="col-3">
                  <div class="text-center mb-n5">  
                    <img src="../../dist/images/breadcrumb/ChatBc.png" alt="" class="img-fluid mb-n4">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card overflow-hidden">
            <div class="card-body p-0">
              <img src="../../dist/images/backgrounds/profilebg.jpg" alt="" class="img-fluid">
              <div class="row align-items-center">
                <div class="col-lg-4"></div>
                <div class="col-lg-4 mt-n3 order-lg-2 order-1">
                  <div class="mt-n5">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                      <div class="linear-gradient d-flex align-items-center justify-content-center rounded-circle" style="width: 110px; height: 110px;";>
                        <div class="border border-4 border-white d-flex align-items-center justify-content-center rounded-circle overflow-hidden" style="width: 100px; height: 100px;";>
                          <img src="../../dist/images/profile/<?=$avatarProfile?>" alt="" class="w-100 h-100">
                        </div>
                      </div>
                    </div>
                    <div class="text-center">
                      <h5 class="fs-5 mb-0 fw-semibold"><?=$username?></h5>
                      <p class="mb-0 fs-4"><?=$job?></p>
                    </div>
                  </div>
                </div>
              </div>


              <ul class="nav nav-pills user-profile-tab justify-content-center mt-2 bg-light-info rounded-2" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link position-relative rounded-0 active d-flex align-items-center justify-content-center bg-transparent fs-3 py-6" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="true">
                    <i class="ti ti-file-text me-2 fs-6"></i>
                    <span class="d-none d-md-block">Mes services</span> 
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-6" id="pills-friends-tab" data-bs-toggle="pill" data-bs-target="#pills-friends" type="button" role="tab" aria-controls="pills-friends" aria-selected="false">
                    <i class="ti ti-user-circle me-2 fs-6"></i>
                    <span class="d-none d-md-block">Profile</span> 
                  </button>
                </li>
              </ul>
            </div>
          </div>
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                <div class="row">

                    <?php

                        $reqService = $database->prepare("SELECT * FROM services WHERE payeur_token=:payeur AND statut=:statut AND confirmer=:confirmer AND reserver=:reserver");
                        $reqService->bindvalue(":payeur", $unique_id);
                        $reqService->bindvalue(":statut", 1);
                        $reqService->bindvalue(":confirmer","non");
                        $reqService->bindvalue(":reserver","non");
                        $reqService->execute();

                        $countService = $reqService->rowCount();

                        if ($countService != 0){

                            while ($dataService = $reqService->fetch()) {
                                ?>
                                <div class="col-md-6">
                                    <div class="p-4 rounded-2 bg-light mb-3">
                                        <div class="d-flex align-items-center gap-3">
                                        <img src="../../dist/images/profile/<?=$avatarProfile?>" alt="" class="rounded-circle" width="33" height="33">
                                        <h6 class="fw-semibold mb-0 fs-4">Moi</h6>
                                        <span class="fs-2"><span class="p-1 bg-muted rounded-circle d-inline-block"></span> <?=$dataService['date']?></span>
                                        </div>
                                        <p class="my-3"><?=nl2br($dataService['description'])?>
                                        </p>
                                        <p class="my-3">Budget : <?=$dataService['prix']?> FCFA</p>
                                        <p class="my-3">Date limite du service : <?=$dataService['date_limite']?></p>
                                        <div class="d-flex align-items-center">
                                        <div class="d-flex align-items-center gap-2">
                                            <a class="text-white btn btn-danger" href="supprimer-service.php?token=<?=$dataService['service_token']?>">
                                            Supprimer
                                            </a>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 ms-4">
                                            <p class="mb-1 badge rounded-pill bg-success">Actif</p>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }

                        }else{
                            ?>
                            <div class="text-center">
                                <p class="btn btn-danger">
                                    Vous n'avez pas d'annonces active
                                </p>
                            </div>
                            <?php
                        }

                    ?>

                    

                </div>
            </div>
            <div class="tab-pane fade" id="pills-friends" role="tabpanel" aria-labelledby="pills-friends-tab" tabindex="0">
              <div class="d-sm-flex align-items-center justify-content-between mt-3 mb-4">
                <h3 class="mb-3 mb-sm-0 fw-semibold d-flex align-items-center">Profile
                
              </div>
              <div class="row">
                <div class="col-sm-6 col-lg-4">
                  <div class="card hover-img">
                    <div class="card-body p-4 text-center border-bottom">
                      <img src="../../dist/images/profile/user-1.jpg" alt="" class="rounded-circle mb-3" width="100" height="100">
                      <h5 class="fw-semibold mb-0">Avatar 1</h5>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                  <div class="card hover-img">
                    <div class="card-body p-4 text-center border-bottom">
                      <img src="../../dist/images/profile/user-2.jpg" alt="" class="rounded-circle mb-3" width="100" height="100">
                      <h5 class="fw-semibold mb-0">Avatar 2</h5>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                  <div class="card hover-img">
                    <div class="card-body p-4 text-center border-bottom">
                      <img src="../../dist/images/profile/user-3.jpg" alt="" class="rounded-circle mb-3" width="100" height="100">
                      <h5 class="fw-semibold mb-0">Avatar 3</h5>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                  <div class="card hover-img">
                    <div class="card-body p-4 text-center border-bottom">
                      <img src="../../dist/images/profile/user-4.jpg" alt="" class="rounded-circle mb-3" width="100" height="100">
                      <h5 class="fw-semibold mb-0">Avatar 4</h5>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                  <div class="card hover-img">
                    <div class="card-body p-4 text-center border-bottom">
                      <img src="../../dist/images/profile/user-5.jpg" alt="" class="rounded-circle mb-3" width="100" height="100">
                      <h5 class="fw-semibold mb-0">Avatar 5</h5>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                  <div class="card hover-img">
                    <div class="card-body p-4 text-center border-bottom">
                      <img src="../../dist/images/profile/user-6.jpg" alt="" class="rounded-circle mb-3" width="100" height="100">
                      <h5 class="fw-semibold mb-0">Avatar 6</h5>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                  <div class="card hover-img">
                    <div class="card-body p-4 text-center border-bottom">
                      <img src="../../dist/images/profile/user-7.jpg" alt="" class="rounded-circle mb-3" width="100" height="100">
                      <h5 class="fw-semibold mb-0">Avatar 7</h5>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                  <div class="card hover-img">
                    <div class="card-body p-4 text-center border-bottom">
                      <img src="../../dist/images/profile/user-8.jpg" alt="" class="rounded-circle mb-3" width="100" height="100">
                      <h5 class="fw-semibold mb-0">Avatar 8</h5>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                  <div class="card hover-img">
                    <div class="card-body p-4 text-center border-bottom">
                      <img src="../../dist/images/profile/user-9.jpg" alt="" class="rounded-circle mb-3" width="100" height="100">
                      <h5 class="fw-semibold mb-0">Avatar 9</h5>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                  <div class="card hover-img">
                    <div class="card-body p-4 text-center border-bottom">
                      <img src="../../dist/images/profile/user-10.jpg" alt="" class="rounded-circle mb-3" width="100" height="100">
                      <h5 class="fw-semibold mb-0">Avatar 10</h5>
                    </div>
                  </div>
                </div>


              </div>

              <form method="post">
                            <div class="form-floating mb-3">
                                <select name="avatar" id="" class="form-control border border-primary">
                                    <option value="user-1.jpg">Avatar 1</option>
                                    <option value="user-2.jpg">Avatar 2</option>
                                    <option value="user-3.jpg">Avatar 3</option>
                                    <option value="user-4.jpg">Avatar 4</option>
                                    <option value="user-5.jpg">Avatar 5</option>
                                    <option value="user-6.jpg">Avatar 6</option>
                                    <option value="user-7.jpg">Avatar 7</option>
                                    <option value="user-8.jpg">Avatar 8</option>
                                    <option value="user-9.jpg">Avatar 9</option>
                                    <option value="user-10.jpg">Avatar 10</option>
                                </select>
                                <label
                                ><i class="ti ti-currency-dollar me-2 fs-4 text-primary"></i><span class="border-start border-primary ps-3"
                                    >Choisir votre avatar <span class="text-danger">*</span></span
                                ></label
                                >
                            </div>

                            <div class="col-md-2">
                                
                                <div class="text-center mt-3 mt-md-0 ms-auto">
                                <button
                                    type="submit"
                                    name="submit"
                                    class="btn btn-primary font-medium rounded-pill px-4 text-center"
                                >
                                    <div class="d-flex align-items-center">
                                    <i class="ti ti-send me-2 fs-4"></i>
                                    Submit
                                    </div>
                                </button>
                                </div>
                            </div>
                        </form>

            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- --------------------------------------------------- -->
    <!-- Customizer -->
    <!-- --------------------------------------------------- -->
   
        <!-- ---------------------------------------------- -->
    <!-- Customizer -->
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

<!-- Mirrored from demos.adminmart.com/premium/bootstrap/Accueilize-bootstrap/package/html/main/profile.php by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 29 May 2023 16:36:51 GMT -->
</html>