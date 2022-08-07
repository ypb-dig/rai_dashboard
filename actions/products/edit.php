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
    $idregions = "";
    $namecountry = "";

    $select_regions = "SELECT * FROM regions";

    if ($_SERVER['REQUEST_METHOD'] == 'GET'){

        if(!isset($_GET["id"]) ){
            header("Location: ../../products.php");
            exit;
        }

        $id = $_GET["id"];
        

        $sql = "SELECT * FROM listings l
                JOIN regions r
                ON l.idregions = r.id WHERE l.id = $id";

        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        // if(!$row){
        //     header("Location: ../../products.php");
        //     exit;
        // }

        $id = $row["id"];
        // $main_img = $row["main_img"];
        $name_listing = $row["name_listing"];
        $sign_listing = $row["sign_listing"];
        $price_listing = $row["price_listing"];
        $address_listing = $row["address_listing"];
        $description_listing = $row["description_listing"];
        $idregions = $row["idregions"];
        $namecountry = $row["name_country"];
        // $idcategories = $row["idcategories"];
        // $categories = $row["name"];
    }else{

        $id = $_POST["id"];
        $name_listing = $_POST["name_listing"];
        $sign_listing = $_POST["sign_listing"];
        $price_listing = $_POST["price_listing"];
        $address_listing = $_POST["address_listing"];
        $description_listing = $_POST["description_listing"];
        $idregions = $_POST["idregions"];
        $namecountry = $_POST["name_country"];
        // $idcategories = $_POST["idcategories"];

        $price_real = str_replace(',00','', $price_listing);

        do{
            if( empty($name_listing) || empty($price_listing) || empty($address_listing) || empty($description_listing)){
                $errorMessage = "Todos os campos são obrigatórios";
                break;
            }

            $conn->begin_transaction();

            $update = "UPDATE `listings` 
                       SET `name_listing` = '$name_listing', `sign_listing` = '$sign_listing', `price_listing` = '$price_listing', `address_listing` = '$address_listing', `description_listing` = '$description_listing', `idregions` = $idregions, `name_country` = '$namecountry' WHERE `listings`.`id` = $id;
                       WHERE l.id = $id";

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
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <div class="row gx-3 mb-3">
                                            <div class="col-xl-4">
                                                <div class="card mb-4 mb-xl-0">
                                                    <div class="card-header">Imagem Principal</div>
                                                    <div class="card-body text-center">
                                                        <div class="custom-file" style="display:inline">
                                                            <!-- <div id="text-img" class='small font-italic text-muted mb-4 d-none'>JPG ou PNG no máximo 1MB</div>
                                                            <input id="file-img" type='file' class='form-control d-none' name='main_img'> -->
                                                            <img id='mainimg' src="<?php echo $permalink ?>/uploads/<?php echo $main_img ?>" class="img-fluid">
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
                                                                <input class="form-control" name="name_listing" type="text" value="<?php echo $name_listing; ?>">
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                                <label class="small mb-1" for="inputFirstName">Valor</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                    <select name="sign_listing" class="form-control">
                                                                        <option value="<?php echo $sign_listing; ?>">
                                                                            <span class="input-group-text"><?php echo $sign_listing; ?></span>
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
                                                                    <input type="text" id="currency" name="price_listing" class="form-control" value="<?php echo $price_listing; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 mt-2">
                                                                <label class="small mb-1" for="exampleFormControlTextarea1">Endereço</label>
                                                                <input type="text" name="address_listing" class="form-control" value="<?php echo $address_listing; ?>">
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                                <div class='select'>
                                                                    <label class="small mb-1" for="inputFirstName">País</label>
                                                                    <select name="name_country" id='select' class='form-control'>
                                                                        <option value="<?php echo $namecountry; ?>"><?php echo $namecountry; ?></option>  
                                                                        <option value="Brasil">Brasil</option>
                                                                        <option value="Estados Unidos">Estados Unidos</option>
                                                                        <option value="Portugal">Portugal</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                                <div class='select'>
                                                                    <label class="small mb-1" for="inputFirstName">Região</label>
                                                                    <select name="idregions" id='select' class='form-control'>
                                                                    <?php 
                                                                        if($regions = $conn->query($select_regions)){
                                                                    ?>
                                                                        <?php
                                                                            while($row2 = $regions->fetch_assoc()){
                                                                                echo "<option value='".$row2['id']."'>".$row2['name_region']."</option>";
                                                                                }
                                                                            }else{
                                                                                echo "0 Resultados";
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- 
                                                            <div class="col-md-12 mt-2">
                                                                <label class="small mb-1" for="exampleFormControlTextarea1">Categorias</label>
                                                            </div>
                                                            
                                                            <div class="col-md-2 mt-2">
                                                                <div class="form-group form-check">
                                                                    <input type="checkbox" value="<?php echo $idcategories ?>" name="idcategories[]" class="form-check-input" checked>
                                                                    <label class="small mb-1"><?php echo $categories ?></label>
                                                                </div>
                                                            </div> -->

                                                            
                                                            <div class="col-md-12 mt-4">
                                                                <label class="small mb-1" for="exampleFormControlTextarea1">Descrição</label>
                                                                <textarea class="form-control" name="description_listing" rows="5" value="<?php echo $description_listing; ?>"><?php echo $description_listing; ?></textarea>
                                                            </div>
                                                        </div>                                 
                                                        <button type="submit" name="save" class="btn btn-primary" type="button">Alterar Produto</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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

    <!-- <script>
        $("#edit-mainimg").click(function() {
            $("#text-img").removeClass("d-none");
            $("#file-img").removeClass("d-none");
            $("#btn-edit-img").addClass("d-none");
            $("#mainimg").addClass("d-none");
        });
    </script> -->

</body>

</html>     