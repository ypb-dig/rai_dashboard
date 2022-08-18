<?php
    include '../../config.php';
    include '../../protect.php';
    include '../../inc/head.php';

    $id = "";
    $name_listing = "";
    

    if ($_SERVER['REQUEST_METHOD'] == 'GET'){

        $id = $_GET["id"];
        $region = $_GET["region"];

        $sql = "SELECT * FROM cadastro_listing_categories c
                JOIN categories cat JOIN regions r JOIN listings l
                ON c.idcategories = cat.id AND l.idregion = r.id
                WHERE c.idlistings = $id AND r.name_region = '$region'";

        $sql2 = "SELECT * FROM demands d
                JOIN regions r
                ON d.idregions = r.id 
                WHERE r.name_region='$region'";

        $result = $conn->query($sql);
        $result1 = $conn->query($sql);
        $result_demands = $conn->query($sql2);
    }
?>

<body id="page-top">
    <div id="wrapper">

        <?php include '../../inc/sidebar.php' ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <?php include '../../inc/topnavbar.php' ?>

                <?php
                    if($row = $result->fetch_assoc()){
                        $price_real = $row['price_listing'];
                        $price_format = number_format($price_real, 2,',','.');
                ?>
                <div class="container-xl px-4 mt-4">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-header">#<?php echo $id; ?> - <?php echo $row["name_listing"]; ?></div>
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
                                            <img src="<?php echo $permalink; ?>/uploads/<?php echo $row["main_img"]; ?>" class="img-fluid"/>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="mb-2">
                                                <label class="small mb-1" for="inputFirstName">Endereço do Imóvel</label>
                                                <input class="form-control" disabled name="source_company" type="text" value="<?php echo $row["address_listing"] ?>">
                                            </div>
                                            <div class="my-2">
                                                <label class="small mb-1" for="inputFirstName">Valor do Imóvel</label>
                                                <input class="form-control" disabled name="source_company" type="text" value="<?php echo $row["sign_listing"]; ?> <?php echo $price_format; ?>">
                                            </div>
                                            <div class='select my-2'>
                                                <label class="small mb-1" for="inputFirstName">Região</label>
                                                <select name="idregion" id='select' class='form-control' disabled>
                                                    <option value="" selected><?php echo $row["name_region"]; ?></option>
                                                </select>
                                            </div>
                                            <div class='select my-2'>
                                                <label class="small mb-1" for="inputFirstName">País</label>
                                                <select name="idcountry" id='select' class='form-control' disabled>
                                                    <option value="" selected><?php echo $row["name_country"]; ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-1">
                                            <label class="small mb-1" for="exampleFormControlTextarea1">Categorias: </label>
                                            <?php 
                                                if($result1->num_rows > 0){
                                                    while($row1 = $result1->fetch_assoc()){  
                                                        echo "<span class='btn btn-info' style='font-size:12px;cursor: auto;'>$row1[name]</span> ";
                                                    }
                                                }
                                            ?>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <label class="small mb-1" for="exampleFormControlTextarea1">Descrição</label>
                                            <textarea class="form-control" name="features_company" rows="5" value="" disabled><?php echo $row["description_listing"] ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
                <?php } ?>

                <div class="container-xl my-4">
                    <div class="row align-items-center">
                        <div class="col-lg-10">
                            <h1 class="h3 mb-2 text-gray-800">Demandas Relacionadas</h1>
                        </div>
                        <?php
                            error_reporting(E_ALL & ~E_NOTICE);           
                            $msg = $_GET["msg"];
                            if($msg === "success"){
                        ?>
                        <div class="col-12">
                            <div class='card mb-4 py-0 border-left-success'>
                                <div class='card-body p-2 text-success'>
                                    Alteração realizada com sucesso!
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <?php
                            error_reporting(E_ALL & ~E_NOTICE);           
                            $msg = $_GET["msg"];
                            if($msg === "error"){
                        ?>
                        <div class="col-12">
                            <div class='card mb-4 py-0 border-left-danger'>
                                <div class='card-body p-2 text-danger'>
                                    Ops! Não foi possível deletar essa demanda pois possui categorias relacionadas, desmarque as categorias dessa demanda para poder excluir.
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Lista de Demandas</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Empresa</th>
                                            <th>Fonte de Contato</th>
                                            <th>Contato</th>
                                            <th>Fone</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Empresa</th>
                                            <th>Fonte de Contato</th>
                                            <th>Contato</th>
                                            <th>Fone</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                            if($result_demands->num_rows > 0){
                                                while($row2 = $result_demands->fetch_assoc()){                                        
                                                echo "
                                                    <tr>
                                                        <td><a href='$permalink/actions/demands/view.php?id=$row2[uid]&region=$row[name_region]'>#$row2[uid]</a></td>
                                                        <td>$row2[name_company]</td>
                                                        <td>$row2[source_company]</td>
                                                        <td>$row2[contact_company]</td>
                                                        <td>$row2[phone_company]</td>
                                                    </tr>
                                                ";
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

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

</body>

</html>