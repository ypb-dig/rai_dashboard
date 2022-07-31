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
    $idcountry = "";
    $idregions = "";
    $name_country = "";
    $name_region = "";
    $idcategories ="";

    $errorMessage = "";

    $select = "SELECT * FROM categories";
    $result_select = $conn->query($select);

    $select_regions = "SELECT * FROM regions";
    $result_regions = $conn->query($select_regions);

    $select_country = "SELECT * FROM countries";
    $result_country = $conn->query($select_country);

    if ($_SERVER['REQUEST_METHOD'] == 'GET'){

        if(!isset($_GET["id"]) ){
            header("Location: ../../demands.php");
            exit;
        }

        $id = $_GET["id"];

        $sql = "SELECT * FROM demands d
                JOIN cadastro_listing_categories cd on d.id = cd.iddemands 
                JOIN categories c on c.id = cd.idcategories 
                JOIN regions r ON r.id = d.idregions 
                JOIN countries cr ON cr.id = d.idcountry WHERE d.id = $id;";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        if(!$row){
            header("Location: ../../demands.php");
            exit;
        }

        $name_company = $row["name_company"];
        $source_company = $row["source_company"];
        $contact_company = $row["contact_company"];
        $phone_company = $row["phone_company"];
        $features_company = $row["features_company"];
        $idcountry = $row["idcountry"];
        $idregions = $row["idregions"];
        $name_country = $row["name_country"];
        $name_region = $row["name_region"];

    }else{

        $id = $_POST["id"];
        $name_company = $_POST["name_company"];
        $source_company = $_POST["source_company"];
        $contact_company = $_POST["contact_company"];
        $phone_company = $_POST["phone_company"];
        $features_company = $_POST["features_company"];
        $idcountry = $_POST["idcountry"];
        $idregions = $_POST["idregions"];

        do{
            if( empty($name_company) || empty($source_company) || empty($contact_company) || empty($phone_company) || empty($features_company) || empty($idcountry) || empty($idregions)){
                $errorMessage = "Todos os campos são obrigatórios";
                break;
            }

            $sql = "UPDATE demands SET name_company = '$name_company', source_company = '$source_company', contact_company = '$contact_company', phone_company = '$phone_company', features_company = '$features_company', idcountry = '$idcountry', idregions = '$idregions' WHERE id = $id"; 
            
            $result = $conn->query($sql);

            echo $sql;

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
                                    <form method="POST">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <div class="row gx-3 mb-3">
                                            <div class="col-md-6 mb-3">
                                                <label class="small mb-1" for="inputFirstName">Empresa</label>
                                                <input class="form-control" name="name_company" type="text" value="<?php echo $name_company; ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="small mb-1" for="inputFirstName">Fonte de Contato</label>
                                                <input class="form-control" name="source_company" type="text" value="<?php echo $source_company; ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="small mb-1" for="inputFirstName">Contato</label>
                                                <input class="form-control" name="contact_company" type="text" value="<?php echo $contact_company; ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="small mb-1" for="inputFirstName">Fone</label>
                                                <input class="form-control" name="phone_company" type="text" value="<?php echo $phone_company; ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class='select'>
                                                    <label class="small mb-1" for="inputFirstName">Região</label>
                                                    <select name="idregions" id='select' class='form-control'>
                                                        <option value="<?php echo $idregions; ?>" selected><?php echo $name_region; ?></option>
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
                                            <div class="col-md-6 mb-3">
                                                <div class='select'>
                                                    <label class="small mb-1" for="inputFirstName">País</label>
                                                    <select name="idcountry" id='select' class='form-control'>
                                                        <option value="<?php echo $idcountry; ?>" selected><?php echo $name_country; ?></option>
                                                        <?php 
                                                        if($result_country->num_rows > 0){
                                                            while($row = $result_country->fetch_assoc()){
                                                                echo "<option value='".$row['id']."'>".$row['name_country']."</option>";
                                                                }
                                                            }else{
                                                                echo "0 Resultados";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <label class="small mb-1" for="exampleFormControlTextarea1">Descrição</label>
                                                <textarea class="form-control" name="features_company" rows="5" value="<?php echo $features_company; ?>"><?php echo $features_company; ?></textarea>
                                            </div>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary" type="button">Cadastrar Demanda</button>
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

    <script>
        $('.select').jselect_search({
            placeholder :'Procurar'
        });
    </script>

</body>

</html>     