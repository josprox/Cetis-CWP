<!-- 
    Código basado en JOSPROX MX | JOSPROX Internacional, con la unión de Facilito FX, Paoo CSS, Zara CSS y código de proyecto libre basado en JS.

    para más información de uso y propiedades favor de leer en el siguiente link oficial: https://josprox.com/politicas debido a la creación de este código, el cuál es independiente de la materia, creado con la tecnología de Facitio FX con la licencia de 2015 - 2022, para más información de licencia visite: https://github.com/josprox

     Por la presente se otorga con cargo, a cualquier persona que obtenga una copia de este software y los archivos de documentación asociados (el "Software"), para operar con el Software con restricciones, incluidos, entre otros, los derechos de uso, copia, modificación, fusión , publicar, distribuir, sublicenciar y / o vender copias del Software, y permitir que las personas a las que se les proporcione el Software lo hagan, sujeto a las siguientes condiciones:

    El aviso de copyright anterior y este aviso de permiso se incluirán en todas las copias o partes sustanciales del Software.

    EL SOFTWARE SE PROPORCIONA "TAL CUAL", SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O IMPLÍCITA, INCLUYENDO, PERO NO LIMITADO A, LAS GARANTÍAS DE COMERCIABILIDAD, APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER RECLAMO, DAÑOS U OTRA RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO, AGRAVIO O DE OTRO MODO, QUE SURJA DE, FUERA DE O EN RELACIÓN CON EL SOFTWARE O EL USO U OTRAS NEGOCIACIONES EN EL SOFTWARE. 
 -->

 <?php
 
 include "../../ps-conexion/conexion.php";
 session_start();
 if (!isset($_SESSION['id_usuario'])) {
     header("Location: ../");
 }
 $iduser = $_SESSION['id_usuario'];

$sql_bienvenido = "SELECT id FROM social WHERE id_usuario = '$iduser'";
$resultado_bienvenido = $conexion->query($sql_bienvenido);
$filas = $resultado_bienvenido -> num_rows;

if ($filas < 1) {
    header("Location: ./bienvenido");
}

$sql = "SELECT usuarios.usuario, usuarios.img, usuarios.nombre, usuarios.correo, usuarios.num_control, social.info_datos, social.fb, social.twt, social.inst FROM usuarios INNER JOIN social ON usuarios.id = social.id_usuario WHERE usuarios.id = '$iduser'";

$resultado = $conexion->query($sql);
$row = $resultado->fetch_assoc();

if (isset($_POST["info"])){
    $contenido = mysqli_real_escape_string($conexion,$_POST['contenido']);

    $sql = "UPDATE `social` SET `info_datos` = '$contenido' WHERE `social`.`id_usuario` = $iduser";
    $insertar_social = $conexion->query($sql);
    echo "<script>
			alert('Se ha guardado los datos correctamente');
			window.location= './perfil';
		</script>";
}

if (isset($_POST["redes"])) {
    $fb = mysqli_real_escape_string($conexion,$_POST['facebook']);
    $twt = mysqli_real_escape_string($conexion,$_POST['twt']);
    $insta = mysqli_real_escape_string($conexion,$_POST['insta']);

    $sql_redes = "UPDATE `social` SET `fb` = '$fb', `twt` = '$twt', `inst` = '$insta' WHERE `social`.`id_usuario` = $iduser";
    $insertar_redes = $conexion->query($sql_redes);
    echo "<script>
            alert('Se ha guardado los datos correctamente');
            window.location= './perfil';
        </script>";
}

if (isset($_POST["btn_enviar"])) {

    include_once "includes/check_img.php";
}

?>

<!DOCTYPE html>
<html lang="es-MX">
<head>

    <title>Cristal | Perfil</title>

    <?php include "includes/head.php"; ?>

    <link rel="stylesheet" href="./textarea/site.css">
    <link rel="stylesheet" href="./textarea/richtext.min.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="./textarea/jquery.richtext.js"></script>
