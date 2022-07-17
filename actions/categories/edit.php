<?php
    include '../../config.php';
    include '../../protect.php';
    include '../../inc/head.php';

    $id = "";
    $name = "";
    $errorMessage = "";

    if ($_SERVER['REQUEST_METHOD'] == 'GET'){

        if(!isset($_GET["id"]) ){
            header("Location: ../../categories.php");
            exit;
        }

        $id = $_GET["id"];

        $sql = "SELECT * FROM categories WHERE id=$id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        if(!$row){
            header("Location: ../../categories.php");
            exit;
        }

        $name = $row["name"];

    }else{

        $id = $_POST["id"];
        $name = $_POST["name"];

        do{
            if( empty($id) || empty($name)){
                $errorMessage = "Todos os campos são obrigatórios";
                break;
            }

            $sql = "UPDATE categories SET name = '$name' WHERE id = $id"; 
            
            $result = $conn->query($sql);

            echo $sql;

            if(!$result){
                $errorMessage = "Erro ao cadastrar" . $conn->error;
                break;
            }
            
            header("Location: ../../categories.php?msg=success");
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
                        <div class="col-xl-8">
                            <div class="card mb-4">
                                <div class="card-header">Detalhes da Categoria</div>
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
                                            <div class="col-md-12">
                                                <label class="small mb-1" for="inputFirstName">Nome</label>
                                                <input class="form-control" name="name" type="text" value="<?php echo $name; ?>">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary" type="button">Alterar Categoria</button>
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