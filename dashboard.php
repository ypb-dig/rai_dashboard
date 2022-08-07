<?php 
    include_once 'config.php';
    include 'protect.php';
    include 'inc/head.php';

    $listings = "SELECT * FROM listings l
                 JOIN regions r 
                 ON l.idregion = r.id";
    $result_products = $conn->query($listings);

    $demands = "SELECT * FROM demands";
    $result_demands = $conn->query($demands);

    $listings = "SELECT * FROM regions WHERE name_country = 'Brasil'";
    $result_regions = $conn->query($listings);

    $country_eua = "SELECT * FROM regions WHERE name_country = 'Estados Unidos'";
    $result_regions_eua = $conn->query($country_eua);

    $country_por = "SELECT * FROM regions WHERE name_country = 'Portugal'";
    $result_regions_por = $conn->query($country_por);
    
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

                    <div class="row products justify-content-center">
                        <div class="col-md-8 offsset-md-2 text-center my-3">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    <form action="dashboard.php" method="POST">
                                        <input type="hidden" id="textInput" value="">
                                        <div class="row gx-3 mb-3 py-4 shadow">
                                            <div class="col-12 py-2">
                                                <h5>Filtro de pesquisa de produtos:</h5>
                                            </div>
                                            <div class="col-md-4 text-left">
                                                <label class="small mb-1" for="inputFirstName">Nome do País</label>
                                                <div class='select'>
                                                    <select name="name_country" id='select' class='form-control country'>
                                                        <option value="">Selecione um País</option>  
                                                        <option value="Brasil">Brasil</option>
                                                        <option value="Estados Unidos">Estados Unidos</option>
                                                        <option value="Portugal">Portugal</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-2 region_bra text-left">
                                                <div class='select'>
                                                    <label class="small mb-1" for="inputFirstName">Região</label>
                                                    <select name="idregion" id='select' class='form-control'>
                                                        <option value="" selected>Selecione uma região</option>
                                                        <?php 
                                                        if($result_regions->num_rows > 0){
                                                            while($row = $result_regions->fetch_assoc()){
                                                                echo "<option value='".$row['id']."'>".$row['name_region']."</option>";
                                                                }
                                                            }else{
                                                                echo "0 Resultados";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4 region_eua text-left">
                                                <div class='select'>
                                                    <label class="small mb-1" for="inputFirstName">Região</label>
                                                    <select name="idregion" id='select' class='form-control'>
                                                        <option value="" selected>Selecione uma região</option>
                                                        <?php 
                                                        if($result_regions_eua->num_rows > 0){
                                                            while($row = $result_regions_eua->fetch_assoc()){
                                                                echo "<option value='".$row['id']."'>".$row['name_region']."</option>";
                                                                }
                                                            }else{
                                                                echo "0 Resultados";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4 region_por text-left">
                                                <div class='select'>
                                                    <label class="small mb-1" for="inputFirstName">Região</label>
                                                    <select name="idregion" id='select' class='form-control'>
                                                        <option value="" selected>Selecione uma região</option>
                                                        <?php 
                                                        if($result_regions_por->num_rows > 0){
                                                            while($row = $result_regions_por->fetch_assoc()){
                                                                echo "<option value='".$row['id']."'>".$row['name_region']."</option>";
                                                                }
                                                            }else{
                                                                echo "0 Resultados";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 text-left">
                                            <label class="small mb-1" for="inputFirstName">Valor</label><br>
                                            <output id="amount" name="amount" for="rangeInput">5</output> Milhões<br>
                                            <input type="range" name="rangeInput" oninput="amount.value=rangeInput.value" onchange="updateTextInput(this.value);" class="w-100" data-a-sign="" data-a-sep="." data-a-dec="," value="5" step="5" min="5" max="50">
                                            
                                            </div>
                                            <div class="col-md-12 mt-4">
                                                <button type="submit" class="btn btn-primary w-100" type="button">Busca Avançada</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab"></div>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
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

    <script>
        $('.select').jselect_search({
            placeholder :'Procurar'
        });
        function updateTextInput(val) {
          document.getElementById('textInput').value=val;
        }
    </script>

<script>
    $(document).ready(function(){
        if($(".country").val() == ''){
            $(".region_bra").css('display', 'block');
            $(".region_eua").css('display', 'none');
            $(".region_por").css('display', 'none');
        }
        $(".country").change(function() {
            if($(this).val() == 'Brasil'){
                $(".region_bra").css('display', 'block');
                $(".region_eua").css('display', 'none');
                $(".region_por").css('display', 'none');
            }
            if($(this).val() == 'Estados Unidos'){
                $(".region_eua").css('display', 'block');
                $(".region_bra").css('display', 'none');
                $(".region_por").css('display', 'none');
            }
            if($(this).val() == 'Portugal'){
                $(".region_eua").css('display', 'none');
                $(".region_bra").css('display', 'none');
                $(".region_por").css('display', 'block');
            }
        });
    });
  </script>

</body>

</html>