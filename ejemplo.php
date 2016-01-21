<html>
<head>
	<title>Consulta de RIF</title>
<style type="text/css"> 
tabla {
	display: table;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	border-spacing: 5px;
	border:2px solid #000;
}
 th, td {
       border:1px solid black;
       }
</style> 

</head>
<?php
// Incluir la librería
require_once 'Rif.php';

// Crear la instancia y pasar como parámetro el RIF a verificar
$rif = new Rif($_POST['txtrif']);

// Obtener los datos fiscales
$datosFiscales = json_decode($rif->getInfo());
//var_dump($datosFiscales);

// Chequear el código resultante
switch ($datosFiscales->code_result) {
  case 1:
    $texto  = 
 "<center>"
."<table border='2px' class='tabla'> "
. "<tr>"
. "<td rowspan='3'><b>Razón social:</b> <br/>{$datosFiscales->seniat->nombre}</td>"
. "<th>Tasa:</th><td>{$datosFiscales->seniat->tasa}</td>"
. "</tr>"
. "<tr>"
. "<th>Agente Retención:</th><td>{$datosFiscales->seniat->agenteretencioniva}</td>"
. "</tr>"
. "<tr>"
. "<th>Contribuyente IVA:</th><td>{$datosFiscales->seniat->contribuyenteiva}</td>"
. "</tr>"
. "</table>"
. "</center>";
    break;
  default:
    $texto = $datosFiscales->message;
  break;
}
echo utf8_decode($texto);
?>
</html>
