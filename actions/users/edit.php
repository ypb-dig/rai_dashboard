<?php
    include '../../config.php';
    include '../../protect.php';
    include '../../inc/head.php';

    $id = "";
    $name = "";
    $surname = "";
    $user = "";
    $pass = "";
    $access = "";
    $errorMessage = "";

    if ($_SERVER['REQUEST_METHOD'] == 'GET'){

        if(!isset($_GET["id"]) ){
            header("Location: ../../users.php");
            exit;
        }

        $id = $_GET["id"];

        $sql = "SELECT * FROM users WHERE id=$id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        if(!$row){
            header("Location: ../../users.php");
            exit;
        }

        $name = $row["name"];
        $surname = $row["surname"];
        $user = $row["user"];
        $access = $row["access"];

    }else{

        $id = $_POST["id"];
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $user = $_POST["user"];
        $access = $_POST["access"];

        do{
            if( empty($id) || empty($name) || empty($surname) || empty($user) || empty($access) ){
                $errorMessage = "Todos os campos são obrigatórios";
                break;
            }



            $sql = "UPDATE users SET user = '$user', name = '$name', surname = '$surname', access = '$access' WHERE id = $id"; 
            
            $result = $conn->query($sql);

            echo $sql;

            if(!$result){
                $errorMessage = "Erro ao cadastrar" . $conn->error;
                break;
            }
            
            header("Location: ../../users.php?msg=success");
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
                        <div class="col-xl-4">
                            <!-- Profile picture card-->
                            <div class="card mb-4 mb-xl-0">
                                <div class="card-header">Foto</div>
                                <div class="card-body text-center">
                                    <!-- Profile picture image-->
                                    <img class="img-account-profile rounded-circle mb-2" src="assets/img/demo/user-placeholder.svg" alt="">
                                    <!-- Profile picture help block-->
                                    <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                                    <!-- Profile picture upload button-->
                                    <button class="btn btn-primary" type="button">Inserir imagem</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8">
                            <div class="card mb-4">
                                <div class="card-header">Detalhes do Usuário</div>
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
                                                <label class="small mb-1" for="inputFirstName">Nome</label>
                                                <input class="form-control" name="name" type="text" value="<?php echo $name; ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="inputLastName">Apelido</label>
                                                <input class="form-control" name="surname" type="text" value="<?php echo $surname; ?>">
                                            </div>
                                        </div>
                                        <div class="row gx-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                <input class="form-control" type="email" name="user" value="<?php echo $user; ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="small mb-1">Nível de Acesso:</label>
                                                <select class="form-select form-control" aria-label="Default select example" name="access">
                                                    <option value="<?php echo $access; ?>">Selecione um nível</option>
                                                    <option value="superadmin">Super Admin</option>
                                                    <option value="admin">Admin</option>
                                                </select>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary" type="button">Alterar Usuário</button>
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