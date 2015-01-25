<?php
// Incluir la librería
require_once 'Rif.php';

// Crear la instancia y pasar como parámetro el RIF a verificar
$rif = new Rif('G200003030');

// Obtener los datos fiscales
$datosFiscales = json_decode($rif->getInfo());

var_dump($datosFiscales);

// Chequear el código resultante
switch ($datosFiscales->code_result) {
  case 1:
    $texto  = "Razón social: {$datosFiscales->seniat->nombre}<br />"
            . "Agente Retención: {$datosFiscales->seniat->agenteretencioniva}<br />"
            . "Contribuyente IVA: {$datosFiscales->seniat->contribuyenteiva}<br />"
            . "Tasa: {$datosFiscales->seniat->tasa}<br />";
    break;

  default:
    $texto = $datosFiscales->message;
  break;
}

echo utf8_decode($texto);