<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Hospital | Reset</title>
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
</head>
<body>
<style>
    body {
        background: #5d6d7e!important;
    }
    li.list-group-item.bg-primary.text-white.text-center {
        font-size: 20;
        font-weight: 500;
    }
</style>
<div class="container">
    <div class="row mt-5">
        <div class="col-md-6 m-auto">
            
        <div class="card">
        <ul class="list-group list-group-flush">
            <li class="list-group-item bg-primary text-white text-center">Recuperar Contraseña</li>
            <div class="row">
                <div class="col-md-12 text-center">
                    <img src="<?=$_ENV["BASE_URL"]?>theme/img/hospital.png" width="80">
                </div>
            </div>
            <li class="list-group-item bg-white">
            <?= $reset; ?>
            </li>
            <li class="list-group-item bg-primary"><a href="<?=$_ENV["BASE_URL"]?>login/index" class="text-white">Acceder</a></li>
        </ul>
        </div>

        </div>
    </div>
</div>
<div id="pdocrud-ajax-loader">
    <img width="300" src="<?=$_ENV["BASE_URL"]?>app/libs/script/images/ajax-loader.gif" class="pdocrud-img-ajax-loader"/>
</div>
</body>
</html>