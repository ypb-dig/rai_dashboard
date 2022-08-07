<?php
    include '../../config.php';
    include '../../protect.php';
    include '../../inc/head.php';

    $id = "";
    $name_region = "";
    $name_country = "";
    $errorMessage = "";

    if ($_SERVER['REQUEST_METHOD'] == 'GET'){

        if(!isset($_GET["id"]) ){
            header("Location: ../../regions.php");
            exit;
        }

        $id = $_GET["id"];

        $sql = "SELECT * FROM regions WHERE id = $id";

        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        if(!$row){
            header("Location: ../../regions.php");
            exit;
        }

        $name_region = $row["name_region"];
        $name_country = $row["name_country"];

    }else{

        $id = $_POST["id"];
        $name_region = $_POST["name_region"];
        $name_country = $_POST["name_country"];

        do{
            if( empty($id) || empty($name_region)){
                $errorMessage = "Todos os campos são obrigatórios";
                break;
            }

            $sql = "
                UPDATE regions SET name_region = '$name_region', name_country = '$name_country' WHERE regions.id = $id;
            "; 
            
            $result = $conn->query($sql);

            echo $sql;

            if(!$result){
                $errorMessage = "Erro ao cadastrar" . $conn->error;
                break;
            }
            
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
                        <div class="col-xl-12">
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
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <div class="row gx-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="inputFirstName">Estado</label>
                                                <input class="form-control" name="name_region" type="text" value="<?php echo $name_region; ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <div class='select'>
                                                    <label class="small mb-1" for="inputFirstName">País</label>
                                                    <select name="name_country" id='select' class='form-control'>
                                                        <option value="<?php echo $name_country; ?>"><?php echo $name_country; ?></option>  
                                                        <option value="Brasil">Brasil</option>
                                                        <option value="Estados Unidos">Estados Unidos</option>
                                                        <option value="Portugal">Portugal</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary" type="button">Alterar Região</button>
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