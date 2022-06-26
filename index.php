<?php
/* token de seguridad */
$token = "Dj7sjshdy4hdFncm547Shjsy"; // cambiar por un token aleatorio

/* get post */
$data = json_decode(file_get_contents('php://input'), true);

$token_key = $data['{nombre_del_token_en_el_json}'];

/* validar token */
if($token_key != $token){
	echo "Invalid token";
	exit;
}

/* TODO: validar que los campos no esten vacios */
/* TODO: Generar JWT */

/* asignar valores a variables */
$first_name = $data['first_name'];
$last_name = $data['last_name'];
$email = $data['email'];
$phone = $data['phone'];
$city = $data['city'];
$comments = $data['comments'];


$jwt = "{Código de jwt}"; // cambiar por el código generado por el servidor

//Llamado a la API de Zoom
$ch = curl_init();
curl_setopt_array($ch, array(
	CURLOPT_URL => "https://api.zoom.us/v2/webinars/{ID-Webinar}/registrants",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POSTFIELDS => "{\n  \"email\": \"$email\",\n  \"first_name\": \"$first_name\",\n  \"last_name\": \"$last_name\"\n \"phone\": \"$phone\",\n \"city\": \"$city\",\n \"comments\": \"$comments\",\n}",
	CURLOPT_HTTPHEADER => array(
		"authorization: Bearer {$jwt}", // You provide your JWT token in the Authorization header.
		"content-type: application/json"
	),
));

$response = curl_exec($ch);
$err = curl_error($ch);

curl_close($ch);

//Si la respuesta de la API de Zoom es correcta, se muestra el mensaje de registro exitoso.
if ($err) {
	//Manejo de errores
	echo "cURL Error #:" . $err;
} else {
	echo $response;
}

?>

