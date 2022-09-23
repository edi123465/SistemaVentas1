<?php
require_once "recursos/Conexion.php";
require_once "recursos/FuncionesPersona.php";
require "recursos/FuncionesPerfil.php";

session_start(); //trabajo con varibles de tipo sesion
//permite invocar datos cuando yo desee
if(isset($_SESSION['cedula'])){
    header("Location:menu.php");
}else{
    
}


if(!empty($_POST)){
    $usuario = $_REQUEST['usuario'];
    $password = $_REQUEST['password'];
    $error = '';
    $md5_pass = md5($password); //encripta password
    
    $resultado = consultarUsuario($con, $usuario, $md5_pass);
    $numUsuarios = $resultado->num_rows; //contando cuantos usuarios estan en la base con esa info
    if($numUsuarios > 0){
        $fila = mysqli_fetch_assoc($resultado);
        //crear variables de tipo sesion
                //nombre que doy     //nombre delcampo en BBD
        $_SESSION['idUsuario'] = $fila['cedula'];
        $_SESSION['usuario'] = $fila['usuario'];
        $_SESSION['nombreUser'] = $fila['nombres'];
        $_SESSION['apellidoUser'] = $fila['apellidos'];
        $_SESSION['idPerfil'] = $fila['id_perfil_p']; //obligatorio
        
        //traer nombre perfil desde usuario
        $nombreRol = consultarPerfil($con,$_SESSION['idPerfil']);
        if($rol = mysqli_fetch_assoc($nombreRol)){
            $_SESSION['nombreRol'] = $rol['nombre_perfil'];
        }
        header("Location:menu.php"); 
    }else{
        $error = "<br><b>**Usuario o contraseña incorrecto**";
    }
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link  href='https://fonts.googleapis.com/css?family=Abel|Abril+Fatface|Alegreya|Arima+Madurai|Dancing+Script|Dosis|Merriweather|Oleo+Script|Overlock|PT+Serif|Pacifico|Playball|Playfair+Display|Share|Unica+One|Vibur') rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <script>
           
            
            
            function mostrarContrasena(){
      var tipo = document.getElementById("pwd");
      if(tipo.type == "password"){
          tipo.type = "text";
      }else{
          tipo.type = "password";
      }
  }
        </script> 
        <title>Login</title>
    </head>
    <body>
        <h1>probando cambio</h1>
        <div class="overlay">
            <form method="POST">
                <div class="con">
                    <header class="head-form">
                        <h2>Log In</h2>
                        <p>Introduzca su usuario y clave para ingresar</p>
                    </header>
                    <br>
                    <div class="field-set">

                        <span class="input-item">
                            <i class="fa fa-user-circle"></i>
                        </span>
                        <input class="form-input" id="txt-input" type="text" name="usuario" placeholder="NombreUsuario" >
                        <br>
                        <span class="input-item">
                            <i class="fa fa-key"></i>
                        </span>
                        <input class="form-input" type="password" placeholder="clave" id="pwd"  name="password"  >

                        <span>
                            <i class="fa fa-eye" aria-hidden="true"  type="button" onclick="mostrarContrasena()" id="eye"></i>
                        </span>

                        <br>
                        <button type="submit" name="login" class="log-in"> Login </button>
                        <div style="font-size: 16px; color:red; "><?php echo isset($error) ? $error : '';?></div>
                        <p>¿No tiene acceso?</p>
                    </div>
                    <div class="other">
                        
                        <button name="crear" class="btn submits sign-up" >Crear cuenta 
                            <i class="fa fa-user-plus" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>

        </div>
    </form>
</div>

</html>

<?php
if(isset($_REQUEST['crear'])){
     header("Location:CrudPersona/crearCuenta.php");
}
?>
