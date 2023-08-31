<?php

    require("includes/header.php");

    if (isset($_POST['submit'])){

        $prix = $_POST['prix'];
        $domaine = $_POST['domaine'];
        $description = $_POST['description'];
        $date_limite = $_POST['date'];

        if (!empty($prix) && !empty($domaine) && !empty($description) && $date_limite){

            $date = date("Y-m-d", strtotime($_POST['date']));

            // Faire le script de contrôle du prix disponible

            $comparaison = $prix > $solde;

            if ($prix <= $solde){

                function token_random_string($leng=40){

                    $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $token = '';
                    for ($i=0;$i<$leng;$i++){
                        $token.=$str[rand(0, strlen($str)-1)];
                    }
                    return $token;
                }
    
                $token = token_random_string(15);
    
                $insertService = $database->prepare("INSERT INTO services(service_token, payeur_token, prix, domaine, description, date_limite) VALUES(:service_token, :payeur_token, :prix, :domaine, :description, :date_limite)");
                $insertService->bindvalue(":service_token", $token);
                $insertService->bindvalue(":payeur_token", $unique_id);
                $insertService->bindvalue(":prix", $prix);
                $insertService->bindvalue(":domaine", $domaine);
                $insertService->bindvalue(":description", $description);
                $insertService->bindvalue(":date_limite", $date);
                $insertService->execute();

                $newSolde = $solde - $prix;

                $updateSolde = $database->prepare("UPDATE users SET solde=:solde WHERE unique_id=:unique_id");
                $updateSolde->bindvalue(":solde", $newSolde);
                $updateSolde->bindvalue(":unique_id", $unique_id);
                $updateSolde->execute();
    
                $success = "Publié avec succès";

            }else{
                $error = "Solde insuffisant, veuillez recharger votre solde";
            }

            
        }else{
            $error = "Veuillez remplir tous les champs important";
        }

    }

?>
        <!-- --------------------------------------------------- -->
        <!-- Header End -->
        <!-- --------------------------------------------------- -->
        <div class="container-fluid">
          <!-- --------------------------------------------------- -->
          <!--  Form Basic Start -->
          <!-- --------------------------------------------------- -->
          <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8">Publication d'un service</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a class="text-muted" href="index.php">Accueil</a></li>
                      <li class="breadcrumb-item" aria-current="page">Publier un service</li>
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
          <section>

            <div class="row">
              <div class="col-md-12">
                <div class="col-lg-12">
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
                    <div class="card">
                    <div class="card-body">
                        <h5>Besoin d'un coup de main pour votre projet ?</h5>
                        <p class="card-subtitle mb-3">
                            Publiez votre demande de service et trouvez le professionnel idéal pour concrétiser votre vision !
                        </p>
                        <form method="post">
                            <div class="form-floating mb-3">
                                <input
                                type="text"
                                class="form-control border border-primary"
                                placeholder="Prix du service" name="prix"
                                />
                                <label
                                ><i class="ti ti-currency-dollar me-2 fs-4 text-primary"></i><span class="border-start border-primary ps-3"
                                    >Prix du service <span class="text-danger">*</span></span
                                ></label
                                >
                            </div>
                            <div class="form-floating mb-3">
                                <input
                                type="text"
                                class="form-control border border-primary"
                                placeholder="domaine" name="domaine"
                                />
                                <label
                                ><i class="ti ti-mail me-2 fs-4 text-primary"></i><span class="border-start border-primary ps-3"
                                    >Domaine du service <span class="text-danger">*</span></span
                                ></label
                                >
                            </div>

                            <!-- <img src="../../dist/images/profile/user-1.jpg" alt="" width="40"> -->
                            

                            <div class="form-floating mb-3">
                                <textarea name="description" id="" cols="30" rows="10" class="form-control border border-primary" >Utilisez cet espace pour présenter votre demande de service de manière claire et concise, en incluant également votre localisation. Plus vous fournissez de détails, y compris votre emplacement, plus les professionnels seront en mesure de vous offrir un service pertinent et géographiquement proche.</textarea>
                                <label
                                ><i class="ti ti-file-export me-2 fs-4 text-primary"></i><span class="border-start border-primary ps-3"
                                    >Description <span class="text-danger">*</span></span
                                ></label
                                >
                            </div>
                            <div class="form-floating mb-3">
                                <input
                                type="date"
                                class="form-control border border-primary"
                                placeholder="Date limite du service" name="date"
                                />
                                <label
                                ><i class="ti ti-calendar me-2 fs-4 text-primary"></i><span class="border-start border-primary ps-3"
                                    >Date limite du service<span class="text-danger">*</span></span
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
          </section>
          <!-- --------------------------------------------------- -->
          <!--  Form Basic End -->
          <!-- --------------------------------------------------- -->
        </div>
      </div>
    </div>
    
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
    <script src="../../dist/libs/prismjs/prism.js"></script>

    <!-- ---------------------------------------------- -->
    <!-- current page js files -->
    <!-- ---------------------------------------------- -->
  </body>

</html>
