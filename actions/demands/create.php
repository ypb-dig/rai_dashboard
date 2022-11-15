<?php
    include '../../config.php';
    include '../../protect.php';
    include '../../inc/head.php';

    ini_set('display_errors', 1);
    ini_set('display_startup_erros', 1);

    $id = "";
    $name_company = "";
    $fundname_company ="";
    $email_company ="";
    $source_company = "";
    $contact_company = "";
    $income_company = "";
    $investment_company = "";
    $phone_company = "";
    $features_company = "";
    $policy_company = "";
    $main_pdf = "";
    $name_country = "";
    $idcategories ="";

    $errorMessage = "";

    $select = "SELECT * FROM categories";
    $result_select = $conn->query($select);

    $listings = "SELECT * FROM regions WHERE name_country = 'Brasil'";
    $result_regions = $conn->query($listings);

    $country_eua = "SELECT * FROM regions WHERE name_country = 'Estados Unidos'";
    $result_regions_eua = $conn->query($country_eua);

    $country_por = "SELECT * FROM regions WHERE name_country = 'Portugal'";
    $result_regions_por = $conn->query($country_por);

    $categories = "SELECT * FROM categories";
    $result_categories = $conn->query($categories);

    $select_country = "SELECT * FROM countries";
    $result_country = $conn->query($select_country);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $id = $_POST["id"];
        $uid = $_POST["id"];
        $name_company = $_POST["name_company"];
        $fundname_company = $_POST["fundname_company"];
        $email_company = $_POST["email_company"];
        $source_company = $_POST["source_company"];
        $contact_company = $_POST["contact_company"];
        $income_company = $_POST["income_company"];
        $investment_company = $_POST["investment_company"];
        $phone_company = $_POST["phone_company"];
        $features_company = $_POST["features_company"];
        $policy_company = $_POST["policy_company"];
        $main_pdf = $_FILES["main_pdf"];
        $idregions = $_POST["idregions"];
        $idcategories = $_POST["idcategories"];

        do{
            if( empty($name_company) || empty($contact_company)){
                $errorMessage = "Todos os campos são obrigatórios";
                break;
            }

            $conn->begin_transaction();
            
            if(!empty($main_pdf)){
                preg_match("/\.(pdf){1}$/i", $main_pdf["name"], $ext);
    
                if($ext == true){
                    $nome_pdf = md5(uniqid(time())) . "." . $ext[1];
                    $path_pdf = "../../uploads/pdf/" . $nome_pdf;
                    move_uploaded_file($main_pdf["tmp_name"], $path_pdf);

                    $insert = "INSERT INTO demands (id, uid, name_company, fundname_company, email_company, income_company, investment_company, source_company, contact_company, phone_company, features_company, policy_company, main_pdf, idregions)" . "VALUES ($id, $uid, '$name_company', '$fundname_company', '$email_company', '$income_company', '$investment_company', '$source_company', '$contact_company', '$phone_company', '$features_company', '$policy_company', '$nome_pdf', $idregions)";

                    $result_insert = $conn->query($insert);
                }else{
                    $insert = "INSERT INTO demands (id, uid, name_company, fundname_company, email_company, income_company, investment_company, source_company, contact_company, phone_company, features_company, policy_company, main_pdf, idregions)" . "VALUES ($id, $uid, '$name_company', '$fundname_company', '$email_company', '$income_company', '$investment_company', '$source_company', '$contact_company', '$phone_company', '$features_company', '$policy_company', '', $idregions)";

                    $result_insert = $conn->query($insert);
                }
            }

            foreach($idcategories as $category)
            {
                $insert2 = "INSERT INTO cadastro_listing_categories (id, data, idcategories, iddemands)" . "VALUES (NULL, NOW(), '$category','$id')"; 
                // echo $category; 
                $result_insert = $conn->query($insert2);
            }

            if(!$result_insert){
                $errorMessage = "Erro ao cadastrar" . $conn->error;
                // $errorMessage = "Erro ao cadastrar, um ou mais campos obrigatórios não foram preenchidos";
                break;
            }

            $conn->commit();

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

                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo(rand(3,100000)); ?>">
                    <input type="hidden" name="idregions" id="idregion" value="">
                    <div class="container-xl px-4 mt-4">
                        <div class="row">
                            <div class="col-xl-4">              
                                <div class="card mb-xl-0">
                                    <div class="card-header">Tipo de Lastro</div>
                                    <div class="card-body overflow-y" style="max-height:800px;height:auto">
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
                                                <input class="form-control" name="name_company" type="text" value="<?php echo $name_company; ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="small mb-1" for="inputFirstName">Nome do Fundo</label>
                                                <input class="form-control" name="fundname_company" type="text" value="<?php echo $fundname_company; ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="small mb-1" for="inputFirstName">Nome do Gestor</label>
                                                <input class="form-control" name="contact_company" type="text" value="<?php echo $contact_company; ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="small mb-1" for="inputFirstName">Email do Gestor</label>
                                                <input class="form-control" name="email_company" type="text" value="<?php echo $email_company; ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="small mb-1" for="inputFirstName">Tipo de Renda</label>
                                                <select class='form-control' name="income_company">
                                                    <option value="">Selecione um tipo de renda</option>  
                                                    <option value="Rendimentos e/ou ganho de capital">
                                                        Rendimentos e/ou ganho de capital
                                                    </option>
                                                    <option value="Renda por aluguel e/ou valorização dos ativos">
                                                        Renda por aluguel e/ou valorização dos ativos
                                                    </option>
                                                    <option value="Valorização dos ativos">Valorização dos ativos</option>
                                                    <option value="Renda por aluguel">Renda por aluguel</option>
                                                </select>
                                            </div>    
                                            <div class="col-md-6 mb-3">
                                                <label class="small mb-1" for="inputFirstName">Tipo de Investimento</label>
                                                <select class='form-control' name="investment_company">
                                                    <option value="">Selecione um tipo de investimento</option>  
                                                    <option value="Ativos Financeiros">Ativos Financeiros</option>
                                                    <option value="Imóvel">Imóvel</option>
                                                    <option value="Cotas">Cotas</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="small mb-1" for="inputFirstName">Fonte de Contato</label>
                                                <input class="form-control" name="source_company" type="text" value="<?php echo $source_company; ?>">
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label class="small mb-1" for="inputFirstName">Fone</label>
                                                <input class="form-control" name="phone_company" type="text" value="<?php echo $phone_company; ?>">
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
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
                                            <div class="col-md-6 region_bra">
                                                <div class='select'>
                                                    <label class="small mb-1" for="inputFirstName">Região</label>
                                                    <select id='select' class='form-control' onchange="changeHiddenInput(this)">
                                                        <option value="" selected>Selecione uma região</option>
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
                                            <div class="col-md-6 region_eua">
                                                <div class='select'>
                                                    <label class="small mb-1" for="inputFirstName">Região</label>
                                                    <select id='select' class='form-control' onchange="changeHiddenInput(this)">
                                                        <option value="" selected>Selecione uma região</option>
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
                                            <div class="col-md-6 region_por">
                                                <div class='select'>
                                                    <label class="small mb-1" for="inputFirstName">Região</label>
                                                    <select id='select' class='form-control' onchange="changeHiddenInput(this)">
                                                        <option value="" selected>Selecione uma região</option>
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
                                                <label class="small mb-1" for="exampleFormControlTextarea1">PDF</label>
                                                <div class="custom-file">
                                                    <input type="file" class="form-control" name="main_pdf">
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <label class="small mb-1" for="exampleFormControlTextarea1">Objetivo do Fundo</label>
                                                <textarea class="form-control" name="features_company" rows="5" value="<?php echo $features_company; ?>"></textarea>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <label class="small mb-1" for="exampleFormControlTextarea1">Política de Investimento</label>
                                                <textarea class="form-control" name="policy_company" rows="5" value="<?php echo $policy_company; ?>"></textarea>
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