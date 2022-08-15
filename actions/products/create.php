<?php
    include '../../config.php';
    include '../../protect.php';
    include '../../inc/head.php';

    $id = "";
    $main_img = "";
    $name_listing = "";
    $sign_listing = "";
    $price_listing = "";
    $address_listing = "";
    $description_listing = "";
    $name_country = "";
    $idcategories = "";

    $errorMessage = "";

    $listings = "SELECT * FROM regions WHERE name_country = 'Brasil'";
    $result_regions = $conn->query($listings);

    $country_eua = "SELECT * FROM regions WHERE name_country = 'Estados Unidos'";
    $result_regions_eua = $conn->query($country_eua);

    $country_por = "SELECT * FROM regions WHERE name_country = 'Portugal'";
    $result_regions_por = $conn->query($country_por);

    $categories = "SELECT * FROM categories";
    $result_categories = $conn->query($categories);


    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id = $_POST["id"];
        $uid = $_POST["id"];
        $main_img = $_FILES["main_img"];
        $name_listing = $_POST["name_listing"];
        $sign_listing = $_POST["sign_listing"];
        $price_listing = $_POST["price_listing"];
        $address_listing = $_POST["address_listing"];
        $description_listing = $_POST["description_listing"];
        $idregion = $_POST["idregion"];
        $idcategories = $_POST["idcategories"];

        $price_real = str_replace(',00','', $price_listing);
        $price_format = str_replace('.','', $price_real);
        $price_format2 = str_replace(',','', $price_format);

        do{
            if( empty($name_listing) || empty($price_listing) || empty($price_listing) || empty($address_listing) || empty($description_listing)){
                $errorMessage = "Todos os campos são obrigatórios";
                break;
            }

            $conn->begin_transaction();

                if($main_img !== null){
                    preg_match("/\.(png|jpg|jpeg){1}$/i", $main_img["name"], $ext);
        
                    if($ext == true){
                        $nome_mainimg = md5(uniqid(time())) . "." . $ext[1];
                        $path_mainimg = "../../uploads/" . $nome_mainimg;
                        move_uploaded_file($main_img["tmp_name"], $path_mainimg);

                        $insert = "INSERT INTO `listings` (`id`, `uid`, `main_img`, `img1`, `img2`, `img3`, `name_listing`, `sign_listing`, `price_listing`, `address_listing`, `description_listing`, `datetime`, `idregion`) VALUES ($id, $uid, '$nome_mainimg', '', '', '', '$name_listing', '$sign_listing', '$price_format2', '$address_listing', '$description_listing', NOW(), '$idregion');";

                        $result_insert = $conn->query($insert);
                    }
                }

                foreach($idcategories as $category)
                {
                    $insert2 = "INSERT INTO cadastro_listing_categories (id, data, idcategories, idlistings)" . "VALUES ($id, NOW(), '$category', $id)"; 
                    // echo $category; 
                    $result_insert = $conn->query($insert2);
                }
            
            $conn->commit();

            if(!$result_insert){
                $errorMessage = "Erro ao cadastrar" . $conn->error;
                break;
            }
            if($result_insert){
                header("Location: ../../products.php?msg=success");
                exit;
            }

        }while(false);   
    }
?>

