<?php
    include '../../config.php';
    include '../../protect.php';
    include '../../inc/head.php';

    if ($_SERVER['REQUEST_METHOD'] == 'GET'){

        $id = $_GET["id"];
        $region = $_GET["region"];
        $cat = $_GET["cat"];

        $sql = "SELECT * FROM cadastro_listing_categories c
                JOIN categories cat 
                JOIN regions r 
                JOIN listings l
                ON l.idregion = r.id AND c.idcategories = cat.id
                WHERE l.id = $id AND c.idlistings = l.id AND r.name_region = '$region'";

        $categories = "SELECT DISTINCT name FROM cadastro_listing_categories c
                        JOIN categories cat
                        ON c.idcategories = cat.id
                        WHERE idlistings = $id";
        
        $sql2 = "SELECT DISTINCT c.idcategories, c.iddemands, d.uid, d.name_company, d.fundname_company,d.investment_company, cat.id, cat.name,r.name_region FROM cadastro_listing_categories c
        JOIN categories cat
        JOIN demands d
        JOIN regions r
        ON c.idcategories = cat.id AND d.id = c.iddemands AND d.idregions = r.id
        WHERE cat.name = '$cat' AND c.iddemands IS NOT NULL;";

        $result = $conn->query($sql);
        $result1 = $conn->query($sql);
        $result_category = $conn->query($categories);
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
                                <div class="card-header">
                                    <div class="d-flex">
                                        <div class="mr-auto">
                                            #<?php echo $id; ?> - <?php echo $row["name_listing"]; ?>
                                        </div>
                                        <?php 
                                            $path = $row["main_pdf"];
                                            if(strpos($path, '.pdf') !== false){
                                        ?>
                                        <div>
                                            <a href="<?php echo $permalink; ?>/uploads/pdf/<?php echo $row["main_pdf"]; ?>" target="_blank">
                                                <i class="far fa-file-pdf" style="font-size:22px;color:red"></i>
                                            </a>
                                        </div>
                                        <?php }else{ ?>
                                            <div class="d-none">
                                                <a href="<?php echo $permalink; ?>/uploads/pdf/<?php echo $row["main_pdf"]; ?>" target="_blank">
                                                    <i class="far fa-file-pdf" style="font-size:22px;color:red"></i>
                                                </a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
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
                                                if($result_category->num_rows > 0){
                                                    while($row1 = $result_category->fetch_assoc()){  
                                                        echo "<span class='btn btn-info my-1' style='font-size:12px;cursor: auto;'>$row1[name]</span> ";
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
                                            <th>Nome do Fundo</th>
                                            <th>Tipo de Investimento</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Empresa</th>
                                            <th>Nome do Fundo</th>
                                            <th>Tipo de Investimento</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                            if($result_demands->num_rows > 0){
                                                while($row2 = $result_demands->fetch_assoc()){     
                                                    if($row2['name'] == $cat){
                                                        echo "
                                                            <tr>
                                                                <td><a href='$permalink/actions/demands/view.php?id=$row2[uid]&region=$row2[name_region]&cat=$row2[name]'>#$row2[uid]</a></td>
                                                                <td>$row2[name_company]</td>
                                                                <td>$row2[fundname_company]</td>
                                                                <td>$row2[investment_company]</td>
                                                            </tr>
                                                        ";
                                                    }else{
                                                        echo "$row2[name] $row1[name]";
                                                    }                              
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

    <script src="../../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="../../js/demo/datatables-demo.js"></script>

</body>

</html>