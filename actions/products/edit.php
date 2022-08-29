<?php
    include '../../config.php';
    include '../../protect.php';
    include '../../inc/head.php';

    $id = "";
    $name_listing = "";
    $sign_listing = "";
    $price_listing = "";
    $address_listing = "";
    $description_listing = "";
    $main_pdf = "";
    $idregions = "";
    $namecountry = "";

    $country_bra = "SELECT * FROM regions WHERE name_country = 'Brasil'";
    $result_regions_bra = $conn->query($country_bra);

    $country_eua = "SELECT * FROM regions WHERE name_country = 'Estados Unidos'";
    $result_regions_eua = $conn->query($country_eua);

    $country_por = "SELECT * FROM regions WHERE name_country = 'Portugal'";
    $result_regions_por = $conn->query($country_por);

    if ($_SERVER['REQUEST_METHOD'] == 'GET'){

        if(!isset($_GET["id"]) ){
            header("Location: ../../products.php");
            exit;
        }

        $id = $_GET["id"];
        $region = $_GET["region"];
        
        $listings = "SELECT listings.id, listings.uid, listings.main_img, listings.name_listing, listings.sign_listing, listings.price_listing, listings.address_listing, listings.idregion, regions.name_region, regions.name_country, listings.description_listing, listings.main_pdf
        FROM `listings` 
        JOIN regions 
        WHERE regions.name_region = '$region'";

        $result = $conn->query($listings);

        // if(!$row){
        //     header("Location: ../../products.php");
        //     exit;
        // }

    }else{

        $id = $_POST["id"];
        $uid = $_POST["id"];
        // $main_img = $_FILES["main_img"];
        $name_listing = $_POST["name_listing"];
        $sign_listing = $_POST["sign_listing"];
        $price_listing = $_POST["price_listing"];
        $address_listing = $_POST["address_listing"];
        $description_listing = $_POST["description_listing"];
        $idregion = $_POST["idregion"];
        // $main_pdf = $_FILES["main_pdf"];

        $price_real = str_replace(',00','', $price_listing);
        $price_format = str_replace('.','', $price_real);
        $price_format2 = str_replace(',','', $price_format);

        do{
            if( empty($name_listing) || empty($price_listing) || empty($address_listing) || empty($description_listing)){
                $errorMessage = "Todos os campos são obrigatórios";
                break;
            }

            $conn->begin_transaction();

            $update = "UPDATE `listings` 
                SET `name_listing` = '$name_listing', `sign_listing` = '$sign_listing', `price_listing` = '$price_format2', `address_listing` = '$address_listing', `description_listing` = '$description_listing', `idregion` = $idregion
                WHERE `listings`.`id` = $id";

            $result_update = $conn->query($update);
                

            // if($main_img !== null){
            //     preg_match("/\.(png|jpg|jpeg){1}$/i", $main_img["name"], $ext);
    
            //     if($ext == true){
            //         $nome_mainimg = md5(uniqid(time())) . "." . $ext[1];
            //         $path_mainimg = "../../uploads/" . $nome_mainimg;
            //         move_uploaded_file($main_img["tmp_name"], $path_mainimg);

                    

            //         $result_insert = $conn->query($update);
            //     }
            // }
            
            // foreach($idcategories as $category)
            // {
            //     $insert2 = "INSERT INTO cadastro_listing_categories (id, data, idcategories, idlistings)" . "VALUES (NULL, NOW(), '$category','$id')"; 
            //     // echo $category; 
            //     $result_insert = $conn->query($insert2);
            // }

            $conn->commit();

            if(!$result_update){
                $erro = $conn->error;
                $errorMessage = "Erro ao cadastrar".$erro;
                break;
            }
            
            header("Location: ../../products.php?msg=success");
            exit;


        }while(false);

    }
?>