</head>
<body>

<?php include "includes/navbar.php" ?>


    <div class="contenedor">

        <div class="grid_1_2">

            <div class="grid_1">
                <img src="../../ps-contenido/img/alumnos/<?php echo $row['img'];?>" alt="">
            </div>

            <div class="grid_2">
                <center>

                    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="MAX_TAM" value="2097152" />
                        <div id="div_file">
                            <p for="imagen" id="txtimg" >Insertar imagen</p>
                            <input type="file" name="imagen" id="imagen" />
                        </div>
                        <input type="submit" class="update" name="btn_enviar" id="btn_enviar" value="Subir" />
                    </form>

                </center>
            </div>

        </div>

        <div class="datos_registro">
            <h2 class="subtitulos">Información registrada</h2>
            <p>Usuario:</p>
            <p><?php echo $row['usuario'] ?></p>
            <p>Correo:</p>
            <p><?php echo $row['correo'] ?></p>
            <p>Número de control (No se mostrará):</p>
            <p><?php echo $row['num_control'] ?></p>
            <p>Nombre Completo:</p>
            <p><?php echo $row['nombre'] ?></p>
            <p>Información personal:</p>
            <p><?php echo $row['info_datos'] ?></p>
            <p>Tus redes sociales:</p>
            <p><i class="fa-brands fa-facebook"></i> Facebook: <a href="https://www.facebook.com/<?php echo $row['fb'] ?>">@<?php echo $row['fb'] ?></a></p>
            <p><i class="fa-brands fa-twitter"></i> Twitter: <a href="https://twitter.com/<?php echo $row['twt'] ?>">@<?php echo $row['twt'] ?></a></p>
            <p><i class="fa-brands fa-instagram"></i> Instagram: <a href="https://www.instagram.com/<?php echo $row['inst'] ?>">@<?php echo $row['inst'] ?></a></p>
        </div>

        <div class="formulario">

            <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="POST">
                <label for="contenido" class="form-label"><h3 class="antesubtitulos">Actualiza la sección "información personal".</h3></label>
                <textarea name="contenido" class="form-control textarea" id="contenido" rows="3" required></textarea>

                <center>
                <input value="Actualizar" name="info" type="submit" class="act_info_personal">
                </center>
            </form>

            <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="POST">
                <label for="contenido" class="form-label"><h3 class="antesubtitulos">Agrega tus redes sociales para que te puedan contactar.</h3></label>

                <div class="redes">
                    <label for="facebook" class="form_lb"><i class="fa-brands fa-facebook"></i> Facebook</label>
                    <label type="text" name="facebook" id="facebook_no_move" class="form_lb_disabled">facebook.com/</label>
                    <input type="text" name="facebook" id="facebook" class="form_inp" placeholder="https://www.facebook.com/" value="<?php echo $row['fb'] ?>">
                </div>

                <div class="redes">
                    <label for="twt" class="form_lb"><i class="fa-brands fa-twitter"></i> Twitter</label>
                    <label type="text" id="twt_no_move" class="form_lb_disabled">twitter.com/</label>
                    <input type="text" name="twt" id="twt" class="form_inp" placeholder="https://twitter.com/" value="<?php echo $row['twt'] ?>">
                </div>

                <div class="redes">
                    <label for="insta" class="form_lb"><i class="fa-brands fa-instagram"></i> Instagram</label>
                    <label type="text" id="insta_no_move" class="form_lb_disabled">instagram.com/</label>
                    <input type="text" name="insta" id="insta" class="form_inp" placeholder="https://www.instagram.com/" value="<?php echo $row['inst'] ?>">
                </div>

                <center>
                <input value="Actualizar" name="redes" type="submit" class="act_info_personal">
                </center>
            </form>

        </div>

    </div>

    <script>
        $(document).ready(function() {
            $('.textarea').richText();
        });
        </script>
    
</body>
</html>