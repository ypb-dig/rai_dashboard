<?php 
    include_once 'config.php';

    if(isset($_POST['user']) || isset($_POST['pass'])){
        $user = $conn->real_escape_string($_POST['user']);
        $passw = $conn->real_escape_string($_POST['pass']);
        $passw = md5($passw);

        $sql = "SELECT * FROM users WHERE user = '$user' AND pass = '$passw'";
        $query = $conn->query($sql) or die("falha na execução :" . $conn->error);

        $qtd = $query->num_rows; 

        if($qtd == 1){

            $user = $query->fetch_assoc();

            if(!isset($_SESSION)){
                session_start();
            }

            $_SESSION['id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['surname'] = $user['surname'];

            header("Location: dashboard.php");

        }else{
            $_SESSION['msg'] = "<div class='card mb-4 py-0 border-left-danger'>
                                    <div class='card-body p-2 text-danger'>
                                        Usuário ou senha inválidos
                                    </div>
                                </div>";
        }

    }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>RAI - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-login">

    <div class="container">

        <!-- Outer Row -->
        <div class="row login justify-content-center align-items-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image py-5">
                                <img src="img/logo_RAI.png" alt="" class="img-fluid">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Bem vindo de volta!</h1>
                                    </div>
                                    <?php
                                        if(isset($_SESSION['msg'])){
                                            echo $_SESSION['msg'];
                                            unset($_SESSION['msg']);
                                        } 
                                    ?>
                                    <form class="user" method="POST" action="">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Email" name="user" value="<?php if(isset($_POST['user'])){ echo $_POST['user'];} ?>">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Senha" name="pass">
                                        </div>
                                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Acessar" name="sendLogin">
                                        <hr>
                                    </form>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Esqueceu a senha?</a>
                                    </div>
                                    <!--
                                    <div class="text-center">
                                        <a class="small" href="register.html">Create an Account!</a>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>