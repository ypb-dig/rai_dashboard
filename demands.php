<?php 
    include_once 'config.php';
    include 'protect.php';
    include 'inc/head.php';

    $listings = "SELECT * FROM cadastro_listing_categories c
    JOIN categories cat
    JOIN demands d
    JOIN regions r
    ON c.idcategories = cat.id AND d.id = c.iddemands AND d.idregions = r.id
    GROUP BY c.iddemands";
    
    $result = $conn->query($listings);

    if(!$result){
        die("Invalid Query" . $conn->error);
    }

?>

<body id="page-top">
    <div id="wrapper">

        <?php include 'inc/sidebar.php' ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <?php include 'inc/topnavbar.php' ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-lg-10">
                            <h1 class="h3 mb-2 text-gray-800">Demandas</h1>
                            <p class="mb-4">Veja abaixo a lista de demandas cadastrados na plataforma:</p>
                        </div>
                        <div class="col-lg-2 d-flex justify-content-end">
                            <a href="actions/demands/create.php" class="mx-1 d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                                <i class="fas fa-plus fa-sm text-white-50"></i> Criar Demanda
                            </a>
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
                                    Ops! Não foi possível deletar essa demanda.
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
                                            <th>Fundo</th>
                                            <th>Tipo de Investimento</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Empresa</th>
                                            <th>Fundo</th>
                                            <th>Tipo de Investimento</th>
                                            <th>Ação</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php 
                                            while($row = $result->fetch_assoc()){                                        
                                                echo "
                                                    <tr>
                                                        <td>#$row[uid]</td>
                                                        <td>$row[name_company]</td>
                                                        <td>$row[fundname_company]</td>
                                                        <td>$row[investment_company]</td>
                                                        <td>
                                                            <a class='btn btn-dark' href='actions/demands/view.php?id=$row[uid]&region=$row[name_region]&cat=$row[name]'>
                                                                <i class='fas fa-eye'></i>
                                                            </a>
                                                            <a class='btn btn-info' href='actions/demands/edit.php?id=$row[uid]&region=$row[name_region]'>
                                                                <i class='fas fa-edit'></i>
                                                            </a>
                                                            <a href='actions/demands/delete.php?id=$row[uid]' class='btn btn-danger'>
                                                                <i class='fas fa-trash'></i>
                                                            </a>
                                                        </td>
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
                <!-- /.container-fluid -->
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

</body>

</html>