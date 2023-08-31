<?php

    require("database/database.php");

    if (isset($_POST['submit'])){

        $username = $_POST['username'];
        $password = $_POST['password'];

        if (!empty($username) && !empty($password)){

            $reqUserInscrit = $database->prepare("SELECT * FROM users WHERE username=:username AND password=:password AND statut=:statut");
            $reqUserInscrit->bindvalue(":username", ucwords($username));
            $reqUserInscrit->bindvalue(":password", sha1($password));
            $reqUserInscrit->bindvalue(":statut", 1);
            $reqUserInscrit->execute();

            $countUserInscrit = $reqUserInscrit->rowCount();

            if ($countUserInscrit == 1){

                session_start();
                $_SESSION['username'] = ucwords($_POST['username']);
                header("Location:index.php");

            }else{
                $error = "Identifiants incorrect, recommencez";
            }

        }else{
            $error = "Remplissez tous les champs";
        }

    }

?>

<!DOCTYPE html>
<html lang="fr">
  
<head>
    <!--  Title -->
    <title>ServicePlus - Connexion</title>
    <!--  Required Meta Tag -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <meta name="description" content="Mordenize" />
    <meta name="author" content="" />
    <meta name="keywords" content="Mordenize" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!--  Favicon -->
    <link rel="shortcut icon" type="image/png" href="../../dist/images/logos/favicon.png" />
    <!-- Core Css -->
    <link  id="themeColors"  rel="stylesheet" href="../../dist/css/style.min.css" />

    <!-- Sweatalert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  </head>
  <body>
    <!-- Preloader -->
    <div class="preloader">
      <img src="../../dist/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!-- Preloader -->
    <div class="preloader">
      <img src="../../dist/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
      <div class="position-relative overflow-hidden radial-gradient min-vh-100">
        <div class="position-relative z-index-5">
          <div class="row">
            <div class="col-xl-7 col-xxl-8">
              <a href="index.php" class="text-nowrap logo-img d-block px-4 py-9 w-100 text-dark" style="font-size:18px;">
                ServicePlus
              </a>
              <div class="d-none d-xl-flex align-items-center justify-content-center" style="height: calc(100vh - 80px);">
                <img src="../../assets/images/login-security.svg" alt="" class="img-fluid" width="500">
              </div>
            </div>
            <div class="col-xl-5 col-xxl-4">
              <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
                <div class="col-sm-8 col-md-6 col-xl-9">
                  <h2 class="mb-3 fs-7 fw-bolder">Bienvenue sur ServicePlus</h2>
                  <p class=" mb-9 text-center">Connectez-vous sur ServicePlus</p>
                  
                    <?php
                        if (isset($error)){
                            ?>
                            <script>
                                swal("Oups", "<?=$error?>", "error");
                            </script>
                            <?php
                        }  
                    ?>

                  <form method="post">
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Nom d'utilisateur</label>
                      <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="username">
                    </div>
                    <div class="mb-4">
                      <label for="exampleInputPassword1" class="form-label">Mot de passe</label>
                      <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                      
                      <a class="text-primary fw-medium" href="authentication-forgot-password.php">Mot de passe oublié ?</a>
                    </div>
                    <input type="submit" value="Se connecter" class="btn btn-primary w-100 py-8 mb-4 rounded-2" name="submit">
                    <div class="d-flex align-items-center justify-content-center">
                      <p class="fs-4 mb-0 fw-medium">Nouveau sur ServicePlus ?</p>
                      <a class="text-primary fw-medium ms-2" href="inscription.php"> Inscrivez-vous</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </div>
    
    <!--  Import Js Files -->
    <script src="../../dist/libs/jquery/dist/jquery.min.js"></script>
    <script src="../../dist/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="../../dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!--  core files -->
    <script src="../../dist/js/app.min.js"></script>
    <script src="../../dist/js/app.init.js"></script>
    <script src="../../dist/js/app-style-switcher.js"></script>
    <script src="../../dist/js/sidebarmenu.js"></script>
    
    <script src="../../dist/js/custom.js"></script>
  </body>

</html>