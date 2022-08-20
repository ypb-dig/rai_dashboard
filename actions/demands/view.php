<?php
    include '../../config.php';
    include '../../protect.php';
    include '../../inc/head.php';

    if ($_SERVER['REQUEST_METHOD'] == 'GET'){

        $id = $_GET["id"];
        $region = $_GET["region"];

        $sql = "SELECT * FROM cadastro_listing_categories c
                JOIN categories cat 
                JOIN regions r 
                JOIN demands d
                ON c.idcategories = cat.id AND c.iddemands = d.id
                WHERE r.name_region = '$region' AND d.uid = $id ";

        $sql2 = "SELECT * FROM listings l
                JOIN regions r
                ON l.idregion = r.id
                WHERE r.name_region='$region'";

        $result = $conn->query($sql);
        $result1 = $conn->query($sql);
        $result_products = $conn->query($sql2);
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
                ?>
                <div class="container-xl px-4 mt-4">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-header">Empresa <?php echo $row["name_company"]; ?></div>
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
                                                <input class="form-control" disabled name="name_company" type="text" value="<?php echo $row["name_company"]; ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="small mb-1" for="inputFirstName">Fonte de Contato</label>
                                                <input class="form-control" disabled name="source_company" type="text" value="<?php echo $row["source_company"]; ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="small mb-1" for="inputFirstName">Contato</label>
                                                <input class="form-control" disabled name="contact_company" type="text" value="<?php echo $row["contact_company"]; ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="small mb-1" for="inputFirstName">Fone</label>
                                                <input class="form-control" disabled name="phone_company" type="text" value="<?php echo $row["phone_company"]; ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class='select'>
                                                    <label class="small mb-1" for="inputFirstName">Região</label>
                                                    <select name="idregions" id='select' class='form-control' disabled>
                                                        <option value="<?php echo $idregions; ?>" selected><?php echo $row["name_region"]; ?></option>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class='select'>
                                                    <label class="small mb-1" for="inputFirstName">País</label>
                                                    <select name="idcountry" id='select' class='form-control' disabled>
                                                        <option value="<?php echo $idcountry; ?>" selected><?php echo $row["name_country"]; ?></option>                                             
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
                                                <textarea class="form-control" name="features_company" rows="5" value="<?php echo $features_company; ?>" disabled><?php echo $row["features_company"]; ?></textarea>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
                <?php } ?>

                <div class="container-xl">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Lista de Produtos</h6>
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
                                            if($result_products->num_rows > 0){
                                                while($row2 = $result_products->fetch_assoc()){ 
                                                
                                                $price_real = $row2['price_listing'];
                                                $price_format = number_format($price_real, 2,',','.');
                                                
                                                echo "
                                                    <tr>
                                                        <td><a href='$permalink/actions/products/view.php?id=$row2[uid]&region=$row[name_region]'>#$row2[uid]</a></td>
                                                        <td><img src='$permalink/uploads/$row2[main_img]' width='100px'></td>
                                                        <td>$row2[name_listing]</td>
                                                        <td>$row2[sign_listing] $price_format</td>
                                                        <td>$row2[name_region]</td>
                                                        <td>$row2[name_country]</td>
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