<?php
    include '../../config.php';
    include '../../protect.php';
    include '../../inc/head.php';

    $id = "";
    $main_img = "";
    $name_listing = "";
    $sign_listing = "";
    $price_listing = "";
    $address_listing = "";
    $description_listing = "";
    $idregion = "";
    $name_country = "";
    $name_region = "";

    if ($_SERVER['REQUEST_METHOD'] == 'GET'){

        $id = $_GET["id"];
    
        $sql = "SELECT * FROM listings l
                JOIN regions r
                ON l.idregion = r.id 
                WHERE l.id=$id";

        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $main_img = $row["main_img"];
        $name_listing = $row["name_listing"];
        $sign_listing = $row["sign_listing"];
        $price_listing = $row["price_listing"];
        $address_listing = $row["address_listing"];
        $description_listing = $row["description_listing"];
        $idregion = $row["idregion"];
        $name_region = $row["name_region"];
        $name_country = $row["name_country"];

        $price_real = $row['price_listing'];
        $price_format = number_format($price_real, 2,',','.');
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
                                <div class="card-header">#<?php echo $id; ?> - <?php echo $name_listing; ?></div>
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
                                                <img src="<?php echo $permalink; ?>/uploads/<?php echo $main_img; ?>" class="img-fluid"/>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="mb-2">
                                                    <label class="small mb-1" for="inputFirstName">Endereço do Imóvel</label>
                                                    <input class="form-control" disabled name="source_company" type="text" value="<?php echo $address_listing ?>">
                                                </div>
                                                <div class="my-2">
                                                    <label class="small mb-1" for="inputFirstName">Valor do Imóvel</label>
                                                    <input class="form-control" disabled name="source_company" type="text" value="<?php echo $sign_listing; ?> <?php echo $price_format; ?>">
                                                </div>
                                                <div class='select my-2'>
                                                    <label class="small mb-1" for="inputFirstName">Região</label>
                                                    <select name="idregion" id='select' class='form-control' disabled>
                                                        <option value="<?php echo $idregion; ?>" selected><?php echo $name_region; ?></option>
                                                    </select>
                                                </div>
                                                <div class='select my-2'>
                                                    <label class="small mb-1" for="inputFirstName">País</label>
                                                    <select name="idcountry" id='select' class='form-control' disabled>
                                                        <option value="<?php echo $idcountry; ?>" selected><?php echo $name_country; ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <label class="small mb-1" for="exampleFormControlTextarea1">Descrição</label>
                                                <textarea class="form-control" name="features_company" rows="5" value="<?php echo $features_company; ?>" disabled><?php echo $description_listing ?></textarea>
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

</body>

</html>