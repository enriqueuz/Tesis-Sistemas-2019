<!DOCTYPE html>
<html>

<head>
    <title>Chequear pagos</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/jpg" href="img/logo.jpg">
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #AAA9AB">
              <a class="navbar-brand" href="../paginaP.php">Programa de Profesionalización Docente de la ULA</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="falsse" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                      <li class="nav-item"><a class="nav-link text-light" href="../registroEs.php">Registre un estudiante</a></li>
                       <li class="nav-item"><a class="nav-link text-light" href="../consultaEs.php">Consulte la información de un estudiante</a></li>
                       <li class="nav-item"><a class="nav-link text-light" href="../registroPa.php">Registre un pago</a></li>
                       <li class="nav-item"><a class="nav-link text-light" href="../consultaPa.php">Consulte un pago</a></li>
                </ul>
            <!--
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            -->
          </div>
        </nav>
    </header>

    <!-- Inicia formulario de chequeo de pagos-->

    <h1>Chequee los pagos de un estudiante</h1>
    <div class="container py-5">
        <br> 
        <form>
			<div class="form-group"  action="" method="POST" name="be" class="form-horizontal">
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm  form-check-inline">
                            <input type="number" placeholder="Ingrese la cédula del estudiante" name="cedula" class="form-control">
                        </div>


                        <div class="col-sm  form-check-inline">
                        	<input type="submit" class="btn btn-success" value="Buscar"></input>
                        </div>                  
                    </div>
                </div>
            </div>	 
        </form>
        <br>
        <form action="" method="POST" name="cp" class="form-horizontal"> 


            <h2>Marque los pagos que desee chequear</h2>
            <div class="row">
                <div class="col">
                    <label for="pago_inscripción" class="form-check-label">Inscripción</label>
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" style="width: 30px; height: 30px;" name="pago_inscripción"value="1">
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="pago_t1" class="form-check-label">Primer trimestre</label>
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" style="width: 30px; height: 30px;" name="pago_t1 value="1">
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="pago_t2" class="form-check-label">Segundo trimestre</label>
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" style="width: 30px; height: 30px;" name="pago_t2 value="1">
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="pago_t3" class="form-check-label">Tercer trimestre</label>
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" style="width: 30px; height: 30px;" name="pago_t3 value="1">
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="pago_t4" class="form-check-label">Cuarto trimestre</label>
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" style="width: 30px; height: 30px;" name="pago_t4 value="1">
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="pago_mg" class="form-check-label">Memoria de grado</label>
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" style="width: 30px; height: 30px;" name="pago_mg value="1">
                            </label>
                        </div>
                    </div>
                </div>


            </div>
            <br>

            <div class="form-group" align="center">
                <input type="submit" class="btn btn-primary" value="Registrar estudiante">
            </div>

        </form>

    </div>

</body>
</html>