<body id="page-top">
    <div id="wrapper">

        <?php include '../../inc/sidebar.php' ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <?php include '../../inc/topnavbar.php' ?>

                <div class="container-xl px-4 mt-4">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-header">Detalhes da Categoria</div>
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
                                    <?php 
                                        while($row = $result->fetch_assoc()){
                                            $price_real = $row['price_listing'];
                                            $price_format = number_format($price_real, 2,',','.');
                                    ?>
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <input type="hidden" name="idregion" id="idregion" value="<?php echo $row['idregion'] ?>">

                                        <div class="row gx-3 mb-3">
                                            <div class="col-xl-4">
                                                <div class="card mb-4 mb-xl-0">
                                                    <div class="card-header">Imagem Principal</div>
                                                    <div class="card-body text-center">
                                                        <div class="custom-file" style="display:inline">
                                                            <!-- <div id="text-img" class='small font-italic text-muted mb-4'>JPG ou PNG no máximo 1MB</div> -->
                                                                
                                                                <input id="file-img" type='file' class='form-control d-none' name='main_img'>
                                                                <img id='mainimg' src="<?php echo $permalink ?>/uploads/<?php echo $row['main_img'] ?>" class="img-fluid">
                                                           
                                                                <?php 
                                                                    // if(isset($main_img)){
                                                                    //     echo "
                                                                    //         <div class='' style='position:absolute;right:0;left:0;width:100%;    top:0;' id='btn-edit-img'>
                                                                    //             <a id='edit-mainimg' class='btn btn-primary'>
                                                                    //                 <i class='fa fa-edit'></i>
                                                                    //             </a>
                                                                    //         </div>
                                                                    //         <img id='mainimg' src='$permalink/uploads/$main_img' class='img-fluid'>
                                                                    //         ";
                                                                    // }else{
                                                                    //     echo "
                                                                    //     <div class='small font-italic text-muted mb-4'>JPG ou PNG no máximo 1MB</div>
                                                                    //     <input type='file' class='form-control' name='main_img'>";
                                                                    // }
                                                                ?>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div class="card my-4 mb-xl-0">
                                                    <div class="card-header">Categorias</div>
                                                    <div class="card-body overflow-y">
                                                        <div class="form-group form-check">
                                                            
                                                            <?php 
                                                                if($result_select->num_rows > 0){
                                                                    while($row = $result_select->fetch_assoc()){
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
                                                                <input class="form-control" name="name_listing" type="text" value="<?php echo $row['name_listing'] ?>">
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                                <label class="small mb-1" for="inputFirstName">Valor</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                    <select name="sign_listing" class="form-control">
                                                                        <option value="<?php echo $row['sign_listing'] ?>">
                                                                            <span class="input-group-text"><?php echo $row['sign_listing'] ?></span>
                                                                        </option>
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
                                                                    <input type="text" name="price_listing" class="form-control" value="<?php echo $price_format; ?>" data-affixes-stay="true" data-thousands="." id="currency">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 mt-2">
                                                                <label class="small mb-1" for="exampleFormControlTextarea1">Endereço</label>
                                                                <input type="text" name="address_listing" class="form-control" value="<?php echo $row['address_listing'] ?>">
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                                <div class='select'>
                                                                    <label class="small mb-1" for="inputFirstName">País</label>
                                                                    <select id='select' class='country form-control'>
                                                                        <option value="<?php echo $row['name_country'] ?>"><?php echo $row['name_country'] ?></option> 
                                                                        <option value="Brasil">Brasil</option>
                                                                        <option value="Estados Unidos">Estados Unidos</option>
                                                                        <option value="Portugal">Portugal</option> 
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mt-2 region_empty">
                                                                <div class='select'>
                                                                    <label class="small mb-1" for="inputFirstName">Região</label>
                                                                    <select id='select' class='country form-control'>
                                                                        <option value="<?php echo $row['idregion'] ?>"><?php echo $row['name_region'] ?></option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mt-2 region_bra">
                                                                <div class='select'>
                                                                    <label class="small mb-1" for="inputFirstName">Região</label>
                                                                    <select id='select' class='form-control' onchange="changeHiddenInput(this)">
                                                                        <option value="">Selecione uma região</option>
                                                                        <?php 
                                                                        if($result_regions_bra->num_rows > 0){
                                                                            while($row2 = $result_regions_bra->fetch_assoc()){
                                                                                echo "<option value='".$row2['id']."'>".$row2['name_region']."</option>";
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
                                                                            while($row2 = $result_regions_eua->fetch_assoc()){
                                                                                echo "<option value='".$row2['id']."'>".$row2['name_region']."</option>";
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
                                                                            while($row2 = $result_regions_por->fetch_assoc()){
                                                                                echo "<option value='".$row2['id']."'>".$row2['name_region']."</option>";
                                                                                }
                                                                            }else{
                                                                                echo "0 Resultados";
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- <div class="col-md-12 mt-4">
                                                                <?php
                                                                    $pdf = $row["main_pdf"];
                                                                    if(!empty($pdf)){ 
                                                                ?>
                                                                <label class="small mb-1" for="exampleFormControlTextarea1">PDF</label>
                                                                <div class="custom-file">
                                                                    <a href="<?php echo $permalink; ?>/uploads/pdf/<?php echo $row["main_pdf"]; ?>" target="_blank">
                                                                        <i class="far fa-file-pdf" style="font-size:22px;color:red"></i> pdf
                                                                    </a>
                                                                </div>
                                                                <?php }else{ ?>
                                                                    <label class="small mb-1" for="exampleFormControlTextarea1">PDF</label>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="form-control" name="main_pdf">
                                                                    </div>
                                                                <?php } ?>
                                                            </div>-->
                                                            <div class="col-md-12 mt-2">
                                                                <label class="small mb-1" for="exampleFormControlTextarea1">Descrição</label>
                                                                <textarea class="form-control" name="description_listing" rows="5" value="<?php echo $row['description_listing'] ?>"><?php echo $row['description_listing'] ?></textarea>
                                                            </div> 
                                                        </div>                              
                                                        <button type="submit" name="save" class="btn btn-primary" type="button">Alterar Produto</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <?php  } ?> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
        $(".region_bra").css('display', 'none');
        $(".region_eua").css('display', 'none');
        $(".region_por").css('display', 'none');

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
                $(".region_empty").css('display', 'none');
            }
            if($(this).val() == 'Estados Unidos'){
                $(".region_eua").css('display', 'block');
                $(".region_bra").css('display', 'none');
                $(".region_por").css('display', 'none');
                $(".region_empty").css('display', 'none');
            }
            if($(this).val() == 'Portugal'){
                $(".region_eua").css('display', 'none');
                $(".region_bra").css('display', 'none');
                $(".region_por").css('display', 'block');
                $(".region_empty").css('display', 'none');
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