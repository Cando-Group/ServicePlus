<?php

session_start();

?>
    <script>
        console.log("<?=$_SESSION['username']?>")    </script>
    <?php
    if (!isset($_SESSION['username'])){
        header('Location:inscription.php');
    }

    require("database/database.php");

    $reqInfo = $database->prepare("SELECT * FROM users WHERE username=:username");
    $reqInfo->bindvalue(":username", $_SESSION['username']);
    $reqInfo->execute();

    $countInfo = $reqInfo->rowCount();

    if ($countInfo == 1){
        $dataInfo = $reqInfo->fetch();

        $unique_id = $dataInfo['unique_id'];
        $solde = $dataInfo['solde'];
        $avatarProfile = $dataInfo['avatar'];
        $username = $dataInfo['username'];
        $job = $dataInfo['job'];
        $email = $dataInfo['email'];
    }

?>

<!DOCTYPE html>
<html lang="fr">
  
<head>
    <!--  Title -->
    <title>ServicePlus - <?=$_SESSION['username']?></title>
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
    <!-- Owl Carousel  -->
    <link rel="stylesheet" href="../../dist/libs/owl.carousel/dist/assets/owl.carousel.min.css">
    
    <!-- Core Css -->
    <link  id="themeColors"  rel="stylesheet" href="../../dist/css/style.min.css" />

    <!-- Sweatalert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    
  </head>
  <body id="content">
    <!-- Preloader -->
    <div class="preloader">
      <img src="../../dist/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!-- Preloader -->
    <div class="preloader">
      <img src="../../dist/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-theme="blue_theme"  data-layout="vertical" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
      <!-- Sidebar Start -->
      <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div>
          <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="index.php" class="text-nowrap logo-img text-dark" style="font-size:18px;">
              ServicePlus
            </a>
            <div class="close-btn d-lg-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
              <i class="ti ti-x fs-8"></i>
            </div>
          </div>
          <!-- Sidebar navigation-->
          <nav class="sidebar-nav scroll-sidebar" data-simplebar>
            <ul id="sidebarnav">
              <!-- ============================= -->
              <!-- Accueil -->
              <!-- ============================= -->
              <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Tableau  de  bord</span>
              </li>
              <!-- =================== -->
              <!-- Dashboard -->
              <!-- =================== -->
              <li class="sidebar-item">
                <a class="sidebar-link" href="index.php" aria-expanded="false">
                  <span>
                    <i class="ti ti-aperture"></i>
                  </span>
                  <span class="hide-menu">Accueil</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="service.php" aria-expanded="false">
                  <span>
                    <i class="ti ti-app-window"></i>
                  </span>
                  <span class="hide-menu">Publier un service</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="confirmation.php" aria-expanded="false">
                  <span>
                    <i class="ti ti-archive"></i>
                  </span>
                  <span class="hide-menu">Confirmation service</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="profile.php" aria-expanded="false">
                  <span>
                    <i class="ti ti-user-circle"></i>
                  </span>
                  <span class="hide-menu">Profile</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="page-faq.php" aria-expanded="false">
                  <span>
                    <i class="ti ti-help"></i>
                  </span>
                  <span class="hide-menu">FAQ</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="disconnect.php" aria-expanded="false">
                  <span>
                    <i class="ti ti-login"></i>
                  </span>
                  <span class="hide-menu">Se déconnecter</span>
                </a>
              </li>
              

            </ul>
          </nav>
          <div class="fixed-profile p-3 bg-light-secondary rounded sidebar-ad mt-3">
            <div class="hstack gap-3">
              <div class="john-img">
                <img src="../../dist/images/profile/<?=$avatarProfile?>" class="rounded-circle" width="40" height="40" alt="">
              </div>
              <div class="john-title">
                <h6 class="mb-0 fs-4 fw-semibold"><?=$username?></h6>
                <span class="fs-2 text-dark"><?=$job?></span>
              </div>
              <button class="border-0 bg-transparent text-primary ms-auto" tabindex="0" type="button" aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout">
                <i class="ti ti-power fs-6"></i>
              </button>
            </div>
          </div>  
          <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
      </aside>
      <!--  Sidebar End -->
      <!--  Main wrapper -->
      <div class="body-wrapper">
        <!--  Header Start -->
        <header class="app-header"> 
          <nav class="navbar navbar-expand-lg navbar-light">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link sidebartoggler nav-icon-hover ms-n3" id="headerCollapse" href="javascript:void(0)">
                  <i class="ti ti-menu-2"></i>
                </a>
              </li>
            </ul>
            
            <div class="d-block d-lg-none">
              <img src="https://demos.adminmart.com/premium/bootstrap/Accueilize-bootstrap/package/dist/images/logos/dark-logo.svg" class="dark-logo" width="180" alt="" />
              <img src="https://demos.adminmart.com/premium/bootstrap/Accueilize-bootstrap/package/dist/images/logos/light-logo.svg" class="light-logo"  width="180" alt="" />
            </div>
            <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="p-2">
                <i class="ti ti-dots fs-7"></i>
              </span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
              <div class="d-flex align-items-center justify-content-between">
                <a href="javascript:void(0)" class="nav-link d-flex d-lg-none align-items-center justify-content-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar" aria-controls="offcanvasWithBothOptions">
                  <i class="ti ti-align-justified fs-7"></i>
                </a>
                <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                  
                  <li class="nav-item dropdown">
                    <a class="nav-link pe-0" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown" aria-expanded="false">
                      <div class="d-flex align-items-center">
                        <div class="user-profile-img">
                          <img src="../../dist/images/profile/<?=$avatarProfile?>" class="rounded-circle" width="35" height="35" alt="" />
                        </div>
                      </div>
                    </a>
                    <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop1">
                      <div class="profile-dropdown position-relative" data-simplebar>
                        <div class="py-3 px-7 pb-0">
                          <h5 class="mb-0 fs-5 fw-semibold">User Profile</h5>
                        </div>
                        <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                          <img src="../../dist/images/profile/<?=$avatarProfile?>" class="rounded-circle" width="80" height="80" alt="" />
                          <div class="ms-3">
                            <h5 class="mb-1 fs-3"><?=$username?></h5>
                            <span class="mb-1 d-block text-dark"><?=$job?></span>
                            <p class="mb-0 d-flex text-dark align-items-center gap-2">
                              <i class="ti ti-mail fs-4"></i> <small><?=$email?></small>
                            </p>
                          </div>
                        </div>
                        <div class="message-body">
                          <a href="profile.php" class="py-8 px-7 mt-8 d-flex align-items-center">
                            <span class="d-flex align-items-center justify-content-center bg-light rounded-1 p-6">
                            <i class="ti ti-user-circle" style="font-size:20px;"></i>
                            </span>
                            <div class="w-75 d-inline-block v-middle ps-3">
                              <h6 class="mb-1 bg-hover-primary fw-semibold"> Mon profile </h6>
                            </div>
                          </a>
                        </div>
                        <div class="d-grid py-4 px-7 pt-8">
                          <a href="disconnect.php" class="btn btn-outline-primary">Déconnexion</a>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
        </header>