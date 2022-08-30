<?php
    include '../../config.php';
    include '../../protect.php';
    include '../../inc/head.php';

    $id = "";
    $name_company = "";
    $source_company = "";
    $contact_company = "";
    $phone_company = "";
    $features_company = "";
    $idregions = "";
    $name_country = "";
    $name_region = "";

    $errorMessage = "";

    $country_bra = "SELECT * FROM regions WHERE name_country = 'Brasil'";
    $result_regions_bra = $conn->query($country_bra);

    $country_eua = "SELECT * FROM regions WHERE name_country = 'Estados Unidos'";
    $result_regions_eua = $conn->query($country_eua);

    $country_por = "SELECT * FROM regions WHERE name_country = 'Portugal'";
    $result_regions_por = $conn->query($country_por);

    if ($_SERVER['REQUEST_METHOD'] == 'GET'){

        if(!isset($_GET["id"]) ){
            header("Location: ../../demands.php");
            exit;
        }

        $id = $_GET["id"];
        $region = $_GET["region"];

        $sql = "SELECT * FROM demands d JOIN regions r WHERE r.name_region = '$region'";

        $demands = "SELECT * FROM cadastro_listing_categories c
        JOIN categories cat JOIN regions r JOIN demands d
        ON c.idcategories = cat.id AND d.idregions = r.id
        WHERE c.iddemands = $id AND r.name_region = '$region'";

        $categories = "SELECT * FROM categories";

        $result = $conn->query($sql);
        $result_demands = $conn->query($demands);
        $result_categories = $conn->query($categories);


        // if(!$row){
        //     header("Location: ../../demands.php");
        //     exit;
        // }

    }else{

        $id = $_POST["id"];
        $name_company = $_POST["name_company"];
        $source_company = $_POST["source_company"];
        $contact_company = $_POST["contact_company"];
        $phone_company = $_POST["phone_company"];
        $features_company = $_POST["features_company"];
        $idregions = $_POST["idregions"];
        $idcategories = $_POST["idcategories"];

        do{
            if( empty($name_company) || empty($source_company) || empty($contact_company) || empty($phone_company) || empty($features_company)){
                $errorMessage = "Todos os campos são obrigatórios";
                break;
            }
            
            $conn->begin_transaction();

            $sql = "UPDATE demands SET name_company = '$name_company', source_company = '$source_company', contact_company = '$contact_company', phone_company = '$phone_company', features_company = '$features_company', idregions = '$idregions' WHERE id = $id"; 

            $result = $conn->query($sql);


            foreach($idcategories as $category)
            {
                $insert2 = "INSERT INTO cadastro_listing_categories (id, data, idcategories, iddemands)" . "VALUES (NULL, NOW(), '$category','$id')"; 
                $result = $conn->query($insert2);
            }
            
               
            $conn->commit();

            if(!$result){
                $errorMessage = "Erro ao cadastrar, um ou mais campos obrigatórios não foram preenchidos";
                break;
            }
            
            header("Location: ../../demands.php?msg=success");
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

                <?php 
                    while($row = $result->fetch_assoc()){
                ?>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="idregions" id="idregion" value="<?php echo $row['idregions'] ?>">
                    <div class="container-xl px-4 mt-4">
                        <div class="row">
                            <div class="col-xl-4">            
                                <div class="card my-4 mb-xl-0">
                                    <div class="card-header">Categorias</div>
                                    <div class="card-body overflow-y">
                                        <div class="form-group form-check"> 
                                            <?php 
                                                while($row2 = $result_demands->fetch_assoc()){
                                            ?>     
                                            <?php
                                                if($result_categories->num_rows > 0){
                                                    $checked = $row2['idcategories'];
                                                    while($row1 = $result_categories->fetch_assoc()){
                                                ?>
                                                <div class='form-group form-check categories'>
                                                    <input type='checkbox' value="<?php echo $row1['id'] ?>" name='idcategories[]' class='form-check-input' <?php if($row1['id']==$checked){echo "checked='checked'"; } ?>>
                                                    <label class='small mb-0'><?php echo $row1['name']; ?></label>
                                                        </div>
                                                <?php }} ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8">
                                <div class="card mb-4">
                                    <div class="card-header">Detalhes da Demanda</div>
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
                                            <div class="col-md-6 mb-3">
                                                <label class="small mb-1" for="inputFirstName">Empresa</label>
                                                <input class="form-control" name="name_company" type="text" value="<?php echo $row['name_company'] ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="small mb-1" for="inputFirstName">Fonte de Contato</label>
                                                <input class="form-control" name="source_company" type="text" value="<?php echo $row['source_company'] ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="inputFirstName">Contato</label>
                                                <input class="form-control" name="contact_company" type="text" value="<?php echo $row['contact_company'] ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="inputFirstName">Fone</label>
                                                <input class="form-control" name="phone_company" type="text" value="<?php echo $row['phone_company'] ?>">
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
                                                        <option value="<?php echo $row['idregions'] ?>"><?php echo $row['name_region'] ?></option>
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
                                            </div> -->
                                            <div class="col-md-12 mt-4">
                                                <label class="small mb-1" for="exampleFormControlTextarea1">Descrição</label>
                                                <textarea class="form-control" name="features_company" rows="5" value="<?php echo $row['features_company'] ?>"><?php echo $row['features_company'] ?></textarea>
                                            </div>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary" type="button">Cadastrar Demanda</button>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                    </form>
                <?php  } ?>
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

    <script>
        $('.select').jselect_search({
            placeholder :'Procurar'
        });
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