<!-- 
    Código basado en JOSPROX MX | JOSPROX Internacional, con la unión de Facilito FX, Paoo CSS, Zara CSS y código de proyecto libre basado en JS.

    para más información de uso y propiedades favor de leer en el siguiente link oficial: https://josprox.com/politicas debido a la creación de este código, el cuál es independiente de la materia, creado con la tecnología de Facitio FX con la licencia de 2015 - 2022, para más información de licencia visite: https://github.com/josprox

     Por la presente se otorga con cargo, a cualquier persona que obtenga una copia de este software y los archivos de documentación asociados (el "Software"), para operar con el Software con restricciones, incluidos, entre otros, los derechos de uso, copia, modificación, fusión , publicar, distribuir, sublicenciar y / o vender copias del Software, y permitir que las personas a las que se les proporcione el Software lo hagan, sujeto a las siguientes condiciones:

    El aviso de copyright anterior y este aviso de permiso se incluirán en todas las copias o partes sustanciales del Software.

    EL SOFTWARE SE PROPORCIONA "TAL CUAL", SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O IMPLÍCITA, INCLUYENDO, PERO NO LIMITADO A, LAS GARANTÍAS DE COMERCIABILIDAD, APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER RECLAMO, DAÑOS U OTRA RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO, AGRAVIO O DE OTRO MODO, QUE SURJA DE, FUERA DE O EN RELACIÓN CON EL SOFTWARE O EL USO U OTRAS NEGOCIACIONES EN EL SOFTWARE. 
 -->

<?php

include "ps-conexion/conexion.php";
session_start();
if (!isset($_SESSION['id_usuario'])) {
	header("Location: ./");
}
$iduser = $_SESSION['id_usuario'];

$sql = "SELECT usuarios.nombre, usuarios.img, usuarios.num_control, usuarios.discapacidad, gradgrup.grado,gradgrup.grupo, especialidades.especialidad, turnos.turno FROM usuarios
INNER JOIN arg_alumno ON usuarios.id = arg_alumno.id_alm INNER JOIN gradgrup
ON arg_alumno.id_gg = gradgrup.id INNER JOIN especialidades
ON especialidades.id = arg_alumno.id_esp INNER JOIN turnos
ON arg_alumno.id_turn = turnos.id WHERE usuarios.id = '$iduser'";

$resultado = $conexion->query($sql);
$row = $resultado->fetch_assoc();

$sqlnumcontrols = "SELECT usuarios.id,usuarios.num_control, numcontrols.num, numcontrols.curp, arg_alumno.id_sexo FROM usuarios INNER JOIN numcontrols ON numcontrols.num = usuarios.num_control INNER JOIN arg_alumno ON arg_alumno.id_alm = usuarios.id WHERE usuarios.id = '$iduser'";
$restsqlnumcontrols = $conexion->query($sqlnumcontrols);
$control = $restsqlnumcontrols -> fetch_assoc();

$sexo = $control['id_sexo'];

$sql_arg_alumno = "SELECT sexo.sexo FROM sexo INNER JOIN arg_alumno ON sexo.id = arg_alumno.id_sexo WHERE arg_alumno.id_alm = '$iduser'";

$rest_arg_alumno = $conexion->query($sql_arg_alumno);
$arg_alumno = $rest_arg_alumno -> fetch_assoc();

if (isset($_POST["btn_enviar"])) {

    include_once "ps-includes/check_img.php";

}

?>

<!DOCTYPE html>
<html lang="es-MX">
    <head>
        <?php include "ps-includes/metas.php"; include "ps-plugins/adsense/ads.php"; ?>
        <title>Cetis CWP | Perfil</title>
        <link rel="stylesheet" href="ps-contenido/css/paps.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    </head>
    <body>
        <?php include "ps-includes/nav.php"; ?>

        <div class="contenedor">
            <main class="perfil">
                <div class="prf-img">
                    <img src="ps-contenido/img/alumnos/<?php echo $row['img'];?>" alt="" />
                </div>

                <div class="prf-edt">
                    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data" name="form1">
                        <table>
                            <input type="hidden" name="MAX_TAM" value="2097152" />
                            <tr>
                                <td  align="center">Cambiar imagen de perfil</td>
                            </tr>
                            <tr>
                                <td  align="center">Seleccione una imagen con tamaño inferior a 2 MB</td>
                            </tr>
                            <tr>
                                <td colspan="2" align="left">
                                    <div id="div_file">
                                        <p id="txtimg" >Insertar imagen</p>
                                        <input type="file" name="imagen" id="imagen" />
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2" align="center">
                                    <input type="submit" name="btn_enviar" id="btn_enviar" value="Enviar" />
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>

                <div class="prf-datos">
                <h1>Datos en el sistema</h1>
                        <p>Nombre registrado: <span><?php echo $row['nombre'];?></span></p>
                        <p>Tu número de control es: <span><?php echo $row['num_control'];?></span></p>
                        <p>Semestre: <span><?php echo $row['grado'];?></span> Grupo: <span><?php echo $row['grupo'];?></span> Especialidad: <span><?php echo $row['especialidad'];?></span></p>
                        <p>Turno: <span><?php echo $row['turno'];?></span></p>
                        <p>Discapacidad: <span><?php echo $row['discapacidad'];?></span></p>
                        <p>Curp: <span><?php echo $control['curp'];?></span></p>
                        <p>Género: <span><?php echo $arg_alumno['sexo'];?></span></p>
                </div>
            </main>
        </div>

        <script src="ps-contenido/js/slider.js"></script>
	<script src="./service.js"></script>

    </body>
</html>
<?php mysqli_close($conexion); ?>