<?php
function llamar_api($accion, $tarea = '' , $tarea_id = '' )
{
	global $apiKey;
	global $backend;
	$datos = array(
		"apiKey" => $apiKey,
		"tarea" => $tarea,
	);
	switch ($accion){
		case "agregar":
			$url = "{$backend}/tareas/agregar";
			break;
		case "borrar":
			$url = "{$backend}/tareas/borrar/{$tarea_id}";
			break;
		case "limpiar":
			$url = "{$backend}/tareas/limpiar";
			break;
	};
	$data_post = json_encode($datos);
	
	// Inicialiazar la conexión cURL
	$curl = curl_init($url);
	
	// Configurar las opciones de cURL
	if ( $accion == "borrar" || $accion == "limpiar"){
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
	};
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data_post);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		"Content-Type: application/json",
		"x-api-key: {$apiKey}"
	));
	
	// Ejecutar cURL
	$curl_response = curl_exec($curl);
	$decoded_response = json_decode($curl_response);
	$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	switch ($httpCode) {
		case 200:
		    return($decoded_response->message);
		    break;
		case 201:
		    return($decoded_response->message);
		case 404:
		    return("404: API Not found");
		    break;
		case 500:
		case 502:
		case 503:
		    return("{$httpCode}: Server encountered an internal error");
		    break;
		default:
		    $error_status = "Undocumented error: " . $httpCode . " : " . curl_error($curl);
		    break;
    	}
	
	// Cerrar la conexión cURL
	curl_close($curl);
}
