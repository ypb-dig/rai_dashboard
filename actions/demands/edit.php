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

        $result = $conn->query($sql);

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
        $main_pdf = $_FILES["main_pdf"];

        do{
            if( empty($name_company) || empty($source_company) || empty($contact_company) || empty($phone_company) || empty($features_company)){
                $errorMessage = "Todos os campos são obrigatórios";
                break;
            }

            if($main_pdf !==null ){
                preg_match("/\.(pdf){1}$/i", $main_pdf["name"], $ext);
    
                if($ext == true){
                    $nome_pdf = md5(uniqid(time())) . "." . $ext[1];
                    $path_pdf = "../../uploads/pdf/" . $nome_pdf;
                    move_uploaded_file($main_pdf["tmp_name"], $path_pdf);

                    $sql = "UPDATE demands SET name_company = '$name_company', source_company = '$source_company', contact_company = '$contact_company', phone_company = '$phone_company', features_company = '$features_company', main_pdf = '$nome_pdf', idregions = '$idregions' WHERE id = $id"; 

                    $result = $conn->query($sql);
                }
            }

            if(!$result){
                $errorMessage = "Erro ao cadastrar" . $conn->error;
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

                <div class="container-xl px-4 mt-4">
                    <div class="row">
                        <div class="col-xl-4">              
                            <div class="card mb-xl-0">
                                <div class="card-header">Categorias</div>
                                <div class="card-body overflow-y">
                                    <!-- <div class="form-group form-check">        
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
                                    </div> -->
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
                                    <?php 
                                        while($row = $result->fetch_assoc()){
                                    ?>
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <input type="hidden" name="idregions" id="idregion" value="<?php echo $row['idregions'] ?>">
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
                                            <div class="col-md-12 mt-4">
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
                                            </div>
                                            <div class="col-md-12">
                                                <label class="small mb-1" for="exampleFormControlTextarea1">Descrição</label>
                                                <textarea class="form-control" name="features_company" rows="5" value="<?php echo $row['features_company'] ?>"><?php echo $row['features_company'] ?></textarea>
                                            </div>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary" type="button">Cadastrar Demanda</button>
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