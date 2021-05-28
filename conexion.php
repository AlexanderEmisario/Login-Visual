<?php 
	//Conexion con base de datos
	$host_db="localhost";   //Donde este la base de datos
	$user_db="root";   //Obligatorio, el usuario de phyadmin (root)
	$pass_db="";   //No tenemos clave
	$db_name="login";   //Nombre de la base de datos
	$tbl_name="loginvisual";   //usuarios repetidos

	//Conexion a la BASE DE DATOS
	$conexion = new mysqli ($host_db, $user_db, $pass_db, $db_name);
	if ($conexion->connect_error) {
		/*die: Imprime los mensajes*/
		die("La conexion fallo: ".$conexion->connect_error);
	}

	//Encriptar los datos de la clave
	$form_pass = $_POST['txtcontra'];
	$hash = password_hash($form_pass, PASSWORD_BCRYPT);

	//No permitir usuarios repetidos
	$buscarUsuarios = "SELECT * FROM $tbl_name WHERE usuario = '$_POST[txtusuario]'";
	/*query: Ejecuta la accion*/
	$result = $conexion->query($buscarUsuarios); //Hace la consulta

	$password = $_POST['txtcontra'];
	$confirmacion = $_POST['confirmar'];
	//Aqui busca usuarios repetidos
	$count = mysqli_num_rows($result);

	if($password != $confirmacion){
		echo "<br>"."Las contraseñas no coinciden ..."."<br>";
		echo "<a href='index.html'>Porfavor verifique las claves ...</a>";
	}else{
	if($count>=1){
		echo "<br>"."El nombre de usuario ya existe ..."."<br>";
		echo "<a href='index.html'>Porfavor escoja otro nombre ...</a>";
	}else{
		$query = "INSERT INTO loginvisual (nombre,apellido,correo,usuario,contraseña) Values('$_POST[txtnombre]','$_POST[txtapellido]','$_POST[txtcorreo]','$_POST[txtusuario]','$hash')";
	if ($conexion->query($query)==TRUE) {
	echo "<br>"."<h2>"."Usuario creado exitosamente :D"."</h2>"."<br>";
	echo "<h4>"."Bienvenido: ".$_POST['txtusuario']."</h4>" ."\n\n";
	echo "<h5>"."Nuevo Login: "."<a href='index.html'>Login</a>"."<h5>";
	}else{
		echo "Error al crear usuario ...".$query."<br>".$conexion->error;
	}
	}
}
	mysqli_close($conexion);
?>