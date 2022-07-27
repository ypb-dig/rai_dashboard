<?php
    include '../../config.php';
    include '../../protect.php';
    include '../../inc/head.php';

    $name_region = "";
    $errorMessage = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name_region = $_POST["name_region"];

        do{
            if( empty($name_region) ){
                $errorMessage = "Todos os campos são obrigatórios";
                break;
            }
            
            $insert = "INSERT INTO regions (name_region)" . "VALUES ('$name_region')";
            $result_insert = $conn->query($insert);

            if(!$result_insert){
                $errorMessage = "Erro ao cadastrar" . $conn->error;
                break;
            }

            $name_region = "";

            header("Location: ../../regions.php?msg=success");
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
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header">Detalhes da Região</div>
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
                                            <div class="col-md-12">
                                                <label class="small mb-1" for="inputFirstName">Nome da Região</label>
                                                <input class="form-control" name="name_region" type="text" value="<?php echo $name_region; ?>">
                                            </div>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary" type="button">Cadastrar Região</button>
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