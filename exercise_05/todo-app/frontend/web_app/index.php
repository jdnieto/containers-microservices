<?php 
    // Cargamos las variables necesarias
	$apiKey = getenv('API_KEY');
        $backend = getenv('BACKEND_HOST');
	include_once './functions.php';
    

    // inicializamos la variable de gestión de avisos 
	$avisos = "";

	// Agregamos la tarea cuando se pulsa el botón
	if (isset($_POST['agregar'])) {
		if (empty($_POST['tarea'])) {
			$avisos = "No puedes crear una tarea sin tarea ;-)";
		}else{
			$avisos = llamar_api("agregar",$_POST['tarea']);
		}
	}
	if (isset($_POST['limpiar'])) {
		$avisos = llamar_api("limpiar","","");
	}	
	if (isset($_GET['borrar_tarea'])) {
	$id = $_GET['borrar_tarea'];
		$avisos = llamar_api("borrar", "", $id);
	}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Aplicación de Lista de Tareas</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet"> 
	<link rel="stylesheet" type="text/css" href="./css/estilos.css">
	<script>    
	    if(typeof window.history.pushState == 'function') {
	        window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF'];?>');
	    }
	</script>
</head>
<body>
	<div class="cabecera">
		<h2>Frontal Web de la aplicación Lista de tareas</h2>
	</div>
	<div class="contenido">
	<form class="formulario" method="post" action="index.php">
		<?php if (isset($avisos)) { ?>
			<p><?php echo $avisos; ?></p>
		<?php };  ?>
		<input class="tarea" type="text" name="tarea">
		<button class="agregar" type="submit" name="agregar" id="boton_agregar">Agregar tarea</button>
	</form>
	<?php 
	$consulta = file_get_contents("http://{$backend}/tareas");
	$tabla = json_decode($consulta);
	if (count($tabla->data->tareas)) {?>
        <form class="formulario" method="post" action="index.php">
		<input type="hidden" name="clean" value="clean"/>
		<button class="borrar" type="submit" name="limpiar" id="boton_limpiar" onclick="return confirm('Vas aborrar todas las tareas y no habrá vuelta atras. ¿Estás realmente seguro?');">Borrar todas las tareas</button>
	</form>
        <table>
	<thead>
		<tr>
			<th>#</th>
			<th>Tarea</th>
			<th style="width: 60px;">Borrar</th>
		</tr>
	</thead>

	<tbody>
	<?php
        // Cycle through the array
        foreach ($tabla->data->tareas as $idx => $tarea) {
	?>
            <tr>
	    <td class="id"><?php echo $tarea->id; ?></td>
	    <td class="tarea"><?php echo $tarea->tarea; ?></td>
	    	<td class="borrar">
			<a href="index.php?borrar_tarea=<?php echo $tarea->id; ?>">x</a>
		</td>
            </tr>
	<?php };}; ?>

	</tbody>
	</table>
	</div>
</body>
</html>