<body id="page-top">
    <div id="wrapper">

        <?php include '../../inc/sidebar.php' ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <?php include '../../inc/topnavbar.php' ?>

                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo(rand(3,100000)); ?>">
                    <input type="hidden" name="idregion" id="idregion" value="">

                    <div class="container-xl px-4 mt-4">
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card mb-4 mb-xl-0">
                                    <div class="card-header">Imagem</div>
                                    <div class="card-body text-center">
                                        <img class="img-account-profile rounded-circle mb-2" src="assets/img/demo/user-placeholder.svg" alt="">
                                        <div class="small font-italic text-muted mb-4">JPG ou PNG no máximo 1MB</div>
                                        <div class="custom-file">
                                            <input type="file" class="form-control" name="main_img">
                                        </div>
                                    </div>
                                </div>
                                <div class="card my-4 mb-xl-0">
                                    <div class="card-header">Categorias</div>
                                    <div class="card-body overflow-y">
                                        <div class="form-group form-check">
                                            
                                            <?php 
                                                if($result_categories->num_rows > 0){
                                                    while($row = $result_categories->fetch_assoc()){
                                                        echo "
                                                        <div class='form-group form-check categories'>
                                                            <input type='checkbox' value='".$row['id']."' name='idcategories[]' class='form-check-input'>
                                                            <label class='small mb-0'>".$row['name']."</label>
                                                        </div>";
                                                    }
                                                }else{
                                                    echo "0 Resultados";
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="row">
                                    <div class="col-lg-4">
                                        <div class="card-body text-center">
                                            <img class="img-account-profile rounded-circle mb-2" src="assets/img/demo/user-placeholder.svg" alt="">
                                            <div class="small font-italic text-muted mb-4">JPG ou PNG no máximo 1MB</div>
                                            <button class="btn btn-primary" type="button">Upload</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="card-body text-center">
                                            <img class="img-account-profile rounded-circle mb-2" src="assets/img/demo/user-placeholder.svg" alt="">
                                            <div class="small font-italic text-muted mb-4">JPG ou PNG no máximo 1MB</div>
                                            <button class="btn btn-primary" type="button">Upload</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="card-body text-center">
                                            <img class="img-account-profile rounded-circle mb-2" src="assets/img/demo/user-placeholder.svg" alt="">
                                            <div class="small font-italic text-muted mb-4">JPG ou PNG no máximo 1MB</div>
                                            <button class="btn btn-primary" type="button">Upload</button>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                            <div class="col-xl-8">
                                <div class="card mb-4">
                                    <div class="card-header">Detalhes do Produto</div>
                                    <div class="card-body">
                                        <?php 
                                            if(!empty($errorMessage)){
                                                echo "<div class='card mb-4 py-0 border-left-danger'>
                                                        <div class='card-body p-2 text-danger'>
                                                            $errorMessage
                                                        </div>
                                                    </div>";
                                            }
                                        ?>

                                        <div class="row gx-3 mb-3">
                                            <div class="col-md-6 mt-2">
                                                <label class="small mb-1" for="inputFirstName">Nome</label>
                                                <input class="form-control" name="name_listing" type="text" value="<?php echo $name_listing; ?>">
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <label class="small mb-1" for="inputFirstName">Valor</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <select name="sign_listing" class="form-control">
                                                            <option value="R$">
                                                                <span class="input-group-text">R$</span>
                                                            </option>
                                                            <option value="$">
                                                                <span class="input-group-text">$</span>
                                                            </option>
                                                            <option value="€">
                                                                <span class="input-group-text">€</span>
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <input type="text" name="price_listing" class="form-control" value="<?php echo $price_listing; ?>" data-affixes-stay="true" data-thousands="." id="currency">
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <label class="small mb-1" for="exampleFormControlTextarea1">Endereço</label>
                                                <input type="text" name="address_listing" class="form-control" value="<?php echo $address_listing; ?>">
                                            </div>
                                            
                                            <div class="col-md-6 mt-2">
                                                <div class='select'>
                                                    <label class="small mb-1" for="inputFirstName">País</label>
                                                    <select id='select' class='country form-control'>
                                                        <option value="">Selecione um País</option>  
                                                        <option value="Brasil">Brasil</option>
                                                        <option value="Estados Unidos">Estados Unidos</option>
                                                        <option value="Portugal">Portugal</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mt-2 region_bra">
                                                <div class='select'>
                                                    <label class="small mb-1" for="inputFirstName">Região</label>
                                                    <select id='select' class='form-control' onchange="changeHiddenInput(this)">
                                                        <option value="">Selecione uma região</option>
                                                        <?php 
                                                        if($result_regions->num_rows > 0){
                                                            while($row = $result_regions->fetch_assoc()){
                                                                echo "<option value='".$row['id']."'>".$row['name_region']."</option>";
                                                                }
                                                            }else{
                                                                echo "0 Resultados";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mt-2 region_eua">
                                                <div class='select'>
                                                    <label class="small mb-1" for="inputFirstName">Região</label>
                                                    <select id='select' class='form-control' onchange="changeHiddenInput(this)">
                                                        <option value="">Selecione uma região</option>
                                                        <?php 
                                                        if($result_regions_eua->num_rows > 0){
                                                            while($row = $result_regions_eua->fetch_assoc()){
                                                                echo "<option value='".$row['id']."'>".$row['name_region']."</option>";
                                                                }
                                                            }else{
                                                                echo "0 Resultados";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mt-2 region_por">
                                                <div class='select'>
                                                    <label class="small mb-1" for="inputFirstName">Região</label>
                                                    <select id='select' class='form-control' onchange="changeHiddenInput(this)">
                                                        <option value="">Selecione uma região</option>
                                                        <?php 
                                                        if($result_regions_por->num_rows > 0){
                                                            while($row = $result_regions_por->fetch_assoc()){
                                                                echo "<option value='".$row['id']."'>".$row['name_region']."</option>";
                                                                }
                                                            }else{
                                                                echo "0 Resultados";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12 mt-4">
                                                <label class="small mb-1" for="exampleFormControlTextarea1">Descrição</label>
                                                <textarea class="form-control" name="description_listing" rows="5" value="<?php echo $description_listing; ?>"></textarea>
                                            </div>
                                        </div>                                 
                                        <button type="submit" name="save" class="btn btn-primary" type="button">Cadastrar Produto</button>
                                    </div>
                                </div>
                            </div>
                        </div>      
                    </div>
                </form>
                <!-- /.container-fluid -->
            </div>

            <?php include '../../inc/footer.php'; ?>

        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
    </a>

    <?php include '../../inc/logoutModal.php'; ?>
    <?php include '../../inc/scripts.php'; ?>
    <script src="<?php echo $permalink ?>/js/jquery.maskMoney.min.js"></script>

    <script>
        $('.select').jselect_search({
            placeholder :'Procurar'
        });
    </script>

    <script>
        $(function() {
            $('#currency').maskMoney({
                decimal:","
            });
        })
  </script>

  <script>
    $(document).ready(function(){
        if($(".country").val() == ''){
            $(".region_bra").css('display', 'none');
            $(".region_eua").css('display', 'none');
            $(".region_por").css('display', 'none');
        }
        $(".country").change(function() {
            if($(this).val() == 'Brasil'){
                $(".region_bra").css('display', 'block');
                $(".region_eua").css('display', 'none');
                $(".region_por").css('display', 'none');
            }
            if($(this).val() == 'Estados Unidos'){
                $(".region_eua").css('display', 'block');
                $(".region_bra").css('display', 'none');
                $(".region_por").css('display', 'none');
            }
            if($(this).val() == 'Portugal'){
                $(".region_eua").css('display', 'none');
                $(".region_bra").css('display', 'none');
                $(".region_por").css('display', 'block');
            }
        });
    });

    function changeHiddenInput (objDropDown)
    {
        var objHidden = document.getElementById("idregion");
        objHidden.value = objDropDown.value; 
    }   
  </script>

</body>

</html>     