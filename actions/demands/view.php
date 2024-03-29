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
                JOIN demands d
                ON d.idregions = r.id AND c.idcategories = cat.id 
                WHERE d.id = $id AND c.iddemands = d.id AND r.name_region = '$region' ";
        
        $categories = "SELECT DISTINCT name FROM cadastro_listing_categories c
                JOIN categories cat
                ON c.idcategories = cat.id
                WHERE iddemands = $id";

        
        $sql2 = "SELECT DISTINCT c.idcategories, c.idlistings, l.uid, l.main_img, l.name_listing,l.sign_listing, l.price_listing, cat.id, cat.name,r.name_region, r.name_country FROM cadastro_listing_categories c
            JOIN categories cat
            JOIN listings l
            JOIN regions r
            ON c.idcategories = cat.id AND l.id = c.idlistings AND l.idregion = r.id
            WHERE cat.name = '$cat' AND c.idlistings IS NOT NULL";  

        $result = $conn->query($sql);
        $result1 = $conn->query($sql);
        $result_category = $conn->query($categories);
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
                                <div class="card-header">
                                <div class="d-flex">
                                        <div class="mr-auto">
                                            #<?php echo $id; ?> - <?php echo $row["name_company"]; ?>
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
                                    <form method="POST">
                                        <div class="row gx-3 mb-3">
                                            <div class="col-md-6 mb-3">
                                                <label class="small mb-1" for="inputFirstName">Empresa</label>
                                                <input class="form-control" disabled name="name_company" type="text" value="<?php echo $row["name_company"]; ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="small mb-1" for="inputFirstName">Nome do Fundo</label>
                                                <input class="form-control" disabled name="fundname_company" type="text" value="<?php echo $row["fundname_company"]; ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="small mb-1" for="inputFirstName">Nome do Gestor</label>
                                                <input class="form-control" disabled name="contact_company" type="text" value="<?php echo $row["contact_company"]; ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class='select'>
                                                    <label class="small mb-1" for="inputFirstName">Email:</label>
                                                    <input class="form-control" disabled name="email_company" type="text" value="<?php echo $row["email_company"]; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class='select'>
                                                    <label class="small mb-1" for="inputFirstName">Tipo de Renda</label>
                                                    <input class="form-control" disabled name="income_company" type="text" value="<?php echo $row["income_company"]; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class='select'>
                                                    <label class="small mb-1" for="inputFirstName">Tipo do Investimento</label>
                                                    <input class="form-control" disabled name="investment_company" type="text" value="<?php echo $row["investment_company"]; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="small mb-1" for="inputFirstName">Fonte de Contato</label>
                                                <input class="form-control" disabled name="source_company" type="text" value="<?php echo $row["source_company"]; ?>">
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
                                                <label class="small mb-1" for="exampleFormControlTextarea1">Tipo do Lastro: </label>
                                                <?php 
                                                    if($result_category->num_rows > 0){
                                                        while($row2 = $result_category->fetch_assoc()){  
                                                            echo "<span class='btn btn-info my-1' style='font-size:12px;cursor: auto;'>$row2[name]</span> ";
                                                        }
                                                    }
                                                ?>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <label class="small mb-1" for="exampleFormControlTextarea1">Objetivo do Fundo</label>
                                                <textarea class="form-control" name="features_company" rows="5" value="<?php echo $features_company; ?>" disabled><?php echo $row["features_company"]; ?></textarea>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <label class="small mb-1" for="exampleFormControlTextarea1">Política de Investimento</label>
                                                <textarea class="form-control" name="features_company" rows="5" value="<?php echo $features_company; ?>" disabled><?php echo $row["policy_company"]; ?></textarea>
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
                    <div class="row">
                        <div class="col-12 mt-4">
                            <h1 class="h3 mb-2 text-gray-800">Produtos Relacionados</h1>
                        </div>
                    </div>
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
                                                        <td><a href='$permalink/actions/products/view.php?id=$row2[uid]&region=$row2[name_region]&cat=$row[name]'>#$row2[uid]</a></td>
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