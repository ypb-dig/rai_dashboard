<?php
    include '../../config.php';
    include '../../protect.php';
    include '../../inc/head.php';

    $name= "";
    $surname = "";
    $user = "";
    $pass = "";
    $access = "";
    $errorMessage = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $user = $_POST["user"];
        $pass = $_POST["pass"];
        $access = $_POST["access"];

        do{
            if( empty($name) || empty($surname) || empty($user) || empty($pass) || empty($access) ){
                $errorMessage = "Todos os campos são obrigatórios";
                break;
            }
            
            $insert = "INSERT INTO users (user, name, surname, pass, access)" . "VALUES ('$user', '$name', '$surname', md5('$pass'), '$access')";
            $result_insert = $conn->query($insert);

            if(!$result_insert){
                $errorMessage = "Erro ao cadastrar" . $conn->error;
                break;
            }

            $name = "";
            $surname = "";
            $user = "";
            $pass = "";
            $access = "";

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
                                    <button class="btn btn-primary" type="button">Upload new image</button>
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
                                                <label class="small mb-1" for="inputEmailAddress">Senha</label>
                                                <input class="form-control" name="pass" type="password" value="<?php echo $pass; ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="small mb-1">Nível de Acesso:</label>
                                            <select class="form-select form-control" aria-label="Default select example" name="access">
                                                <option value="">Selecione um nível</option>
                                                <option value="superadmin">Super Admin</option>
                                                <option value="admin">Admin</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary" type="button">Cadastrar Usuário</button>
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