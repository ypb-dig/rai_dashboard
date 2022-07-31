<?php 
    include_once 'config.php';
    include 'protect.php';
    include 'inc/head.php';

    $listings = "SELECT listings.id, listings.main_img, listings.name_listing, listings.name_listing, listings.price_listing, regions.name_region, countries.name_country FROM `listings` JOIN countries ON countries.id = listings.idcountry JOIN regions ON regions.id = listings.idregions;";
    $result_products = $conn->query($listings);

    $demands = "SELECT * FROM demands";
    $result_demands = $conn->query($demands);
?>

<body id="page-top">
    <div id="wrapper">

        <?php include 'inc/sidebar.php' ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <?php include 'inc/topnavbar.php' ?>

                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center mb-4">
                        <div class="flex-grow-1">
                            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        </div>
                        <a href="<?php echo $permalink; ?>/actions/products/create.php" class="mx-1 d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                            <i class="fas fa-plus fa-sm text-white-50"></i> Criar Produtos
                        </a>
                        <a href="<?php echo $permalink; ?>/actions/demands/create.php" class="mx-1 d-none d-sm-inline-block btn btn-sm btn-info shadow-sm">
                            <i class="fas fa-plus fa-sm text-white-50"></i> Criar Demandas
                        </a>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2 mb-4">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item w-50" role="presentation">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                                    <div class="card border-left-success shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-lg font-weight-bold text-success text-uppercase mb-1">
                                                        Produtos
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                </li>
                                <li class="nav-item w-50" role="presentation">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                                        <div class="card border-left-info shadow h-100 py-2">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-lg font-weight-bold text-info text-uppercase mb-1">
                                                            Demandas
                                                        </div>
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col-auto"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>   

                    <div class="row products">
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab"></div>
                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab"></div>
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-success">Lista de Produtos</h6>
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
                                                        while($row = $result_products->fetch_assoc()){   
                                                            
                                                            $price_real = $row['price_listing'];
                                                            
                                                            echo "
                                                                <tr>
                                                                    <td>$row[id]</td>
                                                                    <td><img src='uploads/$row[main_img]' width='100px'></td>
                                                                    <td>$row[name_listing]</td>
                                                                    <td>R$ $price_real</td>
                                                                    <td>$row[name_region]</td>
                                                                    <td>$row[name_country]</td>
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

                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-info">Players</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body products">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable_demands" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Empresa</th>
                                                    <th>Fone</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Empresa</th>
                                                    <th>Fone</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php 
                                                    while($row2 = $result_demands->fetch_assoc()){                                        
                                                        echo "
                                                            <tr>
                                                                <td>$row2[id]</td>
                                                                <td>$row2[name_company]</td>
                                                                <td>$row2[phone_company]</td>
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
                </div>
            </div>

            <?php include 'inc/footer.php'; ?>

        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php include 'inc/logoutModal.php'; ?>
    <?php include 'inc/scripts.php'; ?>

    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="js/demo/datatables-demo.js"></script>

    <script>
        $(document).ready(function() {
            $('#dataTable_demands').DataTable();
        });
    </script>

</body>

</html>