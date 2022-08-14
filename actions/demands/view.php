<?php
    include '../../config.php';
    include '../../protect.php';
    include '../../inc/head.php';

    $id = "";
    $idregions = "";
    $name_company = "";
    $source_company = "";
    $contact_company = "";
    $phone_company = "";
    $features_company = "";
    $name_country = "";
    $name_region = "";

    $main_img = "";
    $name_listing = "";
    $sign_listing = "";
    $price_listing = "";
    $address_listing = "";
    $description_listing = "";
    $name_country = "";

    if ($_SERVER['REQUEST_METHOD'] == 'GET'){

        $id = $_GET["id"];

        $sql = "SELECT * FROM demands d
                JOIN regions r
                ON d.idregions = r.id
                WHERE d.id=$id";

        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $name_company = $row["name_company"];
        $source_company = $row["source_company"];
        $contact_company = $row["contact_company"];
        $phone_company = $row["phone_company"];
        $features_company = $row["features_company"];
        $name_region = $row["name_region"];
        $name_country = $row["name_country"];
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET'){

        $idregion = $_GET["idregions"];

        $sql2 = "SELECT * FROM listings l
                JOIN regions r
                ON l.idregion = r.id
                WHERE l.idregion=$idregion";

        $result_listing = $conn->query($sql2);
        $row2 = $result_listing->fetch_assoc();

        $main_img = $row2["main_img"];
        $name_listing = $row2["name_listing"];
        $sign_listing = $row2["sign_listing"];
        $price_listing = $row2["price_listing"];
        $address_listing = $row2["address_listing"];
        $description_listing = $row2["name_region"];
        $name_country = $row2["name_country"];
        
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
                                <div class="card-header">Detalhes do <?php echo $name_company; ?></div>
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
                                        <div class="row gx-3 mb-3">
                                            <div class="col-md-6 mb-3">
                                                <label class="small mb-1" for="inputFirstName">Empresa</label>
                                                <input class="form-control" disabled name="name_company" type="text" value="<?php echo $name_company; ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="small mb-1" for="inputFirstName">Fonte de Contato</label>
                                                <input class="form-control" disabled name="source_company" type="text" value="<?php echo $source_company; ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="small mb-1" for="inputFirstName">Contato</label>
                                                <input class="form-control" disabled name="contact_company" type="text" value="<?php echo $contact_company; ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="small mb-1" for="inputFirstName">Fone</label>
                                                <input class="form-control" disabled name="phone_company" type="text" value="<?php echo $phone_company; ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class='select'>
                                                    <label class="small mb-1" for="inputFirstName">Região</label>
                                                    <select name="idregions" id='select' class='form-control' disabled>
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
                                                    <select name="idcountry" id='select' class='form-control' disabled>
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
                                                <textarea class="form-control" name="features_company" rows="5" value="<?php echo $features_company; ?>" disabled><?php echo $features_company; ?></textarea>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 px-0">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-success">Produtos Relacionados</h6>
                                <div class="dropdown no-arrow">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Imagem</th>
                                                <th>Nome</th>
                                                <th>Preço</th>
                                                <th>Região</th>
                                                <th>País</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Imagem</th>
                                                <th>Nome</th>
                                                <th>Preço</th>
                                                <th>Região</th>
                                                <th>País</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php 
                                                while($row2 = $result_listing->fetch_assoc()){   
                                                    
                                                    $price_real = $row2['price_listing'];
                                                    $price_format = number_format($price_real, 2,',','.');
                                                    
                                                    echo "
                                                        <tr>
                                                            <td>#$row2[uid]</td>
                                                            <td><img src='$permalink/uploads/$row2[main_img]' width='100px'></td>
                                                            <td>$row2[name_listing]</td>
                                                            <td>$row2[sign_listing] $price_format</td>
                                                            <td>$row2[name_region]</td>
                                                            <td>$row2[name_country]</td>
                                                        </tr>
                                                    ";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
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

</body>

</html>     